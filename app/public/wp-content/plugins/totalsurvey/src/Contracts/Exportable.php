<?php

namespace TotalSurvey\Contracts;
! defined( 'ABSPATH' ) && exit();


//@TODO: Extract this contract to the foundation framework

/**
 * Interface Exportable
 *
 * @package TotalSurvey\Contracts
 */
interface Exportable
{
    /**
     * @param $format
     *
     * @return mixed
     */
    public function toExport($format);
}