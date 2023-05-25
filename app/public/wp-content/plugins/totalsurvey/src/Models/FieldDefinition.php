<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class Field
 *
 * @package TotalSurvey\Models
 *
 * @property string $uid
 * @property string $type
 * @property array $options
 * @property Collection | Validation[] $validations
 */
class FieldDefinition extends Model
{
    protected $types = [
        'options'     => 'array',
        'validations' => 'validations',
    ];

    /**
     * @var Block
     */
    public $question;

    /**
     * FieldDefinition constructor.
     *
     * @param  Block  $question
     * @param  array  $attributes
     */
    public function __construct(Block $question, $attributes = [])
    {
        $attributes['uid'] = $attributes['uid'] ?? $question->uid;

        parent::__construct($attributes);
        $this->question = $question;
    }


    /**
     * @param  array  $data
     *
     * @return Collection
     * @noinspection PhpUnused
     */
    public function castToValidations(array $data): Collection
    {
        $validations = [];

        foreach ($data as $name => $validation) {
            $validations[$name] = new Validation($validation);
        }

        return Collection::create($validations);
    }

    /**
     * @return Collection<Validation>|Validation[]
     */
    public function getEnabledValidations()
    {
        return $this->validations->where(['enabled' => true]);
    }

    /**
     * @param  string  $attribute
     *
     * @param  null  $key
     *
     * @return array
     */
    public function getChoicesAttribute($attribute, $key = null): array
    {
        $choices = $this->getAttribute('options.choices', []);

        if (empty($choices)) {
            return [];
        }

        if ($this->allowOther()) {
            $choices[] = [
                'uid'   => 'other',
                'label' => __('Other', 'totalsurvey'),
            ];
        }

        return Arrays::extract($choices, $attribute, $key);
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        $required = $this->validations->get('required');

        return isset($required['enabled']) && $required['enabled'] === true;
    }

    /**
     * @return bool
     */
    public function allowOther(): bool
    {
        return (bool) $this->getAttribute('options.allowOther', false);
    }

    public function jsonSerialize(): array
    {
        $json            = parent::jsonSerialize();
        $json['options'] = (object) $json['options'];

        return $json;
    }
}
