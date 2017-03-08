<?php
/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 05.03.2017
 * Time: 21:39
 */
include "Functions.php";
$navs = get_nav(6);
include "header.php";

$deal = new Deal($db);
$item = new Item($db);
$category = new Category($db);

$purData = $saleData = $profitData = [
    "date-from" => "",
    "date-to" => "",
    "price-from" => "",
    "price-to" => "",
    "item" => "",
    "category" => "",
];

if(count($_POST) && isset($_POST["target"])) {
    $data = [];

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

    switch ($_POST["target"]) {
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
?>
<article class="container">
    <section class="row">
        <div class="col-md-offset-1 col-md-10">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#purchase" aria-controls="purchase" role="tab" data-toggle="tab">Առք</a></li>
                <li role="presentation"><a href="#sale" aria-controls="sale" role="tab" data-toggle="tab">Վաճառք</a></li>
                <li role="presentation"><a href="#profit" aria-controls="profit" role="tab" data-toggle="tab">Շահույթ</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="purchase">
                    <form class="col-md-offset-2 col-md-8" method="post">
                        <div class="form-group col-md-12">
                            <label for="id">Կոդ</label>
                            <input type="text" id="id" class="form-control" placeholder="Կոդ">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category">Կատեգորիա</label>
                            <select id="category" name="category" class="form-control">
                                <option selected value="">Ընտրված չէ</option>
                                <?php foreach($categories as $category) { ?>
                                    <option <?= $category["ID"] == $purData["category"] ? "selected" : ""; ?> value="<?= $category["ID"]; ?>"><?= $category["Name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="item">Ապրանք</label>
                            <select id="item" name="item" class="form-control" name="item">
                                <option selected value="">Ընտրված չէ</option>
                                <?php foreach($items as $item) { ?>
                                    <option <?= $item["ID"] == $purData["item"] ? "selected" : ""; ?> value="<?= $item["ID"]; ?>"><?= $item["Name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price-from">Գումար սկսած</label>
                            <input type="number" min="0" id="price-from" value="<?= $purData["price-from"]; ?>" name="price-from" class="form-control" placeholder="Սկսած">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price-to">Գումար վերջացրած</label>
                            <input type="number" min="0" id="price-to" value="<?= $purData["price-to"]; ?>" name="price-to" class="form-control" placeholder="Վերջացրած">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date-from">Ամսաթիվ սկսած</label>
                            <input type="date" id="date-from" value="<?= $purData["date-from"]; ?>" name="date-from" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date-to">Ամսաթիվ վերջացրած</label>
                            <input type="date" id="date-to" value="<?= $purData["date-to"]; ?>" name="date-to" class="form-control">
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
                <div role="tabpanel" class="tab-pane" id="sale">
                    <form class="col-md-offset-2 col-md-8" method="post">
                        <div class="form-group col-md-12">
                            <label for="id">Կոդ</label>
                            <input type="text" id="id" class="form-control" placeholder="Կոդ">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category">Կատեգորիա</label>
                            <select id="category" name="category" class="form-control">
                                <option selected value="">Ընտրված չէ</option>
                                <?php foreach($categories as $category) { ?>
                                    <option <?= $category["ID"] == $saleData["category"] ? "selected" : ""; ?> value="<?= $category["ID"]; ?>"><?= $category["Name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="item">Ապրանք</label>
                            <select id="item" name="item" class="form-control" name="item">
                                <option selected value="">Ընտրված չէ</option>
                                <?php foreach($items as $item) { ?>
                                    <option <?= $item["ID"] == $saleData["item"] ? "selected" : ""; ?> value="<?= $item["ID"]; ?>"><?= $item["Name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price-from">Գումար սկսած</label>
                            <input type="number" min="0" id="price-from" value="<?= $saleData["price-from"]; ?>" name="price-from" class="form-control" placeholder="Սկսած">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price-to">Գումար վերջացրած</label>
                            <input type="number" min="0" id="price-to" value="<?= $saleData["price-to"]; ?>" name="price-to" class="form-control" placeholder="Վերջացրած">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date-from">Ամսաթիվ սկսած</label>
                            <input type="date" id="date-from" value="<?= $saleData["date-from"]; ?>" name="date-from" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="date-to">Ամսաթիվ վերջացրած</label>
                            <input type="date" id="date-to" value="<?= $saleData["date-to"]; ?>" name="date-to" class="form-control">
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
                <div role="tabpanel" class="tab-pane" id="profit">
                    Ես ձեր մերկությունը լավ եմ տեսել և երբեք չեմ գայթակղվել և ազգիս ասեմ՝ դեմ
                    լինելը դա ընդդեմը չէ այդ տեսանկյունից ցմահ կլինի մահապատիժը, ինչևէ լուրջ
                    մարդկային փոխհարաբերություններում բոլորը պետք է փոխհարաբերվեն:
                </div>
            </div>
        </div>
    </section>
</article>
<script src="js/sell.js"></script>
<?php
include "footer.php";
?>
