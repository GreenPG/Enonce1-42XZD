<?php

namespace TotalSurvey\Tasks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Helpers\ReCaptcha;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Request;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;

/**
 * Class Captcha
 *
 * @package TotalSurvey\Tasks
 */
class Captcha extends Task
{
    /**
     * @var Options
     */
    protected $options;

    /**
     * @var Request
     */
    protected $request;


    /**
     * Captcha constructor.
     *
     * @param Request $request
     * @param Options $options
     */
    public function __construct(Request $request, Options $options)
    {
        $this->request = $request;
        $this->options = $options;
    }


    /**
     * @return bool|mixed|void
     */
    public function validate()
    {
        return true;
    }

    /**
     * @return bool|mixed
     * @throws Exception
     */
    public function execute()
    {
        if ($this->options->get('advanced.recaptcha.enabled', false)) {
            $secret    = $this->options->get('advanced.recaptcha.secret');
            $threshold = $this->options->get('advanced.recaptcha.threshold');
            $response  = $this->request->getParam('recaptcha');
            $ip        = $this->request->getServerParam('REMOTE_ADDR');

            $captcha = new ReCaptcha($secret, $threshold);

            if (!$captcha->verify($response, $ip)) {
                throw new Exception('Invalid captcha');
            }
        }

        return true;
    }
}
