<?php

namespace TotalSurvey\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Scale extends Text
{
    /**
     * @var string
     */
    protected $type = 'radio';

    /**
     * @return Html
     */
    public function render(): Html
    {
        $max   = $this->definition->getAttribute('options.scale', 5);
        $least = $this->definition->getAttribute('options.labels.least', __('Least', 'totalsurvey'));
        $most  = $this->definition->getAttribute('options.labels.most', __('Most', 'totalsurvey'));

        $input = Html::create(
            'div',
            [
                'class'      => 'form-scale',
                'data-least' => $least,
                'data-most'  => $most,
            ]
        );

        $scale = Html::create('div', ['class' => 'scale']);

        for ($i = 1; $i <= $max; $i++) {
            $id    = $this->definition->uid . '-step' . $i;
            $label = Html::create('label', ['class' => 'scale-step', 'for' => $id], $i);
            $radio = Html::create('input', array_merge($this->getAttributes(), ['id' => $id, 'value' => $i]), $label);
            $scale->addContent($radio);
        }


        return $input->addContent($scale);
    }
}