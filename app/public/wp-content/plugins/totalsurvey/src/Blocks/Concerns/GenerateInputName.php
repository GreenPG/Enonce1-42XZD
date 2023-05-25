<?php

namespace TotalSurvey\Blocks\Concerns;
! defined( 'ABSPATH' ) && exit();



trait GenerateInputName
{
    public static function getInputName(...$args)
    {
        $name = array_shift($args) ?? '';

        foreach ($args as $arg) {
            $name .= "[{$arg}]";
        }

        return $name;
    }
}
