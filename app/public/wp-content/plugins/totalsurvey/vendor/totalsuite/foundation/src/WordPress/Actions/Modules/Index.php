<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Modules;
! defined( 'ABSPATH' ) && exit();


use Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

class Index extends Action
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * Index constructor.
     *
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function execute()
    {
        return $this->manager->fetch()
                             ->values()
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
