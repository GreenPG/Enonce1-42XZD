<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Activation;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\License;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Activation\RemoveLicense as RemoveLicenseTask;

class Unlink extends Action
{
    public function authorize(): bool
    {
        return true;
    }

    protected function execute()
    {
        $license = License::instance();

        try {
            RemoveLicenseTask::invoke();
        } catch (Exception $exception) {
            ResponseFactory::json([
                'message' => $exception->getMessage(),
                'license' => $license
            ], 422);
        }

        return ResponseFactory::json($license);
    }
}