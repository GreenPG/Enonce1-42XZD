<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Contracts\Support\Arrayable;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class DuplicateSurvey
 *
 * @package TotalSurvey\Tasks\Survey
 * @method static Survey invoke(string $surveyUid)
 * @method static Survey invokeWithFallback($fallback, string $surveyUid)
 */
class DuplicateSurvey extends Task
{

    /**
     * @var string
     */
    protected $surveyUid;

    /**
     * GetSurvey constructor.
     *
     * @param  string  $surveyUid
     */
    public function __construct(string $surveyUid)
    {
        $this->surveyUid = $surveyUid;
    }

    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function execute()
    {
        $survey = Survey::byUid($this->surveyUid);

        $uids = $this->regenerateUids($survey->getAttributes());

        $data = json_decode(
            str_replace(
                array_keys($uids),
                array_values($uids),
                json_encode($survey->getAttributes())
            ),
            true
        );

        $data['name'] .= '(Copy)';
        unset($data['id']);

        $clone = new Survey($data);
        $clone->save();


        return $clone;
    }

    /**
     * @param $array
     * @param  array  $uids
     *
     * @return array
     */
    protected function regenerateUids($array, array &$uids = [])
    {
        foreach ($array as $key => $value) {
            if ($value instanceof Arrayable) {
                $this->regenerateUids($value->toArray(), $uids);
            } elseif (is_array($value)) {
                $this->regenerateUids($value, $uids);
            } elseif ($key === 'uid') {
                $uids[$value] = wp_generate_uuid4();
            }
        }

        return $uids;
    }
}
