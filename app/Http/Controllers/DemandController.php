<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class DemandController extends Controller
{
    public function index()
    {
        $demands = Demand::where('to_date', '>=', now()->toDateString())
            ->latest()
            ->paginate(5);
        $page_title = 'Demands';
        return view('backend.demand.index', compact('demands','page_title'));
    }

    public function create()
    {
        $countries = Country::all();
        
        return view('backend.demand.create', compact('countries'));
    }

    public function store(Request $request)
{
    try {
         if ($request->hasFile('image')) {
            $imageSize = $request->file('image')->getSize() / 1024;
            if ($imageSize > 2048) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Error! Image size cannot exceed 2 MB. Your image is ' . number_format($imageSize, 2) . ' KB.');
            }
        }

        if ($request->hasFile('image')) {
            $newImageName = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/demands'), $newImageName);
        } else {
            return redirect()->back()->with('error', 'No image uploaded. Please upload an image.');
        }
            $demand = new Demand;
            $demand->country_id = $request->country_id;
            $demand->from_date = $request->from_date;
            $demand->to_date = $request->to_date;
            $demand->content = $request->content;
            $demand->vacancy = $request->vacancy;
            $demand->number_of_people_required = $request->number_of_people_required;
            $demand->image = $newImageName; 

            if ($demand->save()) {
                return redirect()->route('admin.demands.index')->with('success', 'Success! Demand created.');
            } else {
                return redirect()->back()->with('error', 'Error! Demand not created.');
            }
      
    } catch (\Exception $e) {
        Log::error('Error creating demand: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error creating demand. Please try again.' . $e->getMessage());
    }




}
public function edit($id)
{
    $demand = Demand::findOrFail($id); 
    $countries = Country::all();

    return view('backend.demand.update', compact('demand', 'countries'));
}

public function update(Request $request, $id)
{
     if ($request->hasFile('image')) {
        $imageSize = $request->file('image')->getSize() / 1024; 
        if ($imageSize > 2048) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error! Image size cannot exceed 2 MB. Your image is ' . number_format($imageSize, 2) . ' KB.');
        }
    }
    
    $request->validate([
        'country_id' => 'required',
        'from_date' => 'required|date',
        'to_date' => 'required|date',
        'vacancy' => 'required',
        'content' => 'required|string',
        'number_of_people_required' => 'required|string',
        'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
    ]);

    $demand = Demand::findOrFail($id);

    $demand->country_id = $request->input('country_id');
    $demand->from_date = $request->input('from_date');
    $demand->to_date = $request->input('to_date');
    $demand->vacancy = $request->input('vacancy');
    $demand->content = $request->input('content');
    $demand->number_of_people_required = $request->input('number_of_people_required');

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads/demands'), $imageName);
        $demand->image = $imageName;
    }

    $demand->save();
    return redirect()->route('admin.demands.index')->with('success', 'Demand updated successfully.');
}

    public function destroy(Demand $demand)
    {
        $demand->delete();

        return redirect()->route('admin.demands.index')->with('success','Demand deleted successfully');
    }
}
