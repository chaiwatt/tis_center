<?php

namespace App\Models\Section5;

use App\User;

use Carbon\Carbon;
use App\Models\Basic\Amphur;
use App\Models\Basic\Prefix;
use App\Models\Basic\District;

use App\Models\Basic\Province;
use App\Models\Sso\User AS SSO_USER;

use Illuminate\Database\Eloquent\Model;
use App\Models\Section5\InspectorsScope;
use App\Models\Section5\InspectorsAgreement;

class Inspectors extends Model
{
        /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $table = 'section5_inspectors';

    protected $primaryKey = 'id';

    protected $fillable = [
        'inspectors_code',
        'inspectors_prefix',
        'inspectors_first_name',
        'inspectors_last_name',
        'inspectors_taxid',
        'inspectors_address',
        'inspectors_moo',
        'inspectors_soi',
        'inspectors_road',
        'inspectors_subdistrict',
        'inspectors_district',
        'inspectors_province',
        'inspectors_zipcode',
        'inspectors_position',
        'inspectors_phone',
        'inspectors_fax',
        'inspectors_mobile',
        'inspectors_email',
        'agency_id',
        'agency_name',
        'agency_taxid',
        'agency_address',
        'agency_moo',
        'agency_soi',
        'agency_road',
        'agency_subdistrict',
        'agency_district',
        'agency_province',
        'agency_zipcode',
        'inspector_first_date',
        'state',
        'application_id',
        'ref_inspector_application_no',
        'created_by',
        'updated_by',
        'type',
        'inspectors_user_id'

    ];

    public function inspectors_subdistricts(){
        return $this->belongsTo(District::class, 'inspectors_subdistrict');
    }

    public function inspectors_districts(){
        return $this->belongsTo(Amphur::class,  'inspectors_district');
    }

    public function inspectors_provinces(){
        return $this->belongsTo(Province::class, 'inspectors_province');
    }

    public function agency_subdistricts(){
        return $this->belongsTo(District::class, 'agency_subdistrict');
    }

    public function agency_districts(){
        return $this->belongsTo(Amphur::class,  'agency_district');
    }

    public function agency_provinces(){
        return $this->belongsTo(Province::class, 'agency_province');
    }

    public function getInspectorSubdistrictNameAttribute() {
        return !empty($this->inspectors_subdistricts)?$this->inspectors_subdistricts->DISTRICT_NAME:null;
    }

    public function getInspectorDistrictNameAttribute() {
        return !empty($this->inspectors_districts)?$this->inspectors_districts->AMPHUR_NAME:null;
    }

    public function getInspectorProvinceNameAttribute() {
        return !empty($this->inspectors_provinces)?$this->inspectors_provinces->PROVINCE_NAME:null;
    }

    public function getAgencySubdistrictNameAttribute() {
        return !empty($this->agency_subdistricts)?$this->agency_subdistricts->DISTRICT_NAME:null;
    }

    public function getAgencyDistrictNameAttribute() {
        return !empty($this->agency_districts)?$this->agency_districts->AMPHUR_NAME:null;
    }

    public function getAgencyProvinceNameAttribute() {
        return !empty($this->agency_provinces)?$this->agency_provinces->PROVINCE_NAME:null;
    }

    public function getAgencyFullNameAttribute() {
        return (!empty($this->inspectors_prefix)?$this->inspectors_prefix:null).($this->inspectors_first_name).' '.($this->inspectors_last_name);
    }

    public function scopes(){
        return $this->hasMany(InspectorsScope::class, 'inspectors_id');
    }

    public function inspectors_agreements(){
        return $this->hasMany(InspectorsAgreement::class, 'inspectors_id');
    }

    public function inspectores(){
        return $this->hasMany(self::class, 'inspectors_taxid', 'inspectors_taxid');
    }

    public function getInspectorsFirstAttribute() {
        return @$this->inspectores->first();
    }

    public function getInspectorsScopeFirstAttribute() {
        return @$this->scopes->first();
    }

    public function getInspectorsAgreementGroupAttribute() {
        return @$this->inspectors_agreements->groupBy('agency_taxid');
    }

    public function getAgencyTitleAttribute() {
        return @$this->inspectors_agreements->pluck('agency_name')->implode(', ');
    }

    public function agency_user() {
        return $this->belongsTo(SSO_USER::class, 'agency_id');
    }

    public function getAgencyUserGroupAttribute() {
        return @$this->agency_user->groupBy('agency_taxid')->pluck('name', 'id');
    }

    public function getScopeGroupAttribute(){

        $app_scope = $this->scopes()->select('branch_group_id')->groupBy('branch_group_id')->get();
        $list = [];
        foreach( $app_scope AS $item ){
            $bs_branch_group = $item->bs_branch_group;

            if( !is_null($bs_branch_group) ){
                $list[] = $bs_branch_group->title;
            }

        }

        $txt = implode( ' ,',  $list );

        return $txt;
    }

    public function getBranchGroupBranchNameAttribute() {

        $groups = $this->scopes()->groupBy('branch_group_id')->get();

        $html = '';
        foreach($groups as $group){

            $html .= $group->BranchGroupTitle."<br>";
            $arr   = $this->scopes()->where('branch_group_id', $group->branch_group_id)->groupBy('branch_id')->get()->pluck('BranchTitle')->implode(', ');
            $html .= "<small><i>(".$arr.")</i></small><br>";
        }

        return $html;
    }

    public function getBranchGroupTitleAttribute(){
        return $this->scopes->pluck('branchGroupTitle')->implode(', ');
    }

    public function getAgencyDataAdressAttribute()
    {

        $agency_provinces = $this->agency_provinces;
        $agency_districts = $this->agency_districts;
        $agency_subdistricts = $this->agency_subdistricts;


        $text = '';
        $text .= (!empty($this->agency_address)?$this->agency_address:null);
        $text .= ' ';
        $text .= (!empty($this->agency_moo)?'หมู่ที่ '.$this->agency_moo:null);
        $text .= ' ';

        if(!is_null($this->agency_soi) &&  $this->agency_soi != '-'){
            $text .= (!empty($this->agency_soi)?'ตรอก/ซอย '.$this->agency_soi:null);
            $text .= ' ';
        }
        if(!is_null($this->agency_road) &&  $this->agency_road != '-'){
            $text .= (!empty($this->agency_road)?'ถนน '.$this->agency_road:null);
            $text .= ' ';
        }

        $subdistrict = ($agency_provinces->PROVINCE_ID == 1) ? 'แขวง' : 'ตำบล';
        $text .= (!empty($agency_subdistricts)?$subdistrict.' '.$agency_subdistricts->DISTRICT_NAME:null);
        $text .= ' ';

        $district_name = ($agency_provinces->PROVINCE_ID  == 1) ? 'เขต' : 'อำเภอ';
        $text .= (!empty($agency_districts)?$district_name.' '.$agency_districts->AMPHUR_NAME:null);
        $text .= ' ';

        $text .= (!empty($agency_provinces)?'จังหวัด '.$agency_provinces->PROVINCE_NAME:null);
        $text .= ' ';
        $text .= (!empty($this->agency_zipcode)?$this->agency_zipcode:null);

        return  $text;
    }

    public function getStateIconAttribute(){

        $btn = '';
        if ($this->state == 1) {
            $btn = '<i class="fa fa-check-circle fa-lg text-success"></i>';
        }else {
            $btn = '<i class="fa fa-times-circle fa-lg text-danger"></i>';
        }
        return $btn;

  	}

    public function user_created(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated(){
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getCreatedNameAttribute() {
        return !is_null($this->user_created) ? $this->user_created->reg_fname.' '.$this->user_created->reg_lname : '-' ;
    }

    public function getUpdatedNameAttribute() {
  		return @$this->user_updated->reg_fname.' '.@$this->user_updated->reg_lname;
  	}

    // วันที่ขึ้นทะเบียนครั้งแรก รูปแบบ 31/01/2565
    public function getFirstRegistrationDateAttribute(){
        $date = null;
        if(Carbon::hasFormat($this->inspector_first_date, 'Y-m-d')){
            $date = Carbon::parse($this->inspector_first_date)->addYear(543)->format('d/m/Y');
        }
        return $date;
    }

    // วันที่ขึ้นทะเบียนครั้งแรก รูปแบบ 31 มกราคม 2565
    public function getFirstRegistrationDateFullAttribute(){
        $date = null;
        if(Carbon::hasFormat($this->inspector_first_date, 'Y-m-d')){
            $date = Carbon::parse($this->inspector_first_date)->addYear(543)->isoFormat('D MMMM YYYY');
        }
        return $date;
    }

}
