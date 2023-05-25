<?php


namespace TotalSurvey\Tasks\Utils;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class GetAllowedSurveyTags
 *
 * @package TotalSurvey\Tasks
 * @method static string invoke()
 * @method static string invokeWithFallback()
 */
class GetAllowedSurveyTags extends Task
{
    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        $genericAttributes = [
            'id'                  => [],
            'uid'                 => [],
            'class'               => [],
            'height'              => [],
            'width'               => [],
            'href'                => [],
            'rel'                 => [],
            'target'              => [],
            'hidden'              => [],
            'type'                => [],
            'name'                => [],
            'value'               => [],
            'accept'              => [],
            'checked'             => [],
            'selected'            => [],
            'label'               => [],
            'action'              => [],
            'method'              => [],
            'novalidate'          => [],
            'for'                 => [],
            'src'                 => [],
            'frameborder'         => [],
            'allowfullscreen'     => [],
            'allow'               => [],
            'srcset'              => [],
            'alt'                 => [],
            'rows'                => [],
            'lang'                => [],
            'tabindex'            => [],
            'data-survey-uid'     => [],
            'data-variable-name'  => [],
            'data-variable-value' => [],
            'data-target'         => [],
            'data-least'          => [],
            'data-most'           => [],
            'loading'             => [],
            'title'             => [],
        ];

        $svgAttributes = [
            'xmlns'             => [],
            'enable-background' => [],
            'height'            => [],
            'width'             => [],
            'viewBox'           => [],
            'fill'              => [],
            'x'                 => [],
            'y'                 => [],
            'd'                 => [],
        ];

        $vueAttributes = $genericAttributes + [
                'v-text'                 => [],
                'v-html'                 => [],
                'v-if'                   => [],
                'v-for'                  => [],
                'v-else'                 => [],
                'v-show'                 => [],
                'v-bind:id'              => [],
                'v-bind:index'           => [],
                'v-bind:class'           => [],
                'v-bind:height'          => [],
                'v-bind:width'           => [],
                'v-bind:href'            => [],
                'v-bind:rel'             => [],
                'v-bind:target'          => [],
                'v-bind:hidden'          => [],
                'v-bind:type'            => [],
                'v-bind:value'           => [],
                'v-bind:checked'         => [],
                'v-bind:label'           => [],
                'v-bind:style'           => [],
                'ref'                    => [],
                'inline-template'        => [],
                'v-bind:survey'          => [],
                'v-bind:api-base'        => [],
                'language'               => [],
                'nonce'                  => [],
                'v-on:click'             => [],
                'v-on:focus'             => [],
                'v-on:hover'             => [],
                'v-on:click.prevent'     => [],
                'v-on:next'              => [],
                'v-on:submit'            => [],
                'v-on:submit.prevent'    => [],
                'v-on:previous'          => [],
                'v-on:restart'           => [],
                'v-on:input'             => [],
                'v-on:reload'            => [],
                'v-bind:change'          => [],
                'mode'                   => [],
                'appear'                 => [],
                'v-other'                => [],
                'v-print'                => [],
                'v-file'                 => [],
                'v-else-if'              => [],
                'v-bind:placeholder'     => [],
                'v-bind:widget'          => [],
                'v-on:blur'              => [],
                'v-on:change'            => [],
                'v-on:keyup'             => [],
                'v-on:keyup.enter'       => [],
                'v-bind:revoke'          => [],
                'v-on:revoke'            => [],
                'v-bind:attribute'       => [],
                'v-bind:attribute-index' => [],
                'v-bind:key'             => [],
                'v-bind:point'           => [],
                'v-bind:point-index'     => [],
                'v-bind:has-rating'      => [],
                'v-bind:has-score'       => [],
                'v-bind:is-changing'     => [],
                'v-bind:display-score'   => [],
                'v-bind:symbol'          => [],
                'v-bind:name'            => [],
                'v-bind:options'         => [],
                'v-bind:entity'          => [],
                'v-bind:nonce'           => [],
            ];

        $tags = [
            'div'             => $vueAttributes,
            'article'         => $vueAttributes,
            'section'         => $vueAttributes,
            'footer'          => $vueAttributes,
            'dl'              => $vueAttributes,
            'dd'              => $vueAttributes,
            'dt'              => $vueAttributes,
            'time'            => $vueAttributes,
            'form'            => $vueAttributes,
            'style'           => $vueAttributes,
            'a'               => $vueAttributes,
            'strong'          => $vueAttributes,
            'svg'             => array_merge($genericAttributes, $svgAttributes),
            'g'               => array_merge($genericAttributes, $svgAttributes),
            'rect'            => array_merge($genericAttributes, $svgAttributes),
            'path'            => array_merge($genericAttributes, $svgAttributes),
            'hr'              => $genericAttributes,
            'br'              => $genericAttributes,
            'h1'              => $vueAttributes,
            'h2'              => $vueAttributes,
            'h3'              => $vueAttributes,
            'h4'              => $vueAttributes,
            'h5'              => $vueAttributes,
            'h6'              => $vueAttributes,
            'p'               => $vueAttributes,
            'label'           => $vueAttributes,
            'span'            => $vueAttributes,
            'table'           => $vueAttributes,
            'thead'           => $vueAttributes,
            'tbody'           => $vueAttributes,
            'tfoot'           => $vueAttributes,
            'th'              => $vueAttributes,
            'tr'              => $vueAttributes,
            'td'              => $vueAttributes,
            'iframe'          => $vueAttributes,
            'figure'          => $vueAttributes,
            'figcaption'      => $vueAttributes,
            'source'          => $vueAttributes,
            'img'             => $vueAttributes,
            'input'           => $vueAttributes,
            'button'          => $vueAttributes,
            'textarea'        => $vueAttributes,
            'select'          => $vueAttributes,
            'option'          => $vueAttributes,
            'template'        => $vueAttributes,
            'canvas'          => $vueAttributes,
            'survey'          => $vueAttributes,
            'progress-status' => $vueAttributes,
            'error-message'   => $vueAttributes,
            'sections'        => $vueAttributes,
            'section-item'    => $vueAttributes,
            'transition'      => $vueAttributes,
            'survey-link'     => $vueAttributes,
            'survey-style'    => $vueAttributes,
            'question'        => $vueAttributes,
        ];

        return $tags;
    }
}
