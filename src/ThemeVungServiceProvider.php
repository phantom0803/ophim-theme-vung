<?php

namespace Ophim\ThemeVung;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ThemeVungServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupDefaultThemeCustomizer();
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'themes');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('themes/vung')
        ], 'vung-assets');
    }

    protected function setupDefaultThemeCustomizer()
    {
        config(['themes' => array_merge(config('themes', []), [
            'vung' => [
                'name' => 'Vung',
                'author' => 'opdlnf01@gmail.com',
                'package_name' => 'ophimcms/theme-vung',
                'publishes' => ['vung-assets'],
                'preview_image' => '',
                'options' => [
                    [
                        'name' => 'recommendations_limit',
                        'label' => 'Recommendations Limit',
                        'type' => 'number',
                        'hint' => 'Number',
                        'value' => 10,
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'latest',
                        'label' => 'Home Page',
                        'type' => 'code',
                        'hint' => 'display_label|relation|find_by_field|value|limit|show_more_url',
                        'value' => <<<EOT
                        Phim chiếu rạp||is_shown_in_theater|1|updated_at|desc|12|/danh-sach/phim-chieu-rap
                        Phim bộ mới||type|series|updated_at|desc|12|/danh-sach/phim-bo
                        Phim lẻ mới||type|single|updated_at|desc|12|/danh-sach/phim-le
                        Hoạt hình|categories|slug|hoat-hinh|updated_at|desc|12|/the-loai/hoat-hinh
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'hotest',
                        'label' => 'Danh sách hot',
                        'type' => 'code',
                        'hint' => 'Label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_template (top_thumb|top_poster|top_poster_small)',
                        'value' => <<<EOT
                        Phim sắp chiếu||type|single|view_week|desc|10|top_poster_small
                        Top phim lẻ||type|single|view_week|desc|5|top_thumb
                        Top phim bộ||type|series|view_week|desc|10|top_poster
                        EOT,
                        'attributes' => [
                            'rows' => 5
                        ],
                        'tab' => 'List'
                    ],
                    [
                        'name' => 'additional_css',
                        'label' => 'Additional CSS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'body_attributes',
                        'label' => 'Body attributes',
                        'type' => 'text',
                        'value' => "class='body-page '",
                        'tab' => 'Custom CSS'
                    ],
                    [
                        'name' => 'additional_header_js',
                        'label' => 'Header JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_body_js',
                        'label' => 'Body JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'additional_footer_js',
                        'label' => 'Footer JS',
                        'type' => 'code',
                        'value' => "",
                        'tab' => 'Custom JS'
                    ],
                    [
                        'name' => 'footer',
                        'label' => 'Footer',
                        'type' => 'code',
                        'value' => <<<EOT
                        <footer>
                            <div class="footer1">
                                <a href="/" style="background-image:url(https://ophim1.cc/logo-ophim-5.png)"></a>
                                <ul>
                                <li>
                                    <a href="#">Hỏi đáp - Hướng dẫn</a>
                                </li>
                                <li>
                                    <a href="#">Điều khoản sử dụng</a>
                                </li>
                                <li>
                                    <a href="#">Chính sách riêng tư</a>
                                </li>
                                <li>
                                    <a href="#">Nguyên tắc Cộng Đồng</a>
                                </li>
                                <li>
                                    <a href="#">Liên hệ Quảng Cáo</a>
                                </li>
                                </ul>
                                <div>Copyright ©2022 OPhimCMS.</div>
                            </div>
                        </footer>
                        EOT,
                        'tab' => 'Custom HTML'
                    ],
                    [
                        'name' => 'ads_header',
                        'label' => 'Ads header',
                        'type' => 'code',
                        'value' => '',
                        'tab' => 'Ads'
                    ],
                    [
                        'name' => 'ads_catfish',
                        'label' => 'Ads catfish',
                        'type' => 'code',
                        'value' => '',
                        'tab' => 'Ads'
                    ]
                ],
            ]
        ])]);
    }
}
