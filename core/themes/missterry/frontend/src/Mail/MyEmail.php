<?php
namespace MissTerryTheme\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data = [];
    public $subject = "";
    public $lang = '';
    public function __construct($subject,$data)
    {
        $this->subject = $subject;
        $this->data = $data;
    }
    public function build()
    {
        $theme = app()->getTheme();
        return $this->view( $theme.'::emails.booking')
            ->from(config('mail.username'),'Missterry')
            ->subject($this->subject)
            ->with($this->data);
    }
}