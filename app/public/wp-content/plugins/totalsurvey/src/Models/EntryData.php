<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\PublicEntrtyFilter;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class EntryData
 *
 * @property Collection $raw
 * @property EntrySection[]|Collection<EntrySection> $sections
 * @property Collection $meta
 *
 * @package TotalSurvey\Models
 */
class EntryData extends Model
{
    /**
     * @var array
     */
    protected $types = [
        'raw'      => 'array',
        'sections' => 'sections',
        'meta'     => 'meta',
    ];

    /**
     * @var Entry
     */
    public $entry;

    public function __construct(Entry $entry, $attributes = [])
    {
        $this->setRawAttributes($attributes);
        $this->entry = $entry;
        parent::__construct($attributes);
    }

    /**
     * @param  mixed  $data
     *
     * @return Collection
     */
    public function castToMeta($data): Collection
    {
        $data = is_string($data) ? json_decode($data, true) : $data;

        return Collection::create($data);
    }


    /**
     * @param  string  $data
     *
     * @return Collection
     * @noinspection PhpUnused
     */
    public function castToSections($data): Collection
    {
        $sections = [];

        if (!empty($data)) {
            $data = is_string($data) ? json_decode($data, true) : $data;

            foreach ($data as $section) {
                $section['blocks'] = $section['questions'] ?? $section['blocks'];
                unset($section['questions']);
                $sections[] = EntrySection::from($this, $section instanceof Model ? $section->toArray() : $section);
            }
        }

        return Collection::create($sections);
    }

    public function toJson()
    {
        return json_encode($this->jsonSerialize(), JSON_UNESCAPED_UNICODE);
    }
}
