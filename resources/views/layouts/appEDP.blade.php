<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('/images/csj.png') }}" type="image/gif" loading=lazy sizes="16x16">
    <title style="font-size: 20px">@yield('title', 'Home EDP')</title>
    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap@5.0.2.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/jquery-dateformat.js') }}"></script>
    <script src="{{ asset('js/RDZ.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/numeral.min.js') }}"></script>
    <script src="{{ asset('js/kitfontawesome.js') }}"></script>
    <script src="{{ asset('js/jsdelivrNpmSelect2.js') }}"></script>
    <script src="{{ asset('js/User.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <!-- Fonts -->
    {{-- Masih belum sepenuhnya Offline --}}
    <link href="{{ asset('css/fonts.googleapis.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/fonts.googleapis.MaterialSymbolsOutlined.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/JsdelivrNpmSelect2.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/FontsGoogleapisIconFamilyMaterialIcons.css') }}" rel="stylesheet" />

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/Rdz.css') }}" rel="stylesheet" />
    <div id="loading-screen">
        <div class="logo">
            <img src="/images/huruf-C.png" class="letter delay-1" alt="C">
            <img src="/images/huruf-S.png" class="letter delay-2" alt="S">
            <img src="/images/huruf-J.png" class="letter delay-3" alt="J">
        </div>
    </div>
</head>

<body onload="Greeting()">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow sticky-top">
            <div class="container col-md-12">
                <a class="navbar-brand RDZNavBrandCenter RDZUnderLine" href="{{ url('/') }}">
                    🡰<img src="{{ asset('/images/csj.png') }}" width="60" height="31" alt="KRR">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                </a>
                @guest
                @else
                    <div class="NameAndroid RDZNavBrandCenter" style="display:none;padding-top: 5px;">
                        <p style="font-size: 15px;display: block;margin-bottom: 0px;text-align:center"><label
                                id="greeting"></label>, {{ Auth::user()->NamaUser }}</p>
                    </div>
                    <br>
                    <button class="navbar-toggler RDZNavBrandCenter" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                @endguest

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @guest
                    @else
                        <ul class="navbar-nav mr-auto RDZNavContenCenter">
                            @foreach ($access['AccessMenu'] as $menuItem)
                                @php
                                    $print = 0;
                                    $cekSubMenuPrint = 0;
                                @endphp
                                @if ($menuItem->Parent_IdMenu === null)
                                    @php
                                        $print = 1;
                                    @endphp
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            style="margin: 10px">
                                            {{ $menuItem->NamaMenu }}
                                        </a>
                                @endif
                                @foreach ($access['AccessMenu'] as $cekSubMenu)
                                    @if ($menuItem->IdMenu == $cekSubMenu->Parent_IdMenu)
                                        <ul class="dropdown-menu" style="cursor: default;">
                                            @php
                                                $cekSubMenuPrint = 1;
                                            @endphp
                                            @break
                                    @endif
                                @endforeach
                                @foreach ($access['AccessMenu'] as $secondMenuItem)
                                    @php
                                        $printSecond = 0;
                                    @endphp
                                    @if ($secondMenuItem->Parent_IdMenu !== null && $secondMenuItem->Parent_IdMenu == $menuItem->IdMenu)
                                        @php
                                            $printSecond = 1;
                                        @endphp
                                        <li>
                                            <a class="" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"
                                                style="margin: 10px;cursor: default;">
                                                {{ $secondMenuItem->NamaMenu }} &raquo;
                                            </a>
                                    @endif
                                    @if ($printSecond == 1)
                                        <ul class="dropdown-menu dropdown-submenu">
                                            @foreach ($access['AccessFitur'] as $secondSubMenuItem)
                                                @if ($secondSubMenuItem->Id_Menu === $secondMenuItem->IdMenu && $printSecond == 1)
                                                    <li>
                                                        <a style="color: black;font-size: 15px;display: block"
                                                            class="dropdown-item" tabindex="-1"
                                                            href="{{ url($secondSubMenuItem->Route) }}">{{ $secondSubMenuItem->NamaFitur }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        </li>
                                    @endif
                                @endforeach
                                @if ($cekSubMenuPrint == 1)
                        </ul>
                        @endif
                        @if ($print == 1 && $printSecond == 0)
                            <ul class="dropdown-menu">
                                @foreach ($access['AccessFitur'] as $subMenuItem)
                                    @if ($subMenuItem->Id_Menu === $menuItem->IdMenu)
                                        <li>
                                            <a style="color: black;font-size: 15px;display: block" class="dropdown-item"
                                                tabindex="-1"
                                                href="{{ url($subMenuItem->Route) }}">{{ $subMenuItem->NamaFitur }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                    </div>
                    @endif
                    @endforeach
                    </ul>
                @endguest
                <!-- Right Side Of Navbar -->

                <!-- Authentication Links -->
                @guest
                @else
                    <ul class="navbar-nav ml-auto">
                        <div style="border-right: 1px solid;margin-right: 5px;padding-right: 5px;" class="NameWindows">
                            <p style="font-size: 15px;display: block;margin-bottom: 0px;"><label id="greeting1"></label>,
                                {{ Auth::user()->NamaUser }}</p> {{-- bisa dikasih profile --}}
                        </div>
                        <li><a class="RDZlogout" style="color: black;font-size: 15px;display: block;"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                @endguest
            </div>
    </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('.dropdown-submenu a.test').on("click", function(e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });
</script>

</html>
