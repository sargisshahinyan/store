<?php
/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 26.02.2017
 * Time: 13:33
 */

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
    header("Location:home.php");
} else {
    header("Location:index.php");
}