<?php

namespace TotalSurvey\Tasks\Dashboard;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

//@TODO: Extract this task to the foundation framework

/**
 * Class BlogFeed
 *
 * @package TotalSurvey\Tasks\Dashboard
 */
class BlogFeed extends Task
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
     */
    protected function execute()
    {
        // Retrieve from cache first
        $cacheKey = md5(Plugin::env('url.blogFeed'));
        if ($cached = get_transient($cacheKey)):
            return Collection::create($cached);
        endif;

        // Fetch
        $request = wp_remote_get(Plugin::env('url.blogFeed'));

        // Decode response
        $response  = json_decode(wp_remote_retrieve_body($request), true) ?: [];
        $blogPosts = [];

        if (!empty($response)):
            $blogPosts = $response;

            // Cache
            set_transient($cacheKey, $blogPosts, DAY_IN_SECONDS * 2);
        endif;

        return Collection::create($blogPosts);
    }
}
