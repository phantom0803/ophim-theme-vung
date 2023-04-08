<div class="top-tintuc">
    <h3>{{$top['label']}}</h3>
    <ul class="film active">
        @foreach ($top['data'] as $movie)
        <li>
            <a href="{{$movie->getUrl()}}">
                <div class="image"
                    style="background-image:url({{$movie->getPosterUrl()}})">
                </div>
                <div class="info">
                    <b class="title-phim">{{$movie->name}} <br /> {{$movie->origin_name}} ({{$movie->publish_year}})</b>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
</div>
