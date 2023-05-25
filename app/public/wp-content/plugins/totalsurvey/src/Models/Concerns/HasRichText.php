<?php

namespace TotalSurvey\Models\Concerns;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\Blocks\BlockMentionFilter;

/**
 * Trait RichEditor
 *
 * @package TotalSurvey\Models\Concerns
 */
trait HasRichText
{
    public static function convertRichTextBlocksToText($blocks)
    {
        $compiledBlocks = [];

        foreach ($blocks as $block) {
            if (empty($block['children'])) {
                continue;
            }

            $title = $block['children'];
            $title = array_map(
                static function ($part) {
                    if (!empty($part['_uid']) && isset($part['type']) && $part['type'] === 'mention') {
                        return BlockMentionFilter::apply(
                            "\${$part['label']}\$",
                            $part
                        );
                    }

                    return $part['text'] ?? '';
                },
                $title
            );

            $compiledBlocks[] = implode('', $title);
        }

        return implode('<br>', $compiledBlocks);
    }

    public static function extractMentionsFromRichTextBlocks($blocks)
    {
        $mentions = [];
        foreach ($blocks as $block) {
            $parts = $block['children'] ?? [];
            foreach ($parts as $part) {
                if (isset($part['type']) && $part['type'] === 'mention') {
                    $mentions[$part['_uid']] = $part;
                }
            }
        }

        return $mentions;
    }
}
