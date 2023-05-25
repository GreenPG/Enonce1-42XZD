<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Exceptions\Surveys\SurveyNotFound;
use TotalSurvey\Exceptions\Surveys\SurveySectionNotFound;
use TotalSurvey\Filters\Surveys\SurveyLinkFilter;
use TotalSurvey\Models\Concerns\SurveySettings;
use TotalSurvey\Models\Concerns\Translatable;
use TotalSurvey\Plugin;
use TotalSurvey\Tasks\Reports\GenerateHTMLReport;
use TotalSurvey\Tasks\Reports\SendSurveyReportToEmail;
use TotalSurvey\Tasks\Reports\StoreSurveyReportFile;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;
use TotalSurveyVendors\TotalSuite\Foundation\Database\TableModel;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;

/**
 * Class SurveyReport
 *
 * @property string $uid
 * @property string $email
 * @property string $interval
 * @property string $intervalStart
 * @property string $intervalEnd
 * @property string $intervalTimestamp
 * @property string $intervalLabel
 * @property Survey $survey
 * @property array $sections
 * @property string $url
 * @property string $path
 * @property string $html
 *
 * @package TotalSurvey\Models
 */
class SurveyReport extends Model
{
    public $survey;

    public function __construct(Survey $survey, $attributes = [])
    {
        $this->survey                    = $survey;
        $attributes['uid']               = Strings::uid();
        $attributes['email']             = $attributes['email'] ?? $survey->getReportEmail();
        $attributes['interval']          = $survey->getReportInterval();
        $attributes['intervalLabel']     = $attributes['intervalLabel'] ?? $survey->getReportIntervalLabel();
        $attributes['intervalStart']     = $attributes['intervalStart'] ?? $survey->getReportIntervalStartTimestamp();
        $attributes['intervalEnd']       = $attributes['intervalEnd'] ?? $survey->getReportIntervalEndTimestamp();
        $attributes['intervalTimestamp'] = $survey->getReportIntervalTimestamp();
        $attributes['label']             = $attributes['label'] ?? $survey->getReportIntervalLabel();
        $attributes['sections']          = $attributes['sections'] ?? $survey->getReportSections();
        $attributes['url']               = Plugin::env('url.userReports.base')."/{$attributes['uid']}.html";
        $attributes['path']              = Plugin::env('path.userReports')."/{$attributes['uid']}.html";
        parent::__construct($attributes);
    }

    public function html()
    {
        if (!$this->hasAttribute('html')) {
            $this->setAttribute('html', GenerateHTMLReport::invoke($this));
        }

        return $this->getAttribute('html');
    }

    public function send()
    {
        return SendSurveyReportToEmail::invoke($this);
    }

    public function store()
    {
        return StoreSurveyReportFile::invoke($this);
    }
}
