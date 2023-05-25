<?php

namespace TotalSurvey\Actions\Entries;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\Entries\EntryCreatedResponseFilter;
use TotalSurvey\Models\Survey;
use TotalSurvey\Tasks\Entries\CreateEntry;
use TotalSurvey\Tasks\Entries\ExtractEntryData;
use TotalSurvey\Tasks\Utils\GetIP;
use TotalSurvey\Tasks\Utils\GetUserAgent;
use TotalSurvey\Tasks\Utils\HonorRequestLocale;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;

class Create extends Action
{
    /**
     * @return Response
     * @throws Exception
     */
    protected function execute(): Response
    {
        $data          = $this->request->getParsedBody();
        $data['ip']    = GetIP::invoke();
        $data['agent'] = GetUserAgent::invoke();
        $files         = $this->request->getUploadedFiles();

        $surveyUid = Arrays::pull($data, 'survey_uid', '');
        $survey    = Survey::byUidAndActive($surveyUid);
        $entryData = ExtractEntryData::invoke($survey, $data, $files);

        $entry = CreateEntry::invoke($survey, $entryData);

        return EntryCreatedResponseFilter::apply($entry->toPublic()->toJsonResponse(), $survey, $entry);
    }

    public function authorize(): bool
    {
        return true;
    }
}
