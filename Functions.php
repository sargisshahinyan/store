<?php
define("NAV_TAB_NUMBER", 6);

function get_nav($index) {
    $navs = [];
    $index--;

    for($i = 0; $i < NAV_TAB_NUMBER; ++$i) {
        $navs[$i] = $i == $index ? "active" : "";
    }

    return $navs;
}