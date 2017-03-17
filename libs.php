<?php
function __autoload($class) {
    if(file_exists("libs/$class.php")) {
        include "libs/$class.php";
    }
}