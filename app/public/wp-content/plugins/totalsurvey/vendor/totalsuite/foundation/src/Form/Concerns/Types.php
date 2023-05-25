<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\Form\Concerns;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Checkbox;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Color;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Date;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Email;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\File;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Hidden;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Month;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Number;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Password;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Radio;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Range;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Select;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Tel;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Text;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\TextArea;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Time;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Url;
use TotalSurveyVendors\TotalSuite\Foundation\Form\Fields\Week;

/**
 * Trait Types
 *
 * @package TotalSurveyVendors\TotalSuite\Foundation\Form\Concerns
 */
trait Types
{
    /**
     * @var array
     */
    protected static $fieldTypes = [
        'checkbox' => Checkbox::class,
        'color'    => Color::class,
        'date'     => Date::class,
        'email'    => Email::class,
        'file'     => File::class,
        'hidden'   => Hidden::class,
        'month'    => Month::class,
        'number'   => Number::class,
        'password' => Password::class,
        'radio'    => Radio::class,
        'range'    => Range::class,
        'tel'      => Tel::class,
        'text'     => Text::class,
        'time'     => Time::class,
        'url'      => Url::class,
        'week'     => Week::class,
        'select'   => Select::class,
        'textarea' => TextArea::class,
    ];

    /**
     * @param string $type
     * @param string $class
     */
    public static function addFieldType($type, $class): void
    {
        static::$fieldTypes[$type] = $class;
    }

    /**
     * @param $type
     *
     * @return bool|mixed
     */
    public static function getFieldType($type)
    {
        if (static::hasFieldType($type)) {
            return static::$fieldTypes[$type];
        }

        return false;
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public static function hasFieldType($type)
    {
        return array_key_exists($type, static::$fieldTypes);
    }
}