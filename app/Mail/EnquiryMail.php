<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

use Illuminate\Contracts\Queue\ShouldQueue;

class EnquiryMail extends Mailable
{
	use Queueable, SerializesModels;
	
	public $sender;
	/**
	* Create a new message instance.
	*
	* @return void
	*/
	public function __construct( $sender) {
		$this->sender = $sender;
	}
	/**
	* Build the message.
	*
	* @return $this
	*/
	public function build() {
		return $this->from($this->sender,'Sender')->subject("Package Enquiry")->view('emails.enquiry');
	}
}
