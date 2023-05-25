<?php
/** @noinspection PhpUnused */

namespace TotalSurvey\Validations;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\ValidationAliasesFilter;
use TotalSurvey\Filters\ValidationMessagesFilter;
use TotalSurvey\Filters\ValidationRulesFilter;
use TotalSurvey\Models\FieldDefinition;
use TotalSurvey\Models\Question;
use TotalSurvey\Models\Validation as ValidationModel;
use TotalSurveyVendors\Rakit\Validation\Validation;
use TotalSurveyVendors\Rakit\Validation\Validator;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Concerns\ResolveFromContainer;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

class FieldValidator
{
    use ResolveFromContainer;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * FieldValidator constructor.
     *
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param Collection | Question[] $questions
     *
     * @param array $data
     *
     * @return Validation
     */
    public function validate(Collection $questions, array $data = []): Validation
    {
        $rules    = [];
        $aliases  = [];
        $messages = [];

        foreach ($questions as $question) {
            $rules[$question->field->uid] = $this->buildRules($question->field);

            $aliases[$question->field->uid] = empty($question->label) ? __('answer', 'totalsurvey') : $question->label;

            if (in_array($question->field->type, ['checkbox', 'radio', 'select'])) {
                $message = str_replace(
                    ['{{allowedValues}}'],
                    [implode(', ', $question->field->getChoicesAttribute('label'))],
                    __('Must be one of: {{allowedValues}}', 'totalsurvey')
                );

                $messages[$question->field->uid . ':inArray'] = $message;
            }

            //@TODO: Move this to a task.
            $messages['required']      = __('Required', 'totalsurvey');
            $messages['email']         = __('Must be a valid email', 'totalsurvey');
            $messages['min']           = str_replace(['{{min}}'], [':min'], __('Minimum is {{min}}', 'totalsurvey'));
            $messages['max']           = str_replace(['{{max}}'], [':max'], __('Maximum is {{max}}', 'totalsurvey'));
            $messages['before']        = str_replace(
                ['{{time}}'],
                [':time'],
                __('Must be a date before {{time}}', 'totalsurvey')
            );
            $messages['after']         = str_replace(
                ['{{time}}'],
                [':time'],
                __('Must be a date after {{time}}', 'totalsurvey')
            );
            $messages['numeric']       = __('Must be numeric', 'totalsurvey');
            $messages['date']          = __('Must be a valid date format', 'totalsurvey');
            $messages['between']       = str_replace(
                ['{{min}}', '{{max}}'],
                [':min', ':max'],
                __('Must be between {{min}} and {{max}}', 'totalsurvey')
            );
            $messages['uploaded_file'] = __('Must be a valid uploaded file', 'totalsurvey');
            $messages['mimes']         = str_replace(
                ['{{allowedTypes}}'],
                [':allowed_types'],
                __('File type must be {{allowedTypes}}', 'totalsurvey')
            );
            $messages['in']            = str_replace(
                ['{{allowedValues}}'],
                [':allowed_values'],
                __('Must be one of: {{allowedValues}}', 'totalsurvey')
            );

            $messages = ValidationMessagesFilter::apply($messages, $question);
            $aliases  = ValidationAliasesFilter::apply($aliases, $question);
        }

        foreach ($data as $index => $item) {
            if (is_numeric($item)) {
                $data[$index] = (int)$item;
            }
        }

        $validation = $this->validator->make($data, array_filter($rules));
        $validation->setAliases($aliases);
        $validation->setMessages($messages);
        $validation->validate();

        return $validation;
    }

    /**
     * @param FieldDefinition $definition
     *
     * @return array
     */
    protected function buildRules(FieldDefinition $definition)
    {
        $validations = $definition->getEnabledValidations();
        $rules       = [];

        if ($definition->isRequired() && in_array($definition->type, ['radio', 'select'], true) && ! $definition->allowOthers()) {
            $rules[] = DefaultRules::inArray($definition->getChoicesAttribute('uid'));
        }

        if ($definition->type === 'select' && $definition->isRequired()) {
            $rules[] = DefaultRules::inArray($definition->getChoicesAttribute('uid'));
        }

        if ($definition->type === 'scale') {
            $rules[] = DefaultRules::between(1, $definition->getAttribute('options.scale', 2));
        }

        if ($definition->type === 'file' && $definition->isRequired()) {
            $rules[] = DefaultRules::file();
        }

        /**
         * @var ValidationModel $validation
         */
        foreach ($validations as $name => $validation) {
            if ($rule = $this->getRule($name)) {
                if ($name === 'fileType') {
                    $rules[] = call_user_func($rule, $validation->options);
                } else {
                    $rules[] = call_user_func_array($rule, $validation->options);
                }
            }
        }

        $rules = ValidationRulesFilter::apply($rules, $definition);

        return $rules;
    }

    /**+
     * @param $name
     *
     * @return array|bool
     */
    protected function getRule($name)
    {
        if (method_exists(DefaultRules::class, $name)) {
            return [DefaultRules::class, $name];
        }

        return false;
    }
}