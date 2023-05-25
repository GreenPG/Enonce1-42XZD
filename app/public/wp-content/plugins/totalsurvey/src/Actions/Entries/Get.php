<?php

namespace TotalSurvey\Actions\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Capabilities\UserCanViewEntries;
use TotalSurvey\Tasks\Entries\GetEntry;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;

class Get extends Action
{
    /**
     * @param string $entryUid
     *
     * @return Response
     * @throws Exception
     */
    public function execute($entryUid): Response
    {
        return GetEntry::invoke($entryUid)
                       ->toJsonResponse();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return UserCanViewEntries::check();
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'entryUid' => [
                'expression'        => '(?<entryUid>([\w-]+))',
                'sanitize_callback' => static function ($entryUid) {
                    return (string)$entryUid;
                },
            ],
        ];
    }
}