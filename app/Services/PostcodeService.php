<?php

namespace App\Services;

use App\Services\Contracts\PostcodeServiceContract;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class PostcodeService implements PostcodeServiceContract
{
    protected string $baseUrl = "https://api.postcodes.io";

    /**
     * @throws RequestException
     */
    public function getDetail(string $postcode)
    {
        $response = Http::get($this->baseUrl . '/postcodes/' . $postcode);
        $response->throw();
        return $response->json('result');
    }

    /**
     * @throws RequestException
     */
    public function validatePostcode(string $postcode): bool
    {
        $response = Http::get($this->baseUrl . '/postcodes/' . $postcode . "/validate");
        $response->throw();

        if ($response->json('result')) {
            return true;
        }
        return false;
    }
}
