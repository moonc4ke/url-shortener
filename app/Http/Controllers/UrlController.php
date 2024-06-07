<?php
namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    public function index()
    {
        return inertia('Home');
    }

    public function shorten(Request $request)
    {
        $request->validate(['url' => 'required|url']);
        $originalUrl = $request->input('url');

        $response = Http::post('https://safebrowsing.googleapis.com/v4/threatMatches:find', [
            'client' => ['clientId' => 'your-client-id', 'clientVersion' => '1.0'],
            'threatInfo' => [
                'threatTypes' => ['MALWARE', 'SOCIAL_ENGINEERING'],
                'platformTypes' => ['WEB'],
                'threatEntryTypes' => ['URL'],
                'threatEntries' => [['url' => $originalUrl]],
            ],
            'key' => env('GOOGLE_SAFE_BROWSING_API_KEY'),
        ]);

        if ($response->json('matches')) {
            return response()->json(['errors' => ['url' => ['The URL is not safe to shorten.']]], 422);
        }

        $url = Url::where('original_url', $originalUrl)->first();
        if ($url) {
            return response()->json(['short_url' => url($url->short_url)]);
        }

        $shortUrl = Str::random(6);
        while (Url::where('short_url', $shortUrl)->exists()) {
            $shortUrl = Str::random(6);
        }

        $url = Url::create([
            'original_url' => $originalUrl,
            'short_url' => $shortUrl,
        ]);

        return response()->json(['short_url' => url($shortUrl)]);
    }

    public function redirect($hash)
    {
        $url = Url::where('short_url', $hash)->firstOrFail();
        return redirect($url->original_url);
    }
}
