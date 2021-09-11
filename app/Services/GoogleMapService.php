<?php

namespace App\Services;

use App\Services\Contracts\GoogleMapServiceContract;
use Illuminate\Support\Facades\Http;

class GoogleMapService implements GoogleMapServiceContract
{
    public function getDistance(array $locationOne, array $locationTwo)
    {
        $url = sprintf(
            "https://maps.googleapis.com/maps/api/distancematrix/json?origins=%s&destinations=%s".
            "&mode=driving&sensor=false&key=%s",
            implode(',', $locationOne),
            implode(',', $locationTwo),
            env('GOOGLE_KEY')
        );

        $response = Http::get($url);
        $response->throw();
        return $response->json();
    }
}
