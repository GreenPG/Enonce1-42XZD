<?php

namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

/**
 * Class ViewSuvey
 *
 * @package TotalSurvey\Tasks\Survey
 */
class ViewEntry extends Task
{
    /**
     * @var Entry
     */
    protected $entry;

    /**
     * @var Engine
     */
    protected $engine;

    /**
     * @var Manager
     */
    protected $manager;

    /**
     * ViewSuvey constructor.
     *
     * @param  Manager  $manager
     * @param  Engine  $engine
     * @param  Entry  $entry
     */
    public function __construct(Manager $manager, Engine $engine, Entry $entry)
    {
        $this->entry   = $entry;
        $this->manager = $manager;
        $this->engine  = $engine;
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
     * @throws \Exception
     */
    protected function execute()
    {
        $renderedEntry = $this->entry->render();

        // Add survey to the title
        add_filter(
            'wp_title_parts',
            function ($parts) {
                array_unshift($parts, $this->entry->uid);

                return $parts;
            }
        );

        // Render view
        return $this->engine->render(
            'entry',
            [
                'entry'   => $this->entry,
                'survey'  => $this->entry->survey(),
                'content' => $renderedEntry,
            ]
        );
    }
}
