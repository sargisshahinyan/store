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

    public function get_purchases($data = []) {
        $condition = "WHERE 1 ";

        foreach ($data as $key => $datum) {
            if(!empty($datum)) {
                switch ($key) {
                    case "item":
                        $condition .= " AND ItemID = '" . $datum . "'";
                        break;
                    case "category":
                        $condition .= " AND items.CategoryID = '" . $datum . "'";
                        break;
                    case "date-from":
                        $condition .= " AND DATE(`Date`) >= '" . $datum . "'";
                        break;
                    case "date-to":
                        $condition .= " AND DATE(`Date`) <= '" . $datum . "'";
                        break;
                    case "price-from":
                        $condition .= " AND purchases.Quantity * purchases.Price >= '" . $datum . "'";
                        break;
                    case "price-to":
                        $condition .= " AND purchases.Quantity * purchases.Price <= '" . $datum . "'";
                        break;
                }
            }
        }

        $result = $this->db->query("SELECT 
                            purchases.ID, 
                            Date, 
                            ItemID, 
                            purchases.Quantity, 
                            purchases.Price, 
                            categories.Name AS Category, 
                            items.Name AS Item
                          FROM 
                            purchases 
                          JOIN 
                            items ON purchases.ItemID = items.ID 
                          JOIN 
                            categories ON items.CategoryID = categories.ID
                          $condition");

        return $result;
    }

    public function get_sales($data = []) {
        $condition = "WHERE 1 ";

        foreach ($data as $key => $datum) {
            if(!empty($datum)) {
                switch ($key) {
                    case "item":
                        $condition .= " AND ItemID = '" . $datum . "'";
                        break;
                    case "category":
                        $condition .= " AND items.CategoryID = '" . $datum . "'";
                        break;
                    case "date-from":
                        $condition .= " AND DATE(`Date`) >= '" . $datum . "'";
                        break;
                    case "date-to":
                        $condition .= " AND DATE(`Date`) <= '" . $datum . "'";
                        break;
                    case "price-from":
                        $condition .= " AND sale_details.Quantity * items.Price >= '" . $datum . "'";
                        break;
                    case "price-to":
                        $condition .= " AND sale_details.Quantity * items.Price <= '" . $datum . "'";
                        break;
                }
            }
        }

        $result = $this->db->query("SELECT 
                            Date, 
                            ItemID, 
                            sale_details.Quantity, 
                            items.Price, 
                            categories.Name AS Category, 
                            items.Name AS Item
                          FROM 
                            sale_details 
                          JOIN 
                            sales ON sale_details.SaleID = sales.ID
                          JOIN 
                            items ON sale_details.ItemID = items.ID 
                          JOIN 
                            categories ON items.CategoryID = categories.ID
                          $condition");

        return $result;
    }
}