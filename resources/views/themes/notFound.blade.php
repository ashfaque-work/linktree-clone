<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LinkHive') }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/icons/link-icon.png">
    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/965bd2f436.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .py-5 {
            padding-top: 3rem !important;
            padding-bottom: 3rem !important;
        }

        .text-center {
            font-size: 2rem;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="">

        <!-- Page Content -->
        <main>
            <div class="container">
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle text-danger fa-5x"></i>
                    <h1 class="mt-4">404 - Not Found</h1>
                    <p class="lead">Sorry, the page you are looking for might be in another castle.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Go to Dashboard</a>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
