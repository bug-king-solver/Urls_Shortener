<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UrlShortenerService;
use Illuminate\Support\Facades\Validator;

class UrlShortenerController extends Controller
{
    protected $urlShortenerService;
    
    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    public function shortenUrl(Request $request)
    {    
        $originalUrl = $request->input('url');
        $sub = $request->input('subdir') ?? "";

        $result = $this->urlShortenerService->shortenUrl($originalUrl, $sub);

        return response()->json($result);
    }
}
