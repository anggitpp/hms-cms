@php
    $prefix = Request::route()->getPrefix();
    $route = Route::current()->getName();
    list($modul, $menu, $action) = explode(".",$route);
    $targetModul = str_replace('/','',$prefix);
@endphp

<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('app-assets/images/icons/logo.png') }}" height="30" width="30"/>
                    <h2 class="brand-text">HMS</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @foreach($app_sub_moduls as $key => $submodul)
                <li class="navigation-header">
                    <span data-i18n="Apps &amp; Pages">{{ $submodul->name }}</span>
                    <i data-feather="more-horizontal"></i>
                </li>
                @foreach($app_menus as $k => $menu)
                    @if($menu->sub_modul_id == $submodul->id)
                        @if($app_sub_menus->contains('parent_id', $menu->id))
                            <li class="nav-item">
                                <a class="d-flex align-items-center" href="#">
                                    <i class="{{ $menu->icon ?? 'fa fa-folder' }}"></i>
                                    <span class="menu-title text-truncate" data-i18n="Invoice">{{ $menu->name }}</span>
                                </a>
                                <ul class="menu-content">
                                    @foreach($app_sub_menus->where('parent_id', $menu->id) as $ksub => $vsub)
                                        <li {{ $route == $targetModul.'.'.$vsub->target.'.'.$action ? 'class=active' : '' }}>
                                            <a class="d-flex align-items-center" href="{{ route($targetModul.'.'.$vsub->target.'.index') }}">
                                                <i class="{{ $vsub->icon ?? 'fa fa-folder' }}"></i>
                                                <span class="menu-title text-truncate" data-i18n="Chat">
                                                {{ $vsub->name }}
                                            </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="{{ $route == $targetModul.'.'.$menu->target.'.'.$action ? 'active' : '' }} nav-item">
                                <a class="d-flex align-items-center" href="{{ route($targetModul.'.'.$menu->target.'.index') }}">
                                    <i class="{{ $menu->icon ?? 'fa fa-folder' }}"></i>
                                    <span class="menu-title text-truncate" data-i18n="Chat">
                                        {{ $menu->name }}
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endif
                @endforeach
            @endforeach
        </ul>
    </div>
</div>
