<?php

include "libs.php";
session_start();

if(!count($_POST)) {
    header("Location:".$_SERVER['HTTP_REFERER']);
}

$login = !empty($_POST["username"]) ? $_POST["username"] : "";
$password= !empty($_POST["password"]) ? $_POST["password"] : "";

$auth = new Auth(new db());

$user = $auth->search_user($login, $password);

if($user) {
    $_SESSION["user"] = $user["ID"];
    $_SESSION["admin"] = $user["Admin"];
    header("Location:sales.php");
} else {
    header("Location:index.php");
}