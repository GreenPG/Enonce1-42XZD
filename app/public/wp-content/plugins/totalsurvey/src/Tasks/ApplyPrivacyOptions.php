<?php


namespace TotalSurvey\Tasks;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Http\Request;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

/**
 * Class ApplyPrivacyOptions
 *
 * @package TotalSurvey\Tasks
 * @method static array invoke(Options $options, Request $request, array $data)
 * @method static array invokeWithFallback(Options $options, Request $request, array $data)
 */
class ApplyPrivacyOptions extends Task
{
    /**
     * @var Options
     */
    protected $options;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var Request
     */
    protected $request;

    /**
     * constructor.
     *
     * @param Options $options
     * @param Request $request
     * @param array $data
     */
    public function __construct(Options $options, Request $request, array $data)
    {
        $this->data    = $data;
        $this->request = $request;
        $this->options = $options;
    }

    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        $honorDNT = $this->options->get('privacy.honorDNT', false) && $this->request->hasHeader('dnt');

        if (isset($this->data['ip']) && ($honorDNT || $this->options->get('privacy.hashIP'))) {
            $this->data['ip'] = sha1($this->data['ip']);
        }

        if (isset($this->data['agent']) && ($honorDNT || $this->options->get('privacy.hashAgent'))) {
            $this->data['agent'] = sha1($this->data['ip']);
        }

        return $this->data;
    }
}