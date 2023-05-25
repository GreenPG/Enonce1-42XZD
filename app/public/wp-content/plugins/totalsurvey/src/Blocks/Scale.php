<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Blocks\Concerns\GenerateInputName;
use TotalSurvey\Models\Block;
use TotalSurvey\Models\Entry;
use TotalSurvey\Models\Validation;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Scale extends BlockType
{
    public static $category  = 'question';
    public static $id        = 'scale';
    public static $icon      = 'linear_scale';
    public static $static    = false;
    public static $aggregate = true;
    public static $aliases   = ['scale'];

    use GenerateInputName;

    /**
     * @param  Block  $block
     *
     * @return Html
     */
    public static function render(Block $block)
    {
        $container = Html::create('');
        $options   = $block->option('choices', []);

        $max   = $block->option('scale', 5);
        $least = $block->option('labels.least', __('Least', 'totalsurvey'));
        $most  = $block->option('labels.most', __('Most', 'totalsurvey'));

        $input = Html::create(
            'div',
            [
                'class'      => 'form-scale',
                'data-least' => $least,
                'data-most'  => $most,
            ]
        );

        $scale = Html::create('div', ['class' => 'scale']);

        for ($currentIndex = 1; $currentIndex <= $max; $currentIndex++) {
            $id    = "{$block->uid}-{$currentIndex}";
            $label = Html::create('label', ['class' => 'scale-step', 'for' => $id], $currentIndex);
            $radio = Html::create(
                'input',
                [
                    'type'               => 'radio',
                    'name'               => static::getInputName($block->section->uid, $block->uid),
                    'value'              => $currentIndex,
                    'id'                 => $id,
                    'class'              => $block->option('cssClass'),
                    'data-variable-name' => $block->uid,
                ],
                $label
            );
            $scale->addContent($radio);
        }

        return $input->addContent($scale);
    }

    public static function getValidationRules(Block $block)
    {
        $block->field->validations->set(
            'between',
            Validation::from(
                [
                    'enabled' => true,
                    'options' => [
                        'min' => 1,
                        'max' => $block->option('scale', 2),
                    ],
                ]
            )
        );

        return parent::getValidationRules($block);
    }

    public static function getSerializedFromRawValue(Block $block, Entry $entry, $value)
    {
        return +$value;
    }

    public static function getMetadataFromRawValue(Block $block, Entry $entry, $value)
    {
        return [
            'scale' => $block->option('scale', 0),
        ];
    }

    public static function getTextFromRawValue(Block $block, Entry $entry, $value)
    {
        return sprintf(__('%d out of %d', 'totalsurvey'), (int) $value, $block->option('scale', 0));
    }

    public static function getTranslatableAttributes()
    {
        return [
            'field.options.labels.least',
            'field.options.labels.most' ,
        ];
    }
}
