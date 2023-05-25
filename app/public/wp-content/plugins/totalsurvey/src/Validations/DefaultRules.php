<?php

namespace TotalSurvey\Validations;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;

class DefaultRules
{
    protected static $fileTypes = [
        "documents" => ['docx', 'pdf', 'txt', 'pptx'],
        "images"    => ['png', 'jpg', 'jpeg'],
        "videos"    => ['avi', 'mp4', 'mov'],
        "archives"  => ['zip', 'rar', 'tar', 'gzip']
    ];

    /**
     * @return string
     */
    public static function required(): string
    {
        return 'required';
    }

    /**
     * @return string
     */
    public static function email(): string
    {
        return 'email';
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public static function minValue($value): string
    {
        return sprintf('min:%d', (int)$value);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public static function maxValue($value): string
    {
        return sprintf('max:%d', (int)$value);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public static function minLength($value): string
    {
        return static::minValue($value);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public static function maxLength($value): string
    {
        return static::maxValue($value);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public static function minSelection($value): string
    {
        return static::minValue($value);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public static function maxSelection($value): string
    {
        return static::maxValue($value);
    }

    /**
     * @param string $date
     *
     * @return string
     */
    public static function beforeDate($date): string
    {
        $date = date('Y-m-d', strtotime($date));

        return sprintf('date:Y-m-d|before:%s', $date);
    }

    /**
     * @param string $date
     *
     * @return string
     */
    public static function afterDate($date): string
    {
        $date = date('Y-m-d', strtotime($date));

        return sprintf('date:Y-m-d|after:%s', $date);
    }

    /**
     * @return string
     */
    public static function number(): string
    {
        return 'numeric';
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public static function date($format): string
    {
        return sprintf('date:%s', $format);
    }

    // Intrinsic validations

    /**
     * @param $values
     *
     * @return string
     */
    public static function inArray($values): string
    {
        return sprintf('inArray:%s', implode(',', (array)$values));
    }

    /**
     * @param int $min
     * @param int $max
     *
     * @return string
     */
    public static function between($min, $max): string
    {
        return sprintf('between:%d,%d', $min, $max);
    }

    /**
     * @return string
     */
    public static function file()
    {
        return 'uploaded_file:100KB';
    }

    /**
     * @param array $types
     *
     * @return string
     */
    public static function fileType(array $types)
    {
        $types = array_keys(array_filter($types));
        $allowed = Arrays::flatten(Arrays::only(static::$fileTypes, $types));
        return sprintf('mimes:%s', implode(',', $allowed));
    }

    /**
     * @param int $size
     *
     * @return string
     */
    public static function fileSize($size)
    {
        return sprintf('max:%s', $size . 'KB');
    }
}