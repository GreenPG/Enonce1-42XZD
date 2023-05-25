<?php

namespace TotalSurvey\Events;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Event;

class OnBackofficeAssetsEnqueued extends Event
{
    const ALIAS = 'totalsurvey/backoffice/assets';
}