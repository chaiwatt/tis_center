<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ConfigsFormatCodeLog extends Model
{
    /**
     * The database table used by the model.
    *
    * @var string
    */
    protected $table = 'configs_format_codes_log';

    /**
     * Attributes that should be mass-assignable.
    *
    * @var array
    */
    protected $fillable = [
                            'format',
                            'data',
                            'sub_data',
                            'format_id',
                            'start_date', 
                            'end_date', 
                            'state',
                            'system'
                        ];

     /* Btn Switch Input*/
    public function getStateIconAttribute(){

        $btn = '';
        if ($this->state == 1) {
            $btn = '<span class="text-success">ใช้งาน</span>';
        }else {
            $btn = '<span class="text-danger">ปิดใช้งาน</span>';
        }

        return $btn;

  	}
}
