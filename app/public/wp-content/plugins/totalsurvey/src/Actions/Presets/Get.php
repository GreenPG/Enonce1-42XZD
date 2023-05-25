<?php
namespace TotalSurvey\Actions\Presets;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Capabilities\UserCanCreateSurvey;
use TotalSurvey\Models\Preset;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;

class Get extends Action
{
    /**
     * @return bool
     */
    public function authorize():bool
    {
        return UserCanCreateSurvey::check();
    }

    /**
     * @param $presetUid
     *
     * @return Response
     * @throws Exception
     */
    protected function execute($presetUid) {
        return ResponseFactory::json(Preset::getByUid($presetUid));
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'presetUid' => [
                'expression'        => '(?<presetUid>([\w-]+))',
                'sanitize_callback' => static function ($presetUid) {
                    return (string)$presetUid;
                },
            ],
        ];
    }
}