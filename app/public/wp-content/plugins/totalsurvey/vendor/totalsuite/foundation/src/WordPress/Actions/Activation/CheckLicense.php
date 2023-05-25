<?php
namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Activation;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\License;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Activation\CheckLicense as CheckLicenseTask;

class CheckLicense extends Action
{

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return Response
     */
    protected function execute()
    {
        try {
            CheckLicenseTask::invoke();
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => $e->getMessage(),
                'license' => License::instance()->toArray()
            ]);
        }

        return ResponseFactory::json(License::instance()->toArray());
    }
}