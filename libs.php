<?php
/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 16.02.2017
 * Time: 22:30
 */

function __autoload($class) {
    if(file_exists("libs/$class.php")) {
        include "libs/$class.php";
    }
}