<?php

namespace TotalSurvey\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Paragraph extends Field
{
    public function render(): Html
    {
        return Html::create(
            'textarea',
            [
                'name'        => $this->getName(),
                'id'          => $this->definition->uid,
                'class'       => $this->definition->getAttribute('options.cssClasses', ''),
                'placeholder' => $this->definition->getAttribute('options.placeholder', ''),
                'rows'        => $this->definition->getAttribute('options.rows', 5),
            ]
        )->addContent($this->definition->getAttribute('options.defaultValue', ''));
    }
}