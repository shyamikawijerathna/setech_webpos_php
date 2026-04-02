<?php

require '../config/function.php';
require 'authentication.php';



?>
<?php 
 
    $page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
 ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - Admin</title>
        <link href="assets/css/style.min.css" rel="stylesheet" />
        <link href="assets/css/styles.css" rel="stylesheet" />
        
        <script src="assets/js/js.all.js" crossorigin="anonymous"></script>
        <link href="assets/css/select2.min.css" rel="stylesheet" />
        <link href="assets/css/custom.css" rel="stylesheet" />


    </head>
    <body class="sb-nav-fixed" style="background: linear-gradient(135deg, #084255 0%, #2bbbeb 100%)">

        <?php include("navbar.php"); ?>


        

            

                <main>
