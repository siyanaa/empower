<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\VisitorBook;
use Illuminate\Http\Request;
use App\Models\StudentDetail;
use App\Models\BlogPostsCategory;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // return view('backend.index');
        $studentCount = StudentDetail::count();
        $visitorCount = VisitorBook::count();
        $blogPostCount = BlogPostsCategory::count();
        $contactRequestCount = Contact::count();

        // Pass counts to the view
        return view('backend.index', compact('studentCount', 'visitorCount', 'blogPostCount', 'contactRequestCount'));
    }
}
