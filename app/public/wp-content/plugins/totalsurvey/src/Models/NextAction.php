<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;

/**
 * Class NextAction
 *
 * @package TotalSurvey\Models
 *
 * @property string $action
 * @property string $section_uid
 */
class NextAction extends Model
{
    public function isNext() {
        return $this->action === Survey::ACTION_NEXT;
    }

    public function isSkip() {
        return $this->action === Survey::ACTION_SECTION;
    }

    public function isSubmit() {
        return $this->action === Survey::ACTION_SUBMIT;
    }
}