<div class="topphim-doc">
    <h3>{{ $top['label'] }}</h3>
    <ul class="film">
        @foreach ($top['data'] as $movie)
            <li> <a href="{{$movie->getUrl()}}">
                <div class="image"
                    style="background-image:url('{{$movie->thumb_url}}')">
                </div>
                <div class="info"> <b class="title-film">{{$movie->name}}</b>
                    <p>{{$movie->origin_name}} ({{$movie->publish_year}})</p>
                    <span class="luotxem">Lượt xem: {{$movie->view_day}}</span>
                    <span class="imdb">Điểm {{ number_format($movie->rating_star ?: 8, 1) }}</span>
                </div>
            </a> </li>
        @endforeach
    </ul>
</div>
