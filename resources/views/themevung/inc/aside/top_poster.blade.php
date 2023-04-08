<div id="widget_top_film_country_by_type_phim-bo" class="topphim-ngang">
    <h3>{{ $top['label'] }}</h3>
    <ul class="film active">
        @foreach ($top['data'] as $movie)
            <li>
                <a href="{{$movie->getUrl()}}">
                    <div class="image"
                        style="background-image:url({{$movie->getPosterUrl()}})">
                    </div> <span class="imdb">Điểm <br> <b>{{$movie->getRatingStar()}}</b></span>
                    <div class="info"> <b class="title-film">{{$movie->name}}</b>
                        <p>{{$movie->origin_name}} ({{$movie->publish_year}})</p>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
