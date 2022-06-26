<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $this->setting_model->get_setting('pagetitle')->value; ?> - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url(); ?>assets/admin/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
    .studentshow.hidediv{display:none;}
    .report_fields:focus, .report_fields:active, .report_fields {
        border: none;
        background: none;
        border-bottom: 1px solid #111;
        font-size:14px;
        outline:0;
    }
    .reports_table {
        margin-top: 32px;
        border-bottom:0;
        height: auto;
        display: table;
    }
    .reports_table td, .reports_table th {
        border: 1px solid #111;
    }
    .reports_table th {
        text-align:center;
        padding: 15px 10px; 
    }
    .reports_table td {
        padding: 5px 10px; 
    }
    .below_reports_table { margin-top: 45px;}
    .print_floating_btn {
        position: absolute;
        top: 85px;
        right: 25px;
        z-index: 999;
    }
    .txt_before { display:none;}
    </style>
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">