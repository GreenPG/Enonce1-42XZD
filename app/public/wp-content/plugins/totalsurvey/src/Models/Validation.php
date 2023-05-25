<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;

/**
 * Class Validation
 *
 * @package TotalSurvey\Models
 *
 * @property string $name
 * @property boolean $enabled
 * @property array $options
 * @property string[] $messages
 */
class Validation extends Model
{
    /**
     * @var string[]
     */
    protected $types = [
        'enabled'  => 'bool',
        'options'  => 'array',
        'messages' => 'array',
    ];

    /**
     * @param $name
     * @param $default
     *
     * @return mixed
     */
    public function option($name, $default = null)
    {
        return Arrays::get($this->options, $name, $default);
    }

    public function jsonSerialize(): array
    {
        $json            = parent::jsonSerialize();
        $json['options'] = (object) $json['options'];

        return $json;
    }
}
