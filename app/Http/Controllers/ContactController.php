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
            'subject' => $request->input('subject', 'Contact Form Submission'),
        ];

        try {
            Mail::to('support@localevents.com')->send(new ContactMessage($data));
            return response()->json(['message' => 'Thank you for contacting us! We will get back to you soon.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Sorry, something went wrong. Please try again later.'], 500);
        }
    }
}
