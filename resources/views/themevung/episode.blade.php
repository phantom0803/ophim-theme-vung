@extends('themes::themevung.layout')

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
                <a itemprop="item" itemprop="url" href="{{ $currentMovie->getUrl() }}" title="{{ $currentMovie->name }}">
                    <span itemprop="name"> {{ $currentMovie->name }}</span>
                </a>
                <i class="fa fa-angle-right"></i>
                <meta itemprop="position" content="3" />
            </li>
            <li>
                <a href="javascript:;"
                    class="active">{{ strpos(strtolower($episode->name), 'tập') ? $episode->name : "Tập $episode->name" }}</a>
            </li>
        </ul>
    </div>

    <div id="player-wrapper">
        <div id="player-holder" class="player-film"></div>
        <div class="buttonlight-film">
            <ul>
                <li>
                    <div class="fb-gg">
                        <div class="fb-like" data-href="{{ $currentMovie->getUrl() }}" data-layout="button_count"
                            data-action="like" data-size="small" data-show-faces="false" data-share="true">
                        </div>
                        <div class="g-plusone" data-size="medium"></div>
                    </div>
                </li>
                <li>
                    <a id="report_error" data-toggle="modal" data-target="#ModalBaoloi">
                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>Báo lỗi
                    </a>
                </li>
                @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                    <li>
                        <a data-id="{{ $server->id }}" data-link="{{ $server->link }}" data-type="{{ $server->type }}"
                            onclick="chooseStreamingServer(this)" class="streaming-server">
                            <i class="fa fa-play" aria-hidden="true"></i>
                            Nguồn #{{ $loop->index + 1 }}
                        </a>
                    </li>
                @endforeach
                <li>
                    <a class="light-on show1">Tắt đèn <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                    </a>
                    <a class="light-off">Bật đèn <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="scene-dim"></li>
            </ul>
        </div>
    </div>


    <div class="alert alert-warning" role="alert"> Xem tốt nhất trên trình duyệt Chrome, Safari. Nếu
        bạn không xem được phim, vui lòng <b>đổi nguồn phát</b> hoặc <b>đổi server</b>, chúc bạn xem phim
        vui vẻ.
    </div>

    <div class="episode-film group-detail">
        @if ($currentMovie->notify && $currentMovie->notify != '')
            <p class="lichchieu"><span class="text-danger">• Thông báo</span>: {{ strip_tags($currentMovie->notify) }}</p>
        @endif
        @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
            <p class="lichchieu"><span class="text-info">• Lịch chiếu</span>: {{ strip_tags($currentMovie->showtimes) }}
            </p>
        @endif

        @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
            <span class="text-success">{{ $server }}</span>
            <div class="episode-main">
                <ul>
                    @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                        <li>
                            <a href="{{ $item->sortByDesc('type')->first()->getUrl() }}"
                                title="Xem phim {{ $currentMovie->name }} {{ $name }}"
                                class="@if ($item->contains($episode)) active @endif">
                                {{ $name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="title-film-film-0">
        <a href="{{ $currentMovie->getUrl() }}" class="">
            <h1 class="title-film-film-1">{{ $currentMovie->name }} -
                {{ strpos(strtolower($name), 'tập') ? $name : 'Tập ' . $name }}</h1> <br>
            <h2 class="title-film-film-2">{{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})</h2>
        </a>
    </div>
    <div class="group-detail ">
        <div class="imdb">Điểm {{$currentMovie->getRatingStar()}}</div>
        <ul class="rated-star hidden-xs">
            <i id="star"></i>
        </ul>
        <span class="rated-text">({{$currentMovie->getRatingCount()}} Đánh giá)</span>
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
@endsection

@push('scripts')
    <div id="ModalBaoloi" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Thông báo</h4>
                </div>
                <div class="modal-body" id="p_content">
                    <p class="alert-danger" id="show_msg"></p>
                    <div class="form-group">
                        <label for="log_des">Báo lỗi phim "{{ $currentMovie->name }} ({{ $currentMovie->origin_name }}) ({{ $currentMovie->publish_year }})"</label>
                        <textarea name="log_des" id="log_des" class="form-control" style="width:100%; height: 50px;"
                            placeholder="Mô tả lỗi phim {{ $currentMovie->name }} ({{ $currentMovie->origin_name }}) ({{ $currentMovie->publish_year }})"></textarea>
                    </div>
                    <a href="javascript:;" class="btn btn-primary" name="but_send_report" id="but_send_report">Gửi</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        var rating = '{{$currentMovie->getRatingStar()}}';
        var URL_POST_RATING = '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}';
        var URL_POST_REPORT = '{{ route('episodes.report', ['movie' => $currentMovie->slug, 'episode' => $episode->slug, 'id' => $episode->id]) }}';
    </script>
    <script defer type="text/javascript" src="/themes/vung/js/rating.js"></script>
    <script defer type="text/javascript" src="/themes/vung/js/episode.js"></script>

    <script src="/themes/vung/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/vung/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        var episode_id = {{ $episode->id }};
        const wrapper = document.getElementById('player-holder');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;


            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('active');
            })
            el.classList.add('active');

            link.replace('http://', 'https://');
            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/vung/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="100%" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    image: "{{ $currentMovie->getPosterUrl() }}",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }


                const resumeData = 'OPCMS-PlayerPosition-' + id;
                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const episode = '{{ $episode->id }}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
