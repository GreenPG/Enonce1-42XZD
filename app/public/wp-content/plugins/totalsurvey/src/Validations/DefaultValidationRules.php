<?php

namespace TotalSurvey\Validations;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Validation;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;

class DefaultValidationRules
{
    protected static $fileTypes = [
        "documents" => ['docx', 'pdf', 'txt', 'pptx'],
        "images"    => ['png', 'jpg', 'jpeg'],
        "videos"    => ['avi', 'mp4', 'mov'],
        "archives"  => ['zip', 'rar', 'tar', 'gzip'],
    ];

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function required(Validation $validation)
    {
        return 'required';
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function email(Validation $validation)
    {
        return 'email';
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function minValue(Validation $validation)
    {
        return sprintf('min:%d', (int) $validation->option('value', 0));
    }



    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function maxValue(Validation $validation)
    {
        return sprintf('max:%d', (int) $validation->option('value', 0));
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function minLength(Validation $validation)
    {
        return sprintf('minLength:%s', (int) $validation->option('value', 0));
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function maxLength(Validation $validation)
    {
        return sprintf('maxLength:%s', (int) $validation->option('value', 0));
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function minSelection(Validation $validation)
    {
        return static::minValue($validation);
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function maxSelection(Validation $validation)
    {
        return static::maxValue($validation);
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function beforeDate(Validation $validation)
    {
        $date = date('Y-m-d', strtotime($validation->option('value')));

        return sprintf('maxDate:%s', $date);
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function afterDate(Validation $validation)
    {
        $date = date('Y-m-d', strtotime($validation->option('value')));

        return sprintf('minDate:%s', $date);
    }

    /**
     * @return string
     */
    public static function number()
    {
        return 'numeric';
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function date(Validation $validation)
    {
        return sprintf('date:%s', $validation->option('format'));
    }

    // Intrinsic validations

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function inArray(Validation $validation)
    {
        return sprintf('in_array:%s', implode(',', (array) $validation->option('values')));
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function between(Validation $validation)
    {
        return sprintf('between:%d,%d', $validation->option('min', 0), $validation->option('max', 0));
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function file(Validation $validation)
    {
        return 'uploaded_file';
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function fileType(Validation $validation)
    {
        $types   = array_keys(array_filter($validation->options));
        $allowed = Arrays::flatten(Arrays::only(static::$fileTypes, $types));

        return sprintf('mimes:%s', implode(',', $allowed));
    }

    /**
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function fileSize(Validation $validation)
    {
        return sprintf('max:%s', "{$validation->option('value', 0)}KB");
    }


    public static function noop(Validation $validation)
    {
        return;
    }

    /**
     * @param  string  $name
     * @param  Validation  $validation
     *
     * @return string
     */
    public static function from($name, Validation $validation)
    {
        return is_callable([static::class, $name]) ? static::$name($validation) : null;
    }
}
