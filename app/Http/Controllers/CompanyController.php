<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Company;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CompanyController extends Controller
{
    public function index()
    {
        // $companies = Company::paginate(10);
        $companies = Company::latest()->paginate(5);
        return view('backend.company.index', ['companies' => $companies, 'page_title' => 'Company']);


    }
    public function create()
    {
        $countries = Country::all();
        return view('backend.company.create', ['countries' => $countries, 'page_title' => 'Create Company']);
    }
    public function store(Request $request)
{
    // Validate the incoming request
    // $this->validate($request, [
    //     'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:1536',
    //     'title' => 'required|string|max:255',
    //     'address' => 'required|string|max:255',
    //     'country_id' => 'required|exists:countries,id',
    //     'phone_no' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
    //     'email' => 'nullable|email',
    //     'website' => 'nullable|url',
    // ]);

    try {
        // Handle file upload
        if ($request->hasFile('logo')) {
            $newLogo = time() . '.' . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('uploads/company/'), $newLogo);
        } else {
            $newLogo = "NoImage";
        }

        // Generate slug
        $slug = SlugService::createSlug(Company::class, 'slug', $request->title);

        // Create a new instance of company
        $company = new Company;
        $company ->logo = $newLogo;
        $company ->title = $request->title;
        $company ->address = $request->address;
        $company ->country_id = $request->country_id;
        $company ->slug = $slug; // Assign generated slug
        $company ->phone_no = $request->phone_no;
        $company ->email = $request->email;
        $company ->website = $request->website;

        // Save the company
        if ($company ->save()) {
            return redirect()->route('admin.companies.index')->with('success', 'Success! Company created.');
        } else {
            return redirect()->back()->with('error', 'Error! Company not created.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error! Something went wrong.');
    }
}


    public function edit($id)
    {
        $countries = Country::all();
        $companies = Company::with('country')->find($id);

        if (!$companies) {
            return redirect()->route('admin.companies.index')->with('error', 'Company not found.');
        }

        return view('backend.company.update', ['companies' => $companies, 'countries' => $countries, 'page_title' => 'Update Company']);
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'logo' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:1536',
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'phone_no' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
        ]);

        try {
            $company = Company::find($id);
            if (!$company) {
                return redirect()->back()->with('error', 'Company not found.');
            }

            if ($request->hasFile('logo')) {
                // Assuming you want to replace the old logo
                $newLogo = time() . '.' . $request->logo->getClientOriginalExtension();
                $request->logo->move(public_path('uploads/company/'), $newLogo);
                $company->logo = $newLogo;
            }
            $company->title = $request->title;
            $company->address = $request->address;
            $company->country_id = $request->country_id;
            $company->phone_no = $request->phone_no;
            $company->email = $request->email;
            $company->website = $request->website;

            if ($company->save()) {
                return redirect()->route('admin.companies.index')->with('success', 'Company updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Error! Company not updated.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error! Something went wrong: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $companies = Company::find($id);

        if ($companies) {
            $companies->delete();
            return redirect()->route('admin.companies.index')->with('success', 'Success !! Company Deleted');
        } else {
            return redirect()->route('admin.companies.index')->with('error', 'Company not found.');
        }
    }
}