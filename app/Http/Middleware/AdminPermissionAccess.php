<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Closure, Auth, AuthenticationException;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminPermissionAccess
{
    public function __construct(User $user)
    {
        $this->auth = $user;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $url_permession_check = $this->urlPermessionCheck($request);
        if ($url_permession_check != '') {
            if ($request->user()->can($url_permession_check, true)) {
                return $next($request);
            }
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }

    public function urlPermessionCheck($request)
    {
        $permession = '';
        $currentRouteName = Route::currentRouteName();
        //dd($currentRouteName);
        $formattedName = $this->formatRouteName($currentRouteName);
        // echo $formattedName;
        // dd($formattedName);


        // Add "list_" in front of the formatted name
        // return 'list_' . $formattedName;
        if ($request->isMethod('GET')) {

            if (Str::endsWith($formattedName, 'index')) {
                echo "index";
                $permession = str_replace('_index', '', $formattedName);
                $permession = "list_" . $permession;
                // dd($permession);
            } elseif (Str::endsWith($formattedName, 'edit')) {
                echo "edit";
                $permession = str_replace('_edit', '', $formattedName);
                $permession = "edit_" . $permession;
            } elseif (Str::endsWith($formattedName, 'create')) {
                echo "create";
                $permession = str_replace('_create', '', $formattedName);
                $permession = "create_" . $permession;
            } else {
                $permission = 'unknown';
            }
        } elseif ($request->isMethod('POST')) {
            //$permession = substr($request->fullUrl(), strrpos($request->fullUrl(), '/' )+1);
            //dd($last_string);
            if (Str::endsWith($formattedName, 'store')) {
                echo "store";
                $permession = str_replace('_store', '', $formattedName);
                $permession = "create_" . $permession;
            }
        } elseif ($request->isMethod('DELETE')) {
            echo "delete";
            $permession = str_replace('_destroy', '', $formattedName);
            $permession = "delete_" . $permession;
        } elseif ($request->isMethod('PUT') || $request->isMethod('PATCH')) {
            echo "put/ patch";
            $permession = str_replace('_update', '', $formattedName);
            $permession = "edit_" . $permession;
        }
        // dd($permession);
        return $permession;
    }

    function formatRouteName($routeName)
    {
        // Split by dots, remove 'admin' element, and implode again
        $formattedName = implode('_', array_filter(explode('.', $routeName), function ($part) {
            return $part !== 'admin';
        }));

        // Check if the string contains "-"
        if (strpos($formattedName, '-') !== false) {
            // Replace "-" with "_"
            $formattedName = str_replace('-', '_', $formattedName);
        }

        return $formattedName;
    }
}