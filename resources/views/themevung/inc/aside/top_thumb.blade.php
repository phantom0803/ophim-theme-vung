<div class="topphim-doc">
    <h3>{{ $top['label'] }}</h3>
    <ul class="film">
        @foreach ($top['data'] as $movie)
            <li> <a href="{{$movie->getUrl()}}">
                <div class="image"
                    style="background-image:url('{{$movie->getThumbUrl()}}')">
                </div>
                <div class="info"> <b class="title-film">{{$movie->name}}</b>
                    <p>{{$movie->origin_name}} ({{$movie->publish_year}})</p>
                    <span class="luotxem">Lượt xem: {{$movie->view_day}}</span>
                    <span class="imdb">Điểm {{$movie->getRatingStar()}}</span>
                </div>
            </a> </li>
        @endforeach
    </ul>
</div>
