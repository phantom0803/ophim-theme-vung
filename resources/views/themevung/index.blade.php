@extends('themes::themevung.layout')

@php
    use Ophim\Core\Models\Movie;

    $recommendations = Cache::remember('site.movies.recommendations', setting('site_cache_ttl', 5 * 60), function () {
        return Movie::where('is_recommended', true)
            ->limit(get_theme_option('recommendations_limit', 10))
            ->orderBy('updated_at', 'desc')
            ->get();
    });

    $data = Cache::remember('site.movies.latest', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('latest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $link] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 12, '']);
                try {
                    $data[] = [
                        'label' => $label,
                        'link' => $link,
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

@section('content')
    @if (count($recommendations))
        @include('themes::themevung.inc.slider_recommended')
    @endif
    @foreach ($data as $item)
        <div class="group-film">
            <h2>
                <a href="{{$item['link']}}">{{$item['label']}} <i class="fa fa-caret-right" aria-hidden="true"></i>
                </a>
            </h2>
            <a href="{{$item['link']}}" class="more"></a>
            <span class="line-ngang"></span>
            <div class="row group-film-small">
                @foreach ($item['data'] as $movie)
                    @include('themes::themevung.inc.movie_card')
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
