<?php

namespace TotalSurveyVendors\TotalSuite\Foundation;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\League\Event\Emitter as AbstractEmitter;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Concerns\ResolveFromContainer;

/**
 * Class Emitter
 *
 * @package TotalSuite\Foundation
 */
class Emitter extends AbstractEmitter
{
    use ResolveFromContainer;
}