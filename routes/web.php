<?php

use App\Models\DirectorMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WorkCategoryController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SingleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FaviconController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontViewController;
use App\Http\Controllers\CoverImageController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SiteSettingController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\VisitorBookController;
use App\Http\Controllers\PhotoGalleryController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\VideoGalleryController;
use App\Http\Controllers\StudentDetailController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ClientMessageController;
use App\Http\Controllers\BlogPostsCategoryController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CeoMessageController;
use App\Http\Controllers\ClientController;
use App\Models\ClientMessage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/lang/{lang}',function ($lang){
//     app()->setLocale($lang);
//     session()->put('locale',$lang);
//     return redirect()->route('fronted.index');
// });


Route::get('/lang/{lang}', function ($lang) {
    // Validate the provided locale
    $supportedLocales = config('app.available_locales');
    if (!in_array($lang, array_keys($supportedLocales))) {
        // Invalid locale provided, handle error (e.g., redirect to default locale)
        return redirect()->route('fronted.index'); // Redirect to homepage
    }

    // Set the application locale
    app()->setLocale($lang);

    // Store the locale in the session
    session()->put('locale', $lang);

    // Redirect to the homepage or landing page
    return redirect()->route('fronted.index');
});






// Frontend routes

Route::get('/', [FrontViewController::class, 'index'])->name('index');
Route::get('/singleposts/{slug}', [FrontViewController::class, 'singlePost'])->name('SinglePost');
Route::post('/contactpage', [ContactController::class, 'store'])->name('Contact.store');

//Routes for SingleController
Route::prefix('/')->group(function () {
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/contactpage', [SingleController::class, 'render_contact'])->name('Contact');
    Route::get('/aboutus', [SingleController::class, 'render_about'])->name('About');
    Route::get('/testimonial', [SingleController::class, 'render_testimonial'])->name('Testimonial');
    Route::get('/blogpostcategories', [SingleController::class, 'render_blogpostcategory'])->name('Blogpostcategory');
    Route::get('/blogpostcategory/{slug}', [SingleController::class, 'render_singleBlogpostcategory'])->name('SingleBlogpostcategory');
    Route::get('/team', [SingleController::class, 'render_team'])->name('Team');
    Route::get('/services', [SingleController::class, 'render_service'])->name('Service');
    Route::get('/singleservice/{slug}', [SingleController::class, 'render_singleService'])->name('SingleService');
    Route::get('/demands', [SingleController::class, 'render_demands'])->name('Demand');
    Route::get('/apply/{id}', [SingleController::class, 'showApplicationForm'])->name('apply');
    Route::post('/apply/{id}', [SingleController::class, 'submitApplication'])->name('submitApplication');


    Route::get('/singledemand/{id}', [SingleController::class, 'render_demand'])->name('SingleDemand');
    Route::get('/gallery', [SingleController::class, 'render_gallery'])->name('Gallery');
    Route::get('/video', [SingleController::class, 'render_videos'])->name('Video');
    Route::get('/countries', [SingleController::class, 'render_Countries'])->name('Countries');
    Route::get('/singlecountry/{slug}', [SingleController::class, 'render_singleCountry'])->name('singleCountry');
    Route::get('/singlecompany/{slug}', [SingleController::class, 'singleCompany'])->name('singleCompany');
    Route::get('/singleworkcategory/{slug}', [SingleController::class, 'render_singleworkCategory'])->name('singleworkCategory');
    Route::get('/singlecategory/{slug}', [SingleController::class, 'render_singleCategory'])->name('singleCategory');
    Route::get('/singlepost/{slug}', [SingleController::class, 'render_singlePost'])->name('singlePost');
    Route::get('/gallerys/{slug}', [SingleController::class, 'render_singleImage'])->name('singleImage');

    // Route::get('/ceo-message', [CeomessageController::class, 'showCeoMessage'])->name('ceo.message');

});

// Authentication routes
Auth::routes();
Route::post('/change-password', [ResetPasswordController::class, 'updatePassword'])->name('changePassword')->middleware('auth');

// Backend routes with prefix and middleware
Route::prefix('/admin')->name('admin.')->middleware(['web', 'auth'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Site settings
    Route::resource('site-settings', SiteSettingController::class);

    // Cover images
    // Route::resource('cover-images', CoverImageController::class);

    // Route::get('cover-images', [CoverImageController::class,'create'])->name('cover-images');
    Route::resource('cover-images', CoverImageController::class);

    // About us
    Route::resource('about-us', AboutController::class);

    // CEO Message
    Route::resource('ceomessage', CeoMessageController::class);

    // Client
    Route::resource('client', ClientController::class);


    // Services
    Route::resource('services', ServiceController::class);

    // Categories
    Route::resource('categories', CategoryController::class);

    // Posts
    Route::resource('posts', PostController::class);

    // Photo galleries
    Route::resource('photo-galleries', PhotoGalleryController::class);

    // Video galleries
    Route::resource('video-galleries', VideoGalleryController::class);

    // Testimonials
    Route::resource('testimonials', TestimonialController::class);

    // Visitor books
    Route::resource('visitors-book', VisitorBookController::class);

    // Blog posts categories
    Route::resource('blog-posts-categories', BlogPostsCategoryController::class);

    // Courses
    Route::resource('work_categories', WorkCategoryController::class);

    // Teams
    Route::resource('teams', TeamController::class);

    // FAQs
    Route::resource('faqs', FaqController::class);

    // Countries
    Route::resource('countries', CountryController::class);

    // companies
    Route::resource('companies', CompanyController::class);

    // Student details
    Route::resource('student-details', StudentDetailController::class);

    // Contact
    Route::resource('contacts', ContactController::class);

    // Favicon controller
    Route::resource('favicons', FaviconController::class);

    //DirectorMessage Controller

    Route::resource('client_messages', ClientMessageController::class);

    // Demands
    Route::resource('demands', DemandController::class);


});

Route::get('/blogs', [FrontViewController::class, 'blogs'])->name('blogs.index');

Route::get('/news', [FrontViewController::class, 'news'])->name('news.index');

Route::get('/courses/{slug}', 'FrontViewController@viewCourse');

Route::post('/apply/{id}', [ApplicationController::class, 'store'])->name('apply.store');
Route::get('/admin/applications', [ApplicationController::class, 'adminIndex'])->name('admin.applications.index');
Route::post('/applications/{id}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
Route::post('/applications/{id}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
Route::post('/applications/{application}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
Route::post('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
Route::post('/applications/{application}/accept', [ApplicationController::class, 'accept'])->name('applications.accept');
Route::post('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');

