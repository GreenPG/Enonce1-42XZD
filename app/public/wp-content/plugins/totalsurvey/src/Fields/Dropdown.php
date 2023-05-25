<?php

namespace TotalSurvey\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Dropdown extends Text
{
    public function render(): Html
    {
        $select = Html::create(
            'select',
            $this->getAttributes(),
            Html::create('option', ['value' => ''], __('Choose', 'totalsurvey'))
        );

        if ($this->definition->getAttribute('options.multiple', false) === true) {
            $select->setAttribute('multiple');
        }

        $options      = $this->definition->getAttribute('options.choices', []);
        $defaultValue = $this->definition->getAttribute('options.defaultValue');

        foreach ($options as $option) {
            $optionTag = new Html('option', ['value' => $option['uid']], $option['label']);

            if (!empty($defaultValue) && $option['uid'] === $defaultValue) {
                $optionTag->setAttribute('selected');
            }

            $select->addContent($optionTag);
        }

        return $select;
    }
}