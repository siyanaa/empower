<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Log;


class AboutController extends Controller
{
    public function index()
    {
        $abouts = About::paginate(10);
        return view('backend.about.index', ['abouts' => $abouts, 'page_title' => 'About Us']);


    }
    public function create()
    {
        return view('backend.about.create', ['page_title' => 'Create About Us']);

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

            $this->validate($request, [
                'title' => 'required|string',
                'subtitle' => 'nullable|string',
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1536',
                // 'description_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:1536',
                'content' => 'required|string',
                // 'scope' => 'nullable|string',
            ]);
    
            $newImageName = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/about'), $newImageName);
    
            // $newDescriptionImageName = null;
            // if ($request->hasFile('description_image')) {
            //     $newDescriptionImageName = time() . '-' . $request->description_image->getClientOriginalName();
            //     $request->description_image->move(public_path('uploads/about'), $newDescriptionImageName);
            // }
    
            $about = new About;
            $about->title = $request->title;
            $about->subtitle = $request->subtitle ?? '';
            $about->description = $request->description;
            $about->slug = SlugService::createSlug(About::class, 'slug', $request->title);
            $about->image = $newImageName;
            $about->content = $request->content;
            // $about->scope = $request->scope;
         
    
            if ($about->save()) {
                return redirect()->route('admin.about-us.index')->with('success', 'Success! About us created.');
            } else {
                return redirect()->back()->with('error', 'Error! About us not created.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error! Something went wrong.');
        }
    }

    public function edit($id)
    {
        $about = About::find($id);
        return view('backend.about.update', ['about' => $about, 'page_title' => 'Update About Us']);

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

            $request->validate([
                'title' => 'required|string',
                'subtitle' => 'nullable|string',
                'description' => 'required|string',
                'image' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1536',
                'content' => 'required|string',
            ]);

            $about = About::findOrFail($id);

            if ($request->hasFile('image')) {
                // Delete the old image from the server
                if ($about->image && file_exists(public_path('uploads/about/' . $about->image))) {
                    unlink(public_path('uploads/about/' . $about->image));
                }

                // Upload the new image
                $newImageName = time() . '-' . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/about'), $newImageName);
                $about->image = $newImageName;
            }

            // Update the model properties
            $about->title = $request->title;
            $about->subtitle = $request->subtitle ?? '';
            $about->description = $request->description;
            $about->slug = SlugService::createSlug(About::class, 'slug', $request->title);
            $about->content = $request->content;

            // Save the updated model
            $about->save();

            return redirect()->route('admin.about-us.index')->with('success', 'Success !! About Updated');
        } catch (\Exception $e) {
            Log::error('About update failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error !! Something went wrong. ' . $e->getMessage());
        }
    
}


    public function destroy($id)
    {
        $about = About::find($id);

        if ($about) {
            $about->delete();
            return redirect()->route('admin.about-us.index')->with('success', 'Success !! About us Deleted');
        } else {
            return redirect()->route('admin.about-us.index')->with('error', 'About us not found.');
        }
    }
}