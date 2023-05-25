<?php

namespace TotalSurvey\Helpers;
! defined( 'ABSPATH' ) && exit();


//@TODO: Extract this helper to the foundation framework

/**
 * Class ReCaptcha
 *
 * @package TotalSurvey\Helpers
 */
class ReCaptcha
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $secret;
    /**
     * @var int
     */
    private $threshold;

    /**
     * ReCaptcha constructor.
     *
     * @param string $secret
     * @param float  $threshold
     */
    public function __construct(string $secret, $threshold = 0.5)
    {
        $this->secret    = $secret;
        $this->url       = 'https://www.google.com/recaptcha/api/siteverify';
        $this->threshold = $threshold;
    }

    /**
     * @param $token
     * @param $ip
     *
     * @return bool|string
     */
    public function verify($token, $ip = null)
    {
        $request = curl_init();
        curl_setopt($request, CURLOPT_URL, $this->url);
        curl_setopt($request, CURLOPT_POST, 3);
        curl_setopt(
            $request,
            CURLOPT_POSTFIELDS,
            [
                'secret'   => $this->secret,
                'response' => $token,
                'remoteip' => $ip,
            ]
        );
        curl_setopt($request, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($request, CURLOPT_TIMEOUT, 60);

        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($request), true);

        curl_close($request);

        return $response['success'] === true && $response['score'] >= $this->threshold;
    }

    /**
     * @param string $url
     *
     * @return ReCaptcha
     */
    public function setUrl(string $url): ReCaptcha
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $secret
     *
     * @return ReCaptcha
     */
    public function setSecret(string $secret): ReCaptcha
    {
        $this->secret = $secret;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

}