<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-121208389-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-121208389-1');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/app.css')) }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script>
        window.App = @json([
            'signedIn' => auth()->check(),
            'user' => auth()->user()
        ]);
    </script>
</head>

<body>
    <div id="app">
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center pt-5 pb-5 border-bottom">技點網 Gdotttt 下載站</h1>
                    </div>
                </div>
            </div>
        </header>
        <main class="container">
            <div class="row">
                <div class="col-8 mr-auto ml-auto">
                    <p class="mt-5 mb-5 text-black-50">Single-tenant cloud services help alleviate security concerns. To meet this need, leading providers,
                        such as AWS and Google, developed single-tenant cloud services -- namely, AWS Dedicated Instances
                        and Google Compute Engine sole-tenant nodes -- that are dedicated to one user. But, despite the benefits
                        of these services, there are some limitations. Public IaaS providers rely on a multi-tenant architecture,
                        in which users share the same underlying compute resources. If one user's workload spikes, latency
                        problems can arise for other users, because the high resource consumption for that spike starves
                        the other workloads of resources. This issue is known as noisy neighbors. Single-tenant cloud instances
                        don't have neighbors, so performance is more reliably consistent. Single-tenant cloud services offer
                        several benefits beyond performance. For example, single-tenant cloud services can reduce security
                        concerns, as they isolate a workload from any attacks on a neighboring VM.</p>
                    <download-steps :file="{{ $file }}" class="text-center"></download-steps>
                </div>
            </div>
        </main>
    </div>

    <script src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    {!! NoCaptcha::renderJs() !!}
</body>

</html>