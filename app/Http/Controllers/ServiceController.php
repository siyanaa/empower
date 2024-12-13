<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SummernoteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(5);
        $summernoteContent = new SummernoteContent();
        return view('backend.services.index', ['services' => $services, 'summernoteContent' => $summernoteContent, 'page_title' => 'Services']);
    }


    public function create()
    {
        return view('backend.services.create', ['page_title' => 'Add Services']);

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

            $this->validate($request, [
                'title' => 'required|string',
                'keywords' => 'nullable|string',
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
                'description' => 'required|string',
            ]);
    
            $newImageName = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/service'), $newImageName);
    
            // Process only the description with Summernote
            $summernoteContent = new SummernoteContent();
            $processedDescription = $summernoteContent->processContent($request->description);
    
            $service = new Service;
            $service->title = $request->title;
            $service->keywords = $request->keywords; // No processing needed
            $service->slug = SlugService::createSlug(Service::class, 'slug', $request->title);
            $service->image = $newImageName;
            $service->description = $processedDescription;
    
            if ($service->save()) {
                return redirect()->route('admin.services.index')->with('success', 'Success! Service created.');
            } else {
                return redirect()->back()->with('error', 'Error! Service not created.');
            }
        } catch (\Exception $e) {
            Log::error('Error storing service: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error! Something went wrong.');
        }
    }

    public function edit($id)
    {
        $service = Service::find($id);

        return view('backend.services.update', ['service' => $service, 'page_title' => 'Update Services']);

    }

    public function update(Request $request, $id)
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

        $validate = $request->validate([
            'title' => 'required|string',
            'keywords' => 'nullable|string',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            'description' => 'required|string',

        ]);

            $service = Service::find($request->id);

            if ($request->hasFile('image')) {
                if ($service->image && file_exists(public_path('uploads/service/' . $service->image))) {
                    unlink(public_path('uploads/service/' . $service->image));
                }

                // Upload the new image
                $newImageName = time() . '-' . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/service'), $newImageName);
                $service->image = $newImageName;
            }

            $service->title = $request->title;
            $service->keywords = $request->keywords;
            $service->description = $request->description;
            $service->slug = SlugService::createSlug(Service::class, 'slug', $request->title);

            // $project->type = $request->type;

            $service->save();

            return redirect()->route('admin.services.index')->with('success', 'Success !! Services Updated');
        } catch (\Exception $e) {
            // Optionally log the error
            Log::error('Services update failed: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Error !! Something went wrong. ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $service = Service::find($id);

        if ($service) {
            $service->delete();
            return redirect()->route('admin.services.index')->with('success', 'Success !! Service Deleted');
        } else {
            return redirect()->route('admin.service.index')->with('error', 'Service not found.');
        }
    }
    private function processServices($services)
    {
        foreach ($services as $service) {
            $service->processedContent = preg_replace('/<p>(.*?)<iframe\b[^>]*>.*?<\/iframe>(.*?)<\/p>/is', '$1$2', $service->summernoteContent);
        }
        return $services;
    
}
}