@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid navbar-top">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/" title="{{ $title }}">
                @if ($logo)
                    {!! $logo !!}
                @else
                    {!! $brand !!}
                @endif
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                @foreach ($menu as $item)
                    @if (count($item['children']))
                        <li class="dropdown">
                            <a href="{{$item['link']}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$item['name']}} <span
                                    class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                @foreach ($item['children'] as $children)
                                    <li>
                                        <a href="{{$children['link']}}">{{$children['name']}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{$item['link']}}">{{$item['name']}}</a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li>
                    <form class="navbar-form" method="GET" id="form-search" action="/">
                        <div class="form-group">
                            <input placeholder="Tìm tên phim..." class="form-control" id="query_search" value="{{ request('search') }}" type="text" name="search" maxlength="100" autocomplete="off" />
                        </div>
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                        <div class="search-hint" id="search-hint"></div>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
