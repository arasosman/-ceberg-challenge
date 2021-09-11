<?php

namespace App\Services\Contracts;

interface GoogleMapServiceContract
{
    public function getDistance(array $locationOne, array $locationTwo);
}
