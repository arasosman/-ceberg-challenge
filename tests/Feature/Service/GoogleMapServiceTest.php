<?php

namespace Tests\Feature\Service;

use App\Services\Contracts\GoogleMapServiceContract;
use App\Services\GoogleMapService;
use Tests\TestCase;

class GoogleMapServiceTest extends TestCase
{
    public function testGoogleApiDistance()
    {
        /** @var GoogleMapService $googleService */
        $googleService = app(GoogleMapServiceContract::class);

        $result = $googleService
            ->getDistance([38.639967561674034, 34.91826694419126], [38.63547567640983, 34.91148662897687]);

        $this->assertEquals([
            "text" => "1.7 km",
            "value" => 1660
        ], $result['distance']);
    }

    public function testGoogleApiAddress()
    {
        /** @var GoogleMapService $googleService */
        $googleService = app(GoogleMapServiceContract::class);

        $result = $googleService
            ->getAddress([38.639967561674034, 34.91826694419126]);

        $this->assertEquals("370 Evler, 503. Sk. No:18, 50400 Ürgüp/Nevşehir, Turkey", $result);
    }
}
