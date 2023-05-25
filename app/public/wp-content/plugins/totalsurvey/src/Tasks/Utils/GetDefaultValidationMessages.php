<?php

namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetDefaultValidationMessages
 *
 * @package TotalSurvey\Tasks
 * @method static array invoke()
 * @method static array invokeWithFallback(array $fallback)
 */
class GetDefaultValidationMessages extends Task
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
        $messages = [];

        $messages['required']      = __('Required', 'totalsurvey');
        $messages['email']         = __('Must be a valid email', 'totalsurvey');
        $messages['min']           = str_replace(['{{min}}'], [':min'], __('Minimum is {{min}}', 'totalsurvey'));
        $messages['max']           = str_replace(['{{max}}'], [':max'], __('Maximum is {{max}}', 'totalsurvey'));
        $messages['before']        = str_replace(
            ['{{time}}'],
            [':time'],
            __('Must be a date before {{time}}', 'totalsurvey')
        );
        $messages['after']         = str_replace(
            ['{{time}}'],
            [':time'],
            __('Must be a date after {{time}}', 'totalsurvey')
        );
        $messages['numeric']       = __('Must be numeric', 'totalsurvey');
        $messages['date']          = __('Must be a valid date format', 'totalsurvey');
        $messages['between']       = str_replace(
            ['{{min}}', '{{max}}'],
            [':min', ':max'],
            __('Must be between {{min}} and {{max}}', 'totalsurvey')
        );
        $messages['uploaded_file'] = __('Must be a valid uploaded file', 'totalsurvey');
        $messages['mimes']         = str_replace(
            ['{{allowedTypes}}'],
            [':allowed_types'],
            __('File type must be {{allowedTypes}}', 'totalsurvey')
        );
        $messages['in']            = str_replace(
            ['{{allowedValues}}'],
            [':allowed_values'],
            __('Must be one of: {{allowedValues}}', 'totalsurvey')
        );

        return $messages;
    }
}
