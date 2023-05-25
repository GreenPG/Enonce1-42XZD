<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Concerns\HasRichText;
use TotalSurvey\Models\Concerns\Translatable;
use TotalSurvey\Services\BlockRegistry;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;

/**
 * Class Block
 *
 * @package TotalSurvey\Models
 *
 * @property string $uid
 * @property string $label
 * @property string $title
 * @property string $category
 * @property string $typeId
 * @property FieldDefinition $field
 * @property array $content
 */
class Block extends Model
{
    use Translatable, HasRichText;

    /**
     * Types
     */
    const CATEGORY_QUESTION = 'question';
    const TYPE_CONTENT      = 'content';

    /**
     * @var Section
     */
    public $section;

    /**
     * Cast.
     *
     * @var string[]
     */
    protected $types = [
        'field'   => 'field',
        'content' => 'array',
    ];

    /**
     * @var \TotalSurvey\Blocks\BlockType
     */
    public $blockType;

    /**
     * Constructor.
     *
     * @param  Section  $section
     * @param  array  $attributes
     */
    public function __construct(Section $section = null, $attributes = [])
    {
        $attributes['category'] = $attributes['category'] ?? (empty($attributes['type']) ? Block::CATEGORY_QUESTION : $attributes['type']);
        $attributes['title']    = $attributes['title'] ?? $attributes['label'] ?? '';

        if (!empty($attributes['title_raw']) && is_array($attributes['title_raw'])) {
            $attributes['title'] = static::convertRichTextBlocksToText($attributes['title_raw']);
        }

        if (!empty($attributes['content']['value_raw']) &&
            is_array($attributes['content']['value_raw']) &&
            count($attributes['content']['value_raw']) > 0 && isset($attributes['content']['value_raw'][0])) {
            $attributes['content']['value'] = static::convertRichTextBlocksToText($attributes['content']['value_raw']);
        }

        unset($attributes['type'], $attributes['label']);

        $this->section = $section;

        $blockCategory = $attributes['category'] ?? $attributes['type'] ?? self::CATEGORY_QUESTION;
        $type          = $attributes['content']['type'] ?? $attributes['field']['type'];
        $this->typeId  = $attributes['typeId'] ?? "$blockCategory:$type";


        $this->blockType = BlockRegistry::blockTypeFrom($this->typeId, null) ?? BlockRegistry::blockTypeFrom($type);

        if ($this->blockType) {
            $this->typeId = $this->blockType::getTypeId();
        }

        $attributes = static::applyTranslations($attributes, $this->blockType::getTranslatableAttributes());

        if (!empty($attributes['field']['uid'])) {
            $attributes['uid'] = $attributes['field']['uid'];
        }

        parent::__construct($attributes);
    }

    /**
     * @param  array  $data
     *
     * @return FieldDefinition
     */
    public function castToField(array $data): FieldDefinition
    {
        return new FieldDefinition($this, $data);
    }

    /**
     * @param  string|null  $name
     * @param  mixed  $default
     *
     * @return mixed
     */
    public function value($name = null, $default = null)
    {
        return $this->getAttribute('content.value'.($name ? ".$name" : ''), $default);
    }

    /**
     * @param $name
     * @param  null  $default
     *
     * @return mixed
     */
    public function option($name, $default = null)
    {
        return $this->getAttribute("content.options.{$name}", $this->getAttribute("field.options.{$name}", $default));
    }

    /**
     * @return bool
     */
    public function isQuestion()
    {
        return $this->category === self::CATEGORY_QUESTION;
    }

    /**
     * @return bool
     */
    public function isContent()
    {
        return $this->category === self::TYPE_CONTENT;
    }

    /**
     * @return string
     */
    public function render()
    {
        return $this->blockType::render($this);
    }

    public static function getTranslatableAttributes()
    {
        return [
            'title',
            'description',
            'field.options.placeholder',
            'content.value',
        ];
    }
}
