<?php
namespace App\Services;

use App\Models\ShortenedUrl;
use App\Models\SubDirectories;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class UrlShortenerService
{
    protected $apiKey;
    protected $clientId;

    public function __construct()
    {
        $this->apiKey = config('google.api_key');
        $this->clientId = config('google.client_id');
    }

    public function shortenUrl(string $originalUrl, string $sub): array
    {
        $existingUrl = ShortenedUrl::with('subDirectories')
                        ->where('original_url', $originalUrl)
                        ->first();
        
        if($existingUrl) {
            return $this->handleExistingUrl($existingUrl);
        }

        if(!$this->isUrlSafe($originalUrl)) {
            return ['error' => 'The URL is not safe.', 'status' => 'error'];
        } 

        $hash = Str::random(6);
        $shortenedUrl = new ShortenedUrl([
            'original_url' => $originalUrl,
            'hash' => $hash,
        ]);

        $subdir = SubDirectories::firstOrCreate(['name' => $sub]);

        $shortenedUrl->sub_id = $subdir->id;
        $shortenedUrl->save();

        return [
            'hash' => $shortenedUrl->hash,
            'sub' => $subdir->name,
            'status' => 'success'
        ];
    }

    protected function handleExistingUrl(ShortenedUrl $existingUrl): array
    {
        if($existingUrl->subDirectories) {
            return [
                'hash' => $existingUrl->hash,
                'sub' => $existingUrl->subDirectories->name,
                'status' => 'exist'
            ];
        } else {
            return [
                'hash' => $existingUrl->hash,
                'status' => 'exist'
            ];
        }
    }

    protected function isUrlSafe(string $url): bool
    {
        $client = new Client();
        $endpoint = 'https://safebrowsing.googleapis.com/v4/threatMatches:find';
        $payload = [
            'client' => [
                'clientId'      => $this->clientId,
                'clientVersion' => '1.0.0'
            ],
            'threatInfo' => [
                'threatTypes'      => ['MALWARE', 'SOCIAL_ENGINEERING'],
                'platformTypes'    => ['ANY_PLATFORM'],
                'threatEntryTypes' => ['URL'],
                'threatEntries'    => [
                    ['url' => $url]
                ]
            ]
        ];
    
        try {
            $response = $client->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($payload),
                'query' => [
                    'key' => $this->apiKey
                ]
            ]);
    
            $body = json_decode($response->getBody());
    
            // Check if any threats are found
            return empty($body->matches);
        } catch (\Exception $e) {
            // Handle exception or error response
            return false;
        }
    }
}
