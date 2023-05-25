<?php

namespace TotalSurvey\Tasks\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Blocks\Choices;
use TotalSurvey\Blocks\Date;
use TotalSurvey\Blocks\Dropdown;
use TotalSurvey\Blocks\MultipleChoices;
use TotalSurvey\Blocks\Number;
use TotalSurvey\Blocks\Paragraph;
use TotalSurvey\Blocks\Scale;
use TotalSurvey\Blocks\Text;
use TotalSurvey\Blocks\TextArea;
use TotalSurvey\Blocks\Title;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class RegisterBlockTypes
 *
 * @method static void invoke()
 * @method static void invokeWithFallback($fallback)
 */
class RegisterDefaultBlockTypes extends Task
{
    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function execute()
    {
        Paragraph::register();
        Title::register();
        Text::register();
        TextArea::register();
        Date::register();
        Number::register();
        Choices::register();
        MultipleChoices::register();
        Scale::register();
        Dropdown::register();
    }
}
