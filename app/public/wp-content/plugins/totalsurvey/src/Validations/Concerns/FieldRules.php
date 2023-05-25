<?php
/** @noinspection PhpUnused */


namespace TotalSurvey\Validations\Concerns;
! defined( 'ABSPATH' ) && exit();



trait FieldRules
{
    /**
     * @return string
     */
    public function validateRequired(): string
    {
        return 'required';
    }

    /**
     * @return string
     */
    public function validateEmail(): string
    {
        return 'email';
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public function validateMinValue($value): string
    {
        return sprintf('min:%d', (int)$value);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public function validateMaxValue($value): string
    {
        return sprintf('max:%d', (int)$value);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public function validateMinLength($value): string
    {
        return $this->validateMinValue($value);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public function validateMaxLength($value): string
    {
        return $this->validateMaxValue($value);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public function validateMinSelection($value): string
    {
        return $this->validateMinValue($value);
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public function validateMaxSelection($value): string
    {
        return $this->validateMaxValue($value);
    }

    /**
     * @param string $date
     *
     * @return string
     */
    public function validateBeforeDate($date): string
    {
        $date = date('Y-m-d', strtotime($date));

        return sprintf('dateFormat:Y-m-d|before:%s', $date);
    }

    /**
     * @param string $date
     *
     * @return string
     */
    public function validateAfterDate($date): string
    {
        $date = date('Y-m-d', strtotime($date));

        return sprintf('dateFormat:Y-m-d|after:%s', $date);
    }

    /**
     * @return string
     */
    public function validateNumber(): string
    {
        return 'numeric';
    }

    /**
     * @param string $format
     *
     * @return string
     */
    public function validateDate($format): string
    {
        return sprintf('date:%s', $format);
    }

    // Intrinsic validations

    /**
     * @param $values
     *
     * @return string
     */
    public function validateInArray($values): string
    {
        return sprintf('inArray:%s', implode(',', (array)$values));
    }

    /**
     * @param int $min
     * @param int $max
     *
     * @return string
     */
    public function validateBetween($min, $max): string
    {
        return sprintf('between:%d,%d', $min, $max);
    }
}