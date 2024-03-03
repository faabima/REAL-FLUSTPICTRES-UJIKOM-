<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="website icon" type="img/png" href="/assets/logo.png">
    <!--CSS-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Hurricane&display=swap" rel="stylesheet">
    <!--icon boostrap--->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @media(max-width:768px) {
            .flex-container {
                flex-direction: column;
            }

            .fulwidth {
                width: 100%;
            }

            .fulheight {
                height: 100%;
            }
        }
    </style>
</head>
<body>
   <!--navbar-->
    @include('Admin.layout.navbar')
   <!--/navbar--> 
   <!--sidebar-->
    @include('Admin.layout.sidebar')
   <!--/sidebar-->
    <!-- pages.content -->
    @yield('content')
    <!-- /pages.content -->
    <script src="/node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>