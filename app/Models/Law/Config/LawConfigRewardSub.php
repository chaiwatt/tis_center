<?php

namespace App\Models\Law\Config;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\User;
use HP;
 
use App\Models\Law\Basic\LawRewardGroup;

class LawConfigRewardSub extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'law_config_reward_sub';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['law_config_reward_id', 'reward_group_id', 'amount', 'created_by', 'updated_by'];

    /*
      User Relation
    */
    public function user_created(){
      return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated(){
      return $this->belongsTo(User::class, 'updated_by');
    }

    public function getCreatedNameAttribute() {
  		return @$this->user_created->reg_fname.' '.@$this->user_created->reg_lname;
  	}

    public function getUpdatedNameAttribute() {
  		return @$this->user_updated->reg_fname.' '.@$this->user_updated->reg_lname;
    }

    public function law_reward_group_to(){
      return $this->belongsTo(LawRewardGroup::class, 'reward_group_id');
    }

    
}
