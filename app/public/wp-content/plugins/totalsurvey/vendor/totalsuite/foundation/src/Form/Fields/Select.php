<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Form\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Form\Field;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

/**
 * Class Select
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Form\Fields
 */
class Select extends Field
{
    /**
     * @var array
     */
    protected $attributes = [
        'options' => [],
    ];

    /**
     * @return Html
     */
    public function toHTML()
    {
        $options    = $this->getAttribute('options', []);
        $attributes = $this->getHtmlAttributes(['value', 'options']);
        $values     = (array)$this->getValue();

        $contents = [];

        foreach ($options as $value => $label) {
            $option = Html::create('option', ['value' => $value], $label);

            if (in_array($value, $values, true)) {
                $option->setAttribute('selected');
            }

            $contents[] = $option;
        }

        return Html::create('select', $attributes, $contents);
    }
}