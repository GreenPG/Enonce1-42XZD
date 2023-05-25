<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Database\Query;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Concerns\Limit;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Concerns\Order;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Concerns\Where;

/**
 * Class Delete
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Database\Query
 */
class Delete extends BaseQuery
{
    use Where, Order, Limit;
}