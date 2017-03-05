<?php

/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 26.02.2017
 * Time: 22:51
 */
class Deal {
    private $db;

    public function __construct(db $db)
    {
        $this->db = $db;
    }

    public function sell($data) {
        $items = $data["items"];

        $this->db->query("INSERT INTO sales () VALUES ()");

        $saleId = $this->db->insert_id();

        foreach ($items as $item) {
            $id = $item["id"];
            $quantity = $item["quantity"];

            $this->db->query("INSERT INTO sale_details (SaleID, ItemID, Quantity) VALUES ($saleId, $id, $quantity)");
        }

        return true;
    }

    public function purchase($data) {
        $item = $data["item"];
        $quantity = $data["quantity"];
        $price = $data["price"];

        $this->db->query("INSERT INTO purchases (ItemID, Quantity, Price) VALUES ($item, $quantity, $price)");

        return true;
    }
}