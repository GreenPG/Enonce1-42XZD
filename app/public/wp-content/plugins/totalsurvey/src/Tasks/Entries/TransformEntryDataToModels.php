<?php

namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Entry;
use TotalSurvey\Models\EntryData;
use TotalSurvey\Models\EntrySection;
use TotalSurvey\Models\Survey;
use TotalSurvey\Plugin;
use TotalSurvey\Services\BlockRegistry;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class TransformEntryDataToModels
 *
 * @package TotalSurvey\Tasks\Entries
 * @method static EntryData invoke(Survey $survey, Entry $entry, Collection $data)
 * @method static EntryData invokeWithFallback($fallback, Survey $survey, Entry $entry, Collection $data)
 */
class TransformEntryDataToModels extends Task
{
    /**
     * @var Collection
     */
    protected $data;

    /**
     * @var Survey
     */
    protected $survey;

    /**
     * @var Entry
     */
    protected $entry;

    /**
     * TransformEntryDataToModels constructor.
     *
     * @param  Survey  $survey
     * @param  Entry  $entry
     * @param  Collection  $data
     */
    public function __construct(Survey $survey, Entry $entry, Collection $data)
    {
        $this->survey = $survey;
        $this->entry  = $entry;
        $this->data   = $data;
    }

    /**
     * @return bool
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @return EntryData
     * @throws Exception
     */
    protected function execute()
    {
        $model = EntryData::from($this->entry, [
            'sections' => [],
            'meta'     => [
                'version' => Plugin::env('version'),
            ],
        ]);

        foreach ($this->data->get('sections', []) as $sectionUid => $sectionData) {
            $section      = $this->survey->getSection($sectionUid);
            $entrySection = EntrySection::from(
                $model,
                [
                    'uid'    => $sectionUid,
                    'title'  => $section->title,
                    'blocks' => [],
                ]
            );

            foreach ($sectionData as $blockUid => $blockValue) {
                try {
                    $block = $section->getBlock($blockUid);
                } catch (Exception $e) {
                    continue;
                }

                $blockType  = BlockRegistry::blockTypeFrom($block->typeId);
                $entryBlock = $blockType::getEntryBlockFromRawValue($blockValue, $block, $entrySection, $this->entry);

                $entrySection->blocks->add($entryBlock);
            }

            $model['sections'][] = $entrySection;
        }

        return $model;
    }
}
