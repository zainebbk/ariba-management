<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <!-- Meta data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>

    @include('admin.layouts.custom-head')
</head>

<body class="h-100vh bg-white">
    <div class="page-main">
        @yield('content')
        <!--Footer-->
        <footer class="footer">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-md-12 col-sm-12 text-center" style=" font-size: 16px;padding: 20px 0;border-top: 1px solid #000;">
                        Ariba : SC INFODAT DEVELOPMENT SRL, Appartement 1 Douar Temsia Inzegane Ait Melloul.<br>
        				Ariba Multiseller Platform
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer-->

        @include('admin.layouts.custom-footer-scripts')
</body>

</html>
