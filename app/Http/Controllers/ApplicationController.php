<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Http;
class ApplicationController extends Controller
{
    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/u',
            'email' => 'nullable|email|max:255|ends_with:@gmail.com',
            'address' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9\s]+$/u',
            'phone_no' => 'required|string|regex:/^[0-9]+$/|digits:10',
            'whatsapp_no' => 'nullable|string|regex:/^[0-9]+$/|digits:10',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'photo' => 'nullable|image|max:2048',
            'g-recaptcha-response' => 'required'
        ], [
            'name.regex' => 'Only letters and spaces are allowed in the name field.',
            'address.regex' => 'Only letters, numbers, and spaces are allowed in the address field.',
            'phone_no.regex' => 'Phone number should only contain digits.',
            'phone_no.digits' => 'Phone number should be exactly 10 digits.',
            'whatsapp_no.regex' => 'WhatsApp number should only contain digits.',
            'whatsapp_no.digits' => 'WhatsApp number should be exactly 10 digits.',
            'email.ends_with' => 'The email must end with @gmail.com.',
        ]);
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip(),
        ]);
        $recaptchaData = $response->json();
        if (!$recaptchaData['success']) {
            return back()->withErrors(['g-recaptcha-response' => 'ReCAPTCHA validation failed.'])->withInput();
        }
        if ($request->hasFile('cv')) {
            $cv = $request->file('cv');
            $cvName = time().'.'.$cv->getClientOriginalExtension();
            $cv->move(public_path('uploads/cv'), $cvName);
            $cv = 'uploads/cv/' . $cvName;
        } else {
            $cv = null;
        }
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time().'.'.$photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/photos'), $photoName);
            $photo = 'uploads/photos/' . $photoName;
        } else {
            $photo = null;
        }
        $application = new Application();
        $application->demand_id = $id;
        $application->name = $request->input('name');
        $application->email = $request->input('email');
        $application->address = $request->input('address');
        $application->phone_no = $request->input('phone_no');
        $application->whatsapp_no = $request->input('whatsapp_no');
        $application->cv = $cv;
        $application->photo = $photo;
        $application->status = 'pending';
        $application->save();
        return redirect()->route('SingleDemand', ['id' => $id])->with('success', 'Application submitted successfully!');
    }
    public function adminIndex()
{
        $applications = Application::with('demand')->get();
        return view('backend.applications.index', compact('applications'));
    }

    public function accept(Request $request)
{
    $application = Application::findOrFail($request->input('application_id'));
    $application->status = 'accepted';
    $application->save();

    return response()->json(['success' => true, 'status' => 'accepted']);
}

public function reject(Request $request)
{
    $application = Application::findOrFail($request->input('application_id'));
    $application->status = 'rejected';
    $application->save();

    return response()->json(['success' => true, 'status' => 'rejected']);
}
}



