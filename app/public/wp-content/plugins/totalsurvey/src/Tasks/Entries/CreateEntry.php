<?php

namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Events\Entries\OnEntryReceived;
use TotalSurvey\Events\Entries\OnPostValidateEntry;
use TotalSurvey\Filters\Entries\BeforeEntrySaveFilter;
use TotalSurvey\Models\Entry;
use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class CreateEntry
 *
 * @package TotalSurvey\Tasks\Entries
 * @method static Entry invoke(Survey $survey, Collection $data)
 * @method static Entry invokeWithFallback($fallback, Survey $survey, Collection $data)
 */
class CreateEntry extends Task
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
     * CreateEntry constructor.
     *
     * @param  Survey  $survey
     * @param  Collection  $data
     *
     */
    public function __construct(Survey $survey, Collection $data)
    {
        $this->survey = $survey;
        $this->data   = $data;
    }

    /**
     * @return bool|mixed|void
     */
    protected function validate()
    {
        OnPostValidateEntry::emit($this->survey, $this->data);

        return true;
    }

    /**
     * @return Entry
     * @throws Exception
     * @throws DatabaseException
     * @throws \Exception
     */
    protected function execute()
    {
        $entry                         = Entry::fill($this->data->toArray());
        $entry->uid                    = Strings::uid();
        $entry->survey_uid             = $this->survey->uid;
        $entry->user_id                = get_current_user_id();
        $entry->created_at             = wp_date('Y-m-d H:i:s');
        $entry->ip                     = esc_html($this->data->get('ip'));
        $entry->agent                  = esc_html($this->data->get('agent'));
        $entry->status                 = Entry::STATUS_OPEN;
        $entry->data                   = TransformEntryDataToModels::invoke($this->survey, $entry, $this->data);
        $entry->data->meta['language'] = esc_html($this->data->get('language'));
        $entry                         = BeforeEntrySaveFilter::apply($entry, $this->survey, $this->data);

        Exception::throwUnless($entry->save(), __('Could not save the entry', 'totalsurvey'));

        OnEntryReceived::emit($this->survey, $entry);

        return $entry;
    }
}
