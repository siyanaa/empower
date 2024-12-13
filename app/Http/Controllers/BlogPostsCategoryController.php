<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\BlogPostsCategory;
use App\Models\SummernoteContent;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BlogPostsCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogPostsCategory::latest()->paginate(20);
        $summernoteContent = new SummernoteContent();
        return view('backend.blog_posts_category.index', ['categories' => $categories, 'summernoteContent' => $summernoteContent, 'page_title' => 'Blog Post Category']);
    }


    public function create()
    {

        $summernoteContent = new SummernoteContent();
        return view('backend.blog_posts_category.create', ['summernoteContent' => $summernoteContent, 'page_title' => 'Blog Post Category']);
    }

    public function store(Request $request)
    {
        try {
            // Check image size before validation
            if ($request->hasFile('image')) {
                $imageSize = $request->file('image')->getSize() / 1024; // Convert to KB
                if ($imageSize > 2048) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Error! Image size cannot exceed 2 MB. Your image is ' . number_format($imageSize, 2) . ' KB.');
                }
            }
            
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $newImageName = time() . '-' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/blogpostcategory'), $newImageName);

            $summernoteContent = new SummernoteContent();
            $processedContent = $summernoteContent->processContent($request->input('content'));

            $category = new BlogPostsCategory();
            $category->title = $request->title;
            $category->slug = SlugService::createSlug(BlogPostsCategory::class, 'slug', $request->input('title'));
            $category->content = $processedContent;
            $category->image = $newImageName;

            if ($category->save()) {
                return redirect()->route('admin.blog-posts-categories.index')->with('success', 'Blog Post Category created successfully.');
            } else {
                return redirect()->back()->with('error', 'Error! Blog Post Category not created.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error! ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $blogPostsCategory = BlogPostsCategory::find($id);
        return view('backend.blog_posts_category.update', compact('blogPostsCategory'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Check image size before validation if a new image is being uploaded
            if ($request->hasFile('image')) {
                $imageSize = $request->file('image')->getSize() / 1024; // Convert to KB
                if ($imageSize > 2048) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Error! Image size cannot exceed 2 MB. Your image is ' . number_format($imageSize, 2) . ' KB.');
                }
            }

            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $message = BlogPostsCategory::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($message->image && file_exists(public_path('uploads/blogpostcategory/' . $message->image))) {
                    unlink(public_path('uploads/blogpostcategory/' . $message->image));
                }

                $newImageName = time() . '-' . $request->image->getClientOriginalName();
                $request->image->move(public_path('uploads/blogpostcategory/'), $newImageName);
                $message->image = $newImageName;
            }

            $summernoteContent = new SummernoteContent();
            $processedContent = $summernoteContent->processContent($request->input('content'));

            $message->title = $request->input('title');
            $message->content = $processedContent;
            $message->slug = SlugService::createSlug(BlogPostsCategory::class, 'slug', $request->input('title'), ['unique' => false, 'source' => 'title', 'onUpdate' => true], $id);

            $message->save();

            return redirect()->route('admin.blog-posts-categories.index')->with('success', 'Blog Post updated successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error updating director message: ' . $e->getMessage());
        }
    }


    public function destroy(BlogPostsCategory $blogPostsCategory)
    {
        $blogPostsCategory->delete();
        return redirect()->route('admin.blog-posts-categories.index')->with('success', 'Blog Post Category deleted successfully.');
    }
}
