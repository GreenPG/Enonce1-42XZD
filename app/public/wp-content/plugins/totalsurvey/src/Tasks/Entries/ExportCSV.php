<?php

namespace TotalSurvey\Tasks\Entries;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Filters\Entries\EntriesExportHeadersFilter;
use TotalSurvey\Filters\Entries\EntriesExportRowFilter;
use TotalSurvey\Filters\Entries\EntryExportQuestionValueFilter;
use TotalSurvey\Models\Entry;
use TotalSurveyVendors\TotalSuite\Foundation\Http\ResponseFactory;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

class ExportCSV extends Task
{

    /**
     * @var Collection
     */
    protected $entries;

    /**
     * ExportJson constructor.
     *
     * @param  Collection|Entry  $entries
     */
    public function __construct(Collection $entries)
    {
        $this->entries = $entries->map(
            static function (Entry $entry) {
                return $entry->toExport('csv');
            }
        );
    }

    /**
     * @inheritDoc
     */
    protected function validate()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function execute()
    {
        $headers = EntriesExportHeadersFilter::apply(
            [
                'survey'     => __('Survey', 'totalsurvey'),
                'entry'      => __('Entry ID', 'totalsurvey'),
                'user'       => __('User Name', 'totalsurvey'),
                'email'      => __('User Email', 'totalsurvey'),
                'created_at' => __('Created at (UTC)', 'totalsurvey'),
                'ip'         => __('IP Address', 'totalsurvey'),
                'agent'      => __('User Agent', 'totalsurvey'),
                'section'    => __('Section', 'totalsurvey'),
                'question'   => __('Question', 'totalsurvey'),
                'answer'     => __('Answer', 'totalsurvey'),
            ],
            'csv'
        );

        $lines = [];

        foreach ($this->entries as $entry) {
            foreach ($entry['data'] as $sectionIndex => $section) {
                $rowNum = 1;

                $section['blocks'] = $section['blocks'] ?? $section['questions'];
                foreach ($section['blocks'] as $blockIndex => $block) {
                    $block = EntryExportQuestionValueFilter::apply($block, 'csv');

                    $row = EntriesExportRowFilter::apply(
                        [
                            $entry['survey'],
                            $entry['id'],
                            $entry['user']['name'] ?? null,
                            $entry['user']['email'] ?? null,
                            $entry['created_at'],
                            $entry['ip'],
                            str_replace(';', ' - ', $entry['agent']),
                            $section['title'] ?: "Section #".($sectionIndex + 1),
                            $block['title'] ?: "Question #".($blockIndex + 1),
                            str_replace("\n", " | ", $block['text']),
                        ],
                        $entry,
                        'csv',
                        $rowNum
                    );

                    $lines[] = implode('; ', $row);
                    $rowNum++;
                }
            }

            $lines[] = "\n\r";
        }

        $content = "sep=;\n\r";
        $content .= implode('; ', $headers)."\n\r";

        foreach ($lines as $line) {
            $content .= "{$line}\n\r";
        }

        $filename = sprintf("entries-export-%s.csv", date('Y-m-d'));

        return ResponseFactory::file($content, $filename, 'text/csv')
                              ->withAddedHeader('Content-Encoding', 'UTF-8');
    }
}
