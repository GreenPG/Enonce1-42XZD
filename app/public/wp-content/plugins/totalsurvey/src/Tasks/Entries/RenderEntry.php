<?php

namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();



use Exception;
use TotalSurvey\Models\Entry;
use TotalSurvey\Views\Template;
use TotalSurveyVendors\TotalSuite\Foundation\Contracts\Support\HTMLRenderable;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class RenderSurvey
 *
 * @package TotalSurvey\Tasks\Survey
 */
class RenderEntry extends Task
{
    /**
     * @var Entry
     */
    protected $entry;
    /**
     * @var Template
     */
    protected $template;

    /**
     * RenderSurvey constructor.
     *
     * @param  Template  $template
     * @param  Entry  $entry
     */
    public function __construct(Template $template, Entry $entry)
    {
        $this->entry   = $entry;
        $this->template = $template;
    }

    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function execute()
    {
        try {
            $rendered = $this->template->renderEntry($this->entry);
        } catch (Exception $exception) {
            if ($exception instanceof HTMLRenderable) {
                $rendered = $exception->toHTML();
            } else {
                $rendered = Html::create('p', [], $exception->getMessage());
            }
        }

        $wrapper = Html::create(
            'div',
            [
                'id'    => "totalsurvey-{$this->entry->uid}",
                'class' => 'totalsurvey-entry-wrapper',
            ],
            $rendered
        );

        return $wrapper->render();
    }
}
