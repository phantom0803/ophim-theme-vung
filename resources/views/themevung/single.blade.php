@extends('themes::themevung.layout')
@php
    $watch_url = '';
    if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '') {
        $watch_url = $currentMovie->episodes
            ->sortBy([['server', 'asc']])
            ->groupBy('server')
            ->first()
            ->sortByDesc('name', SORT_NATURAL)
            ->groupBy('name')
            ->last()
            ->sortByDesc('type')
            ->first()
            ->getUrl();
    }
@endphp

@section('content')
    <div class="path-folder-film" style="margin-top: 20px">
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
                    href="{{route('types.movies.index', ['type' => $currentMovie->type == 'single' ? 'phim-le' : 'phim-bo'])}}"
                    title="{{ $currentMovie->type == 'single' ? 'Phim lẻ' : 'Phim bộ' }}">
                    <span itemprop="name"> {{ $currentMovie->type == 'single' ? 'Phim lẻ' : 'Phim bộ' }}</span>
                </a>
                <i class="fa fa-angle-right"></i>
                <meta itemprop="position" content="2" />
            </li>
            <li>
                <a href="javascript:;" class="active">{{$currentMovie->name}}</a>
            </li>
        </ul>
    </div>
    <div class="group-detail" itemscope itemtype="http://schema.org/Movie">
        <div style="display: none">
            <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                <span itemprop="ratingValue">{{ number_format($currentMovie->rating_start, 1) }}</span>
                <meta itemprop="bestRating" content="10" />
                <meta itemprop="worstRating" content="1" />
                <span itemprop="ratingCount">{{ $currentMovie->rating_count ?: 0 }}</span>
            </div>
        </div>
        <a href="{{ $watch_url }}" class="big-img-film-detail {{ !$watch_url ? 'comingsoon' : '' }}">
            <img src="{{ $currentMovie->poster_url ?: '/themes/vung/img/big-img-detail.jpg' }}"
                style="position: absolute; width: 100%; height: 100%" />
            <div style="position: absolute; width: 100%; height: 100%">
                <i class="fa fa-play-circle" aria-hidden="true"></i>
            </div>
        </a>
        <h1 class="title-film-detail-1" itemprop="name">{{ $currentMovie->name }} </h1>
        <h2 class="title-film-detail-2">{{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})</h2>
        <div class="fb-gg">
            <div class="fb-like" data-href="{{$currentMovie->getUrl()}}"
                data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="true">
            </div>
            <div class="g-plusone" data-size="medium"></div>
        </div>
        <div class="imdb">Điểm {{ number_format($currentMovie->rating_star, 1) }}</div>
        <ul class="rated-star hidden-xs">
            <i id="star"></i>
        </ul>
        <span class="rated-text">({{ $currentMovie->rating_count }} Đánh giá)</span>
        <span class="hd">{{ $currentMovie->quality }}</span>
        <br>
        @if ($watch_url)
            <a href="{{ $watch_url }}" class="play-film">Xem Phim <i class="fa fa-caret-right" aria-hidden="true"></i>
        @endif
        </a>
        @if ($currentMovie->trailer_url && strpos($currentMovie->trailer_url, 'youtube'))
            <a href="{{ $currentMovie->trailer_url }}" class="play-trailer">Xem Trailer<i class="fa fa-caret-right"
                    aria-hidden="true"></i></a>
        @endif
        @if ($currentMovie->notify && $currentMovie->notify != '')
            <p class="lichchieu"><span class="text-danger">• Thông báo</span>: {{ strip_tags($currentMovie->notify) }}</p>
        @endif
        @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
            <p class="lichchieu"><span class="text-info">• Lịch chiếu</span>: {{ strip_tags($currentMovie->showtimes) }}
            </p>
        @endif
        <ul class="infomation-film">
            <li class="title">Thông tin:</li>
            <li>Trạng thái: <span>{{ $currentMovie->episode_current }}</span>
            </li>
            <li>Thời lượng: <span>{{ $currentMovie->episode_time }}</span>
            </li>
            <li>Đạo diễn
                {!! $currentMovie->directors->map(function ($director) {
                        return '<a href="' . $director->getUrl() . '" title="' . $director->name . '">' . $director->name . '</a>';
                    })->implode(', ') !!}
            </li>
            <li>Diễn viên:
                {!! $currentMovie->actors->map(function ($actor) {
                        return '<a href="' . $actor->getUrl() . '" title="' . $actor->name . '">' . $actor->name . '</a>';
                    })->implode(', ') !!}
            </li>
            <li>Thể loại:
                {!! $currentMovie->categories->map(function ($category) {
                        return '<a href="' . $category->getUrl() . '" title="' . $category->name . '">' . $category->name . '</a>';
                    })->implode(', ') !!}
            </li>
            <li>Quốc gia:
                {!! $currentMovie->regions->map(function ($region) {
                        return '<a href="' . $region->getUrl() . '" title="' . $region->name . '">' . $region->name . '</a>';
                    })->implode(', ') !!}
            </li>
            <li>Số tập: <span>{{ $currentMovie->episode_total }}</span>
            </li>
            <li class="tags">
                <span>TAGS: </span>
                {!! $currentMovie->tags->map(function ($tag) {
                        return '<a href="' . $tag->getUrl() . '" title="' . $tag->name . '">' . $tag->name . '</a>';
                    })->implode(', ') !!}
            </li>
        </ul>
        <p class="content-film">
            @if ($currentMovie->content)
                {!! strip_tags($currentMovie->content) !!}
            @else
                <p>Hãy xem phim để cảm nhận...</p>
            @endif
        </p>
    </div>
    <div class="group-vote-detail">
        <h2>Đánh giá phim này</h2>
        <ul>
            <li class="star" id="star-vote"></li>
        </ul>
    </div>
    <div class="fbchat">
        <div class="fb-comments" data-width="100%" data-include-parent="false" data-href="{{ $currentMovie->getUrl() }}"
            data-numposts="10" data-order-by="reverse_time" data-colorscheme="dark"></div>
    </div>
    <div class="group-film">
        <h2>phim liên quan <i class="fa fa-caret-right" aria-hidden="true"></i>
        </h2>
        <span class="line-ngang"></span>
        <div class="group-film-small">
            @foreach ($movie_related as $movie)
                @include('themes::themevung.inc.movie_card')
            @endforeach
        </div>
    </div>
    <div class="group-tag-detail">
        <h3>
            <small>{{ $currentMovie->name }} VietSub, {{ $currentMovie->name }} thuyết minh, {{ $currentMovie->name }}
                HD, {{ $currentMovie->name }}, Vượt
                Ngục: Phần 1 full/trọn bộ, {{ $currentMovie->name }} phụ đề, {{ $currentMovie->name }} trailer, Vuot Nguc:
                Phan 1 VietSub,
                Vuot Nguc: Phan 1 thuyet minh, Vuot Nguc: Phan 1 HD, Vuot Nguc: Phan 1, Vuot Nguc: Phan 1 full/tron bo, Vuot
                Nguc: Phan 1 phu de, Vuot Nguc: Phan 1 trailer Xem phim {{ $currentMovie->originName }},
                {{ $currentMovie->originName }},
                {{ $currentMovie->originName }} VietSub, {{ $currentMovie->originName }} Thuyết minh,
                {{ $currentMovie->originName }} full HD, Prison
                Break: Season 1 bản đẹp, {{ $currentMovie->originName }} trọn bộ, {{ $currentMovie->originName }} phụ đề,
                Prison Break: Season
                1 trailer</small>
        </h3>
    </div>
    <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body modal-padding">
                    <!-- content dynamically inserted -->
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        var rating = '{{ number_format($currentMovie->rating_star) }}';
        var URL_POST_RATING = '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}';
    </script>
    <script defer type="text/javascript" src="/themes/vung/js/rating.js"></script>
    <script defer type="text/javascript" src="/themes/vung/js/single.js"></script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
