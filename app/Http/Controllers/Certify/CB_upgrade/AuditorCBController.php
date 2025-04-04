<?php

namespace App\Http\Controllers\Certify\CB;

use DB;
use HP;

use Storage;
use App\User;
use stdClass;
use Carbon\Carbon;
use App\Http\Requests;

use Illuminate\Http\Request;

use App\Mail\CB\CBRequestMail;
use App\Mail\CB\CBAuditorsMail;
use App\Mail\CB\CBDocumentsMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;   
use  App\Models\Bcertify\StatusAuditor; 
use App\Models\Certify\ApplicantCB\CertiCb; 
use App\Models\Certify\Applicant\CostDetails;
use App\Models\Certify\ApplicantCB\CertiCBCost; 
use App\Models\Certify\ApplicantCB\CertiCBCheck; 
use App\Models\Certify\ApplicantCB\CertiCBReview;
use App\Models\Certify\ApplicantCB\CertiCbHistory; 
use App\Models\Certify\ApplicantCB\CertiCBAuditors; 
use App\Models\Certify\ApplicantCB\CertiCBPayInOne; 

use App\Models\Certify\ApplicantCB\CertiCBAttachAll; 

use App\Models\Certify\ApplicantCB\CertiCBAuditorsCost;
use App\Models\Certify\ApplicantCB\CertiCBAuditorsDate;
use App\Models\Certify\ApplicantCB\CertiCBAuditorsList; 
use App\Models\Certify\ApplicantCB\CertiCBAuditorsStatus;

class AuditorCBController extends Controller
{
     private $attach_path;//ที่เก็บไฟล์แนบ
    public function __construct()
    {
        $this->middleware('auth');
        $this->attach_path = 'files/applicants/check_files_cb/';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
     
        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('view-'.$model)) {

            $keyword = $request->get('search');
        
            $filter = [];
 
            $filter['filter_status'] = $request->get('filter_status', '');
            $filter['filter_search'] = $request->get('filter_search', '');
            $filter['perPage'] = $request->get('perPage', 10);


            $Query = new CertiCBAuditors;
            $Query = $Query->select('app_certi_cb_auditors.*');

            if ($filter['filter_status']!='') {
                if($filter['filter_status'] == 0){
                    $Query = $Query->whereNull('status');
                }else{
                    $Query = $Query->where('status', $filter['filter_status']);
                } 
            }

            if ($filter['filter_search'] != '') {
                $CertiCb  = CertiCb::where('app_no', 'like', '%'.$filter['filter_search'].'%')->pluck('id');
                $Query = $Query->whereIn('app_certi_cb_id', $CertiCb);
            }
             //เจ้าหน้าที่ CB และไม่มีสิทธิ์ admin , ผอ , ผก , ลท.
             if(in_array("29",auth()->user()->RoleListId) && auth()->user()->SetRolesAdminCertify() == "false" ){ 
                $check = CertiCBCheck::where('user_id',auth()->user()->runrecno)->pluck('app_certi_cb_id'); // เช็คเจ้าหน้าที่ IB
                if(isset($check) && count($check) > 0  ) { 
                     $Query = $Query->LeftJoin('app_certi_cb_check','app_certi_cb_check.app_certi_cb_id','=','app_certi_cb_auditors.app_certi_cb_id')
                                    ->where('user_id',auth()->user()->runrecno);  //เจ้าหน้าที่  IB ที่ได้มอบหมาย 
                }else{
                    $Query = $Query->whereIn('id',['']);  // ไม่ตรงกับเงื่อนไข
                } 
            }
            $auditors =  $Query->orderby('id','desc')
                                // ->sortable()
                                ->paginate($filter['perPage']);


            return view('certify.cb.auditor_cb.index', compact('auditors', 'filter'));
        }
        abort(403);

    }

    public function auditor_cb_doc_review_index()
    {
      dd('index of auditor_cb_doc_review_index');
    }

    public function save_board_auditor_doc_review_index()
    {
      dd('index of save_board_auditor_doc_review_index');
    }


    public function auditor_cb_doc_review($id)
    {

        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('add-'.$model)) {
      
          $previousUrl = app('url')->previous();
           
            $auditorcb = new CertiCBAuditors;
            $auditors_status = [new CertiCBAuditorsStatus]; 
          if(!empty($request->certicb_id)){
            $auditorcb->app_certi_cb_id = $request->certicb_id;
            $auditorcb->certi_cb_change =  true;
          } 
        
            $app_no = [];
            //เจ้าหน้าที่ CB และไม่มีสิทธิ์ admin , ผอ , ผก , ลท.
           if(in_array("29",auth()->user()->RoleListId) && auth()->user()->SetRolesAdminCertify() == "false" ){ 
               $check = CertiCBCheck::where('user_id',auth()->user()->runrecno)->pluck('app_certi_cb_id'); // เช็คเจ้าหน้าที่ IB
               if(count($check) > 0 ){
                   $app_no= CertiCb::whereNotIn('status',[0,4,5])
                                    ->whereIn('id',$check)
                                    ->whereIn('status',[9,10,11])
                                    ->orderby('id','desc')
                                    ->pluck('app_no', 'id');
                } 
           }else{
                   $app_no = CertiCb::whereNotIn('status',[0,4,5])
                                        ->whereIn('status',[9,10,11])
                                       ->orderby('id','desc')
                                       ->pluck('app_no', 'id');
           }
           $certiCb = CertiCb::find($id);
           
            return view('certify.cb.auditor_cb_doc_review.create',[
                'certiCb' => $certiCb ,
                'app_no' => $app_no ,
                'auditorcb' => $auditorcb,
                'auditors_status'=> $auditors_status,
                'previousUrl'=>$previousUrl
            ]);
        }
        abort(403);

    }

    public function auditor_cb_doc_review_store(Request $request)
    {
      
        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('add-'.$model)) {
  
          try {
      
                $request->request->add(['created_by' => auth()->user()->getKey()]); //user create
                $requestData = $request->all();
                $requestData['status'] =   null ;
                $requestData['step_id'] =  2  ;//ขอความเห็นแต่งคณะผู้ตรวจประเมิน
                $requestData['vehicle'] = isset($request->vehicle) ? 1 : null ;
                $requestData['is_review_state'] =   1 ;
                $auditors =  CertiCBAuditors::create($requestData);
              // ไฟล์แนบ
                  if ($request->other_attach){
                    $this->set_attachs($request->other_attach, $auditors,"1");
                  }
                  if ($request->attach){
                    $this->set_attachs($request->attach, $auditors,"2");
                  }

                  //วันที่ตรวจประเมิน
                $this->DataCertiCBAuditorsDate($auditors->id,$request);

        
                $this->storeStatus($auditors->id,(array)$requestData['list']);

                //ค่าใช้จ่าย
                $this->storeItems($auditors->id,$request);

                $certi_cb = CertiCb::findOrFail($auditors->app_certi_cb_id);
                if(!is_null($certi_cb->email)){
                    if(isset($request->vehicle)){
                        $certi_cb->update(['status'=>9]); // ยังให้อยู่ที่ 9 เหมือนเดิม คือขั้นตอนแต่งตั้งคณะผู้ตรวจเอกสาร	
                        // Log
                        $this->set_history($auditors,$certi_cb);
                        //E-mail 
                        $this->set_mail($auditors,$certi_cb);
              
                    }else{
                        $certi_cb->update(['status'=>9]); //  ยังให้อยู่ที่ 9 เหมือนเดิม คือขั้นตอนแต่งตั้งคณะผู้ตรวจเอกสาร
                    }
                }
                
            
                if($request->previousUrl){
                  return redirect("$request->previousUrl")->with('flash_message', 'เรียบร้อยแล้ว!');
                }else{
                    return redirect('certify/auditor-cb')->with('flash_message', 'เรียบร้อยแล้ว!');
                }
          } catch (\Exception $e) {
                 return redirect('certify/auditor-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาทำรายการใหม่!');
          }

        }
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('add-'.$model)) {
          $previousUrl = app('url')->previous();
           
            $auditorcb = new CertiCBAuditors;
            $auditors_status = [new CertiCBAuditorsStatus]; 
          if(!empty($request->certicb_id)){
            $auditorcb->app_certi_cb_id = $request->certicb_id;
            $auditorcb->certi_cb_change =  true;
          } 
         
            $app_no = [];
            //เจ้าหน้าที่ CB และไม่มีสิทธิ์ admin , ผอ , ผก , ลท.
           if(in_array("29",auth()->user()->RoleListId) && auth()->user()->SetRolesAdminCertify() == "false" ){ 
               $check = CertiCBCheck::where('user_id',auth()->user()->runrecno)->pluck('app_certi_cb_id'); // เช็คเจ้าหน้าที่ IB
               if(count($check) > 0 ){
                   $app_no= CertiCb::whereNotIn('status',[0,4,5])
                                    ->whereIn('id',$check)
                                    ->whereIn('status',[9,10,11])
                                    ->orderby('id','desc')
                                    ->pluck('app_no', 'id');
                } 
           }else{
                   $app_no = CertiCb::whereNotIn('status',[0,4,5])
                                        ->whereIn('status',[9,10,11])
                                       ->orderby('id','desc')
                                       ->pluck('app_no', 'id');
           }

            return view('certify.cb.auditor_cb.create',['app_no' => $app_no ,'auditorcb' => $auditorcb,'auditors_status'=> $auditors_status,'previousUrl'=>$previousUrl]);
        }
        abort(403);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('add-'.$model)) {
  
          try {
                $request->request->add(['created_by' => auth()->user()->getKey()]); //user create
                $requestData = $request->all();
                $requestData['status'] =   null ;
                $requestData['step_id'] =  2  ;//ขอความเห็นแต่งคณะผู้ตรวจประเมิน
                $requestData['vehicle'] = isset($request->vehicle) ? 1 : null ;
                $auditors =  CertiCBAuditors::create($requestData);
              // ไฟล์แนบ
                  if ($request->other_attach){
                    $this->set_attachs($request->other_attach, $auditors,"1");
                  }
                  if ($request->attach){
                    $this->set_attachs($request->attach, $auditors,"2");
                  }

                  //วันที่ตรวจประเมิน
                $this->DataCertiCBAuditorsDate($auditors->id,$request);

        
                $this->storeStatus($auditors->id,(array)$requestData['list']);

                //ค่าใช้จ่าย
                $this->storeItems($auditors->id,$request);

                $certi_cb = CertiCb::findOrFail($auditors->app_certi_cb_id);
                if(!is_null($certi_cb->email)){
                    if(isset($request->vehicle)){
                        $certi_cb->update(['status'=>10]); // อยู่ระหว่างดำเนินการ 	
                        // Log
                        $this->set_history($auditors,$certi_cb);
                        //E-mail 
                        $this->set_mail($auditors,$certi_cb);
              
                    }else{
                        $certi_cb->update(['status'=>10]); //  อยู่ระหว่างดำเนินการ
                    }
                }
                
            
                if($request->previousUrl){
                  return redirect("$request->previousUrl")->with('flash_message', 'เรียบร้อยแล้ว!');
                }else{
                    return redirect('certify/auditor-cb')->with('flash_message', 'เรียบร้อยแล้ว!');
                }
          } catch (\Exception $e) {
                 return redirect('certify/auditor-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาทำรายการใหม่!');
          }

        }
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
  
        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('view-'.$model)) {
            $auditorcb = AuditorCB::findOrFail($id);
            return view('certify/cb.auditor_cb.show', compact('auditorcb'));
        }
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
      
        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('edit-'.$model)) {
          $previousUrl = app('url')->previous();
          $auditorcb = CertiCBAuditors::findOrFail($id);
  
          $auditors_status = CertiCBAuditorsStatus::where('auditors_id',$id)->get();
          if(count($auditors_status) <= 0){
              $auditors_status = [new CertiCBAuditorsStatus];
          }
            $attach_path = $this->attach_path;//path ไฟล์แนบ
            return view('certify/cb.auditor_cb.edit', compact('auditorcb','auditors_status','previousUrl','attach_path'));
        }
        abort(403);
    }

    public function auditor_cb_doc_review_edit($id)
    {
     
        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('edit-'.$model)) {
          $previousUrl = app('url')->previous();
          $auditorcb = CertiCBAuditors::findOrFail($id);
  
          $auditors_status = CertiCBAuditorsStatus::where('auditors_id',$id)->get();
          if(count($auditors_status) <= 0){
              $auditors_status = [new CertiCBAuditorsStatus];
          }
            $attach_path = $this->attach_path;//path ไฟล์แนบ

            $certiCb =  CertiCb::find($auditorcb->app_certi_cb_id);
            return view('certify/cb.auditor_cb_doc_review.edit', compact('auditorcb','auditors_status','previousUrl','attach_path','certiCb'));
        }
        abort(403);
    }


    public function auditor_cb_doc_review_result_update(Request $request, $id)
    {
        
        $model = str_slug('checkcertificatecb','-');
        if(auth()->user()->can('edit-'.$model)) {
            $request->validate([
              'status' => 'required|in:2,3,4,5,6,7,9,15,27',
            ]);
      try {
       
            $tb = new CertiCb;
            $config = HP::getConfig();
            $url  =   !empty($config->url_acc) ? $config->url_acc : url('');

            $requestData = $request->all();
            $requestData['save_date'] =  $request->save_date ? HP::convertDate($request->save_date,true) : null;
            $certi_cb = CertiCb::findOrFail($id);

            $status = $request->status;
            // dd($status);
       // status = 2,3,5,6
        if (in_array($status, ['3'])) { // 3. ขอเอกสารเพิ่มเติม 4. ยกเลิกคำขอ 5. ไม่ผ่านการตรวจสอบ

            if($status == 3){
                $section = 6; // ขอเอกสารเพิ่มเติม
                $system = 1;
                // $system_mail = 3; //ขอเอกสารเพิ่มเติม
                $requestData['details']         =  $request->desc ?? null;
            }
          unset($requestData['status']);
          //dd($status,$request->desc ,$requestData);
          $requestData['more_doc_require'] = 1;
           $certi_cb->update($requestData);

            if ($request->hasFile('file')) {
                $attachs = [];
                foreach ($request->file as $index => $item){
                    $certi_cb_attach_more = new CertiCBAttachAll();
                    $certi_cb_attach_more->app_certi_cb_id  = $certi_cb->id;
                    $certi_cb_attach_more->table_name       =  $tb->getTable();
                    $certi_cb_attach_more->file_section     = $section ?? null;
                    $certi_cb_attach_more->file             = $this->storeFile($item,$certi_cb->app_no);
                    $certi_cb_attach_more->file_client_name = HP::ConvertCertifyFileName($item->getClientOriginalName());
                    $certi_cb_attach_more->token            = str_random(16);
                    $certi_cb_attach_more->save();

                    $list  = new  stdClass;
                    $list->file_desc        =    $certi_cb_attach_more->file_desc ;
                    $list->file             =    $certi_cb_attach_more->file ;
                    $list->file_client_name =    $certi_cb_attach_more->file_client_name ;
                    $list->attach_path      =    $this->attach_path ;
                    $attachs[]              =    $list;
                }
            }
            // log
            CertiCbHistory::create([
                                    'app_certi_cb_id'   => $certi_cb->id ?? null,
                                    'system'            => isset($system) ? $system : null,
                                    'table_name'        => $tb->getTable(),
                                    'status'            => $certi_cb->status ?? null,
                                    'ref_id'            => $certi_cb->id,
                                    'details_one'       => $certi_cb->details ?? null,
                                    'details_two'       => $certi_cb->desc_delete ?? null,
                                    'attachs'           => isset($attachs) ?  json_encode($attachs) : null,
                                    'created_by'        =>  auth()->user()->runrecno
                                  ]);

        if(!is_null($certi_cb->email)){
             // mail
             $title_status =  ['3'=>'ขอเอกสารเพิ่มเติม','4'=>'ยกเลิกคำขอ','5'=>'ไม่ผ่านการตรวจสอบ'];
             $data_status =  ['3'=>'แนบเอกสารเพิ่มเติม','4'=>'ยกเลิกคำขอ','5'=>'ไม่ผ่านการตรวจสอบ'];
             
            $data_app = ['certi_cb'     => $certi_cb ?? '-',
                        'desc'         =>  $certi_cb->details ?? '-',
                        'status'       =>   $status,
                        'title'        =>   array_key_exists($status,$title_status) ?$title_status[$status] : null,
                        'data'         =>   array_key_exists($status,$data_status) ?$data_status[$status] : null,
                        'name'         =>   !empty($certi_cb->name)  ?   $certi_cb->name  : '-',
                        'attachs'      =>  isset($attachs) ?  $attachs   : '-',
                        'url'          =>  $url.'certify/applicant-cb',
                        'email'        =>  !empty($certi_cb->DataEmailCertifyCenter) ? $certi_cb->DataEmailCertifyCenter : 'cb@tisi.mail.go.th',
                        'email_cc'     =>  !empty($certi_cb->DataEmailDirectorCBCC) ? $certi_cb->DataEmailDirectorCBCC : 'cb@tisi.mail.go.th',
                        'email_reply'  => !empty($certi_cb->DataEmailDirectorCBReply) ? $certi_cb->DataEmailDirectorCBReply : 'cb@tisi.mail.go.th'
                        ];
            
                    $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                            $certi_cb->id,
                                                            (new CertiCb)->getTable(),
                                                            $certi_cb->id,
                                                            (new CertiCb)->getTable(),
                                                            3,
                                                            $title_status[$status]  ?? null,
                                                            view('mail.CB.documents', $data_app),
                                                            $certi_cb->created_by,
                                                            $certi_cb->agent_id,
                                                            auth()->user()->getKey(),
                                                            !empty($certi_cb->DataEmailCertifyCenter) ?  implode(',',(array)$certi_cb->DataEmailCertifyCenter)  :  'cb@tisi.mail.go.th',
                                                            $certi_cb->email,
                                                            !empty($certi_cb->DataEmailDirectorCBCC) ? implode(',',(array)$certi_cb->DataEmailDirectorCBCC)   :   'cb@tisi.mail.go.th',
                                                            !empty($certi_cb->DataEmailDirectorCBReply) ?implode(',',(array)$certi_cb->DataEmailDirectorCBReply)   :   'cb@tisi.mail.go.th',
                                                            null
                                                            );

                    $html = new CBDocumentsMail($data_app);
                    $mail =  Mail::to($certi_cb->email)->send($html);
        
                    if(is_null($mail) && !empty($log_email)){
                        HP::getUpdateCertifyLogEmail($log_email->id);
                    }    
         }
               
      }

   

            if (in_array($status, ['6'])) {
                $requestData['app_no']      =  isset($certi_cb->app_no) ?  str_replace("RQ-","",$certi_cb->app_no) : @$certi_cb->app_no;
                $requestData['get_date']    =   date('Y-m-d h:m:s');
                
                unset($requestData['status']);
                $requestData['more_doc_require'] = 2;
                $certi_cb->update($requestData);
                if($certi_cb && !is_null($certi_cb->email)){


             $data_app = [  'certi_cb'       => $certi_cb ?? '-',
                            'url'           => $url.'certify/applicant-cb' ?? '-',
                            'email'         => !empty($certi_cb->DataEmailCertifyCenter) ? $certi_cb->DataEmailCertifyCenter : 'cb@tisi.mail.go.th',
                            'email_cc'      => !empty($certi_cb->DataEmailDirectorCBCC) ? $certi_cb->DataEmailDirectorCBCC : 'cb@tisi.mail.go.th',
                            'email_reply'   => !empty($certi_cb->DataEmailDirectorCBReply) ? $certi_cb->DataEmailDirectorCBReply : 'cb@tisi.mail.go.th'
                         ];
            
                    $log_email =  HP::getInsertCertifyLogEmail( $certi_cb->app_no,
                                                            $certi_cb->id,
                                                            (new CertiCb)->getTable(),
                                                            $certi_cb->id,
                                                            (new CertiCb)->getTable(),
                                                            3,
                                                            'รับคำขอรับบริการ',
                                                            view('mail.CB.request', $data_app),
                                                            $certi_cb->created_by,
                                                            $certi_cb->agent_id,
                                                            auth()->user()->getKey(),
                                                            !empty($certi_cb->DataEmailCertifyCenter) ?  implode(',',(array)$certi_cb->DataEmailCertifyCenter)  :  'cb@tisi.mail.go.th',
                                                            $certi_cb->email,
                                                            !empty($certi_cb->DataEmailDirectorCBCC) ? implode(',',(array)$certi_cb->DataEmailDirectorCBCC)   :   'cb@tisi.mail.go.th',
                                                            !empty($certi_cb->DataEmailDirectorCBReply) ?implode(',',(array)$certi_cb->DataEmailDirectorCBReply)   :   'cb@tisi.mail.go.th',
                                                            null
                                                            );

                    $html = new CBRequestMail($data_app);
                    $mail =  Mail::to($certi_cb->email)->send($html);
        
                    if(is_null($mail) && !empty($log_email)){
                        HP::getUpdateCertifyLogEmail($log_email->id);
                    }    

                 }
            }

           

            if(isset($certi_cb->token)){
                // dd('fggdfg');
                return redirect('certify/auditor_cb_doc_review/auditor_cb_doc_review_result_show/'.$certi_cb->id)->with('flash_message', 'เรียบร้อยแล้ว');
            }else{
            return redirect('certify/check_certificate-cb')->with('flash_message', 'เรียบร้อยแล้ว!');
            }

       } catch (\Exception $e) {
             return redirect('certify/check_certificate-cb')->with('message_error', 'เกิดข้อผิดพลาดกรุณาบันทึกใหม่');
        }  
    }
        abort(403);
    }


    public function auditor_cb_doc_review_result_show($id)
    {

     $model = str_slug('checkcertificatecb','-');
     if(auth()->user()->can('view-'.$model)) {
         $certi_cb = CertiCb::find($id);
         // ประวัติคำขอ
         $config = HP::getConfig();
         $url  =   !empty($config->url_acc) ? $config->url_acc : url('');
         $history  =  CertiCbHistory::where('app_certi_cb_id',$certi_cb->id)
                                     ->orderby('id','desc')
                                     ->get();
          $attach_path = $this->attach_path;//path ไฟล์แนบ
          $selectedCertiCb = CertiCb::find($id);
         
     return view('certify.cb.auditor_cb_doc_review.show', compact('certi_cb','history','attach_path','selectedCertiCb'));
     }
     abort(403);
    }
    
    

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
   
        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('edit-'.$model)) {
     
          try {
          $request->request->add(['updated_by' => auth()->user()->getKey()]); //user update
          $requestData = $request->all();
          $requestData['status'] =   null ;
          $requestData['step_id'] =  2  ; //ขอความเห็นแต่งคณะผู้ตรวจประเมิน
          $requestData['vehicle'] = isset($request->vehicle) ? 1 : null ;
          $auditors = CertiCBAuditors::findOrFail($id);
          $auditors->update($requestData);
        
         // ไฟล์แนบ
            if ($request->other_attach){
              $this->set_attachs($request->other_attach, $auditors,"1");
            }
            if ($request->attach){
              $this->set_attachs($request->attach, $auditors,"2");
            }

          //วันที่ตรวจประเมิน
          $this->DataCertiCBAuditorsDate($auditors->id,$request);

          $this->storeStatus($auditors->id,(array)$requestData['list']);

           //ค่าใช้จ่าย
          $this->storeItems($auditors->id,$request);

          $certi_cb = CertiCb::findOrFail($auditors->app_certi_cb_id);
          if(!is_null($certi_cb->email)){
              if(isset($request->vehicle)){
                  $certi_cb->update(['status'=>10]); // อยู่ระหว่างดำเนินการ 	
                  //Log
                  $this->set_history($auditors,$certi_cb);
                  //E-mail 
                   $this->set_mail($auditors,$certi_cb);
 
              }else{
                   $certi_cb->update(['status'=>10]); //  อยู่ระหว่างดำเนินการ
              }
          }

            if($request->previousUrl){
              return redirect("$request->previousUrl")->with('flash_message', 'เรียบร้อยแล้ว!');
            }else{
                return redirect('certify/auditor-cb')->with('flash_message', 'เรียบร้อยแล้ว!');
            }

          } catch (\Exception $e) {
           return redirect('certify/auditor-cb/'.$id.'/edit')->with('message_error', 'เกิดข้อผิดพลาดกรุณาทำรายการใหม่!');
          }

          
        }
        abort(403);

    }

    public function auditor_cb_doc_review_update(Request $request, $id)
    {

        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('edit-'.$model)) {
     
          try {
          $request->request->add(['updated_by' => auth()->user()->getKey()]); //user update
          $requestData = $request->all();
          $requestData['status'] =   null ;
          $requestData['step_id'] =  2  ; //ขอความเห็นแต่งคณะผู้ตรวจประเมิน
          $requestData['vehicle'] = isset($request->vehicle) ? 1 : null ;
          $auditors = CertiCBAuditors::findOrFail($id);
          $auditors->update($requestData);
        
         // ไฟล์แนบ
            if ($request->other_attach){
              $this->set_attachs($request->other_attach, $auditors,"1");
            }
            if ($request->attach){
              $this->set_attachs($request->attach, $auditors,"2");
            }

          //วันที่ตรวจประเมิน
          $this->DataCertiCBAuditorsDate($auditors->id,$request);

          $this->storeStatus($auditors->id,(array)$requestData['list']);

           //ค่าใช้จ่าย
          $this->storeItems($auditors->id,$request);

          $certi_cb = CertiCb::findOrFail($auditors->app_certi_cb_id);
          if(!is_null($certi_cb->email)){
              if(isset($request->vehicle)){
                  $certi_cb->update(['status'=>9]); // อยู่ระหว่างดำเนินการ 	
                  //Log
                  $this->set_history($auditors,$certi_cb);
                  //E-mail 
                   $this->set_mail($auditors,$certi_cb);
 
              }else{
                   $certi_cb->update(['status'=>9]); //  อยู่ระหว่างดำเนินการ
              }
          }

            if($request->previousUrl){
              return redirect("$request->previousUrl")->with('flash_message', 'เรียบร้อยแล้ว!');
            }else{
                return redirect('certify/auditor-cb')->with('flash_message', 'เรียบร้อยแล้ว!');
            }

          } catch (\Exception $e) {
           return redirect('certify/auditor-cb/'.$id.'/edit')->with('message_error', 'เกิดข้อผิดพลาดกรุณาทำรายการใหม่!');
          }

          
        }
        abort(403);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id, Request $request)
    {
        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('delete-'.$model)) {

          $requestData = $request->all();

          if(array_key_exists('cb', $requestData)){
            $ids = $requestData['cb'];
            $db = new AuditorCB;
            AuditorCB::whereIn($db->getKeyName(), $ids)->delete();
          }else{
            AuditorCB::destroy($id);
          }

          return redirect('certify/auditor_cb')->with('flash_message', 'ลบข้อมูลเรียบร้อยแล้ว!');
        }
        abort(403);

    }


    /*
      **** Update State ****
    */
    public function update_state(Request $request){

      $model = str_slug('auditorcb','-');
      if(auth()->user()->can('edit-'.$model)) {

        $requestData = $request->all();

        if(array_key_exists('cb', $requestData)){
          $ids = $requestData['cb'];
          $db = new AuditorCB;
          AuditorCB::whereIn($db->getKeyName(), $ids)->update(['state' => $requestData['state']]);
        }

        return redirect('certify/auditor_cb')->with('flash_message', 'แก้ไขข้อมูลเรียบร้อยแล้ว!');
      }

      abort(403);

    }

    public function set_attachs($attachs, $auditors,$number) {
        $tb = new CertiCBAuditors;
            $certi_cb_attach_more = new CertiCBAttachAll();
            $certi_cb_attach_more->app_certi_cb_id = $auditors->CertiCbCostTo->id ?? null;
            $certi_cb_attach_more->ref_id = $auditors->id;
            $certi_cb_attach_more->table_name = $tb->getTable();
            $certi_cb_attach_more->file_section =  $number;
            $certi_cb_attach_more->file = $this->storeFile($attachs,($auditors->CertiCbCostTo->app_no ?? 'files_cb'));
            $certi_cb_attach_more->file_client_name = HP::ConvertCertifyFileName($attachs->getClientOriginalName());
            $certi_cb_attach_more->token = str_random(16);
            $certi_cb_attach_more->save();
      }

    public function DataCertiNo($id) {

        $app_no =  CertiCb::findOrFail($id);
        if(!is_null($app_no)){
            $cost = CertiCBCost::where('app_certi_cb_id',$app_no->id)->orderby('id','desc')->first();
            if(!is_null($cost)){
                $cost_item = $cost->items;
            }
        }
        $cost_details =  StatusAuditor::orderbyRaw('CONVERT(title USING tis620)')->pluck('title', 'id');
        return response()->json([
           'name'=> !empty($app_no->name) ? $app_no->name : ' ' ,
           'id'=> !empty($app_no->id) ? $app_no->id : ' ' ,
           'cost_item' => isset($cost_item) ? $cost_item : '-',
           'cost_details' => $cost_details
        ]);
    }

    public function update_delete(Request $request, $id)
    {
        $model = str_slug('auditorcb','-');
        if(auth()->user()->can('delete-'.$model)) {
            
            try {
                $details  = [];
                $requestData = $request->all();
                $requestData['reason_cancel']   =  $request->reason_cancel ;
                $requestData['status_cancel']   =   1 ;
                $requestData['created_cancel']  =  auth()->user()->runrecno;
                $requestData['date_cancel']     =    date('Y-m-d H:i:s') ;
                $requestData['step_id']         =   12 ; // ยกเลิกแต่งตั้งคณะผู้ตรวจประเมิน
                $auditors = CertiCBAuditors::findOrFail($id);
                $auditors->update($requestData);
    
                $response = [];
                $response['reason_cancel']  =  $auditors->reason_cancel ?? null;
                $response['status_cancel']  =  $auditors->status_cancel ?? null;
                $response['created_cancel'] =  $auditors->created_cancel ?? null;    
                $response['date_cancel']    =  $auditors->date_cancel ?? null;
                $response['step_id']        =  $auditors->step_id ?? null;
 
                if(count($response) > 0){ // update log แต่งตั้งคณะกรรมการ
                  CertiCbHistory::where('ref_id',$id)->where('table_name',(new CertiCBAuditors)->getTable())->update(['details_auditors_cancel' => json_encode($response) ]);
                }

                $CertiCb = CertiCb::findOrFail($auditors->app_certi_cb_id);
                if(!is_null($CertiCb)){

                  $payin_one =  CertiCBPayInOne::where('app_certi_cb_id',$CertiCb->id)->where('app_certi_cb_id',$CertiCb->id)->orderby('id','desc')->first();
                  if(!is_null($payin_one)){ // update log payin
                    // / update   payin
                    CertiCBPayInOne::where('auditors_id',$auditors->id)->update(['status'=>3]);
                    CertiCbHistory::where('ref_id',$payin_one->id)->where('table_name',(new CertiCBPayInOne)->getTable())->update(['details_auditors_cancel' => json_encode($response) ]);
                  }
                 // สถานะ แต่งตั้งคณะกรรมการ
                 $auditor = CertiCBAuditors::where('app_certi_cb_id',$CertiCb->id)
                                            ->whereIn('step_id',[9,10])
                                            ->whereNull('status_cancel')
                                            ->get(); 
                  if(count($auditor) == count($CertiCb->CertiCBAuditorsManyBy)){
                      $report = new   CertiCBReview;  //ทบทวนฯ
                      $report->app_certi_cb_id  = $CertiCb->id;
                      $report->save();
                      $CertiCb->update(['review'=>1,'status'=>11]);  // ทบทวน
                  }
                }
   
                return redirect('certify/auditor-cb')->with('flash_message', 'update ยกเลิกแต่งตั้งคณะผู้ตรวจประเมินเรียบร้อยแล้ว');
            } catch (\Exception $e) {
                return redirect('certify/auditor-cb')->with('flash_message', 'เกิดข้อผิดพลาดในการบันทึก');
            }
        }
        abort(403);
    }


            // สำหรับเพิ่มรูปไปที่ store
        public function storeFile($files, $app_no = 'files_cb', $name = null)
        {
            $no  = str_replace("RQ-","",$app_no);
            $no  = str_replace("-","_",$no);
            if ($files) {
                $attach_path  =  $this->attach_path.$no;
                $file_extension = $files->getClientOriginalExtension();
                $fileClientOriginal   =  HP::ConvertCertifyFileName($files->getClientOriginalName());
                $filename = pathinfo($fileClientOriginal, PATHINFO_FILENAME);
                $fullFileName =   str_random(10).'-date_time'.date('Ymd_hms') . '.' . $files->getClientOriginalExtension();
  
                $storagePath = Storage::putFileAs($attach_path, $files,  str_replace(" ","",$fullFileName) );
                $storageName = basename($storagePath); // Extract the filename
                return  $no.'/'.$storageName;
            }else{
                return null;
            }
        }

          
    public function DataCertiCBAuditorsDate($baId, $request) {
      if(isset($request->start_date)){ 
          CertiCBAuditorsDate::where('auditors_id',$baId)->delete();
        /* วันที่ตรวจประเมิน */
        foreach($request->start_date as $key => $itme) {
            $input = [];
            $input['auditors_id'] = $baId;
            $input['start_date'] = HP::convertDate( $itme ,true) ?? null;
            $input['end_date']   = HP::convertDate( $request->end_date[$key]  ,true)?? null;
            CertiCBAuditorsDate::create($input);
          }
       }
     }
     public function storeStatus($baId, $list) {
      if(isset($list['status'])){ 
        CertiCBAuditorsStatus::where('auditors_id',$baId)->delete();
        CertiCBAuditorsList::where('auditors_id',$baId)->delete();
          foreach($list['status'] as $key => $itme) {
            if($itme != null){
                $input = [];
                $input['auditors_id'] = $baId;
                $input['status'] =  $itme;
                $auditors_status =  CertiCBAuditorsStatus::create($input);
                $this->storeList($auditors_status,
                                $list['temp_users'][$auditors_status->status],
                                $list['user_id'][$auditors_status->status],
                                $list['temp_departments'][$auditors_status->status]
                              );
            }
          }
       }
     } 
     public function storeList($status,$temp_users,$user_id,$temp_departments) {
        foreach($temp_users as $key => $itme) {
          if($itme != null){
              $input = [];
              $input['auditors_status_id'] = $status->id;
              $input['auditors_id'] = $status->auditors_id;
              $input['status'] = $status->status;
              $input['temp_users'] =  $itme;
              $input['user_id'] =   $user_id[$key] ?? null;
              $input['temp_departments'] =  $temp_departments[$key] ?? null;
              CertiCBAuditorsList::create($input);
          }
        }
     }
  
    public function storeItems($baId, $items) {
        if(isset($items['detail'])){
            CertiCBAuditorsCost::where('auditors_id',$baId)->delete();    
            $detail = (array)@$items['detail'];
          foreach($detail['detail'] as $key => $data ) {
              $item = new CertiCBAuditorsCost;
              $item->auditors_id = $baId;
              $item->detail = $data ?? null;
              $item->amount_date = $detail['amount_date'][$key] ?? 0;
              $item->amount =  !empty(str_replace(",","", $detail['amount'][$key]))?str_replace(",","",$detail['amount'][$key]):null; 
              $item->save();
          }
        }
  }
  
      public function set_history($data,$certi_cb = null) {
              $tb = new CertiCBAuditors;
          $auditors = CertiCBAuditors::select('app_certi_cb_id', 'no','auditor')
                        ->where('id',$data->id)
                        ->first();
        
          $auditors_date = CertiCBAuditorsDate::select('start_date','end_date')
                                        ->where('auditors_id',$data->id)
                                        ->get()
                                        ->toArray();
          $auditors_list = CertiCBAuditorsList::select('status','temp_users','user_id','temp_departments')
                                        ->where('auditors_id',$data->id)
                                        ->get()
                                        ->toArray();
          $auditors_cost = CertiCBAuditorsCost::select('detail','amount_date','amount')
                                        ->where('auditors_id',$data->id)
                                        ->get()
                                        ->toArray();
  
         CertiCbHistory::create([ 
                                      'app_certi_cb_id'   => $certi_cb->id ?? null,
                                      'auditors_id'       =>  $data->id ?? null,
                                      'system'            => 5,
                                      'table_name'        => $tb->getTable(),
                                      'ref_id'            => $data->id,
                                      'details_one'       =>  json_encode($auditors) ?? null,
                                      'details_two'       =>  (count($auditors_date) > 0) ? json_encode($auditors_date) : null,
                                      'details_three'     =>  (count($auditors_list) > 0) ? json_encode($auditors_list) : null,
                                      'details_four'      =>  (count($auditors_cost) > 0) ? json_encode($auditors_cost) : null,
                                      'file'              => !empty($data->FileAuditors1->file) ?  $data->FileAuditors1->file  : null,
                                      'file_client_name'  => !empty($data->FileAuditors1->file_client_name) ?  $data->FileAuditors1->file_client_name  : null,
                                      'attachs'           => !empty($data->FileAuditors2->file) ? $data->FileAuditors2->file : null,
                                      'attach_client_name'=> !empty($data->FileAuditors2->file_client_name) ?  $data->FileAuditors2->file_client_name  : null,
                                      'created_by'        =>  auth()->user()->runrecno
                               ]);

      }
      
      public function set_mail($auditors,$certi_cb) {
        if(!is_null($certi_cb->email)){

            $config = HP::getConfig();
            $url  =   !empty($config->url_acc) ? $config->url_acc : url('');

            if(!empty($certi_cb->DataEmailDirectorCBCC)){
                $mail_cc = $certi_cb->DataEmailDirectorCBCC;
                array_push($mail_cc, auth()->user()->reg_email) ;
            }

            $data_app = [
                          'title'          =>  'แต่งตั้งคณะผู้ตรวจประเมิน (CB)',
                          'auditors'       => $auditors,
                          'certi_cb'       => $certi_cb ,
                          'url'            => $url.'certify/applicant-cb' ?? '-',
                          'email'          =>  !empty($certi_cb->DataEmailCertifyCenter) ? $certi_cb->DataEmailCertifyCenter : 'cb@tisi.mail.go.th',
                          'email_cc'       =>  !empty($mail_cc) ? $mail_cc : 'cb@tisi.mail.go.th',
                          'email_reply'    => !empty($certi_cb->DataEmailDirectorCBReply) ? $certi_cb->DataEmailDirectorCBReply : 'cb@tisi.mail.go.th'
                    ];

            $log_email =  HP::getInsertCertifyLogEmail($certi_cb->app_no,
                                                    $certi_cb->id,
                                                    (new CertiCb)->getTable(),
                                                    $auditors->id,
                                                    (new CertiCBAuditors)->getTable(),
                                                    3,
                                                    'การแต่งตั้งคณะผู้ตรวจประเมิน',
                                                    view('mail.CB.auditors', $data_app),
                                                    $certi_cb->created_by,
                                                    $certi_cb->agent_id,
                                                    auth()->user()->getKey(),
                                                    !empty($certi_cb->DataEmailCertifyCenter) ?  implode(',',(array)$certi_cb->DataEmailCertifyCenter)  :  'cb@tisi.mail.go.th',
                                                    $certi_cb->email,
                                                    !empty($mail_cc) ?  implode(',',(array)$mail_cc)  : 'cb@tisi.mail.go.th',
                                                    !empty($certi_cb->DataEmailDirectorCBReply) ?implode(',',(array)$certi_cb->DataEmailDirectorCBReply)   :   'cb@tisi.mail.go.th',
                                                    null
                                                    );

            $html = new CBAuditorsMail($data_app);
            $mail =  Mail::to($certi_cb->email)->send($html);

            if(is_null($mail) && !empty($log_email)){
                HP::getUpdateCertifyLogEmail($log_email->id);
            } 
        }
   }
  
}
