<?php
namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


/**
 * Class Content
 *
 * @package TotalSurvey\Models
 */
class Content extends Block
{
    protected $types = [
        'content' => 'array',
    ];

    public function is($type) {
        return $this->getAttribute('content.type') === $type;
    }

    public function value() {
        return $this->getAttribute('content.value');
    }

    public function option($name, $default = null) {
        return $this->getAttribute('content.options.' . $name, $default);
    }
}