<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Http;
! defined( 'ABSPATH' ) && exit();


/**
 * Class Body
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Http
 */
class Body extends Stream
{
    /**
     * @return static
     */
    public static function createFromServer(): Body
    {
        $stream = fopen('php://temp', 'wb+');
        stream_copy_to_stream(fopen('php://input', 'rb'), $stream);
        return new static($stream);
    }
}