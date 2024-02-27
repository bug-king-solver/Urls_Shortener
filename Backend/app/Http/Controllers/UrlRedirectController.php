<?php

namespace App\Http\Controllers;

use App\Models\ShortenedUrl; 
use App\Models\SubDirectories;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class UrlRedirectController extends Controller
{
    public function redirectWithSub($sub, $hash): RedirectResponse
    {
        $shortUrl = ShortenedUrl::with('subdirectories')
                        ->where('hash', $hash)
                        ->first();

        $subDirectory = SubDirectories::where('name', $sub)
                        ->first();

        if (!$subDirectory || !$shortUrl) {
            return Redirect::to('/error-page');
        }
        return Redirect::to($shortUrl->original_url);
    }
    
    public function redirectWithoutSub($hash): RedirectResponse
    {
        return $this->redirectWithSub("", $hash);
    }
}