<?php


namespace TotalSurvey\Tasks\Sections;
! defined( 'ABSPATH' ) && exit();



use TotalSurveyVendors\TotalSuite\Foundation\Http\UploadedFile;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Arrays;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Task;

/**
 * Class ExtractSectionData
 *
 * @package TotalSurvey\Tasks\Sections
 * @method static Collection invoke(string $sectionUid, array $data, array $files = [])
 * @method static Collection invokeWithFallback($fallback, string $sectionUid, array $data, array $files = [])
 */
class ExtractSectionData extends Task
{
    /**
     * @var string
     */
    protected $sectionUid;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var UploadedFile[] $files
     */
    protected $files;

    /**
     * ExtractSectionData constructor.
     *
     * @param  string  $sectionUid
     * @param  array  $data
     * @param  array  $files
     */
    public function __construct(string $sectionUid, array $data, array $files = [])
    {
        $this->sectionUid = $sectionUid;
        $this->data       = $data;
        $this->files      = $files;
    }


    protected function validate()
    {
        return true;
    }

    protected function execute()
    {
        // Raw
        $inputs = Arrays::get($this->data, $this->sectionUid, []);

        // Normalize numerics
        foreach ($inputs as $index => $input) {
            if (is_numeric($input)) {
                $inputs[$index] = +$input;
            }
        }

        // Normalize files
        $files = Arrays::get($this->files, $this->sectionUid, []);
        foreach ($files as $name => $file) {
            if ($file->getSize()) {
                $inputs[$name] = [
                    'name'     => $file->getClientFilename(),
                    'type'     => $file->getClientMediaType(),
                    'size'     => $file->getSize(),
                    'tmp_name' => $file->file,
                    'error'    => $file->getError(),
                ];
            }
        }

        // Return the normalized collection
        return Collection::create($inputs);
    }
}
