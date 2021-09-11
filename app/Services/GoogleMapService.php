<?php

namespace App\Services;

use App\Services\Contracts\GoogleMapServiceContract;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class GoogleMapService implements GoogleMapServiceContract
{
    /**
     * @throws RequestException
     */
    public function getDistance(array $locationOne, array $locationTwo): array
    {
        $url = sprintf(
            "https://maps.googleapis.com/maps/api/distancematrix/json?origins=%s&destinations=%s" .
            "&mode=driving&sensor=false&key=%s",
            implode(',', $locationOne),
            implode(',', $locationTwo),
            env('GOOGLE_KEY')
        );

        $response = Http::get($url);
        $response->throw();
        $result = $response->json();

        return $result["rows"][0]["elements"][0];
    }

    /**
     * @throws RequestException
     */
    public function getAddress(array $coordinates): string
    {
        $url = sprintf(
            "https://maps.googleapis.com/maps/api/geocode/json?latlng=%s&key=%s",
            implode(',', $coordinates),
            env('GOOGLE_KEY')
        );

        $response = Http::get($url);
        $response->throw();
        $result = $response->json();
        return $result["results"][0]["formatted_address"];
    }
}
