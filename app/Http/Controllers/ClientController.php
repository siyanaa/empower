<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    public function index()
    {
        $client = Client::paginate(10);
        return view('backend.client.index', ['client' => $client, 'page_title' => 'Client']);
    }

    public function create()
    {
        return view('backend.client.create', ['page_title' => 'Create Client']);
    }

    public function store(Request $request)
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

            // Log request data for debugging
            Log::info('Request data for store method:', $request->all());

            // Validate request data
            $this->validate($request, [
                'name' => 'required|string',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            ]);

            // Handle image upload
            $image = $request->file('image');
            if ($image) {
                $newImageName = time() . '-' . $image->getClientOriginalName();
                $image->move(public_path('uploads/client'), $newImageName);
            } else {
                throw new \Exception('Image upload failed.');
            }

            // Create new client
            $client= new Client ;
            $client->name= $request->input('name');
            $client->image = $newImageName;
            

            // Log client details before saving
            Log::info('Client details before saving:', $client->toArray());

            // Save client
            if ($client->save()) {
                return redirect()->route('admin.client.index')->with('success', 'Success! Client created.');
            } else {
                throw new \Exception('Failed to save client.');
            }
        } catch (\Exception $e) {
            // Log the exception details
            Log::error('Client creation failed:', ['exception' => $e]);

            // Return error client
            return redirect()->back()->with('error', 'Error! Something went wrong. ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('backend.client.update', ['client' => $client, 'page_title' => 'Update Client']);
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
            'name' => 'required|string',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
        ]);

       
            $client = Client::findOrFail($id);

            if ($request->hasFile('image')) {
                // Delete the old image from the server
                if ($client->image && file_exists(public_path('uploads/client/' . $client->image))) {
                    unlink(public_path('uploads/client/' . $client->image));
                }

                // Upload the new image
                $newImageName = time() . '-' . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/client'), $newImageName);
                $client->image = $newImageName;
            }

            // Update the model properties
            $client->name = $request->name;
           

            // Save the updated model
            $client->save();

            return redirect()->route('admin.client.index')->with('success', 'Success! Client Updated');
        } catch (\Exception $e) {
            // Optionally log the error
            Log::error('Client update failed: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Error! Something went wrong. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $client = Client::find($id);

        if ($client) {
            $client->delete();
            return redirect()->route('admin.client.index')->with('success', 'Success! Client Deleted');
        } else {
            return redirect()->route('admin.client.index')->with('error', 'Client not found.');
        }
    }

    public function showClient()
    {
        $clients = Client::all();
        return view('frontend.index', compact('clients'));
    }
    
}
