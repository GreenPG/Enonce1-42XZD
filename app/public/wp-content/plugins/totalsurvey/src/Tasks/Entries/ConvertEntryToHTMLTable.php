<?php

namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();



use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\Helpers\Html;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class ConvertEntryToHTMLTable extends Task
{
    /**
     * @var Entry
     */
    protected $entry;

    /**
     * ConvertEntryToHTMLTable constructor.
     *
     * @param  Entry  $entry
     */
    public function __construct(Entry $entry)
    {
        $this->entry = $entry;
    }


    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        $table = Html::create('table', ['style' => 'width : 100%; border-collapse: collapse']);

        foreach ($this->entry->data->sections as $section) {
            if ($section->blocks->isEmpty()) {
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
                        $section->title
                    )
                )
            );

            foreach ($section->blocks as $block) {
                $table->addContent(
                    Html::create(
                        'tr',
                        [],
                        Html::create(
                            'td',
                            ['style' => 'text-weight:500; padding: 10px 0; color: #444'],
                            $block->title
                        )
                    )
                );
                $table->addContent(
                    Html::create(
                        'tr',
                        [],
                        Html::create(
                            'td',
                            ['style' => 'padding: 10px; border-bottom: 2px solid #eee; background-color: #f6f6f6;'],
                            $block->text
                        )
                    )
                );
            }
            $table->addContent('<tr><td style="padding: 10px;"><br></td></tr>');
        }

        return $table->render();
    }
}
