<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Block;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Paragraph extends BlockType
{
    public static $category = 'content';
    public static $id       = 'paragraph';
    public static $icon     = 'subject';
    public static $static   = true;

    public static function render(Block $block)
    {
        return Html::create(
            'p',
            [
                'class' => [
                    'paragraph-block',
                    "paragraph-block-{$block->option('alignment', 'start')}",
                ],
            ],
            $block->value()
        );
    }


    public static function getTranslatableAttributes()
    {
        return [
            'content.value',
        ];
    }
}
