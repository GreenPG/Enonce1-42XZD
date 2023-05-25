<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Form\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

/**
 * Class File
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Form\Fields
 */
class File extends Text
{
    /**
     * @var array
     */
    protected $attributes = ['type' => 'file'];

    /**
     * @return Html
     */
    public function toHTML()
    {
        $html = parent::toHTML();
        $html->removeAttribute('value');

        return $html;
    }


}