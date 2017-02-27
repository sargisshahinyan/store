<?php
/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 16.02.2017
 * Time: 22:39
 */
include "libs.php";

session_start();
if(!isset($_SESSION["user"])) {
    header("Location:index.php");
}

$navs = isset($navs) ? $navs : ['', '', '', '', ''];

$db = new db();
?>
<html>
    <head>
        <title>Title</title>

        <link rel="apple-touch-icon" sizes="180x180" href="icons/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="icons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="icons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="icons/manifest.json">
        <link rel="mask-icon" href="icons/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="theme-color" content="#ffffff">

        <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">

        <script src="js/jquery.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>
    </head>
    <body>
        <header class="container">
            <div class="row">
                <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="home.php">Խանութ</a>
                        </div>
                        <div class="collapse navbar-collapse" id="myNavbar">
                            <ul class="nav navbar-nav">
                                <li class="<?= $navs[0]; ?>"><a href="home.php">Գլխավոր</a></li>
                                <li class="<?= $navs[1]; ?>"><a href="categories.php">Կատեգորիաներ</a></li>
                                <li class="<?= $navs[2]; ?>"><a href="items.php">Ապրանքներ</a></li>
                                <li class="<?= $navs[3]; ?>"><a href="purchases.php">Առք</a></li>
                                <li class="<?= $navs[4]; ?>"><a href="sales.php">Վաճառք</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Դուրս գալ</a></li>
                            </ul>
                        </div>
                </nav>
            </div>
        </header>
