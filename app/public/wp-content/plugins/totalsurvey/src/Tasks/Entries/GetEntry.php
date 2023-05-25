<?php


namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Filters\Entries\EntryFilter;
use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetEntry
 * @package TotalSurvey\Tasks\Entries
 * @method static Entry invoke(string $entryUid)
 * @method static Entry invokeWithFallback($fallback, string $entryUid)
 */
class GetEntry extends Task
{
    /**
     * @var string
     */
    protected $entryUid;

    /**
     * GetEntry constructor.
     *
     * @param string $entryUid
     */
    public function __construct(string $entryUid)
    {
        $this->entryUid = $entryUid;
    }

    /**
     * @return bool
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @return mixed|Entry
     * @throws Exception
     */
    protected function execute()
    {
        $entry = Entry::byUid($this->entryUid);
        return EntryFilter::apply($entry);
    }

}
