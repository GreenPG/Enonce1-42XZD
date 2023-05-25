<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Block;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class DefaultBlockType extends BlockType
{
    public static $category = 'default';
    public static $id       = 'default';
    public static $icon     = 'subject';
    public static $static   = true;

    public static function render(Block $block)
    {
        return Html::create(
            'p',
            ['style' => 'color: red'],
            __('Missing survey block. Please review the survey settings.', 'totalsurvey')
        );
    }
}
