<?php


namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Entry;
use TotalSurvey\Tasks\Utils\DeleteUploadedFiles;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class DeleteEntry
 * @package TotalSurvey\Tasks\Entries
 * @method static Entry invoke(string $entryUid)
 * @method static Entry invokeWithFallback($fallback, string $entryUid)
 */
class DeleteEntry extends Task
{
    /**
     * @var
     */
    protected $entryUid;

    /**
     * DeleteEntry constructor.
     *
     * @param $entryUid
     */
    public function __construct($entryUid)
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
     * @return Entry
     * @throws DatabaseException|Exception
     */
    protected function execute()
    {
        $entry = Entry::byUid($this->entryUid);
        Exception::throwUnless($entry->delete(), 'Could not delete the entry');

        DeleteUploadedFiles::invoke($entry->survey_uid . DIRECTORY_SEPARATOR . $entry->uid);

        return $entry;
    }
}
