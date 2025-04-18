<?php

namespace App\Mail\Mail\Law\Cases;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailCasesApprove extends Mailable
{
    use Queueable, SerializesModels;
    private $lawcasesform;
    private $title;
    private $url;
    private $authorize_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    { 
    
        $this->title          = $item['title'];
        $this->url            = $item['url'];
        $this->lawcasesform   = $item['lawcasesform'];
        $this->authorize_name   = $item['authorize_name'];
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from( config('mail.from.address'), config('mail.from.name')) 
                    ->subject($this->title)
                    ->view('mail.Law.Cases.cases-forms-approve')
                    ->with([
                            'url' => $this->url,
                            'lawcasesform' => $this->lawcasesform,
                            'authorize_name' => $this->authorize_name
                        ]);
    }
}
