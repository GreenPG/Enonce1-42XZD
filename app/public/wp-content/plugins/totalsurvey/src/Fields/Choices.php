<?php

namespace TotalSurvey\Fields;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;

class Choices extends Text
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
        $html = Html::create('');

        $options = $this->definition->getAttribute('options.choices', []);

        foreach ($options as $option) {
            $html->addContent($this->createInput($option['label'], $option['uid']));
        }

        if ($this->definition->getAttribute('options.allowOther') === true) {
            $html->addContent($this->createOthers(__('Other', 'totalsurvey')));
        }

        return $html;
    }

    /**
     * @param string $text
     * @param mixed $value
     *
     * @return Html
     */
    protected function createInput($text, $value): Html
    {
        $label = Html::create('label', ['class' => $this->type]);
        $input = Html::create('input', $this->getAttributes(), $text);
        $input->setAttribute('value', $value);

        $default = $this->definition->getAttribute('options.defaultValue', false);

        if ($default && $default === $value) {
            $input->setAttribute('checked');
        }

        return $label->addContent($input);
    }

    /**
     * @param mixed $label
     *
     * @return Html
     */
    protected function createOthers($label): Html
    {
        $name = $this->getName();

        return Html::create('label', ['class' => $this->type . ' other-container',])
                   ->addContent(
                       Html::create(
                           'input',
                           [
                               'class' => 'other',
                               'type'  => $this->type,
                               'name'  => $name,
                               'value' => '',
                           ],
                           __('Other', 'totalsurvey')
                       )
                   )
                   ->addContent(
                       Html::create(
                           'input',
                           [
                               'type'        => 'text',
                               'name'        => '',
                               'data-target' => $name,
                               'id'          => $this->definition->uid,
                               'placeholder' => $label,
                           ]
                       )
                   );
    }
}