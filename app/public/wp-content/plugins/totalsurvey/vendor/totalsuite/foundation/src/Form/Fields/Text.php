<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Form\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Form\Field;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

/**
 * Class Text
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Form\Fields
 */
class Text extends Field
{
    /**
     * @var array
     */
    protected $attributes = ['type' => 'text'];

    /**
     * @return Html
     */
    public function toHTML()
    {
        return Html::create('input', $this->getHtmlAttributes());
    }
}