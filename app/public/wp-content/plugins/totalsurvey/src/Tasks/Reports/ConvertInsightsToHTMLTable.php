<?php

namespace TotalSurvey\Tasks\Reports;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class ConvertInsightsToHTMLTable extends Task
{
    /**
     * @var array
     */
    protected $insights;

    /**
     * @param  array  $insights
     */
    public function __construct(array $insights)
    {
        $this->insights = $insights;
    }


    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        $table = Html::create('table', ['style' => 'width : 100%; border-collapse: collapse']);
        $users = [
            "Authenticated users: {$this->insights['users']['authenticated']}%",
            "Unauthenticated users: {$this->insights['users']['anonymous']}%",
        ];

        foreach ($this->insights['sections'] as $section) {
            if (empty($section['blocks'])) {
                continue;
            }

            $table->addContent(
                Html::create(
                    'tr',
                    [],
                    Html::create(
                        'th',
                        [
                            'style' => 'font-family: sans-serif; padding: 10px; margin: 0; background-color: #eee;',
                        ],
                        $section['title']
                    )
                )
            );

            foreach ($section['blocks'] as $block) {
                $table->addContent(
                    Html::create(
                        'tr',
                        [],
                        Html::create(
                            'td',
                            ['style' => 'text-weight:500; padding: 10px 0; color: #444;'],
                            $block['title']
                        )
                    )
                );

                $block['text'] = [];

                if ($block['type'] === 'matrix') {
                    foreach ($block['values']['criteria'] as $criterionName => $criterion) {
                        foreach ($criterion['values'] as $column => $value){
                            $percentage    = round(($value * 100) / $criterion['total']) . '%';
                            $block['text'][] = "$criterionName ($column): $value entries ⟶ $percentage";
                        }

                        $block['text'][] = '—';
                    }
                } else {
                    foreach ($block['values'] as $key => $value) {
                        $percentage    = round(($value * 100) / $block['total']) . '%';
                        $block['text'][] = "$key: $value entries ⟶ $percentage";
                    }
                }
                $table->addContent(
                    Html::create(
                        'tr',
                        [],
                        Html::create(
                            'td',
                            ['style' => 'padding: 10px; border-bottom: 2px solid #eee; background-color: #f6f6f6; font-size: 14px; line-height: 1.5; font-family: monospace;'],
                            join('<br>', $block['text'])
                        )
                    )
                );
            }
            $table->addContent('<tr><td style="padding: 10px;"><br></td></tr>');
        }

        $table->addContent(
            Html::create(
                'tr',
                [],
                Html::create(
                    'th',
                    [
                        'style' => 'font-family: sans-serif; padding: 10px; margin: 0; background-color: #eee;',
                    ],
                    'Metrics Overview'
                )
            )
        );
        $table->addContent(
            Html::create(
                'tr',
                [],
                Html::create(
                    'td',
                    ['style' => 'text-weight:500; padding: 10px 0; color: #444'],
                    'Entries'
                )
            )
        );
        $table->addContent(
            Html::create(
                'tr',
                [],
                Html::create(
                    'td',
                    ['style' => 'padding: 10px; border-bottom: 2px solid #eee; background-color: #f6f6f6; font-size: 14px; line-height: 1.5; font-family: monospace;'],
                    "Total of entries: ".$this->insights['count']['total']
                )
            )
        );
        // users
        $table->addContent(
            Html::create(
                'tr',
                [],
                Html::create(
                    'td',
                    ['style' => 'text-weight:500; padding: 10px 0; color: #444'],
                    'Users'
                )
            )
        );
        $table->addContent(
            Html::create(
                'tr',
                [],
                Html::create(
                    'td',
                    ['style' => 'padding: 10px; border-bottom: 2px solid #eee; background-color: #f6f6f6; font-size: 14px; line-height: 1.5; font-family: monospace;'],
                    join("<br/>", $users)
                )
            )
        );


        return $table->render();
    }
}
