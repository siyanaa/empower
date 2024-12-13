<?php
namespace App\Http\Controllers;

use App\Models\VideoGallery;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class VideoGalleryController extends Controller
{
    public function index()
    {
        $videos = VideoGallery::latest()->paginate(5);
        return view('backend.videogallery.index', ['videos' => $videos, 'page_title' => 'Video Gallery']);
    }

    public function create()
    {
        return view('backend.videogallery.create', ['page_title' => 'Add Video']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'url' => ['required', 'url'],
        ]);

        try {
            $video = new VideoGallery();
            $video->title = $request->title;
            $video->slug = SlugService::createSlug(VideoGallery::class, 'slug', $request->title);
            $video->url = $this->extractVideoId($request->url);
            if ($video->save()) {
                return redirect()->route('admin.video-galleries.index')->with('success', 'Success! Video created.');
            }
            return redirect()->back()->with('error', 'Error! Video not created.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error! Something went wrong: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $video = VideoGallery::findOrFail($id);
        return view('backend.videogallery.update', ['video' => $video, 'page_title' => 'Update Video Gallery']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'url' => ['required', 'url'],
        ]);

        try {
            $video = VideoGallery::findOrFail($id);
            $video->title = $request->title;
            $video->slug = SlugService::createSlug(VideoGallery::class, 'slug', $request->title);
            $video->url = $this->extractVideoId($request->url);
            if ($video->save()) {
                return redirect()->route('admin.video-galleries.index')->with('success', 'Success! Video Updated.');
            } else {
                return redirect()->back()->with('error', 'Error! Video not updated.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error! Something went wrong: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $video = VideoGallery::find($id);
        if ($video) {
            $video->delete();
            return redirect()->route('admin.video-galleries.index')->with('success', 'Success!! Video Deleted');
        } else {
            return redirect()->route('admin.video-galleries.index')->with('error', 'Video not found.');
        }
    }

    private function extractVideoId($url)
    {
        // Regular expression to match different video URL formats
        $patterns = [
            '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            '/(?:https?:\/\/)?(?:www\.)?youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return $url;
    }
}