<?php

namespace TotalSurvey\Actions\Dashboard;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Capabilities\UserCanViewData;
use TotalSurvey\Models\Entry;
use TotalSurvey\Tasks\Dashboard\ActivityFeed;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;

class Activity extends Action
{

    /**
     * @return Response
     * @throws Exception
     */
    public function execute(): Response
    {
        return ActivityFeed::invoke()
                           ->map(
                               static function (Entry $entry) {
                                   return $entry->withUser()
                                                ->withSurey();
                               }
                           )
                           ->toJsonResponse();
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return UserCanViewData::check();
    }
}
