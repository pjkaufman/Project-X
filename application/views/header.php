<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $_SESSION['title']; ?></title>
    <!----JQuery CDNs ---->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!----Bootstrap CDNs ---->
    <link rel="stylesheet" type="text/css" rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!----moment CDNs ---->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
    <!----Daterangepicker CDNs ---->
	  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css"/>
		<script src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <!----Select2 CDNs ---->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <!----D3 CDNs ---->
		<script src="https://www.gstatic.com/charts/loader.js"></script>
		<script src="https://d3js.org/d3.v3.js"></script>
    <!----Tinymce CDNs ---->
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <!----Datatables CDNs ---->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
    <script charset="utf8" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <!----Regular Links ---->
    <link href="<?php echo base_url() . 'assets/css/style.css';?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/'.$_SESSION['cmod'].'/css/style.css';?>"/>
    <link rel="icon" type="image/jpeg" href=<?php echo base_url().'assets/images/favicon.jpg';?>>
    <script src="<?php echo base_url() . 'assets/'.$_SESSION['cmod'].'/js/'.$_SESSION['cmod'].'.js';?>"></script>
    <script src="<?php echo base_url() . 'assets/js/objects.js';?>"></script>
    <script src="<?php echo base_url() . 'assets/js/default.js';?>"></script>
  </head>
<body>
