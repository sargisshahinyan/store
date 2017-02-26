<?php

/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 26.02.2017
 * Time: 22:51
 */
class Deals {
    private $db;

    public function __construct(db $db)
    {
        $this->db = $db;
    }

    public function sell($data) {
        $date = $data["date"];
        $items = $data["items"];

        $this->db->query("INSERT INTO sales (Date) VALUES ('$date')");

        $saleId = $this->db->insert_id();

        foreach ($items as $item) {
            $id = $item["id"];
            $quantity = $item["quantity"];

            $this->db->query("INSERT INTO sale_details (SaleID, ItemID, Quantity) VALUES ($saleId, $id, $quantity)");
        }

        return true;
    }

    public function purchase($data) {
        $date = $data["date"];
        $items = $data["items"];

        $this->db->query("INSERT INTO purchases (Date) VALUES ('$date')");$saleId = $this->db->insert_id();

        $purchaseId = $this->db->insert_id();

        foreach ($items as $item) {
            $id = $item["id"];
            $quantity = $item["quantity"];
            $price = $item["price"];

            $this->db->query("INSERT INTO purchase_details (PurchaseID, ItemID, Quantity, UnitPrice) VALUES ($purchaseId, $id, $quantity, $price)");
        }

        return true;
    }
}