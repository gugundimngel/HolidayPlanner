<?php

namespace App\Mail;



use Illuminate\Bus\Queueable;



use Illuminate\Mail\Mailable;



use Illuminate\Queue\SerializesModels;



use Illuminate\Contracts\Queue\ShouldQueue;



class HotelTicketMail extends Mailable

{

	use Queueable, SerializesModels;

	

	public $content;

	public $subject;

	public $sender;

	public $array;

	/**

	* Create a new message instance.

	*

	* @return void

	*/

	public function __construct($content, $subject, $sender, $array) {

		$this->content = $content;

		$this->subject = $subject;

		$this->sender = $sender;

		$this->array = $array;

	}

	/**

	* Build the message.

	*

	* @return $this

	*/

	public function build() {
			$fetchedData = $this->content;		
					 
		return $this->from($this->sender, 'holidaychacha')->subject($this->subject)->view('emails.commail', compact(['fetchedData'])) ->attach($this->array['file'],[
                         'as' => $this->array['file_name'],
                         'mime' => 'application/pdf'
                     ]);
		 
	}

}

