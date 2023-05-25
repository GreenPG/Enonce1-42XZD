<?php

namespace TotalSurvey\Fields;
! defined( 'ABSPATH' ) && exit();


class MultipleChoices extends Choices
{
    protected $type = 'checkbox';

    protected $multiple = true;
}