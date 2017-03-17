<?php
class Category {
    private $db;

    public function __construct(db $db)
    {
        $this->db = $db;
    }

    public function get_category($id) {
        $category = $this->db->query("SELECT * FROM categories WHERE ID = $id");

        return isset($category[0]) ? $category[0] : null;
    }

    public function get_categories() {
        $categories= $this->db->query("SELECT * FROM categories");

        return isset($categories[0]) ? $categories : null;
    }

    public function add_category($data) {
        $name = $data["name"];

        $this->db->query("INSERT INTO `categories`(`Name`) VALUES ('$name')");

        return true;
    }

    public function delete_category($id) {
        $this->db->query("DELETE FROM `categories` WHERE ID = $id");

        return true;
    }

    public function change_category($data) {
        $id = $data["id"];
        $name = $data["name"];

        $this->db->query("UPDATE `categories` SET `Name` = '$name' WHERE ID = $id");

        return true;
    }
}