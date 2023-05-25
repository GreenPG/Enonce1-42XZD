<?php


namespace TotalSurveyVendors\TotalSuite\Foundation\Http\Concerns;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;

trait WithJsonResponse
{
    /**
     * Convert to HTTP Response.
     *
     * @return Response
     */
    public function toJsonResponse(): Response
    {
        return ResponseFactory::json($this->jsonSerialize());
    }
}