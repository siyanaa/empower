<?php

namespace App\Http\Controllers;

use App\Models\Favicon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class FaviconController extends Controller
{
    public function index()
    {
        $icons = Favicon::all();
        return view('backend.favicon.index', [
            'icons' => $icons,
            'page_title' => 'Favicons'
        ]);
    }
    public function create()
    {
        return view('backend.favicon.create', [
            'page_title' => 'Favicons create',
        ]);
    }
    public function store(Request $request)
    {
        // dd($request);
        try {
            // Validate the incoming request data.
            $this->validate($request, [
                'android_chrome_oneninetwo' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
                'android_chrome_fiveonetwo' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
                'favicon_thirtyTwo' => 'image|mimes:jpg,png,peg,gif,svg,webp|max:2048',
                'favicon_sixteen' => 'image|mimes:jpg,png,peg,gif,svg,webp|max:2048',
                // 'favicon_ico' => 'image|mimes:jpg,png,jpeg,gif,svg,ico|max:2048',
                'favicon_ico' => 'file|mimes:ico|max:2048',
                'apple_touch_icon' => 'image|mimes:jpg,png,peg,gif,svg,webp|max:2048',
                'site_webmanifest' => 'required|file|max:4000'
            ]);

            $directory = public_path('uploads/favicon/');
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true, true);
            }

            if ($request->hasFile('android_chrome_oneninetwo')) {
                $favIconOneNinetyTwo = time() . '.' . $request->file('android_chrome_oneninetwo')->getClientOriginalExtension();
                $request->file('android_chrome_oneninetwo')->move($directory, $favIconOneNinetyTwo);
            } else {
                $favIconOneNinetyTwo = "NoFile";
            }

            if ($request->hasFile('android_chrome_fiveonetwo')) {
                $favIconFiveOneTwo = time() . '.' . $request->file('android_chrome_fiveonetwo')->getClientOriginalExtension();
                $request->file('android_chrome_fiveonetwo')->move($directory, $favIconFiveOneTwo);
            } else {
                $favIconFiveOneTwo = "NoFile";
            }

            if ($request->hasFile('favicon_thirtyTwo')) {
                $favIconThirtyTwo = time() . '.' . $request->file('favicon_thirtyTwo')->getClientOriginalExtension();
                $request->file('favicon_thirtyTwo')->move($directory, $favIconThirtyTwo);
            } else {
                $favIconThirtyTwo = "NoFile";
            }

            if ($request->hasFile('favicon_sixteen')) {
                $favIconSixteen = time() . '.' . $request->file('favicon_sixteen')->getClientOriginalExtension();
                $request->file('favicon_sixteen')->move($directory, $favIconSixteen);
            } else {
                $favIconSixteen = "NoFile";
            }
            if ($request->hasFile('favicon_ico')) {
                $favIconIco = time() . '.' . $request->file('favicon_ico')->getClientOriginalExtension();
                $request->file('favicon_ico')->move($directory, $favIconIco);
            } else {
                $favIconIco = "NoFile";
            }

            if ($request->hasFile('apple_touch_icon')) {
                $AppleTouchIcon = time() . '.' . $request->file('apple_touch_icon')->getClientOriginalExtension();
                $request->file('apple_touch_icon')->move($directory, $AppleTouchIcon);
            } else {
                $AppleTouchIcon = "NoFile";
            }

            $postPath = time() . '.' . $request->file('site_webmanifest')->getClientOriginalExtension();
            $request->file('site_webmanifest')->move(public_path('uploads/favicon/file/'), $postPath);

            $favicon = new Favicon;
            $favicon->android_chrome_oneninetwo = $favIconOneNinetyTwo;
            $favicon->android_chrome_fiveonetwo = $favIconFiveOneTwo;
            $favicon->favicon_thirtyTwo = $favIconThirtyTwo;
            $favicon->favicon_sixteen = $favIconSixteen;
            $favicon->favicon_ico = $favIconIco;
            $favicon->apple_touch_icon = $AppleTouchIcon;
            $favicon->site_webmanifest = $postPath;
            $favicon->save();

            return redirect()->route('admin.favicons.index')->with(['success' => 'Success !! Favicon Updated']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Error occurred: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $favicon = Favicon::find($id);
        return view('backend.favicon.update', [
            'favicon' => $favicon,
            'page_title' => 'Update favicon'
        ]);
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        $this->validate($request, [
            'android_chrome_oneninetwo' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            'android_chrome_fiveonetwo' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
            'favicon_thirtyTwo' => 'image|mimes:jpg,png,peg,gif,svg,webp|max:2048',
            'favicon_sixteen' => 'image|mimes:jpg,png,peg,gif,svg,webp|max:2048',
            // 'favicon_ico' => 'image|mimes:jpg,png,jpeg,gif,svg,ico|max:2048',
            'favicon_ico' => 'file|mimes:ico|max:2048',
            'apple_touch_icon' => 'image|mimes:jpg,png,peg,gif,svg,webp|max:2048',
            'site_webmanifest' => 'required|file|max:4000'
        ]);

        try {
            $favicon = Favicon::findOrFail($id);

            if ($request->hasFile('android_chrome_oneninetwo')) {
                $favIconOneNinetyTwo = time() . '.' . $request->android_chrome_oneninetwo->extension();
                $request->android_chrome_oneninetwo->move(public_path('uploads/favicon/'), $favIconOneNinetyTwo);
            } else {
                $favIconOneNinetyTwo = "NoFile";
            }

            if ($request->hasFile('android_chrome_fiveonetwo')) {
                $favIconFiveOneTwo = time() . '.' . $request->android_chrome_fiveonetwo->extension();
                $request->android_chrome_fiveonetwo->move(public_path('uploads/favicon/'), $favIconFiveOneTwo);
            } else {
                $favIconFiveOneTwo = "NoFile";
            }

            if ($request->hasFile('favicon_thirtyTwo')) {
                $favIconThirtyTwo = time() . '.' . $request->favicon_thirtyTwo->extension();
                $request->favicon_thirtyTwo->move(public_path('uploads/favicon/'), $favIconThirtyTwo);
            } else {
                $favIconThirtyTwo = "NoFile";
            }

            if ($request->hasFile('favicon_sixteen')) {
                $favIconSixteen = time() . '.' . $request->favicon_sixteen->extension();
                $request->favicon_sixteen->move(public_path('uploads/favicon/'), $favIconSixteen);
            } else {
                $favIconSixteen = "NoFile";
            }
            if ($request->hasFile('favicon_ico')) {
                $favIconIco = time() . '.' . $request->favicon_ico->extension();
                $request->favicon_ico->move(public_path('uploads/favicon/'), $favIconIco);
            } else {
                $favIconIco = "NoFile";
            }

            if ($request->hasFile('apple_touch_icon')) {
                $AppleTouchIcon = time() . '.' . $request->apple_touch_icon->extension();
                // dd($AppleTouchIcon);
                $request->apple_touch_icon->move(public_path('uploads/favicon/'), $AppleTouchIcon);

            } else {
                $AppleTouchIcon = "NoFile";
            }

            if ($request->hasFile('site_webmanifest')) {
                $postPath = time() . '.' . $request->site_webmanifest->extension();
                $request->site_webmanifest->move(public_path('uploads/favicon/file/'), $postPath);
            } else {
                $postPath = "NoFile";
            }

            // Update the model properties
            $favicon->android_chrome_oneninetwo = $favIconOneNinetyTwo;
            $favicon->android_chrome_fiveonetwo = $favIconFiveOneTwo;
            $favicon->favicon_thirtyTwo = $favIconThirtyTwo;
            $favicon->favicon_sixteen = $favIconSixteen;
            $favicon->favicon_ico = $favIconIco;
            $favicon->apple_touch_icon = $AppleTouchIcon;
            $favicon->site_webmanifest = $postPath;
            // dd($favicon);
            $favicon->save();
            return redirect()->route('admin.favicons.index')->with(['success' => 'Success !! Favicon Updated']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'error' . $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        $icon = Favicon::find($id);
        if ($icon) {
            $icon->delete();
            return redirect()->route('admin.favicons.index')->with('success', 'Success !! Favicon Deleted');
        } else {
            return redirect()->route('admin.favicons.index')->with('error', 'Favicon not found.');
        }
    }
}