<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(5);
        return view('backend.contact.index', [
            'contacts' => $contacts,
            'page_title' => 'Contact Us'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/u', 
            'email' => 'nullable|email|max:255|ends_with:@gmail.com', 
            'phone_no' => 'required|string|regex:/^[0-9]+$/|digits:10', 
            'message' => 'required|string',
            'g-recaptcha-response' => 'required',
        ], [
            'name.regex' => 'Only letters and spaces are allowed in the name field.',
            'phone_no.regex' => 'Phone number should only contain digits.',
            'phone_no.digits' => 'Phone number should be exactly 10 digits.',
        ]);

        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone_no = $request->phone_no;
        $contact->message = $request->message;
        $contact->save();
        return response()->json(['success' => true]);
    }
}
