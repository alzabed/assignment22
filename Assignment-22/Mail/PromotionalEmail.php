<?php

// app/Mail/PromotionalEmail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Mail\PromotionalEmail;
use Illuminate\Support\Facades\Mail;


class PromotionalEmail extends Mailable
{
    use Queueable, SerializesModels;

    // Define any public properties that you want to pass to the email view.
    public $subject;
    public $content;

    public function __construct($subject, $content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->markdown('emails.promotional', ['content' => $this->content]);
    }
}


public function sendPromotionalEmail(Request $request)
{
    // Validate the request data for the email details (subject and content).
    $validatedData = $request->validate([
        'subject' => 'required|string',
        'content' => 'required|string',
    ]);

    // Get the list of email addresses from the customers in the database.
    $emailList = Customer::pluck('email')->toArray();

    // Send the promotional email to all customers.
    Mail::to($emailList)->send(new PromotionalEmail($validatedData['subject'], $validatedData['content']));

    return redirect()->back()->with('success', 'Promotional email sent successfully!');
}
