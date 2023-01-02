# THEME - VUNG 2022 - OPHIM CMS

## Demo
### Trang Chủ

![Alt text](https://i.ibb.co/J7rX36z/THEME-VUNG-INDEX.png "Home Page")

### Trang Danh Sách Phim

![Alt text](https://i.ibb.co/hKRW8kp/THEME-VUNG-CATALOG.png "Catalog Page")

### Trang Thông Tin Phim

![Alt text](https://i.ibb.co/7WN0gD7/THEME-VUNG-SINGLE.png "Info Page")

### Trang Xem Phim

![Alt text](https://i.ibb.co/HpSJg0y/THEME-VUNG-EPISODE.png "Episode Page")

## Requirements
https://github.com/hacoidev/ophim-core

## Install
1. Tại thư mục của Project: `composer require ophimcms/theme-vung`
2. Kích hoạt giao diện trong Admin Panel

## Update
1. Tại thư mục của Project: `composer update ophimcms/theme-vung`
2. Re-Activate giao diện trong Admin Panel

## Note
- Một vài lưu ý quan trọng của các nút chức năng:
    + `Activate` và `Re-Activate` sẽ publish toàn bộ file js,css trong themes ra ngoài public của laravel.
    + `Reset` reset lại toàn bộ cấu hình của themes

## Document
### List
- Trang chủ: `display_label|relation|find_by_field|value|limit|show_more_url`

    ```
    Phim chiếu rạp||is_shown_in_theater|1|updated_at|desc|12|/danh-sach/phim-chieu-rap
    Phim bộ mới||type|series|updated_at|desc|12|/danh-sach/phim-bo
    Phim lẻ mới||type|single|updated_at|desc|12|/danh-sach/phim-le
    Hoạt hình|categories|slug|hoat-hinh|updated_at|desc|12|/the-loai/hoat-hinh
    
    ```

- Top: `Label|relation|find_by_field|value|sort_by_field|sort_algo|limit|show_template (top_thumb|top_poster|top_poster_small)`

    ```
    Phim sắp chiếu||type|single|view_week|desc|10|top_poster_small
    Top phim lẻ||type|single|view_week|desc|5|top_thumb
    Top phim bộ||type|series|view_week|desc|10|top_poster
    
    ```


### Custom View Blade
- File blade gốc trong Package: `/vendor/ophimcms/theme-vung/resources/views/themevung`
- Copy file cần custom đến: `/resources/views/vendor/themes/themevung`
