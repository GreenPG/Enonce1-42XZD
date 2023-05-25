<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Actions\Onboarding;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Plugin;

class Collect extends Action
{
    /**
     * @var Options
     */
    protected $options;

    /**
     * Collect constructor.
     *
     * @param  Options  $options
     */
    public function __construct(Options $options)
    {
        $this->options = $options;
    }


    public function execute()
    {
        $data = array_merge([
            "status"     => "skip",
            "email"      => "",
            "audience"   => "other",
            "usage"      => "other",
            "tracking"   => false,
            "newsletter" => false
        ],
            $this->request->getParsedBody());


        $this->options->set('customer', $data)
                      ->save();

        $url = Plugin::env('url.tracking.onboarding');

        wp_remote_request($url,
            [
                'method'   => 'POST',
                'blocking' => false,
                'body'     => [
                    'uid'     => Plugin::uid(),
                    'product' => Plugin::env('product.id'),
                    'date'    => date(DATE_ATOM),
                    'data'    => $data
                ]
            ]);

        return ResponseFactory::json($data);
    }


    public function authorize(): bool
    {
        return true;
    }
}