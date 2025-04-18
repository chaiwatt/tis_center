<?php

namespace App\Mail\Lab;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LABAssignStaffMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    { 
        $this->app = $item['app'];
        $this->email = $item['email'];
        $this->reg_fname = $item['reg_fname'];
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
   
        return $this->from( config('mail.from.address'), (!empty($this->email)  ? $this->email : config('mail.from.name')) )
                        ->subject('ขอให้ตรวจสอบคำขอรับบริการยืนยันความสามารถห้องปฏิบัติการ')
                        ->view('mail.Lab.assign_staff')
                        ->with([
                              'app' => $this->app,
                              'reg_fname' => $this->reg_fname
                            ]);
    }
}
