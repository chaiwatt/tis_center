<?php

namespace App\Mail\CB;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CBRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    { 
   
        $this->certi_cb = $item['certi_cb'];
  
        $this->url = $item['url'];
        $this->email = $item['email'];
        $this->email_cc = $item['email_cc'];
        $this->email_reply = $item['email_reply'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from( config('mail.from.address'), (!empty($this->email)  ? $this->email : config('mail.from.name')) )
                    ->cc($this->email_cc)
                    ->replyTo($this->email_reply)
                    ->subject('รับคำขอรับบริการ')
                    ->view('mail/CB.request')
                    ->with([
                              'certi_cb' => $this->certi_cb,
                              'url' => $this->url
                         ]);
    }
}
