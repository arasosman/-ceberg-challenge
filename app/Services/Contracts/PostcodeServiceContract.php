<?php

namespace App\Services\Contracts;

interface PostcodeServiceContract
{

    public function getDetail(string $postcode);

    public function validatePostcode(string $postcode): bool;
}
