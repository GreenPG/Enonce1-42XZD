<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Blocks\Concerns\GenerateInputName;
use TotalSurvey\Models\Block;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class TextArea extends BlockType
{
    public static $category = 'question';
    public static $id       = 'textarea';
    public static $icon     = 'crop_landscape';
    public static $static   = false;
    public static $aliases  = ['paragraph'];

    use GenerateInputName;

    public static function render(Block $block)
    {
        $textarea = Html::create(
            'textarea',
            [
                'name'        => static::getInputName($block->section->uid, $block->uid),
                'id'          => $block->uid,
                'class'       => $block->option('cssClass'),
                'rows'        => $block->option('rows', 3),
                'placeholder' => $block->option('placeholder'),
            ]
        );

        $textarea->setContent($block->option('defaultValue'));

        return $textarea;
    }
}
