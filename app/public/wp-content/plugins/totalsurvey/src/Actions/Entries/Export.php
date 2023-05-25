<?php

namespace TotalSurvey\Actions\Entries;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Capabilities\UserCanExportEntries;
use TotalSurvey\Filters\Entries\ExportFilter;
use TotalSurvey\Tasks\Entries\ExportCSV;
use TotalSurvey\Tasks\Entries\ExportJSON;
use TotalSurvey\Tasks\Entries\GetEntries;
use TotalSurveyVendors\TotalSuite\Foundation\Action;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Http\Response;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;

class Export extends Action
{
    /**
     * @param $format
     *
     * @return mixed
     * @throws Exception
     */
    public function execute($format)
    {
        $filters             = $this->request->getParsedBody();
        $filters['per_page'] = null;
        $entries             = GetEntries::invoke($filters, false);

        return $this->export($entries, $format);
    }

    /**
     * @param Collection $entries
     * @param            $format
     *
     * @return mixed|void
     * @throws Exception
     */
    protected function export(Collection $entries, $format)
    {
        $export = ExportFilter::apply($format);

        if ($export instanceof Response) {
            return $export;
        }

        switch ($format) {
            case 'json' :
            {
                return ExportJSON::invoke($entries);
            }
            case 'csv' :
            {
                return ExportCSV::invoke($entries);
            }
            default :
            {
                Exception::throw('Invalid export format');
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return UserCanExportEntries::check();
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return [
            'format' => [
                'expression'        => '(?<format>([\w]+))',
                'sanitize_callback' => static function ($format) {
                    return (string)$format;
                },
            ],
        ];
    }
}
