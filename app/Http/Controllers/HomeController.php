<?php

namespace App\Http\Controllers;

use App\Models\CoverImage;
use App\Models\Demand;
use App\Models\About;
use App\Models\Service;
use App\Models\Message;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch cover images
        $coverImages = CoverImage::all();

        // Fetch demands
        $demands = Demand::all();

        // Fetch about section
        $about = About::first();

        // Fetch services
        $services = Service::all();

        // Fetch testimonials
        $testimonials = Testimonial::all();

        // Fetch Messages
        $messages = Message::all();

        // Pass data to view
        return view('home', compact('coverImages', 'demands', 'about', 'services', 'testimonials', 'messages'));
    }
}
