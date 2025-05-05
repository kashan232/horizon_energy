<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets/images/logoIcon/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/app.css?v=1') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <!-- <link rel="stylesheet" href="assets/global/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/admin/css/vendor/bootstrap-toggle.min.css">
    <link rel="stylesheet" href="assets/global/css/all.min.css">
    <link rel="stylesheet" href="assets/global/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/admin/css/vendor/select2.min.css">
    <link rel="stylesheet" href="assets/admin/css/vendor/datepicker.min.css">
    <link rel="stylesheet" href="assets/admin/css/app.css?v=1">
    <link rel="stylesheet" href="assets/admin/css/custom.css"> -->





    <style>
        .widget-two__btn {
            right: 15px !important;
        }
    </style>
</head>
<body>
