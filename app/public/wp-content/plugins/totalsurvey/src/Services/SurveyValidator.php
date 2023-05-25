<?php

namespace TotalSurvey\Services;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\Validations\ValidationAliasesFilter;
use TotalSurvey\Filters\Validations\ValidationMessagesFilter;
use TotalSurvey\Filters\Validations\ValidationRulesFilter;
use TotalSurvey\Models\Section;
use TotalSurvey\Tasks\Utils\GetDefaultValidationMessages;
use TotalSurveyVendors\Rakit\Validation\Validator;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Concerns\ResolveFromContainer;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

/**
 * Class BlockRegistry
 *
 * @package TotalSurvey
 */
class SurveyValidator
{
    use ResolveFromContainer;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var BlockRegistry
     */
    protected $blockRegistry;

    public function __construct(Validator $validator, BlockRegistry $blockRegistry)
    {
        $this->validator     = $validator;
        $this->blockRegistry = $blockRegistry;
    }

    /**
     * @param  Section  $section
     * @param  Collection  $entry
     */
    public function validateSection($section, $entry)
    {
        $validation = $this->buildValidationForSection($section);
        $validation->validate($entry->toArray());

        return $validation;
    }

    /**
     * @param  Section  $section
     *
     * @return \TotalSurveyVendors\Rakit\Validation\Validation
     */
    public function buildValidationForSection($section)
    {
        $rules    = [];
        $aliases  = [];
        $messages = GetDefaultValidationMessages::invokeWithFallback([]);

        foreach ($section->blocks as $block) {
            $blockType = $this->blockRegistry->getBlockType($block->typeId);
            if ($blockType::$static) {
                continue;
            }

            $rules    = array_merge($rules, $blockType::getValidationRules($block));
            $messages = array_merge($messages, $blockType::getValidationMessages($block));
            $aliases  = array_merge($aliases, $blockType::getValidationAliases($block));
        }

        $rules    = ValidationRulesFilter::apply($rules, $section);
        $messages = ValidationMessagesFilter::apply($messages, $section);
        $aliases  = ValidationAliasesFilter::apply($aliases, $section);

        $validation = $this->validator->make([], array_filter($rules));
        $validation->setMessages(array_filter($messages));
        $validation->setAliases(array_filter($aliases));

        return $validation;
    }

}
