<?php

namespace App\Rules;

use App\Services\Contracts\PostcodeServiceContract;
use Illuminate\Contracts\Validation\Rule;

class ValidatePostcode implements Rule
{
    private PostcodeServiceContract $postcodeService;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->postcodeService = app(PostcodeServiceContract::class);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @SuppressWarnings(PHPMD)
     */
    public function passes($attribute, $value): bool
    {
        $isValid = $this->postcodeService->validatePostcode($value);
        if ($isValid) {
            $detail = $this->postcodeService->getDetail($value);
            return $detail['country'] == "England";
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Invalid Postcode only right code in UK.';
    }
}
