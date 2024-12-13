<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\About;
use App\Models\WorkCategory;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Category;
use App\Models\Service;
use App\Models\StudentDetail;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Models\BlogPostsCategory;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $posts = Post::where('title', 'like', "%$searchTerm%")
            ->orWhere('description', 'like', "%$searchTerm%")
            ->get();

        $abouts = About::where('title', 'like', "%$searchTerm%")
            ->orWhere('description', 'like', "%$searchTerm%")
            ->get();

        $services = Service::where('title', 'like', "%$searchTerm%")
            ->orWhere('description', 'like', "%$searchTerm%")
            ->get();

        $categories = Category::where('title', 'like', "%$searchTerm%")
            ->get();

        $contacts = Contact::where('name', 'like', "%$searchTerm%")
            ->orWhere('email', 'like', "%$searchTerm%")
            ->orWhere('phone_no', 'like', "%$searchTerm%")
            ->orWhere('message', 'like', "%$searchTerm%")
            ->get();

        $countries = Country::where('name', 'like', "%$searchTerm%")
            ->orWhere('content', 'like', "%$searchTerm%")
            ->get();

        $work_categories = WorkCategory::where('title', 'like', "%$searchTerm%")
            ->orWhere('description', 'like', "%$searchTerm%")
            ->get();

        $testimonials = Testimonial::where('name', 'like', "%$searchTerm%")
            ->orWhere('description', 'like', "%$searchTerm%")
            ->get();

        $blogCategories = BlogPostsCategory::where('title', 'like', "%$searchTerm%")
            ->orWhere('content', 'like', "%$searchTerm%")
            ->get();

        $studentDetails = StudentDetail::where('name', 'like', "%$searchTerm%")
            ->get();

        return view('frontend.search-results', compact('posts', 'abouts', 'services', 'categories', 'contacts', 'countries', 'work_categories', 'testimonials', 'blogCategories', 'studentDetails'));
    }
}