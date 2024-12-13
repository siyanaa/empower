<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Team;
use App\Models\About;
// use App\Models\Service;

use App\Models\Course;
use App\Models\Demand;
use App\Models\Contact;
use App\Models\Country;
use App\Models\Service;
use App\Models\Category;
use App\Models\CoverImage;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use App\Models\BlogPostsCategory;
use App\Models\Client;
use App\Models\ClientMessage;
use App\Models\Message;
use Carbon\Carbon;

class FrontViewController extends Controller
{
    public function index()
    {

        
        $sitesetting = SiteSetting::first();
        $teams= Team::first();
        $about = About::first();
        $services = Service::latest()->get()->take(6);
        $contacts = Contact::latest()->get();
        $blogs = BlogPostsCategory::latest()->get()->take(3);
        $testimonials = Testimonial::latest()->get()->take(10);
        $coverImages = CoverImage::all();
        $demands = Demand::with('country')->latest()->get();
        $message = Message::latest()->first();
        $firstCategory = Category::first();
        $posts = $firstCategory->posts()->latest()->take(6)->get();
        $clients = Client::latest()->get();
        $clientMessages = ClientMessage::latest()->get();
        $latestVacancies = Demand::where('to_date', '>=', Carbon::today())->get();
    
        return view('frontend.index', compact([
            'services',
            'contacts',
            'teams',
            'blogs',
            'sitesetting',
            'testimonials',
            'coverImages',
            'message',
            'clients',
            'demands',
            'about',
            'posts',
            'firstCategory',
            'clientMessages',
            'latestVacancies'
        ]));
    }
}
