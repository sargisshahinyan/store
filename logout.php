<?php
/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 26.02.2017
 * Time: 19:49
 */
session_start();
session_destroy();
header("Location:index.php");