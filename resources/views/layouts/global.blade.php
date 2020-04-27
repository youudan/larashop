<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Larashop - @yield("title")</title>
    
    <!-- favicon -->
    <link rel="icon" type="image/png" href="" />
    <link rel="apple-touch-icon" href="">

    <link rel="stylesheet" href="/polished/polished.min.css">
    <link rel="stylesheet" href="/polished/iconic/css/open-iconic-bootstrap.min.css">
    <style>
        .grid-highlight {
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: #5c6ac4;
            border: 1px solid #202e78;
            color: #fff;
        }

        hr {
            margin: 6rem 0;
        }

        hr+.display-3,
        hr+.display-2+.display-3 {
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand p-0">
        <a class="navbar-brand text-center col-xs-12 col-md-3 col-lg-2 mr-0" href="/"> Larashop </a>
        <button class="btn btn-link d-block d-md-none" data-toggle="collapse" data-target="#sidebar-nav" role="button">
            <span class="oi oi-menu"></span>
        </button>
        <input class="border-dark bg-primary-darkest form-control d-none d-md-block w-50 ml-3 mr-2" type="text"
            placeholder="Search" aria- label="Search">
        <div class="dropdown d-none d-md-block">
            @if(\Auth::user())
            <button class="btn btn-link btn-link-primary dropdown-toggle" id="navbar-dropdown" data-toggle="dropdown">
                {{Auth::user()->name}}
            </button>
            @endif
            <div class="dropdown-menu dropdown-menu-right" id="navbar- dropdown">
                <a href="#" class="dropdown-item">Profile</a> 
                <a href="{{ route('users.setting') }}" class="dropdown-item">Setting</a>
                <a href="{{ route('users.password') }}" class="dropdown-item">Change password</a>
                <div class="dropdown-divider"></div>
                <li>
                    <form action="{{ route("logout") }}" method="POST">
                        @csrf
                        <button class="dropdown-item" style="cursor:pointer">SignOut</button>
                    </form>
                </li>
            </div>
        </div>
    </nav>
    <div class="container-fluid h-100 p-0">
        <div style="min-height: 100%" class="flex-row d-flex align-items-stretch m-0">
            <div class="polished-sidebar bg-light col-12 col-md-3 col-lg-2 p-0 collapse d-md-inline" id="sidebar-nav">
                <ul class="polished-sidebar-menu ml-0 pt-4 p-0 d-md-block">
                    <input class="border-dark form-control d-block d-md-none mb-4" type="text" placeholder="Search"
                        aria-label="Search" />
                    <li>
                        <a href="{{ route('home') }}">
                            <span class="oi oi-home"></span>Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}">
                            <span class="oi oi-people"></span> Manage Users 
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}">
                            <span class="oi oi-tag"></span> Manage Categories 
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('books.index') }}">
                            <span class="oi oi-book"></span> Manage Books 
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orders.index') }}">
                            <span class="oi oi-inbox"></span> Manage orders
                        </a>
                    </li>
                    <div class="d-block d-md-none">
                        <div class="dropdown-divider"></div>
                        <li><a href="#"> Profile</a></li>
                        <li><a href="#"> Setting</a></li>
                        <li>
                            <form action="{{route("logout")}}" method="POST">
                                @csrf
                                <button class="dropdown-item" style="cursor:pointer">Sign Out</button>
                            </form>
                        </li>
                    </div>
                </ul>
                <div class="pl-3 d-none d-md-block position-fixed" style="bottom: 0px">
                    <span class="oi oi-cog"></span> Setting
                </div>
            </div>
            <div class="col-lg-10 col-md-9 p-4">
                <div class="row ">
                    <div class="col-md-12 pl-3 pt-2">
                        <div class="pl-3">
                            <h3>@yield("pageTitle")</h3><br />
                        </div>
                    </div>
                </div>
                @yield("content")
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>
    @yield('footer-scripts')
</body>

</html>
