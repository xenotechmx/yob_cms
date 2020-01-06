<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        {{ ENV('APP_NAME')  }}
    </title>

    {{-- Fonts --}}
    {{ Html::style('https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800') }}
    {{-- Bootstrap --}}
    {{ Html::style('back/bower_components/bootstrap/dist/css/bootstrap.min.css') }}
    {{-- themify icons --}}
    {{ Html::style('back/assets/icon/themify-icons/themify-icons.css') }}
    {{-- ico fonts --}}
    {{ Html::style('back/assets/icon/icofont/css/icofont.css') }}
    {{-- flag icon framework css --}}
    {{ Html::style('back/assets/pages/flag-icon/flag-icon.min.css') }}
    {{-- Menu-Search css --}}
    {{ Html::style('back/assets/pages/menu-search/css/component.css') }}
    {{-- Menu-Search css --}}
    {{--{{ Html::style('Horizontal-Timeline.css') }}--}}
    {{-- amchart css --}}
    {{ Html::style('back/assets/pages/dashboard/amchart/css/amchart.css') }}
    {{-- flag icon framework css --}}
    {{--{{ Html::style('assets/pages/flag-icon/flag-icon.min.css') }}--}}
    {{-- Datatable --}}
    {{ Html::style('back/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}
    {{ Html::style('back/assets/pages/data-table/css/buttons.dataTables.min.css') }}
    {{ Html::style('back/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}
    {{-- Sweetalert --}}
    {{ Html::style('back/bower_components/sweetalert/dist/sweetalert.css') }}
    {{-- style --}}
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

{{--    {{ Html::script('back/js/bootstrap-year-calendar/css/bootstrap-year-calendar.js') }}--}}

    {{ Html::style('back/assets/css/style.css') }}
    {{-- color --}}
    {{ Html::style('back/assets/css/color/color-1.css') }}

    {{-- Page CSS --}}
    @section('pageCSS')
    @show

</head>

<body class="fix-menu">
{{-- Pre-loader start --}}
<div class="theme-loader">
    <div class="ball-scale">
        <div></div>
    </div>
</div>

{{-- Menu Header --}}
@include('back.layout.partials.top-menu')

{{-- Menu Sidebar --}}
@include('back.layout.partials.sidebar-menu')

{{-- Main Content --}}
<div class="main-body">
    <div class="page-wrapper">
        {{-- Page header --}}
        <div class="page-header">
            <div class="page-header-title">
                <h4>
                    @section('contentTitle')
                    @show
                </h4>
            </div>

            <div class="page-header-breadcrumb">
                @section('pageTopButton')
                @show
            </div>
        </div>

        {{-- Page Content --}}
        <div class="page-body">
            @yield('mainContent')
        </div>
    </div>
</div>

{{-- JQuery --}}
{{ Html::script('back/bower_components/jquery/dist/jquery.min.js') }}
{{ Html::script('back/bower_components/jquery-ui/jquery-ui.min.js') }}
{{ Html::script('back/bower_components/tether/dist/js/tether.min.js') }}
{{ Html::script('back/bower_components/bootstrap/dist/js/bootstrap.min.js') }}
{{-- JQuery slimscroll --}}
{{ Html::script('back/bower_components/jquery-slimscroll/jquery.slimscroll.js') }}
{{-- Modernizr --}}
{{ Html::script('back/bower_components/modernizr/modernizr.js') }}
{{ Html::script('back/bower_components/modernizr/feature-detects/css-scrollbars.js') }}
{{-- Classie js --}}
{{--{{ Html::script('back/back/bower_components/classie/classie.js') }}--}}
{{-- sweet alert js --}}
{{ Html::script('back/bower_components/sweetalert/dist/sweetalert.min.js') }}
{{--{{ Html::script('back/assets/js/modal.js') }}--}}
{{-- modalEffects js nifty modal window effects --}}
{{ Html::script('back/assets/js/modalEffects.js') }}
{{--{{ Html::script('back/js/classie.js') }}--}}
{{-- Datatable --}}
{{ Html::script('back/bower_components/datatables.net/js/jquery.dataTables.min.js') }}
{{ Html::script('back/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}
{{ Html::script('https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js') }}
{{ Html::script('back/assets/pages/data-table/js/jszip.min.js') }}
{{ Html::script('back/assets/pages/data-table/js/pdfmake.min.js') }}
{{ Html::script('back/assets/pages/data-table/js/vfs_fonts.js') }}
{{ Html::script('back/bower_components/datatables.net-buttons/js/buttons.html5.min.js') }}
{{ Html::script('back/bower_components/datatables.net-buttons/js/buttons.print.min.js') }}
{{ Html::script('back/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}
{{ Html::script('back/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}
{{ Html::script('back/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}
{{-- Masking --}}
{{ Html::script('back/assets/pages/form-masking/inputmask.js') }}
{{ Html::script('back/assets/pages/form-masking/jquery.inputmask.js') }}
{{ Html::script('back/assets/pages/form-masking/autoNumeric.js') }}
{{ Html::script('back/assets/pages/form-masking/form-mask.js') }}
{{-- i18next.min.js --}}
{{ Html::script('back/bower_components/i18next/i18next.min.js') }}
{{ Html::script('back/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js') }}
{{ Html::script('back/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js') }}
{{ Html::script('back/bower_components/jquery-i18next/jquery-i18next.min.js') }}
{{-- Custom JS --}}
{{ Html::script('back/js/bootstrap-year-calendar/js/bootstrap-year-calendar.js') }}
{{ Html::script('back/assets/js/script.js') }}
{{-- Pastora --}}
{{ Html::script('back/js/pastora.js') }}

{{-- Page JS --}}
@section('pageJS')
@show
</body>
</html>