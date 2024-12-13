<?php

namespace App\Http\Controllers;

use App\Models\VisitorBook;
use App\Models\Country;
use Illuminate\Http\Request;

class VisitorBookController extends Controller
{
    public function index()
    {
        $visitorBooks = VisitorBook::with('country')->latest()->paginate(5);
        return view('backend.visitorbook.index', ['visitorBooks' => $visitorBooks, 'page_title' => 'Visitor Books']);
    }

    public function create()
    {
        $countries = Country::all();
        return view('backend.visitorbook.create', ['countries' => $countries, 'page_title' => 'Create Visitor Books']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone_no' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'country_id' => 'required|exists:countries,id',
            'description' => 'nullable|string',
        ]);
        try {
            $visitorBook = new VisitorBook;
            $visitorBook->name = $request->name;
            $visitorBook->phone_no = $request->phone_no;
            $visitorBook->email = $request->email;
            $visitorBook->country_id = $request->country_id;
            $visitorBook->description = $request->description;

            if ($visitorBook->save()) {
                return redirect()->route('admin.visitors-book.index')->with('success', 'Success! visitors book created.');
            } else {
                return redirect()->back()->with('error', 'Error! visitors book  not created.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error! Something went wrong.');
        }
    }

    public function edit($id)
    {
        $visitorBook = VisitorBook::findOrFail($id);
        $countries = Country::all();
        return view('backend.visitorbook.update', ['visitorBook' => $visitorBook, 'countries' => $countries, 'page_title' => 'Edit Visitor Book']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'phone_no' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'country_id' => 'required|exists:countries,id',
            'description' => 'nullable|string',
        ]);

        try {
            $visitorBook = VisitorBook::findOrFail($id);
            $visitorBook->update([
                'name' => $request->name,
                'phone_no' => $request->phone_no,
                'email' => $request->email,
                'country_id' => $request->country_id,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.visitors-book.index')->with('success', 'Success! Visitor book updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error! Something went wrong.');
        }
    }
    public function destroy($id)
    {
        try {
            $visitorBook = VisitorBook::findOrFail($id);
            $visitorBook->delete();
            return redirect()->route('admin.visitors-book.index')->with('success', 'Success! Visitor book deleted.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error! Something went wrong.');
        }
    }
}
