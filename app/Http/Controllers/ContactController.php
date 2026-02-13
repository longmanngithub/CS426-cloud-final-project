<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'subject' => 'Contact Form Submission',
        ];

        // Send email to support
        // Note: Configure MAIL_FROM_ADDRESS and MAIL_USERNAME/PASSWORD in .env
        try {
            Mail::to('support@localevents.com')->send(new ContactMessage($data));
            return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, something went wrong. Please try again later.')->withInput();
        }
    }
}
