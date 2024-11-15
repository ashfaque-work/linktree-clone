<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LinkHive') }}</title>
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KPZLPSRG');</script>
    <!-- End Google Tag Manager -->
    
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/icons/link-icon.png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="{{ url('assets/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/dropify-app.min.css') }}" rel="stylesheet" type="text/css" />
    <!--<link href="{{ url('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />-->
    <link href="{{ url('/assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://kit.fontawesome.com/965bd2f436.js" crossorigin="anonymous"></script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XQCSTTH2HL"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-XQCSTTH2HL');
    </script>
</head>

<body class="font-sans antialiased">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KPZLPSRG"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
    
    <!--for premium user-->
    @if( $user->userDetail->user_type == 'premium')
        @include('layouts.offCanvas')
        @include('layouts.addProfileModal')
    @else
        @include('layouts.proModal')
    @endif
    
    @include('layouts.shareModal')
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>   
    <script src="{{ url('assets/js/dropify.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.form-upload.init.js') }}"></script>
    <script src="{{ url('assets/js/custom.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#generateQrCodeBtn').click(function () {
                $('#qrCodeImage').attr('src', '');
                $.ajax({
                    url: '{{route("qrcode.generate")}}',
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        // Update the image source with the generated QR code
                        $('#qrCodeImage').attr('src',  "{{ url('') }}" + '/' + response.pathPNG);
                        $('#profile_link').html(response.profile_url);
                        $('#link').attr('value', response.profile_url);
                        $('#openMyLink').attr('href', response.profile_url);
                        
                        // Update the download links
                        $('#downloadPNG').attr('href', "{{ url('') }}" + '/' + response.pathPNG).attr('download', response.url_slug+ '.png');
                    },
                    error: function (error) {
                        // Handle errors
                        console.log(error);
                    }
                });
            });
        });
    </script>
    <script>
        function myFunction(button) {
            var copyText = document.getElementById("link");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);

            button.textContent = 'Copied';
            setTimeout(function() {
                button.textContent = 'Copy';
            }, 2000);
        }
    </script>
</body>

</html>
