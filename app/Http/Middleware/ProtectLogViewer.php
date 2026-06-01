<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProtectLogViewer
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // allow the login POST route to pass through
        if ($request->is('log-viewer-login')) {
            return $next($request);
        }

        // If the requested path is under log-viewer and not authenticated, show login
        if ($request->is('log-viewer*')) {
            if (!$request->session()->get('log_viewer_authenticated', false)) {
                // store intended URL
                $request->session()->put('log_viewer_target', $request->fullUrl());
                return response()->view('logviewer.login');
            }
        }

        return $next($request);
    }
}
