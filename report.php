<?php
include "Functions.php";
$navs = get_nav(6);
include "header.php";

$deal = new Deal($db);
$item = new Item($db);
$category = new Category($db);

$purData = $saleData = $profitData = [
    "date-from" => date("Y-m-01"),
    "date-to" => date("Y-m-d"),
    "price-from" => "",
    "price-to" => "",
    "item" => "",
    "category" => "",
];

$target = "purchase";

if(count($_POST) && isset($_POST["target"])) {
    $data = [];
    $target = $_POST["target"];

    foreach ($_POST as $key => $datum) {
        switch ($key) {
            case "date-from":
                $data["date-from"] = $datum;
                break;
            case "date-to":
                $data["date-to"] = $datum;
                break;
            case "price-from":
                $data["price-from"] = $datum;
                break;
            case "price-to":
                $data["price-to"] = $datum;
                break;
            case "item":
                $data["item"] = $datum;
                break;
            case "category":
                $data["category"] = $datum;
                break;
        }
    }

    switch ($target) {
        case "purchase":
            $purData = $data;
            break;
        case "sale":
            $saleData = $data;
            break;
        case "profit":
            $profitData = $data;
            break;
    }
}

$items = $item->get_items();
$categories = $category->get_categories();

$purchases = $deal->get_purchases($purData);
$sales = $deal->get_sales($saleData);
$profit = $deal->get_profit($profitData);
?>
<article class="container">
    <section class="row">
        <div class="col-md-offset-1 col-md-10">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="<?= $target == "purchase" ? "active" : ""; ?>"><a href="#purchase" aria-controls="purchase" role="tab" data-toggle="tab">Առք</a></li>
                <li role="presentation" class="<?= $target == "sale" ? "active" : ""; ?>"><a href="#sale" aria-controls="sale" role="tab" data-toggle="tab">Վաճառք</a></li>
                <li role="presentation" class="<?= $target == "profit" ? "active" : ""; ?>"><a href="#profit" aria-controls="profit" role="tab" data-toggle="tab">Շահույթ</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane <?= $target == "purchase" ? "active" : ""; ?>" id="purchase">
                    <form class="col-md-offset-2 col-md-8" method="get">
                        <div class="form-group col-md-12">
                            <label for="pur-id">Կոդ</label>
                            <input type="text" id="pur-id" class="form-control" placeholder="Կոդ">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pur-category">Կատեգորիա</label>
                            <select id="pur-category" name="category" class="form-control">
                                <option selected value="">Ընտրված չէ</option>
                                <?php foreach($categories as $category) { ?>
                                    <option <?= $category["ID"] == $purData["category"] ? "selected" : ""; ?> value="<?= $category["ID"]; ?>"><?= $category["Name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pur-item">Ապրանք</label>
                            <select id="pur-item" name="item" class="form-control" name="item">
                                <option selected value="">Ընտրված չէ</option>
                                <?php foreach($items as $item) { ?>
                                    <option <?= $item["ID"] == $purData["item"] ? "selected" : ""; ?> value="<?= $item["ID"]; ?>"><?= $item["Name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pur-price-from">Գումար սկսած</label>
                            <input type="number" min="0" id="pur-price-from" value="<?= $purData["price-from"]; ?>" name="price-from" class="form-control" placeholder="Սկսած">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pur-price-to">Գումար վերջացրած</label>
                            <input type="number" min="0" id="pur-price-to" value="<?= $purData["price-to"]; ?>" name="price-to" class="form-control" placeholder="Վերջացրած">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pur-date-from">Ամսաթիվ սկսած</label>
                            <input type="date" id="pur-date-from" value="<?= $purData["date-from"]; ?>" name="date-from" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pur-date-to">Ամսաթիվ վերջացրած</label>
                            <input type="date" id="pur-date-to" value="<?= $purData["date-to"]; ?>" name="date-to" class="form-control">
                        </div>
                        <input type="hidden" name="target" value="purchase">
                        <div class="form-group col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Փնտրել</button>
                        </div>
                    </form>

                    <div class="col-md-offset-1 col-md-10">
                        <table class="table">
                            <tr>
                                <th>Ապրանք</th>
                                <th>Ամսաթիվ</th>
                                <th>Գին</th>
                                <th>Քանակ</th>
                                <th>Գումար</th>
                                <th>Կատեգորիա</th>
                            </tr>
                            <?php foreach($purchases as $purchase) { ?>
                            <tr>
                                <td><?= $purchase["Item"]; ?></td>
                                <td><?= $purchase["Date"]; ?></td>
                                <td><?= $purchase["Price"]; ?></td>
                                <td><?= $purchase["Quantity"]; ?></td>
                                <td><?= $purchase["Price"] * $purchase["Quantity"]; ?></td>
                                <td><?= $purchase["Category"]; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane <?= $target == "sale" ? "active" : ""; ?>" id="sale">
                    <form class="col-md-offset-2 col-md-8" method="post">
                        <div class="form-group col-md-12">
                            <label for="sale-id">Կոդ</label>
                            <input type="text" id="sale-id" class="form-control" placeholder="Կոդ">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sale-category">Կատեգորիա</label>
                            <select id="sale-category" name="category" class="form-control">
                                <option selected value="">Ընտրված չէ</option>
                                <?php foreach($categories as $category) { ?>
                                    <option <?= $category["ID"] == $saleData["category"] ? "selected" : ""; ?> value="<?= $category["ID"]; ?>"><?= $category["Name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sale-item">Ապրանք</label>
                            <select id="sale-item" name="item" class="form-control" name="item">
                                <option selected value="">Ընտրված չէ</option>
                                <?php foreach($items as $item) { ?>
                                    <option <?= $item["ID"] == $saleData["item"] ? "selected" : ""; ?> value="<?= $item["ID"]; ?>"><?= $item["Name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sale-price-from">Գումար սկսած</label>
                            <input type="number" min="0" id="sale-price-from" value="<?= $saleData["price-from"]; ?>" name="price-from" class="form-control" placeholder="Սկսած">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sale-price-to">Գումար վերջացրած</label>
                            <input type="number" min="0" id="sale-price-to" value="<?= $saleData["price-to"]; ?>" name="price-to" class="form-control" placeholder="Վերջացրած">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sale-date-from">Ամսաթիվ սկսած</label>
                            <input type="date" id="sale-date-from" value="<?= $saleData["date-from"]; ?>" name="date-from" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sale-date-to">Ամսաթիվ վերջացրած</label>
                            <input type="date" id="sale-date-to" value="<?= $saleData["date-to"]; ?>" name="date-to" class="form-control">
                        </div>
                        <input type="hidden" name="target" value="sale">
                        <div class="form-group col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Փնտրել</button>
                        </div>
                    </form>

                    <div class="col-md-offset-1 col-md-10">
                        <table class="table">
                            <tr>
                                <th>Ապրանք</th>
                                <th>Ամսաթիվ</th>
                                <th>Գին</th>
                                <th>Քանակ</th>
                                <th>Գումար</th>
                                <th>Կատեգորիա</th>
                            </tr>
                            <?php foreach($sales as $sale) { ?>
                                <tr>
                                    <td><?= $sale["Item"]; ?></td>
                                    <td><?= $sale["Date"]; ?></td>
                                    <td><?= $sale["Price"]; ?></td>
                                    <td><?= $sale["Quantity"]; ?></td>
                                    <td><?= $sale["Price"] * $sale["Quantity"]; ?></td>
                                    <td><?= $sale["Category"]; ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane <?= $target == "profit" ? "active" : ""; ?>" id="profit">
                    <form class="col-md-offset-2 col-md-8" method="post">
                        <div class="form-group col-md-6">
                            <label for="profit-date-from">Ամսաթիվ սկսած</label>
                            <input type="date" id="profit-date-from" value="<?= $profitData["date-from"]; ?>" name="date-from" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="profit-date-to">Ամսաթիվ վերջացրած</label>
                            <input type="date" id="profit-date-to" value="<?= $profitData["date-to"]; ?>" name="date-to" class="form-control">
                        </div>
                        <input type="hidden" name="target" value="profit">
                        <div class="form-group col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Փնտրել</button>
                        </div>
                    </form>

                    <div class="col-md-offset-1 col-md-10">
                        <table class="table">
                            <tr>
                                <th>Ծախս</th>
                                <th>Հասույթ</th>
                                <th>Շահույթ</th>
                            </tr>
                            <tr>
                                <td><?= $profit["proceeds"]; ?> դրամ</td>
                                <td><?= $profit["expenditure"]; ?> դրամ</td>
                                <td><?= $profit["expenditure"] - $profit["proceeds"]; ?> դրամ</td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </section>
</article>
<script src="js/report.js"></script>
<?php
include "footer.php";
?>
