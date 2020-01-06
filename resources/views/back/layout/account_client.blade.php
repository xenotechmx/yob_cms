<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>@yield("pageTitle")</title>

    <link href="{{ asset('assets/node_modules/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">

    <!-- page css -->
    <link href="{{ asset('template/dist/css/pages/login-register-lock.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('template/dist/css/style.min.css') }}" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-default card-no-border">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">Elite admin</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">

    @yield("content_account_client")

</section>

<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('assets/node_modules/popper/popper.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/node_modules/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/node_modules/sweetalert/jquery.sweet-alert.custom.js') }}"></script>

{{ Html::script('system/js/pastora.js')  }}

<!--Custom JavaScript -->
<script type="text/javascript">
    $(function() {
        $(".preloader").fadeOut();
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // ==============================================================
    // Login and Recover Password
    // ==============================================================
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    $('#to-recover-hide').on("click", function() {
        $("#loginform").slideDown();
        $("#recoverform").fadeOut();
    });



    $(document).ready(function () {

        $(this).on('submit', '#recoverform' ,function (e) {
            e.preventDefault();

            var data = new FormData(this);
            var url = $(this).attr('action');

            $.ajax({
                url: url,
                type: "POST",
                dataType: "JSON",
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function () {
                    blockForm();
                },
                error: function (e) {

                    unblockForm();
                    if (e.status == 422) {
                        modalErrors(JSON.parse(e.responseText));
                    } else {
                        errorAlert('!Ups, algo salio mal!');
                    }
                },
                success: function (response) {

                    unblockForm();
                    if (response.status == true) {

                        swal({
                            title: "¡Excelente!",
                            text: response.message,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonText: "Aceptar",
                        }).then((willDelete) => {
                            window.location = response.url;
                        });

                    } else {
                        errorAlert(response.message);
                    }
                }
            });

        });

    });


</script>

</body>

</html>