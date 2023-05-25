<?php

namespace TotalSurvey\Actions\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Tasks\Sections\ExtractSectionData;
use TotalSurvey\Tasks\Sections\ProcessSection;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;

class Section extends Action
{
    /**
     * @return Response
     * @throws Exception
     */
    public function execute(): Response
    {
        $data  = $this->request->getParsedBody();
        $files = $this->request->getUploadedFiles();

        $surveyUid   = Arrays::pull($data, 'survey_uid', '');
        $sectionUid  = Arrays::pull($data, 'section_uid', '');
        $sectionData = ExtractSectionData::invoke($sectionUid, $data, $files);

        return ProcessSection::invoke($surveyUid, $sectionUid, $sectionData)
                             ->toJsonResponse();
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
