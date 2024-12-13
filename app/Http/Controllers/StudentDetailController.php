<?php

namespace App\Http\Controllers;

use App\Models\WorkCategory;
use App\Models\Country;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\StudentDetail;

class StudentDetailController extends Controller
{
    public function index()
    {
        $studentDetails = StudentDetail::with(['country', 'company', 'work_category'])->paginate(10);
        return view('backend.studentdetail.index', ['studentDetails' => $studentDetails, 'page_title' => 'Worker Details']);
    }

    public function create()
    {
        $countries = Country::all();
        $companies = Company::all();
        $work_categories = WorkCategory::all();
        return view('backend.studentdetail.create', ['countries' => $countries, 'companies' => $companies, 'work_categories' => $work_categories, 'page_title' => 'Create Worker Details']);
    }
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_no' => 'required',
            'country_id' => 'required|exists:countries,id',
            'company_id' => 'required|exists:companies,id',
            'work_category_id' => 'required|exists:work_categories,id',
            'intake_month_year' => 'required|date',
            'image' => 'nullable|image',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        try {
            $documentPaths = [];

            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $fileName = time() . '-' . uniqid() . '.' . $document->getClientOriginalExtension();
                    $targetDirectory = 'uploads/students_detail/file';
                    $absoluteDirectory = public_path($targetDirectory);
                    if (!file_exists($absoluteDirectory)) {
                        mkdir($absoluteDirectory, 0777, true);
                    }
                    $document->move($absoluteDirectory, $fileName);
                    $documentPaths[] = asset($targetDirectory . '/' . $fileName);
                }
            }


            if ($request->hasFile('image')) {
                $newImage = time() . '.' . $request->image->getClientOriginalName();
                $request->image->move('uploads/students_detail/image/', $newImage);
            } else {
                $newImage = "NoImage";
            }

            $studentdetail = new StudentDetail;
            $studentdetail->image = $newImage;
            $studentdetail->name = $request->name;
            $studentdetail->email = $request->email;
            $studentdetail->phone_no = $request->phone_no;
            $studentdetail->country_id = $request->country_id;
            $studentdetail->company_id = $request->company_id;
            $studentdetail->work_category_id = $request->work_category_id;
            $studentdetail->intake_month_year = $request->intake_month_year;
            $studentdetail->documents = json_encode($documentPaths);

            if ($studentdetail->save()) {
                return redirect()->route('admin.student-details.index')->with('success', 'Success! Student Details created.');
            } else {
                return redirect()->back()->with('error', 'Error! Student Details  not created.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error! Something went wrong.');
        }
    }

    public function edit($id)
    {
        $studentDetail = StudentDetail::findOrFail($id);
        $countries = Country::all();
        $companies = Company::all();
        $work_categories = WorkCategory::all();
        return view('backend.studentdetail.update', [
            'studentDetail' => $studentDetail,
            'countries' => $countries,
            'companies' => $companies,
            'work_categories' => $work_categories,
            'page_title' => 'Edit Worker Details'
        ]);
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone_no' => 'required',
            'country_id' => 'required|exists:countries,id',
            'company_id' => 'required|exists:companies,id',
            'work_category_id' => 'required|exists:work_categories,id',
            'intake_month_year' => 'required|date',
            'image' => 'nullable|image',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $studentDetail = StudentDetail::findOrFail($id);

        try {
            if ($request->hasFile('image')) {
                $oldImage = public_path('uploads/students_detail/image/' . $studentDetail->image);
                if (file_exists($oldImage) && $studentDetail->image != 'NoImage') {
                    unlink($oldImage);
                }

                $newImageName = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('uploads/students_detail/image'), $newImageName);
                $studentDetail->image = $newImageName;
            }

            // Handling document uploads
            // $documentPaths = json_decode($studentDetail->documents, true) ?: [];
            $documentPaths = [];
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $fileName = time() . '-' . uniqid() . '.' . $document->getClientOriginalExtension();
                    $targetDirectory = 'uploads/students_detail/file';
                    $absoluteDirectory = public_path($targetDirectory);
                    if (!file_exists($absoluteDirectory)) {
                        mkdir($absoluteDirectory, 0777, true);
                    }
                    $document->move($absoluteDirectory, $fileName);
                    $documentPaths[] = asset($targetDirectory . '/' . $fileName);
                }
            }
            //clear existing file
            $existingDocuments = json_decode($studentDetail->documents, true);
            if (is_array($existingDocuments)) {
                foreach ($existingDocuments as $existingDocument) {
                    $existingDocumentPath = public_path(str_replace(asset(''), '', $existingDocument));
                    if (file_exists($existingDocumentPath)) {
                        unlink($existingDocumentPath);
                    }
                }
            }
            // Updating student details
            $studentDetail->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_no' => $validated['phone_no'],
                'country_id' => $validated['country_id'],
                'company_id' => $validated['company_id'],
                'work_category_id' => $validated['work_category_id'],
                'intake_month_year' => $validated['intake_month_year'],
                'documents' => json_encode($documentPaths),
                // 'image' is already set above
            ]);

            return redirect()->route('admin.student-details.index')->with('success', 'Worker Details updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating Worker details: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $studentDetail = StudentDetail::findOrFail($id);
            $studentDetail->delete();
            return redirect()->route('admin.student-details.index')->with('success', 'Worker detail deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting Worker detail: ' . $e->getMessage());
        }
    }





}
