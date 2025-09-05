<div class="sidenav-menu">
    <a href="{{ route('dashboard') }}" class="logo">
        <span class="logo-light">
            <span class="logo-lg"><img src="assets/images/brand/logo-white.png" alt="logo"></span>
            <span class="logo-sm"><img src="assets/images/brand/logo-white.png" alt="small logo"></span>
        </span>
        <span class="logo-dark">
            <span class="logo-lg"><img src="assets/images/brand/logo-color.png" alt="dark logo"></span>
            <span class="logo-sm"><img src="assets/images/brand/logo-color.png" alt="small logo"></span>
        </span>
    </a>

    <button class="button-close-fullsidebar">
        <i class="ri-close-line align-middle"></i>
    </button>

    <div data-simplebar>
        <ul class="side-nav">
            @foreach ($siderbars as $s)
                <li class="side-nav-title">{{$s['group']}}</li>
                @foreach ($s['chil'] as $item)
                    @if (isset($item['children']) && $item['children'])
                        <li class="side-nav-item {{$item['active'] ? "active" : ""}}">
                            <a data-bs-toggle="collapse" href="#{{$item['route']}}" aria-expanded="false"
                                aria-controls="{{$item['route']}}" class="side-nav-link">
                                <span class="menu-icon">{!! $item['icon'] !!}</span>
                                <span class="menu-text">
                                    {{$item['label']}}
                                </span>
                                @if (isset($item['noti']) && $item['noti'] > 0)
                                    <span class="badge bg-danger text-white rounded-pill ms-auto notification-badge">
                                        {{ $item['noti'] > 99 ? '99+' : $item['noti'] }}
                                    </span>
                                @elseif (isset($item['noti']) && $item['noti'] == 0)
                                    <span class="badge bg-light text-muted rounded-pill ms-auto notification-badge">
                                        0
                                    </span>
                                @endif
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse {{$item['active'] ? "show" : ""}}" id="{{$item['route']}}">
                                <ul class="sub-menu">
                                    @foreach ($item['children'] as $itemChild)
                                        <li class="side-nav-item">
                                            <a href="{{ $itemChild['route'] }}" class="side-nav-link {{(isset($itemChild['active']) && $itemChild['active']) ? 'active' : ''}}">
                                                <span class="menu-text">{{$itemChild['label']}}</span>
                                                @if (isset($itemChild['noti']) && $itemChild['noti'] > 0)
                                                    <span class="badge bg-danger text-white rounded-pill ms-auto notification-badge-small">
                                                        {{ $itemChild['noti'] > 99 ? '99+' : $itemChild['noti'] }}
                                                    </span>
                                                @elseif (isset($itemChild['noti']) && $itemChild['noti'] == 0)
                                                    <span class="badge bg-light text-muted rounded-pill ms-auto notification-badge-small">
                                                        0
                                                    </span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="side-nav-item {{$item['active'] ? "active" : ""}}">
                            <a href="{{ $item['route'] }}" class="side-nav-link">
                                <span class="menu-icon">{!! $item['icon'] !!}</span>
                                <span class="menu-text"> {{$item['label']}} </span>
                                @if (isset($item['noti']) && $item['noti'] > 0)
                                    <span class="badge bg-danger text-white rounded-pill ms-auto notification-badge">
                                        {{ $item['noti'] > 99 ? '99+' : $item['noti'] }}
                                    </span>
                                @elseif (isset($item['noti']) && $item['noti'] == 0)
                                    <span class="badge bg-light text-muted rounded-pill ms-auto notification-badge">
                                        0
                                    </span>
                                @endif
                            </a>
                        </li>
                    @endif
                @endforeach
            @endforeach
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
