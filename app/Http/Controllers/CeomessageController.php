<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CeomessageController extends Controller
{
    public function index()
    {
        $ceomessage = Message::paginate(10);
        return view('backend.ceomessage.index', ['ceomessage' => $ceomessage, 'page_title' => 'CEO Message']);
    }

    public function create()
    {
        return view('backend.ceomessage.create', ['page_title' => 'Create CEO Message']);
    }

    public function store(Request $request)
    {
        try {

              // Check image size before validation
            if ($request->hasFile('image')) {
                $imageSize = $request->file('image')->getSize() / 1024; // Convert to KB
                if ($imageSize > 2048) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Error! Image size cannot exceed 2 MB. Your image is ' . number_format($imageSize, 2) . ' KB.');
                }
            }

            // Log request data for debugging
            Log::info('Request data for store method:', $request->all());

            // Validate request data
            $this->validate($request, [
                'title' => 'required|string',
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            ]);

            // Handle image upload
            $image = $request->file('image');
            if ($image) {
                $newImageName = time() . '-' . $image->getClientOriginalName();
                $image->move(public_path('uploads/message'), $newImageName);
            } else {
                throw new \Exception('Image upload failed.');
            }

            // Create new message
            $message = new Message;
            $message->title = $request->input('title');
            $message->description = $request->input('description');
            $message->image = $newImageName;
            // $message->content = $request->input('content');

            // Log message details before saving
            Log::info('Message details before saving:', $message->toArray());

            // Save message
            if ($message->save()) {
                return redirect()->route('admin.ceomessage.index')->with('success', 'Success! Message created.');
            } else {
                throw new \Exception('Failed to save message.');
            }
        } catch (\Exception $e) {
            // Log the exception details
            Log::error('Message creation failed:', ['exception' => $e]);

            // Return error message
            return redirect()->back()->with('error', 'Error! Something went wrong. ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $message = Message::find($id);
        return view('backend.ceomessage.update', ['message' => $message, 'page_title' => 'Update Message']);
    }

    public function update(Request $request, $id)
    {

        try {
            // Check image size before validation if a new image is being uploaded
            if ($request->hasFile('image')) {
                $imageSize = $request->file('image')->getSize() / 1024; // Convert to KB
                if ($imageSize > 2048) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Error! Image size cannot exceed 2 MB. Your image is ' . number_format($imageSize, 2) . ' KB.');
                }
            }

        // Validate the request data
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
        ]);

            $message = Message::findOrFail($id);

            if ($request->hasFile('image')) {
                // Delete the old image from the server
                if ($message->image && file_exists(public_path('uploads/message/' . $message->image))) {
                    unlink(public_path('uploads/message/' . $message->image));
                }

                // Upload the new image
                $newImageName = time() . '-' . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/message'), $newImageName);
                $message->image = $newImageName;
            }

            // Update the model properties
            $message->title = $request->title;
            $message->description = $request->description;
            // $message->content = $request->content;

            // Save the updated model
            $message->save();

            return redirect()->route('admin.ceomessage.index')->with('success', 'Success! Message Updated');
        } catch (\Exception $e) {
            // Optionally log the error
            Log::error('Message update failed: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Error! Something went wrong. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $message = Message::find($id);

        if ($message) {
            $message->delete();
            return redirect()->route('admin.ceomessage.index')->with('success', 'Success! Message Deleted');
        } else {
            return redirect()->route('admin.ceomessage.index')->with('error', 'Message not found.');
        }
    }

    public function showCeoMessage()
    {
        $message = Message::first(); // Fetch the CEO message
        return view('frontend.index', compact('message'));
    }
    
}
