<?php

namespace Tests\Feature\Service;

use App\Services\Contracts\PostcodeServiceContract;
use Tests\TestCase;

class PostcodeServiceTest extends TestCase
{
    public function testApiValidate()
    {
        /** @var PostcodeServiceContract $postcodeService */
        $postcodeService = app(PostcodeServiceContract::class);

        $this->assertTrue($postcodeService->validatePostcode("cm27pj"));
        $this->assertFalse($postcodeService->validatePostcode("wrongcode-22"));
    }

    public function testApiGetPostCodeDetail()
    {
        /** @var PostcodeServiceContract $postcodeService */
        $postcodeService = app(PostcodeServiceContract::class);

        $result = $postcodeService->getDetail("cm27pj");
        $this->assertArrayHasKey('postcode', $result);
        $this->assertArrayHasKey('longitude', $result);
        $this->assertArrayHasKey('latitude', $result);
    }
}
