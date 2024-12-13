<?php
namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Team;
use App\Models\About;
use App\Models\WorkCategory;
use App\Models\Country;
use App\Models\Service;
use App\Models\Category;
use App\Models\CoverImage;
use App\Models\Company;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\PhotoGallery;
use App\Models\VideoGallery;
use Illuminate\Http\Request;
use App\Models\DirectorMessage;
use App\Models\BlogPostsCategory;
use App\Models\Demand;
use App\Models\ClientMessage;

class SingleController extends Controller
{
    public function render_about()
{
    $about = About::first();
    $teams = Team::all();
    $posts = Post::with('category')->latest()->get()->take(3);
    $listservices = Service::latest()->get()->take(5);
    $message = DirectorMessage::first();
    $siteSetting = SiteSetting::first(); 
    $demands = Demand::latest()->get(); 

    return view('frontend.aboutus', compact('about', 'posts', 'listservices', 'message', 'siteSetting', 'teams', 'demands'));
}

    public function render_team(Request $request)
    {
        $teams = Team::all();
        $page_title = 'Our Team';
        $services = Service::latest()->get()->take(6);
        $sitesetting = SiteSetting::first();
        $categories = Category::latest()->get()->take(10);
        $about = About::first();
        $posts = Post::with('category')->latest()->get()->take(3);
        return view('frontend.team', compact('teams', 'sitesetting', 'categories', 'about', 'page_title', 'services', 'posts'));
    }

    public function render_service()
    {
    
        $images = PhotoGallery::latest()->get();
        $categories = Category::all();
        $services = Service::latest()->get();
        $sitesetting = SiteSetting::first();
        $about = About::first();
        $serviceHead = Service::latest()->get()->take(1);
        $demands = Demand::latest()->get(); 
        return view('frontend.services', compact('images', 'services', 'categories', 'sitesetting', 'about', 'serviceHead','demands'));
    }

    public function render_testimonial()
    {
        $clientMessages = ClientMessage::latest()->get();
        $demands = Demand::latest()->get(); 
        $testimonials = Testimonial::latest()->take(12)->get();
        return view('frontend.testimonials', compact('testimonials','demands','clientMessages'));
    }

    
    public function render_blogpostcategory()
    {
        $demands = Demand::latest()->get(); 
        $blogpostcategories = BlogPostsCategory::all();
        return view('frontend.blogpostcategories', compact('blogpostcategories','demands'));
        return view('frontend.blogpostcategories', compact('blogpostcategories','demands'));
        return view('frontend.blogpostcategories', compact('blogpostcategories','demands'));
    }
    public function render_singleBlogpostcategory($slug)
    {
        $demands = Demand::latest()->get(); 
        $blogpostcategory = BlogPostsCategory::where('slug', $slug)->firstOrFail();
        $listblogs = BlogPostsCategory::where('slug', '!=', $slug)->latest()->get()->take(5);
        return view('frontend.blogpostcategory', compact('blogpostcategory', 'listblogs','demands'));
        return view('frontend.blogpostcategory', compact('blogpostcategory', 'listblogs','demands'));
        return view('frontend.blogpostcategory', compact('blogpostcategory', 'listblogs','demands'));
    }
    public function render_singleService($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        $images = PhotoGallery::latest()->get();
        $categories = Category::all();
        $services = Service::latest()->get();
        $sitesetting = SiteSetting::first();
        $about = About::first();
        $listservices = Service::where('slug', '!=', $slug)->get();
        $demands = Demand::latest()->get(); 
        return view('frontend.service', compact('service', 'images', 'services', 'categories', 'sitesetting', 'about', 'listservices','demands'));
    }
    public function render_Countries()
    {
        $countries = Country::all();
        return view('frontend.countries', compact('countries'));
    }

    public function render_singleCountry($slug)
    {
        $country = Country::where('slug', $slug)->firstOrFail();
        $recommendedCountries = Country::where('slug', '!=', $slug)->get();
        // $countries = Country::all();
        return view('frontend.single', compact('country', 'recommendedCountries'));
    }
    public function render_singleCompany($slug)
    {
        $company = Company::where('slug', $slug)->firstOrFail();
        return view('frontend.company', compact('company'));
    }
    public function render_singleworkCategory($slug)
    {
        $work_category = WorkCategory::where('slug', $slug)->firstOrFail();
        $listwork_category = WorkCategory::latest()->get()->take(4);
        return view('frontend.work_category', compact('work_category', 'listwork_category'));
    }

    public function render_singleCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $relatedCategories = Category::where('id', '!=', $category->id)->get();
        $posts = $category->posts()->paginate(10);
        return view('frontend.category', compact('category', 'relatedCategories', 'posts'));
    }
    public function render_singlePost($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        // Get the category associated with the post
        $category = $post->category;
        // Get all posts related to the same category
        $relatedPosts = $category->posts()->where('id', '!=', $post->id)->get();
        return view('frontend.post', compact('post', 'relatedPosts'));
    }

    public function render_gallery()
    {
        $demands = Demand::latest()->get(); 
        $images = PhotoGallery::latest()->get();
        $categories = Category::all();
        $services = Service::latest()->get();
        $sitesetting = SiteSetting::first();
        $about = About::first();
        return view('frontend.galleries', compact('images', 'services', 'categories', 'sitesetting', 'about','demands'));
        return view('frontend.galleries', compact('images', 'services', 'categories', 'sitesetting', 'about','demands'));
        return view('frontend.galleries', compact('images', 'services', 'categories', 'sitesetting', 'about','demands'));
    }
    public function render_singleImage($slug)
    {
        $demands = Demand::latest()->get(); 
        $image = PhotoGallery::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        $services = Service::latest()->get();
        $sitesetting = SiteSetting::first();
        $about = About::first();
        return view('frontend.singleImage', compact('image', 'services', 'categories', 'sitesetting', 'about','demands'));
        return view('frontend.singleImage', compact('image', 'services', 'categories', 'sitesetting', 'about','demands'));
        return view('frontend.singleImage', compact('image', 'services', 'categories', 'sitesetting', 'about','demands'));
    }

    public function render_videos()
{
    $demands = Demand::latest()->get(); 
    $videos = VideoGallery::latest()->get();
    $videos = $videos->map(function($video) {
        $video->embed_url = 'https://www.youtube.com/embed/' . $video->url;
        return $video;
    });
    $videos = $videos->map(function($video) {
        $video->embed_url = 'https://www.youtube.com/embed/' . $video->url;
        return $video;
    });
    $categories = Category::all();
    $services = Service::latest()->get();
    $sitesetting = SiteSetting::first();
    $about = About::first();
    return view('frontend.video', compact('videos', 'services', 'categories', 'sitesetting', 'about','demands'));
    return view('frontend.video', compact('videos', 'services', 'categories', 'sitesetting', 'about','demands'));
}

    public function teams()
    {
        $teams = Team::latest()->get();
        $categories = Category::all();
        $services = Service::latest()->get();
        $sitesetting = SiteSetting::first();
        $about = About::first();
        return view('portal.team', compact('teams', 'services', 'categories', 'sitesetting', 'about'));
    }
    public function render_contact()
    {
        $demands = Demand::latest()->get(); 
        $page_title = 'Contact Us';
        $googleMapsLink = SiteSetting::first()->google_maps_link;
        return view('frontend.contactpage', compact('page_title', 'googleMapsLink','demands'));
        return view('frontend.contactpage', compact('page_title', 'googleMapsLink','demands'));
        return view('frontend.contactpage', compact('page_title', 'googleMapsLink','demands'));
    }
    public function render_demand($id)
    {
        $demand = Demand::where('id', $id)->firstOrFail();
        $demands = Demand::latest()->get(); 
        $listdemands = Demand::where('id', '!=', $id)->get();
        return view('frontend.demand', compact('demand','listdemands','demands'));
        return view('frontend.demand', compact('demand','listdemands','demands'));
    }
    
    
    public function render_demands()
    {
        $demands = Demand::latest()->get();
        return view('frontend.demands', compact('demands'));
    }
    public function showApplicationForm($id)
    {
        $demand = Demand::findOrFail($id);
        $demands = Demand::latest()->get(); 
        return view('frontend.apply', compact('demand','demands'));
    }
}

