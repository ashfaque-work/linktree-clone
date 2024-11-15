<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
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
    <script src="https://kit.fontawesome.com/965bd2f436.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        .container {
            max-width: 1000px !important;
        }
    </style>
    @if ($theme == 'custom')
        <style>
            body {
                background: {{ isset($customColor->backgroundColor) ? $customColor->backgroundColor : 'grey' }};
                background-attachment: fixed;
            }

            .btn-links {
                position: relative;
                font-family: {{ isset($customColor->font) ? $customColor->font : 'Arial' }};
                background-color: {{ isset($customColor->buttonColor) ? $customColor->buttonColor : '#000000' }};
                color: {{ isset($customColor->fontColor) ? $customColor->fontColor : '#fdfdfd' }};
                border-radius: 0.37rem;
            }
            .preview-name, .preview-bio{
                color: {{ isset($customColor->fontColor) ? $customColor->fontColor : '#fdfdfd' }} !important;
            }
            .social-icon-color{
                color: {{ isset($customColor->fontColor) ? $customColor->fontColor : '#fdfdfd' }} !important;
            }
            .btn-color {
                position: relative;
                background-color: rgb(176, 161, 137);
                color: #fff;
                border-radius: 0.37rem;
                padding-right: 1.5rem;
            }

            .btn-color :hover {
                color: #fff !important;
                background-color: {{ isset($customColor->buttonColor) ? $customColor->buttonColor : 'lightgrey' }};
            }
            
            .popup-share-btn a, .share-close-btn{
                 background-color: {{ isset($customColor->buttonColor) ? $customColor->buttonColor : '#000000' }};
                 color: {{ isset($customColor->fontColor) ? $customColor->fontColor : '#fdfdfd' }};
            }

            .profile-img {
                width:150px;
                height:150px;
                object-fit: contain;
                object-position: initial;
                filter: none;
            }
            .thumbnail-image{
                width: 30px !important;
                height: 30px !important;
                border-radius: 5px;
                margin-left: 5px;
                position: absolute !important;
                z-index: 999;
            }

            .btn-modal {
                position: relative;
                background-color: #e9dcdc;
                color: #fff;
                border-radius: 0.37rem;
                padding-right: 1.5rem;
            }

            .btn-modal :hover {
                color: #fff !important;
                background-color: #c0c0c0 !important;
            }

            .btn-modal :hover {
                color: #fff !important;
                background-color: #c0c0c0 !important;
            }

            .btn-response{
                width: 70%;
                margin-bottom: 1.1rem !important;
            }
            
            .a-response{
                font-size: 20px;
                padding: 11px 30px 11px 35px ;
                font-weight: 700;
            }
            
            @media (max-width: 768px) {
                .btn-response {
                   width: 90% !important;
                }
                .a-response{
                    font-size: 14px !important;
                }
            }
            
            @media (min-width: 769px) {
                .btn-response {
                   width: 70% !important;
                }
                .a-response{
                    font-size: 16px !important;
                }
            }


            .preview {
                /* Your default styles here */
                position: fixed;
                top: 0;
                right: 0;
                width: 200px;
                height: 100%;
                background-color: #f0f0f0;
                padding: 20px;
                border: 1px solid #ccc;
            }

            @media (min-width: 1000px) {
                .preview {
                    position: relative;
                }
            }
        </style>
    @else
        <link href="{{ asset('css/' . $theme . '.css') }}" rel="stylesheet" type="text/css" />
    @endif
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
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>

</html>
