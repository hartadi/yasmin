<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield("title") | Persediaan Stock Barang</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <link rel="stylesheet" href="{{url("plugins/fontawesome-free/css/all.min.css")}}" />
    <link rel="stylesheet" href="{{url("plugins/jquery-confirm/jquery-confirm.min.css")}}" />
    <link rel="stylesheet" href="{{url("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}" />
    <link rel="stylesheet" href="{{url("theme/css/adminlte.min.css")}}" />
    <link rel="stylesheet" href="{{url("theme/app.css")}}" />
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    {{strftime('%A, %d %B %Y, %H:%M')}}
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{url("theme/img/user2-160x160.jpg")}}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Alexander Pierce</a>
                    </div>
                </div>

                <nav class="mt-2">
                    @include('layouts.sidebar')
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield("title")</h1>
                        </div>
                        <div class="col-sm-6">
                            {{-- <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Starter Page</li>
                            </ol> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container-fluid">
                    @include('layouts.flash-message')
                    @yield("content")
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Version 1
            </div>
            <strong>Copyright &copy; {{date("Y")}}</strong> All rights reserved.
        </footer>
    </div>

    <style>
        .card-success>.card-header {
            width: 100%;
            font-size: 12px;
            background: #436283;
            color: white;
            line-height: 150%;
            border-radius: 3px 3px 0 0;
            box-shadow: 0 2px 5px 1px rgba(0, 0, 0, 0.2);
        }

        .card-primary:not(.card-outline)>.card-header {
            background-color: #681515c2;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #31708f;
            border-color: #ccd7cf;
        }

        .btn-primary {
            color: #fff;
            background-color: #31708f;
            border-color: #2e6da4;
        }

        .btn-warning:hover {
            color: #fff;
            background-color: #d9534f;
            border-color: #ccd7cf;
        }

        .btn-warning {
            color: #fff;
            background-color: #d9534f;
            border-color: #2e6da4;
        }

        .pagination>.active>a,
        .pagination>.active>a:focus,
        .pagination>.active>a:hover,
        .pagination>.active>span,
        .pagination>.active>span:focus,
        .pagination>.active>span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #31708f;
            border-color: #e2e7eb;
        }

        table tr:hover {
            background-color: #ffff99;
        }

        .selectedtr {
            background-color: #ffff99;
        }

        input:hover {
            background-color: #ffff99;
        }

        select:hover {
            background-color: #ffff99;
        }

        input[type="checkbox"]:hover {
            background-color: #ffff99;
        }

        textarea:hover {
            background-color: #ffff99;
        }
    </style>
    <script src="{{url("plugins/jquery/jquery.min.js")}}"></script>
    <script src="{{url("plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{url("plugins/moment/moment.min.js")}}"></script>
    <script src="{{url("plugins/moment/locale/id.js")}}"></script>
    <script src="{{url("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}"></script>
    <script src="{{url("plugins/jquery-confirm/jquery-confirm.min.js")}}"></script>
    <script src="{{url("plugins/inputmask/jquery.inputmask.min.js")}}"></script>
    <script src="{{url("theme/js/adminlte.min.js")}}"></script>
    <script src="{{url("theme/app.js")}}"></script>
    @yield("script")
</body>

</html>