<?php

// app/Http/Controllers/PromotionalEmailController.php

namespace App\Http\Controllers;

use App\Mail\PromotionalEmail;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PromotionalEmailController extends Controller
{
    public function showForm()
    {
        return view('emails.send_promotional_email');
    }

    public function sendEmail(Request $request)
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
}
