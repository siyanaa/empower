<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teamMembers = Team::latest()->paginate(5);
        
        // Return the teams to a view for display
        return view('backend.team.index', compact('teamMembers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the view for creating a new team
        return view('backend.team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'phone_no' => 'required',
            'role' => 'nullable',
            'email' => 'nullable|email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('uploads/team'), $imageName);
        } else {
            $imageName = null; 
        }

        $team = new Team();

        $team->name = $request->input('name');
        $team->position = $request->input('position');
        $team->phone_no = $request->input('phone_no');
        $team->role = $request->input('role');
        $team->email = $request->input('email');
        $team->image = $imageName; 

        $team->save();

        return redirect()->route('admin.teams.index')->with('success', 'Team member created successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
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

        // Validate the request data
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'phone_no' => 'required',
            'role' => 'nullable',
            'email' => 'nullable|email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('uploads/team'), $imageName);
        } else {
            $imageName = $team->image; 
        }

        $team->update([
            'name' => $request->input('name'),
            'position' => $request->input('position'),
            'phone_no' => $request->input('phone_no'),
            'role' => $request->input('role'),
            'email' => $request->input('email'),
            'image' => $imageName, 
        ]);

        // Redirect to the team index page with a success message
        return redirect()->route('admin.teams.index')->with('success', 'Team member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        // Delete the team member
        $team->delete();

        // Redirect to the team index page with a success message
        return redirect()->route('admin.teams.index')->with('success', 'Team member deleted successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
{
    // Find the team member by ID
    $teamMember = Team::find($team->id);
    
    // Return the view for editing the team member with the team member data
    return view('backend.team.update', compact('teamMember'));
}
}

