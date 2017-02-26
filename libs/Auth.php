<?php

/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 26.02.2017
 * Time: 13:27
 */
class Auth
{
    private $db;

    public function __construct(db $db)
    {
        $this->db = $db;
    }

    public function search_user($login, $password) {
        $user = $this->db->query("SELECT * FROM users WHERE Login = '$login' AND Password = '$password'");

        return isset($user[0]) ? $user[0] : null;
    }

    public function get_user($id) {
        $user = $this->db->query("SELECT * FROM users WHERE ID = $id");

        return isset($user[0]) ? $user[0] : null;
    }

    public function get_users() {
        $users = $this->db->query("SELECT * FROM users");

        return isset($users[0]) ? $users : null;
    }

    public function add_user($data) {
        $name = $data["name"];
        $login= $data["login"];
        $password= $data["password"];

        $this->db->query("INSERT INTO `users`(`Name`, `Login`, `Password`) VALUES ('$name', '$login', '$password')");

        return true;
    }
}