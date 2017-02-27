<?php

/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 26.02.2017
 * Time: 22:07
 */
class Item {
    private $db;

    public function __construct(db $db)
    {
        $this->db = $db;
    }

    public function get_item($id) {
        $item = $this->db->query("SELECT * FROM items WHERE ID = $id");

        return isset($item[0]) ? $item[0] : null;
    }

    public function get_items($data = null) {
        $condition = "WHERE 1 ";

        if($data) {
            foreach ($data as $key => $datum) {
                switch ($key) {
                    case "category":
                        $condition .= " AND CategoryID = $datum";
                        break;
                }
            }
        }

        $items= $this->db->query("SELECT * FROM items $condition");

        return isset($items[0]) ? $items : null;
    }

    public function add_item($data) {
        $name = $data["name"];
        $price = $data["price"];
        $category = $data["category"];
        $quantity = $data["quantity"];

        $this->db->query("INSERT INTO `items`(`Name`, `Price`, `CategoryID`, `Quantity`) VALUES ('$name', $price, $category, $quantity)");

        return true;
    }

    public function delete_item($id) {
        $this->db->query("DELETE FROM `items` WHERE ID = $id");

        return true;
    }

    public function change_item($data) {
        $id = $data["id"];
        $name = $data["name"];
        $price= $data["price"];
        $category= $data["category"];
        $quantity= $data["quantity"];

        $this->db->query("UPDATE `items` SET `Name`='$name',`Price`=$price,`CategoryID`=$category,`Quantity`=$quantity WHERE ID = $id");

        return true;
    }
}