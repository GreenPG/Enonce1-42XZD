<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Blocks\Concerns\GenerateInputName;
use TotalSurvey\Models\Block;
use TotalSurvey\Models\Entry;
use TotalSurvey\Models\Validation;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Dropdown extends BlockType
{
    public static $category  = 'question';
    public static $id        = 'dropdown';
    public static $icon      = 'list';
    public static $static    = false;
    public static $aggregate = true;
    public static $aliases   = ['select'];

    use GenerateInputName;

    /**
     * @param  Block  $block
     *
     * @return Html
     */
    public static function render(Block $block)
    {
        $select = Html::create(
            'select',
            [
                'name'  => static::getInputName($block->section->uid, $block->uid),
                'id'    => $block->uid,
                'class' => $block->option('cssClass'),
            ],
            Html::create('option', ['value' => ''], $block->option('placeholder', __('Choose', 'totalsurvey')))
        );

        if ($block->option('multiple', false) === true) {
            $select->setAttribute('multiple');
        }

        $options      = $block->option('choices', []);
        $defaultValue = $block->option('defaultValue');

        foreach ($options as $option) {
            $optionTag = Html::create('option', ['value' => $option['uid']], $option['label']);

            if (!empty($defaultValue) && $option['uid'] === $defaultValue) {
                $optionTag->setAttribute('selected');
            }

            $optionTag->setAttribute('data-variable-value', $option['label']);

            $select->addContent($optionTag);
        }

        return $select;
    }

    public static function getValidationRules(Block $block)
    {
        if ($block->field->isRequired()) {
            $block->field->validations->set(
                'inArray',
                Validation::from(
                    [
                        'enabled' => true,
                        'options' => [
                            'values' => $block->field->getChoicesAttribute('uid'),
                        ],
                    ]
                )
            );
        }

        return parent::getValidationRules($block);
    }

    public static function getValidationMessages(Block $block)
    {
        return [
            "{$block->uid}:in_array" => str_replace(
                ['{{allowedValues}}'],
                [implode(', ', $block->field->getChoicesAttribute('label'))],
                __('Must be one of: {{allowedValues}}', 'totalsurvey')
            ),
        ];
    }

    public static function getSerializedFromRawValue(Block $block, Entry $entry, $value)
    {
        return $value;
    }

    public static function getTextFromRawValue(Block $block, Entry $entry, $value)
    {
        $value   = (array) $value;
        $choices = $block->field->getChoicesAttribute('label', 'uid');

        foreach ($value as $index => $subValue) {
            if (isset($choices[$subValue])) {
                $value[$index] = esc_html($choices[$subValue]);
            } else {
                $value[$index] = sprintf(__('Other: %s', 'totalsurvey'), esc_html($subValue));
            }
        }

        return implode(', ', (array) $value);
    }

    public static function getTranslatableAttributes()
    {
        return [
            'field.options.choices.label',
        ];
    }
}
