<a href="{{$movie->getUrl()}}" class="col-xs-4 col-lg-2 film-small">
    <div class="poster-film-small"
        style="background-image:url('{{$movie->getThumbUrl()}}')">
        @if ($movie->type == 'series')
            <div class="sotap">{{$movie->episode_current}}</div>
        @endif
        <ul class="tag-film">
            <li>
                <div class="hd">{{$movie->quality}}</div>
            </li>
            @if (strpos(strtolower($movie->language), 'thuyết minh'))
            <li>
                <div class="sd tm">TM</div>
            </li>
            @endif
        </ul>
        <div class="play"></div>
    </div>
    <div class="title-film-small">
        <b class="title-film">{{$movie->name}}</b>
        <p>{{$movie->origin_name}} ({{$movie->publish_year}})</p>
    </div>
</a>
