<?php

namespace App\Services;

class ThemeService
{

    protected $themes;

    public function __construct()
    {
        $this->themes = [
            'development1' => [
                'theme' => 'development1',
                'colors' => 'to-black via-black from-black shadow-job/20 dark:shadow-job/80',
                'backg-color' => 'bg-black',
                'buttonColor' => 'bg-job hover:bg-jobHover focus:bg-jobHover',
                'logo' => base_url() . 'images/logosm.png',
                'icon' => base_url() . 'images/favicon2.ico',
            ],
            'development2' => [
                'theme' => 'development2',
                'colors' => 'to-teal-500 via-teal-700 from-teal-800 shadow-teal-600/20 dark:shadow-teal-800/80',
                'backg-color' => 'bg-white',
                'buttonColor' => ' bg-teal-500 hover:bg-teal-300',
                'logo' => 'https://institutosergiomurilo.com.br/wp-content/uploads/2020/08/dojo-min.png',
                'icon' => base_url() . 'images/favicon.ico',
            ],
            'dojo' => [
                'theme' => 'dojo',
                'colors' => 'to-teal-500 via-teal-700 from-teal-800 shadow-teal-600/20 dark:shadow-teal-800/80',
                'backg-color' => 'bg-white',
                'buttonColor' => ' bg-teal-500 hover:bg-teal-300',
                'logo' => 'https://institutosergiomurilo.com.br/wp-content/uploads/2020/08/dojo-min.png',
                'icon' => base_url() . 'images/favicon.ico',
            ],
        ];
    }

    public function getTheme()
    {
        $theme = getenv('LOCATION') ?? 'dojo';
        $theme = $this->themes[$theme] ?? $this->themes['dojo'];
        return $theme;
    }
}
