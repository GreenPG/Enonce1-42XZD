<?php

namespace TotalSurvey\Tasks\Sections;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\NextAction;
use TotalSurvey\Models\Section;
use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class ProcessSection
 *
 * @package TotalSurvey\Tasks\Sections
 * @method static NextAction invoke(string $surveyUid, string $sectionUid, Collection $entry)
 * @method static NextAction invokeWithFallback($fallback, string $surveyUid, string $sectionUid, Collection $entry)
 */
class ProcessSection extends Task
{
    /**
     * @var Survey
     */
    protected $survey;

    /**
     * @var Section
     */
    protected $section;

    /**
     * @var array
     */
    protected $entry = [];

    /**
     * ProcessSection constructor.
     *
     * @param  string  $surveyUid
     * @param  string  $sectionUid
     * @param  Collection|array  $entry
     *
     * @throws Exception
     */
    public function __construct(string $surveyUid, string $sectionUid, $entry)
    {
        $this->survey  = Survey::byUid($surveyUid);
        $this->section = $this->survey->getSection($sectionUid);
        $this->entry   = $entry;
    }

    /**
     * @inheritDoc
     * @return bool
     * @throws Exception
     */
    protected function validate()
    {
        ValidateSection::invoke($this->section, $this->entry);

        return true;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function execute()
    {
        return ProcessConditions::invoke($this->survey, $this->section, $this->entry);
    }
}
