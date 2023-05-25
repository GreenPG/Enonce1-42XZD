<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Blocks\BlockType;
use TotalSurvey\Models\Block;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Title extends BlockType
{
    public static $category = 'content';
    public static $id       = 'title';
    public static $icon     = 'title';
    public static $static   = true;

    public static function render(Block $block)
    {
        return Html::create(
            $block->option('size', 'h2'),
            [
                'class' => [
                    'title-block',
                    "title-block-{$block->option('alignment', 'start')}",
                ],
            ],
            $block->value()
        );
    }
}
