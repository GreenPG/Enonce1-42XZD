<?php

namespace TotalSurvey\Blocks;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Block;
use TotalSurvey\Models\Entry;
use TotalSurvey\Models\EntryBlock;
use TotalSurvey\Models\EntrySection;
use TotalSurvey\Services\BlockRegistry;
use TotalSurvey\Validations\DefaultValidationRules;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;

abstract class BlockType
{
    public static $category  = 'default';
    public static $id        = 'default';
    public static $icon      = 'subject';
    public static $static    = true;
    public static $aggregate = false;
    public static $aliases   = [];

    /**
     * @param  string|null  $alias
     *
     * @return string
     */
    public static function getTypeId($alias = null)
    {
        return sprintf("%s:%s", static::$category, $alias ?? static::$id);
    }

    /**
     * @throws \TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception
     */
    public static function register()
    {
        BlockRegistry::register(static::class);
    }

    /**
     * @param  Block  $block
     *
     * @return array
     */
    public static function getValidationRules(Block $block)
    {
        $rules       = [$block->uid => []];
        $validations = $block->field->getEnabledValidations();

        foreach ($validations as $name => $validation) {
            $rules[$block->uid][] = DefaultValidationRules::from($name, $validation);
        }

        return $rules;
    }

    /**
     * @param  Block  $block
     *
     * @return array
     */
    public static function getValidationMessages(Block $block)
    {
        return [];
    }

    /**
     * @param  Block  $block
     *
     * @return array
     */
    public static function getValidationAliases(Block $block)
    {
        return [$block->uid => empty($block->label) ? __('answer', 'totalsurvey') : $block->label];
    }

    /**
     * @param  EntrySection  $entrySection
     * @param  Block  $block
     * @param  Entry  $entry
     * @param  mixed  $value
     *
     * @return EntryBlock
     */
    public static function getEntryBlockFromRawValue($value, Block $block, EntrySection $entrySection, Entry $entry)
    {
        return new EntryBlock(
            $entrySection,
            [
                'uid'    => $block->uid,
                'title'  => $block->title,
                'value'  => static::getSerializedFromRawValue($block, $entry, $value),
                'text'   => static::getTextFromRawValue($block, $entry, $value),
                'meta'   => static::getMetadataFromRawValue($block, $entry, $value),
                'typeId' => $block->typeId,
            ]
        );
    }

    /**
     * @param  Block  $block
     * @param  Entry  $entry
     * @param $value
     *
     * @return mixed
     */
    public static function getSerializedFromRawValue(Block $block, Entry $entry, $value)
    {
        return static::getTextFromRawValue($block, $entry, $value);
    }

    /**
     * @param  Block  $block
     * @param  Entry  $entry
     * @param $value
     *
     * @return string
     */
    public static function getTextFromRawValue(Block $block, Entry $entry, $value)
    {
        return implode(
            ', ',
            array_map(
                static function ($input) {
                    return stripslashes(wp_kses($input, []));
                },
                (array) $value
            )
        );
    }

    /**
     * @param  Block  $block
     * @param  Entry  $entry
     * @param $value
     *
     * @return array
     */
    public static function getMetadataFromRawValue(Block $block, Entry $entry, $value)
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getTranslatableAttributes()
    {
        return [];
    }

    /**
     * @param  Block  $block
     *
     * @return null
     */
    public static function render(Block $block)
    {
        return null;
    }

    public static function migrate(EntryBlock $entryBlock)
    {
        if (!isset($entryBlock->text)) {
            $entryBlock->text = implode(', ', Arrays::flatten((array) $entryBlock->value));
        }

        return $entryBlock;
    }

    public static function optionsFromEntryBlock(EntryBlock $entryBlock)
    {
        return [];
    }
}
