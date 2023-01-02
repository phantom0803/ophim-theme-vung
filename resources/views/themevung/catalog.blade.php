@extends('themes::themevung.layout')

@php
$years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
    return \Ophim\Core\Models\Movie::select('publish_year')
        ->distinct()
        ->pluck('publish_year')
        ->sortDesc();
});
@endphp

@section('content')
    <div class="path-folder-film" style="margin-top: 30px">
        <ul itemscope itemtype="http://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" itemprop="url" href="/" title="Xem phim">
                    <span itemprop="name"> <i class="fa fa-home"></i> Xem phim</span>
                </a>
                <i class="fa fa-angle-right"></i>
                <meta itemprop="position" content="1" />
            </li>
            <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                <a itemprop="item" itemprop="url"
                    href="{{ url()->current() }}"
                    title="{{ $section_name ?? 'Danh Sách Phim' }}">
                    <span itemprop="name"> {{ $section_name ?? 'Danh Sách Phim' }}</span>
                </a>
                <i class="fa fa-angle-right"></i>
                <meta itemprop="position" content="2" />
            </li>
        </ul>
    </div>

    <div class="group-film group-film-category">
        <h1>{{$section_name}}<i class="fa fa-caret-right" aria-hidden="true"></i></h1> <span class="line-ngang"></span>
        @include('themes::themevung.inc.catalog_filter')
        <div class="row group-film-small">
            @if (count($data))
                @foreach ($data as $movie)
                    @include('themes::themevung.inc.movie_card')
                @endforeach
            @else
                <p class="text-danger">Không có dữ liệu cho mục này</p>
            @endif
        </div>
        {{ $data->appends(request()->all())->links("themes::themevung.inc.pagination") }}
    </div>
@endsection
