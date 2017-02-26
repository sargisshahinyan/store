<?php
/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 27.02.2017
 * Time: 0:37
 */

define("NAV_TAB_NUMBER", 5);

function get_nav($index) {
    $navs = [];
    $index--;

    for($i = 0; $i < NAV_TAB_NUMBER; ++$i) {
        $navs[$i] = $i == $index ? "active" : "";
    }

    return $navs;
}