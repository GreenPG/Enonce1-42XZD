<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Blocks\Concerns\GenerateInputName;
use TotalSurvey\Models\Block;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Text extends BlockType
{
    public static $category = 'question';
    public static $id       = 'text';
    public static $icon     = 'crop_7_5';
    public static $static   = false;
    public static $aliases  = ['text'];

    use GenerateInputName;

    public static function render(Block $block)
    {
        $input = Html::create(
            'input',
            [
                'type'               => 'text',
                'name'               => static::getInputName($block->section->uid, $block->uid),
                'id'                 => $block->uid,
                'class'              => $block->option('cssClass'),
                'placeholder'        => $block->option('placeholder'),
                'value'              => $block->option('defaultValue'),
            ]
        );

        return $input;
    }
}
