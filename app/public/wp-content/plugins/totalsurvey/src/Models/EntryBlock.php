<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Blocks\BlockType;
use TotalSurvey\Services\BlockRegistry;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class EntryBlock
 *
 * @package TotalSurvey\Models
 *
 * @property string $uid
 * @property string $title
 * @property mixed $value
 * @property string $text
 * @property string $type
 * @property string $typeId
 * @property Collection $meta
 * @property EntrySection $section
 */
class EntryBlock extends Model
{
    /**
     * Cast.
     *
     * @var string[]
     */
    protected $types = [
        'meta' => 'meta',
    ];

    /**
     * @var EntrySection
     */
    public $section;

    /**
     * @var BlockType
     */
    public $blockType;

    /**
     * Constructor.
     *
     * @param  EntrySection|null  $section
     * @param  array  $attributes
     */
    public function __construct(EntrySection $section = null, $attributes = [])
    {
        $this->section = $section;
        $attributes['text'] = stripslashes($attributes['text']);
        $attributes['text'] = html_entity_decode($attributes['text'], ENT_QUOTES);
        parent::__construct($attributes);

        // Migration
        if (!empty($attributes['type'])) {
            $this->blockType = BlockRegistry::blockTypeFrom($attributes['type']);
            $this->typeId    = $this->blockType::getTypeId();
            unset($this->type);

            $this->blockType::migrate($this);
        }
        if (empty($this->blockType)) {
            $this->blockType = BlockRegistry::blockTypeFrom($this->typeId);
        }
    }

    /**
     * @param  mixed  $data
     *
     * @return Collection
     */
    public function castToMeta($data): Collection
    {
        $data = is_string($data) ? json_decode($data, true) : $data;

        return $data instanceof Collection ? $data : Collection::create($data);
    }
}
