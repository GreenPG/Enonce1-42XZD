<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class EntrySection
 *
 * @package TotalSurvey\Models
 *
 * @property string $uid
 * @property string $title
 * @property EntryBlock[]|Collection<EntryBlock> $blocks
 */
class EntrySection extends Model
{
    /**
     * Cast.
     *
     * @var string[]
     */
    protected $types = [
        'blocks' => 'blocks',
    ];

    /**
     * @var EntryData
     */
    public $entryData;

    public function __construct(EntryData $entryData, $attributes = [])
    {
        $this->setRawAttributes($attributes);
        $this->entryData = $entryData;
        $attributes['title'] = $attributes['title'] ?? $attributes['name'] ?? '';
        unset($attributes['name']);
        parent::__construct($attributes);
    }

    /**
     * @param  array  $data
     *
     * @return Collection
     */
    public function castToBlocks($data): Collection
    {
        $data   = $data instanceof Collection ? $data->toArray() : (array) $data;
        $blocks = [];

        foreach ($data as $block) {
            $blocks[] = new EntryBlock($this, $block instanceof Model ? $block->toArray() : $block);
        }

        return Collection::create($blocks);
    }
}
