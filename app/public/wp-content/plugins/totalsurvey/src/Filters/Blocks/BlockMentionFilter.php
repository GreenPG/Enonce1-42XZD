<?php

namespace TotalSurvey\Filters\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Filter;

/**
 * Class BlockMentionFilter
 * @method static string apply(string $mention, $part)
 *
 * @package TotalSurvey\Filters
 */
class BlockMentionFilter extends Filter
{
    protected static function alias()
    {
        return 'totalsurvey/blocks/mention';
    }
}
