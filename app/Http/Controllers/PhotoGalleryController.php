<?php

namespace App\Http\Controllers;

use App\Models\PhotoGallery;
use Illuminate\Http\Request;

use App\Models\ImageConverter;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use Cviebrock\EloquentSluggable\Services\SlugService;

class PhotoGalleryController extends Controller
{
    public function index()
    {
        $gallery = PhotoGallery::latest()->paginate(5);
        return view('backend.photogallery.index', ['gallery' => $gallery, 'page_title' => 'Photo Gallery']);
    }

    public function create()
    {
        return view('backend.photogallery.create', ['page_title' => 'Create Photo Gallery']);
    }

    public function store(Request $request)
    {
        try{

         // Check image size before validation if a new image is being uploaded
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
            'img_desc' => 'nullable|string',
            'img' => 'required|array',
            'img.*' => 'required|image|mimes:jpeg,png,jpg,gif,avif,webp,avi|max:2048' 
        ]);

            $gallery = new PhotoGallery;
            $gallery->title = $request->title;
            $gallery->img_desc = $request->img_desc;
            $gallery->slug = SlugService::createSlug(PhotoGallery::class, 'slug', $request->title);

            $convertedImages = [];
            foreach ($request->file('img') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/photogallery/'), $imageName);
                $convertedImages[] = 'uploads/photogallery/' . $imageName;
            }

            $gallery->img = $convertedImages;
            $gallery->save();
            
            return redirect()->route('admin.photo-galleries.index')->with(['success' => 'Success!! Gallery Created']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Error creating gallery. Please try again.']);
        }
    }

    public function edit($id)
    {
        $gallery = PhotoGallery::find($id);
        return view('backend.photogallery.update', ['gallery' => $gallery, 'page_title' => 'Update Photo Gallery']);
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

    $this->validate($request, [
        'title' => 'required|string',
        'img_desc' => 'nullable|string',
        'img' => 'nullable|array',
        'img.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif,webp,avi|max:2048',
        'existing_images' => 'nullable|array'
    ]);

        $gallery = PhotoGallery::findOrFail($id);
        $gallery->title = $request->title;
        $gallery->img_desc = $request->img_desc;
        $gallery->slug = SlugService::createSlug(PhotoGallery::class, 'slug', $request->title);

        // Get the existing images that were not removed
        $existingImages = $request->input('existing_images', []);

        // Handle new image uploads
        if ($request->hasFile('img')) {
            foreach ($request->file('img') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/photogallery/'), $imageName);
                $existingImages[] = 'uploads/photogallery/' . $imageName;
            }
        }

        // Remove old images that are no longer in the existing images array
        $oldImages = $gallery->img ?? [];
        foreach ($oldImages as $oldImage) {
            if (!in_array($oldImage, $existingImages)) {
                // Delete the physical file
                $fullPath = public_path($oldImage);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            }
        }

        // Update gallery with new image array
        $gallery->img = $existingImages;
        $gallery->save();

        return redirect()->route('admin.photo-galleries.index')->with(['success' => 'Success!! Gallery Updated']);
    } catch (\Exception $e) {
        return redirect()->back()->with(['error' => 'Error updating gallery: ' . $e->getMessage()]);
    }
}

    public function destroy($id)
    {
        $gallery = PhotoGallery::find($id);
        if ($gallery) {
            foreach ($gallery->img as $image) {
                File::delete(public_path($image));
            }
            $gallery->delete();
            return redirect()->route('admin.photo-galleries.index')->with('success', 'Success !! Photo Gallery Deleted');
        } else {
            return redirect()->route('admin.photo-galleries.index')->with('error', 'Photo Gallery not found.');
        }
    }
}
