<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Blocks\Concerns\GenerateInputName;
use TotalSurvey\Models\Block;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Date extends BlockType
{
    public static $category = 'question';
    public static $id       = 'date';
    public static $icon     = 'calendar_today';
    public static $static   = false;
    public static $aliases  = ['date'];

    use GenerateInputName;

    public static function render(Block $block)
    {
        $input = Html::create(
            'input',
            [
                'type'        => 'date',
                'name'        => static::getInputName($block->section->uid, $block->uid),
                'id'          => $block->uid,
                'class'       => $block->option('cssClass'),
                'placeholder' => $block->option('placeholder'),
                'value'       => $block->option('defaultValue'),
            ]
        );

        return $input;
    }
}
