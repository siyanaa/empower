<?php

namespace App\Http\Controllers;

use App\Models\SummernoteContent;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(5);
        $summernoteContent = new SummernoteContent();
        $post = $summernoteContent;
        return view('backend.post.index', compact('posts', 'summernoteContent'));
    }

    public function create()
    {
        $categories = Category::latest()->get(); // Fetch all categories
        return view('backend.post.create', compact('categories'));
    }
    public function store(Request $request)
    {
         // Check image size before validation if a new image is being uploaded
         if ($request->hasFile('image')) {
            $imageSize = $request->file('image')->getSize() / 1024; // Convert to KB
            if ($imageSize > 2048) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Error! Image size cannot exceed 2 MB. Your image is ' . number_format($imageSize, 2) . ' KB.');
            }
        }

        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,avif,webp,avi|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);


        // Move the uploaded image to the desired directory
        $imageName = $request->image->getClientOriginalName();
        $request->image->move(public_path('uploads/post'), $imageName);


        $summernoteContent = new SummernoteContent();
        $processedDescription = $summernoteContent->processContent($request->description);

        // Create a new Post instance and save it to the database
        $post = new Post();
        $post->title = $request->input('title');
        $post->description = $processedDescription;
        $post->image = $imageName; // Store only the filename in the database
        $post->category_id = $request->input('category_id');
        $post->save();



        // Redirect back to the index page with a success message
        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $post = Post::with('category')->find($id);
        return view('backend.post.update', ['categories' => $categories, 'post' => $post, 'page_title' => 'Update Post']);
    }


    public function update(Request $request, $id)
    {

        try{

         // Check image size before validation if a new image is being uploaded
         if ($request->hasFile('image')) {
            $imageSize = $request->file('image')->getSize() / 1024; // Convert to KB
            if ($imageSize > 2048) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Error! Image size cannot exceed 2 MB. Your image is ' . number_format($imageSize, 2) . ' KB.');
            }
        }

        // dd($request);
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,avif,webp,avi|max:2048',
            'category_id' => 'required|exists:categories,id'
        ]);
       
            $post = Post::find($id);
            // Check if a new image has been uploaded
            if ($request->hasFile('image')) {
                // Assuming you want to replace the old logo
                $newImage = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('uploads/post/'), $newImage);
                $post->image = $newImage;
            }
            // Update the image attribute of the post with the new image path
            $post->title = $request->title;
            $post->description = $request->description;

            $post->category_id = $request->category_id;

            if ($post->save()) {
                return redirect()->route('admin.posts.index')->with('success', 'Success !! Post Updated');
            } else {
                return redirect()->back()->with('error', 'Error! Post not updated.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error! Something went wrong: ' . $e->getMessage());
        }
    }




    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully');
    }
}