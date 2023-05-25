<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Exceptions\Presets\PresetNotFound;
use TotalSurvey\Plugin;
use TotalSurvey\Tasks\Surveys\GetSurveyDefaults;
use TotalSurveyVendors\TotalSuite\Foundation\Database\Query\Expression;
use TotalSurveyVendors\TotalSuite\Foundation\Database\TableModel;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\DatabaseException;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;

/**
 * Class Preset
 * @package TotalSurvey\Models
 *
 * @property string $name
 * @property Survey $survey
 * @property string uid
 * @property int|null user_id
 * @property string thumbnail
 */
class Preset extends TableModel
{
    const DEFAULT_SOURCE = 'default';
    /**
     * @var string
     */
    protected $table = 'totalsurvey_presets';

    /**
     * @var array
     */
    protected $types = [
        'survey' => 'survey',
    ];

    /**
     * @var array
     */
    protected $fillable = ['name', 'survey', 'description', 'thumbnail', 'category', 'source'];

    /**
     * @param $data
     *
     * @return Survey
     * @throws Exception
     */
    public function castToSurvey($data)
    {
        $data = json_decode($data, true);
        $data = array_replace_recursive(GetSurveyDefaults::invoke(), $data);

        return Survey::from($data);
    }

    /**
     * @param $uid
     *
     * @return Preset
     * @throws Exception
     */
    public static function getByUid($uid)
    {
        $preset = static::query()
                        ->where('uid', $uid)
                        ->first();

        PresetNotFound::throwUnless($preset, __('Preset not found', 'totalsurvey'));

        return $preset;
    }

    /**
     * @param array $arguments
     *
     * @return string|void
     */
    public function getUrl($arguments = [])
    {
        $baseUrl                        = site_url();
        $arguments['survey_preset_uid'] = $this->uid;

        if (get_option('permalink_structure')) {
            $baseUrl = site_url("survey-preset/{$this->uid}/");
            unset($arguments['survey_preset_uid']);
        }

        return add_query_arg($arguments, $baseUrl);
    }

    /**
     * @return array
     * @throws DatabaseException
     */
    public static function getCategories()
    {
        return Preset::query()
                     ->column('category', 'name')
                     ->column(new Expression('COUNT(*)'), 'counter')
                     ->groupBy('category')
                     ->all();
    }

    public function toArray(): array
    {
        $preset              = parent::toArray();
        $preset['url']       = $this->getUrl();
        $preset['thumbnail'] = $this->getThumbnail();

        return $preset;
    }

    public function getThumbnail()
    {
        return str_replace('./', Plugin::env('url.base') . '/', $this->thumbnail);
    }
}
