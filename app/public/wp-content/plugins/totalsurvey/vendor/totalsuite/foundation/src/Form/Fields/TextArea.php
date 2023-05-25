<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Form\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Form\Field;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;


/**
 * Class TextArea
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Form\Fields
 */
class TextArea extends Field
{
    /**
     * @return Html
     */
    public function toHTML()
    {
        return Html::create('textarea', $this->getHtmlAttributes(['value']), $this->getValue());
    }
}