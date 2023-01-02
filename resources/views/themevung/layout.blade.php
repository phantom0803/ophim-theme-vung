@extends('themes::layout')

@php
    $menu = \Ophim\Core\Models\Menu::getTree();

    $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $template] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4, 'top_thumb']);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get(),
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }

        return $data;
    });
@endphp

@push('header')
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/themes/vung/css/v.min.css') }}" as="style" rel="preload" />
@endpush

@section('body')
    @include('themes::themevung.inc.nav')
    @if (get_theme_option('ads_header'))
        {!! get_theme_option('ads_header') !!}
    @endif
    <div class="container khoi-body">
        <div class="khoi-trai">
            @yield('content')
        </div>
        <div class="khoi-phai">
            @foreach ($tops as $top)
                @include('themes::themevung.inc.aside.' . $top['template'])
            @endforeach
        </div>
    </div>
@endsection

@section('footer')
    <script defer type="text/javascript" src="{{ asset('/themes/vung/js/v.min.js') }}"></script>
    {!! get_theme_option('footer') !!}
    @if (get_theme_option('ads_catfish'))
        {!! get_theme_option('ads_catfish') !!}
    @endif
    {!! setting('site_scripts_google_analytics') !!}
@endsection
