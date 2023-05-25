<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Database\Concerns;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Database\Query;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;

trait QueryHelpers
{
    /**
     * @param $name
     * @param null $model
     * @return Query
     * @throws DatabaseException
     */
    public static function table($name, $model = null)
    {
        $query = new Query($name);
        if ($model) {
            $query->setModel($model);
        }

        return $query;
    }
}
