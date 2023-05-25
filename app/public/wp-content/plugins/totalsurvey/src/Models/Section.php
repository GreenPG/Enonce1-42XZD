<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Concerns\Translatable;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Model;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class Section
 *
 * @package TotalSurvey\Models
 *
 * @property string $uid
 * @property string $title
 * @property string $description
 * @property Collection<Block> | Block[] $blocks
 * @property string $action
 * @property string $next_section_uid
 * @property string $previous_section_uid
 * @property Collection | Condition[] $conditions
 * @property int index
 * @property Survey survey
 */
class Section extends Model
{
    use Translatable;

    /**
     * @var string[]
     */
    protected $types = [
        'questions'  => 'blocks',
        'blocks'     => 'blocks',
        'conditions' => 'conditions',
    ];

    /**
     * @var Section|null
     */
    public $nextSection;

    /**
     * @var Section|null
     */
    public $previousSection;

    /**
     * @var Survey
     */
    public $survey;

    /**
     * Constructor.
     *
     * @param  Survey  $survey
     * @param  array  $attributes
     */
    public function __construct(Survey $survey, $attributes = [])
    {
        $this->survey         = $survey;
        $attributes['title']  = $attributes['name'] ?? $attributes['title'] ?? '';
        $attributes['blocks'] = $attributes['questions'] ?? $attributes['blocks'] ?? [];

        unset($attributes['name'], $attributes['questions']);

        $attributes = static::applyTranslations($attributes);

        parent::__construct($attributes);
    }

    /**
     * @param  array  $data
     *
     * @return Collection
     * @noinspection PhpUnused
     */
    public function castToBlocks(array $data): Collection
    {
        $blocks = [];

        foreach ($data as $block) {
            $block    = new Block($this, $block);
            $blocks[] = $block;
        }

        return Collection::create($blocks);
    }

    /**
     * @param  array  $data
     *
     * @return Collection
     * @noinspection PhpUnused
     */
    public function castToConditions(array $data): Collection
    {
        $conditions = [];

        foreach ($data as $condition) {
            $conditions[] = new Condition($condition);
        }

        return Collection::create($conditions);
    }

    /**
     * @param $uid
     *
     * @return Block
     * @throws Exception
     */
    public function getBlock($uid)
    {
        $block = $this->blocks->first(
            static function (Block $block) use ($uid) {
                return $block->uid === $uid;
            }
        );
        Exception::throwUnless($block, 'Block not found');

        return $block;
    }

    /**
     * @return Section|null
     */
    public function getPreviousSection()
    {
        return $this->previousSection;
    }

    /**
     * @param  Section|null  $previousSection
     */
    public function setPreviousSection(Section $previousSection)
    {
        $this->previousSection = $previousSection;
    }

    /**
     * @return Section|null
     */
    public function getNextSection()
    {
        return $this->nextSection;
    }

    /**
     * @param  Section|null  $nextSection
     */
    public function setNextSection(Section $nextSection)
    {
        $this->nextSection = $nextSection;
    }

    public static function getTranslatableAttributes()
    {
        return [
            'title',
            'description',
        ];
    }
}
