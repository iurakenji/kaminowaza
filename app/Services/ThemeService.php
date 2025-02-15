<?php

namespace App\Services;

class ThemeService
{

    protected $themes;

    public function getTheme()
    {
        $location = getenv('LOCATION') ?? 'dojo';

        $themeModel = model('App\Models\ThemeModel');
        $theme = $themeModel->where('selected', 1)->first();

        if ($location == 'development1') {
            $theme = $themeModel->where('name',  'Development 1')->first();
        }
        $theme['theme_css'] = "
                            :root {
                                --color_1: {$theme['color_1']};
                                --color_2: {$theme['color_2']};
                                --color_3: {$theme['color_3']};
                                --bg_color: {$theme['background_color']};
                                --btn_color: {$theme['button_color']};
                                --font_color: {$theme['font_color']};
                            }
                        ";
        return $theme;

    }
}
