<?php

namespace App\Services\Contracts;

interface GoogleMapServiceContract
{
    public function getDistance(array $locationOne, array $locationTwo): array;

    public function getAddress(array $coordinates): string;
}
