<?php

namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Entry;
use TotalSurvey\Models\Section;
use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\Sections\ExtractSectionData;
use TotalSurvey\Tasks\Sections\ProcessSection;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class ExtractEntryData
 *
 * @package TotalSurvey\Tasks\Entries
 * @method static Collection invoke(Survey $survey, array $data, array $files)
 * @method static Collection invokeWithFallback($fallback, Survey $survey, array $data, array $files)
 */
class ExtractEntryData extends Task
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $files = [];

    /**
     * @var Survey
     */
    protected $survey;

    /**
     * @var Entry
     */
    protected $entry;

    /**
     * ExtractEntryData constructor.
     *
     * @param  Survey  $survey
     * @param  array  $data
     * @param  array  $files
     *
     * @throws Exception
     */
    public function __construct(Survey $survey, array $data, array $files = [])
    {
        $this->survey = $survey;
        $this->data   = $data;
        $this->files  = $files;
    }

    /**
     * @return bool|mixed|void
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @return mixed|Collection
     * @throws Exception
     */
    protected function execute()
    {
        $entryData             = Arrays::only($this->data, ['ip', 'agent','language']);
        $entryData['sections'] = [];

        $sections = $this->survey->sections->getIterator();

        /**
         * @var Section $section
         */
        foreach ($sections as $section) {
            $entryData['sections'][$section->uid] = ExtractSectionData::invoke(
                $section->uid,
                $this->data,
                $this->files
            );

            $nextAction = ProcessSection::invoke(
                $this->survey->uid,
                $section->uid,
                $entryData['sections'][$section->uid]
            );

            if ($nextAction->isSubmit()) {
                break;
            }

            if ($nextAction->isSkip()) {
                while ($sections->valid()) {
                    $sections->next();
                    if ($nextAction->section_uid === $sections->current()->uid) {
                        $sections->seek($sections->key() - 1);
                        continue 2;
                    }
                }
            }
        }

        return Collection::create($entryData);
    }
}
