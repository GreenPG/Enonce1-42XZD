<?php

namespace TotalSurvey\Events\Backoffice;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Event;

class OnBackofficeAssetsEnqueued extends Event
{
    const ALIAS = 'totalsurvey/backoffice/assets';
}
