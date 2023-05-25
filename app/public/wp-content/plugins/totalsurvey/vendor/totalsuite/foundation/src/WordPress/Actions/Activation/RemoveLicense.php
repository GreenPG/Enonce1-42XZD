<?php
namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Activation;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\License;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Activation\RemoveLicense as RemoveLicenseTask;

class RemoveLicense extends Action
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
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => $e->getMessage(),
                'license' => $license->toArray()
            ]);
        }

        return ResponseFactory::json($license->toArray());
    }
}