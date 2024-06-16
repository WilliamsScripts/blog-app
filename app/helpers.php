<?php
use Illuminate\Validation\Validator;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

if (!function_exists('processText')) {
    function processText($content)
    {
        $plainText = strip_tags($content);
        return $plainText;
    }
}


if (!function_exists('failedValidationResponse')) {
    function failedValidationResponse(Validator $validator): JsonResponse
    {
        return (new Controller)->sendError(
            implode(" ", $validator->errors()->all()),
            422
        );
    }
}
