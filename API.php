<?php

include "libs.php";

$request = isset($_SERVER["PATH_INFO"]) ? explode("/", $_SERVER["PATH_INFO"]) : null;

if($request && count($request) > 1) {
    array_shift($request);

    $target = array_shift($request);
    $id = array_shift($request);

    switch ($target) {
        case "categories":
            $category = new Category(new db());

            $response = $id ? $category->get_category((int)$id) : $category->get_categories();

            echo json_encode($response);
            break;
        case "items":
            $item = new Item(new db());

            $data = count($_GET) ? $_GET : null;

            $response = $id ? $item->get_item((int)$id) : $item->get_items($data);

            echo json_encode($response);
            break;
        case "sell":
            $deal = new Deal(new db());
            $data = $_POST;

            if(!empty($data["items"])) {
                $deal->sell([
                    "items" => $data["items"]
                ]);
            }

            echo true;
            break;
        default:
            header("Wrong target", true, 400);
            echo null;
    }
} else {
    header("Wrong target", true, 400);
    echo null;
}