<?php

namespace TotalSurvey\Tasks\Surveys;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Exceptions\Limitations\UnauthenticatedUser;
use TotalSurvey\Exceptions\Limitations\UnauthorizedUser;
use TotalSurvey\Models\Survey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;
use WP_User;

/**
 * Class CheckLimitations
 * @package TotalSurvey\Tasks\Surveys
 *
 * @method static void invoke(Survey $survey)
 * @method static void invokeWithFallback($fallback, Survey $survey)
 */
class CheckLimitations extends Task
{
    /**
     * @var Survey
     */
    protected $survey;

    /**
     * @var WP_User
     */
    protected $user;

    /**
     * CheckLimitations constructor.
     *
     * @param Survey $survey
     */
    public function __construct(Survey $survey)
    {
        $this->survey = $survey;
        $this->user   = wp_get_current_user();
    }

    protected function validate()
    {
        return true;
    }

    /**
     * @throws Exception
     */
    protected function execute()
    {
        if ($this->survey->isLimitationEnabled('authentication')) {
            UnauthenticatedUser::throwIf(
                $this->user->ID === 0,
                __('This survey is limited to authenticated users.', 'totalsurvey'),
                [],
                501
            );

            if ($this->survey->getLimitationParams('authentication', 'options.specificRoles', false)) {
                $roles = $this->survey->getLimitationParams('authentication', 'options.roles', []);
                $roles = array_keys(array_filter($roles));

                $match = array_intersect((array)$this->user->roles, $roles);
                UnauthorizedUser::throwIf(
                    empty($match),
                    __(
                        'This survey is limited to a specific group of users, please consider contacting your administrator if you think that is a mistake.',
                        'totalsurvey'
                    )
                );
            }
        }
    }
}