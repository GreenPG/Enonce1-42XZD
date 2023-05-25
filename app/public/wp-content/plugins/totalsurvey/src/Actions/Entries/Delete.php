<?php

namespace TotalSurvey\Actions\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Capabilities\UserCanDeleteEntries;
use TotalSurvey\Tasks\Entries\DeleteEntry;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;

class Delete extends Action
{
    /**
     * @param $entryUid
     *
     * @return Response
     * @throws Exception
     */
    public function execute(string $entryUid): Response
    {
        return DeleteEntry::invoke($entryUid)
                          ->toJsonResponse();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return UserCanDeleteEntries::check();
    }

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