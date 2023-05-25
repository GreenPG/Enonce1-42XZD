<?php

namespace TotalSurvey\Actions\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Tasks\Entries\GetPublicEntry;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;

class GetPublic extends Action
{
    /**
     * @param  string  $entryUid
     *
     * @return Response
     * @throws Exception
     */
    public function execute($entryUid): Response
    {
        return GetPublicEntry::invoke($entryUid)
                             ->toJsonResponse();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'entryUid' => [
                'expression'        => '(?<entryUid>([\w-]+))',
                'sanitize_callback' => static function ($uid) {
                    return (string)$uid;
                },
            ],
        ];
    }
}