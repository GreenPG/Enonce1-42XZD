<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Activation;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\License;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Activation\CheckLicense as CheckLicenseTask;

class Check extends Action
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
        } catch (Exception $exception) {
            ResponseFactory::json(
                [
                    'message' => $exception->getMessage(),
                    'license' => License::instance()
                ],
                422
            );
        }

        return ResponseFactory::json(['license' => License::instance()]);
    }
}