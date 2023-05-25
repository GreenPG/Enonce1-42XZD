<?php

namespace TotalSurvey\Models\Concerns;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\Blocks\BlockMentionFilter;
use TotalSurvey\Models\Block;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;

/**
 * Trait Translatable
 *
 * @package TotalSurvey\Models\Concerns
 */
trait Translatable
{
    /**
     * Get a list of translatable attributes (dot-notation supported for nested attributes).
     *
     * @return array
     */
    public static function getTranslatableAttributes()
    {
        return [];
    }

    /**
     * Apply translations on the current attributes based on the current locale.
     *
     * @param $attributes
     * @param  array  $extraTranslatableAttributes
     *
     * @return mixed
     */
    public static function applyTranslations($attributes, $extraTranslatableAttributes = [])
    {
        // Make sure translations attribute exists

        $attributes['translations'] = $attributes['translations'] ?? [];

        // Cast to array
        if (is_string($attributes['translations'])) {
            $attributes['translations'] = json_decode($attributes['translations'], true);
        }

        // Get translatable attributes
        $translatableAttributes = array_merge(static::getTranslatableAttributes(), $extraTranslatableAttributes);
        // Get current language
        $locale = get_locale();

        // Iterate over translatable attributes (dot-notation)
        foreach ($translatableAttributes as $translatableAttribute) {
            $parts = explode('.', $translatableAttribute);
            $path  = $attributes;

            // Process the translatable attribute
            foreach ($parts as $partIndex => $part) {
                // Array case

                if (wp_is_numeric_array($path)) {
                    $attributes = static::handleArrays($path, $locale, $parts, $part, $attributes);
                    // Rich text (with mentions, etc...)
                } elseif (isset($path[$part], $path["{$part}_raw"])) {
                    $attributes = static::handleMentions($path, $part, $locale, $attributes, $translatableAttribute);
                    // Top-level (like title)
                } elseif (count($parts) - 1 === $partIndex) {
                    $attributes = static::handleTopLevel($path, $part, $locale, $translatableAttribute, $attributes);
                }

                if (!isset($path[$part])) {
                    break;
                }

                $path = $path[$part];
            }
        }

        return $attributes;
    }

    /**
     * Handle arrays.
     *
     * @param $path
     * @param $locale
     * @param $parts
     * @param $part
     * @param $attributes
     *
     * @return mixed
     */
    private static function handleArrays($path, $locale, $parts, $part, $attributes)
    {
        foreach ($path as $itemIndex => $item) {
            if (!empty($item['translations'][$locale][$part])) {
                $path[$itemIndex][$part] = $item['translations'][$locale][$part];
            }
        }
        $translatableAttributePath = implode('.', array_slice($parts, 0, -1));
        Arrays::set($attributes, $translatableAttributePath, $path);

        return $attributes;
    }

    /**
     * Handle mentions.
     *
     * @param $path
     * @param $part
     * @param $locale
     * @param $attributes
     * @param $translatableAttribute
     *
     * @return mixed
     */
    private static function handleMentions($path, $part, $locale, $attributes, $translatableAttribute)
    {
        if (empty($path['translations'][$locale][$part])) {
            return $attributes;
        }

        $rawAttribute = "{$part}_raw";
        $translation  = $path['translations'][$locale][$part] ?? $path[$part];
        $mentions     = Block::extractMentionsFromRichTextBlocks($path[$rawAttribute] ?? []);

        foreach ($mentions as $mentionUid => $mention) {
            $mentionLabel = BlockMentionFilter::apply(
                "\${$mention['label']}\$",
                $mention
            );

            $translation = str_replace(
                "\${$mention['label']}\$",
                $mentionLabel,
                $translation
            );
        }

        Arrays::set(
            $attributes,
            $translatableAttribute,
            $translation
        );

        return $attributes;
    }

    /**
     * Handle top-level attributes.
     *
     * @param $path
     * @param $part
     * @param $locale
     * @param $translatableAttribute
     * @param $attributes
     *
     * @return mixed
     */
    private static function handleTopLevel($path, $part, $locale, $translatableAttribute, $attributes)
    {
        if (!empty($path['translations'][$locale][$part])) {
            Arrays::set($attributes, $translatableAttribute, $path['translations'][$locale][$part]);
        }

        return $attributes;
    }
}
