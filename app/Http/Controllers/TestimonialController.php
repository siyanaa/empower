<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\WorkCategory;

class TestimonialController extends Controller
{
    public function index()
    {

        $testimonials = Testimonial::with(['company', 'work_category'])->latest()->paginate(10);

        return view('backend.testimonial.index', ['testimonials' => $testimonials, 'page_title' => 'Testimonials']);
    }

    public function create()
    {
        $companies = Company::all();
        $work_categories = WorkCategory::all();
        return view('backend.testimonial.create', ['companies' => $companies, 'work_categories' => $work_categories, 'page_title' => 'Testimonials']);
    }

    public function store(Request $request)
    {

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
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'work_category_id' => 'required|exists:work_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,avif,webp,avi|max:2048',
            'description' => 'required|string',
        ]);

        try {
            $newImageName = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/testimonial'), $newImageName);

            $testimonial = new Testimonial();
            $testimonial->name = $request->name;
            $testimonial->company_id = $request->company_id;
            $testimonial->work_category_id = $request->work_category_id;
            $testimonial->image = $newImageName;
            $testimonial->description = $request->description;
            $testimonial->save();
            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'An error occurred while creating testimonial: ' . $e->getMessage());
        }
    }

    // Inside TestimonialController

    public function edit($id)
    {
        $testimonials = Testimonial::find($id);
        if (!$testimonials) {
            return redirect()->route('admin.testimonials.index')->with('error', 'Testimonial not found.');
        }

        $companies = Company::all();
        $work_categories = WorkCategory::all();
        return view('backend.testimonial.update', [
            'testimonials' => $testimonials,
            'companies' => $companies,
            'work_categories' => $work_categories,
            'page_title' => 'Update Testimonial'
        ]);
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

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'work_category_id' => 'required|exists:work_categories,id',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,avif,webp|nullable|max:2048',
            'description' => 'required|string',
        ]);

            $testimonial = Testimonial::find($id);
            if (!$testimonial) {
                return back()->with('error', 'Testimonial not found.');
            }

            // Check if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete the old image from the server if it exists
                if ($testimonial->image && file_exists(public_path('uploads/testimonial/' . $testimonial->image))) {
                    unlink(public_path('uploads/testimonial/' . $testimonial->image));
                }

                // Upload the new image
                $newImageName = time() . '-' . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/testimonial'), $newImageName);
                $testimonial->image = $newImageName;
            }

            // Update the testimonial with the new data
            $testimonial->name = $request->name;
            $testimonial->company_id = $request->company_id;
            $testimonial->work_category_id = $request->work_category_id;
            $testimonial->description = $request->description;
            $testimonial->save();

            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'An error occurred while updating the Testimonial: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $testimonials = Testimonial::find($id);
            if (!$testimonials) {
                return back()->with('error', 'Testimonial not found.');
            }

            $testimonials->delete();
            return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while deleting Testimonial: ' . $e->getMessage());
        }
    }



}
