<?php

namespace TotalSurvey\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Text extends Field
{
    /**
     * @var string
     */
    protected $type = 'text';

    public function render(): Html
    {
        $input = Html::create('input', $this->getAttributes());
        $input->setAttribute('value', $this->definition->getAttribute('options.defaultValue', ''));

        return $input;
    }

    /**
     * @return array
     */
    protected function getAttributes(): array
    {
        return [
            'type'        => $this->type,
            'name'        => $this->getName(),
            'id'          => $this->definition->uid,
            'class'       => $this->definition->getAttribute('options.cssClass', ''),
            'placeholder' => $this->definition->getAttribute('options.placeholder', ''),
        ];
    }
}