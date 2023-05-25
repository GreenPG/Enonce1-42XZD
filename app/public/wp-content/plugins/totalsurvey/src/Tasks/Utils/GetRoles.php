<?php

namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetRoles
 *
 * @package TotalSurvey\Tasks
 * @method static array invoke()
 * @method static array invokeWithFallback(array $fallback)
 */
class GetRoles extends Task
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
        $roles = [];

        if (!is_admin()) {
            return $roles;
        }

        foreach (get_editable_roles() as $roleId => $role) {
            $roles[] = [
                'id'   => $roleId,
                'name' => $role['name'],
            ];
        }

        return $roles;
    }
}
