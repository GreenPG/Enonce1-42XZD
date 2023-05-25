<?php

namespace TotalSurvey\Tasks\Dashboard;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class ActivityFeed
 * @package TotalSurvey\Tasks\Dashboard
 * @method static Collection invoke()
 * @method static Collection invokeWithFallback($fallback)
 */
class ActivityFeed extends Task
{
    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws DatabaseException
     */
    protected function execute()
    {
        return Entry::query()
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
    }
}
