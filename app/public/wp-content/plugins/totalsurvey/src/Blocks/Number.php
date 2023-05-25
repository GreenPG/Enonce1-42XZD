<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Blocks\Concerns\GenerateInputName;
use TotalSurvey\Models\Block;
use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Number extends BlockType
{
    public static $category = 'question';
    public static $id       = 'number';
    public static $icon     = 'looks_one';
    public static $static   = false;
    public static $aliases  = ['number'];

    use GenerateInputName;

    public static function render(Block $block)
    {
        $input = Html::create(
            'input',
            [
                'type'               => 'number',
                'name'               => static::getInputName($block->section->uid, $block->uid),
                'id'                 => $block->uid,
                'class'              => $block->option('cssClass'),
                'placeholder'        => $block->option('placeholder'),
                'value'              => $block->option('defaultValue'),
            ]
        );

        return $input;
    }

    public static function getSerializedFromRawValue(Block $block, Entry $entry, $value)
    {
        return is_numeric($value) ? +$value : $value;
    }
}
