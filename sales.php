<?php
include "Functions.php";
$navs = get_nav(5);
include "header.php";

$category = new Category($db);
$item = new Item($db);

$categories = $category->get_categories();
$items = $item->get_items();

?>
<article class="container">
    <div class="row">
        <form class="col-md-offset-2 col-md-8">
            <div class="form-group col-md-12">
                <label for="category">Կատեգորիա</label>
                <select id="category" class="form-control">
                    <option selected value="">Ընտրված չէ</option>
                    <?php foreach($categories as $category) { ?>
                        <option value="<?= $category["ID"]; ?>"><?= $category["Name"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="item">Ապրանք</label>
                <select id="item" class="form-control" name="item" required>
                    <option selected disabled value="">Ընտրեք ապրանքը</option>
                    <?php foreach($items as $item) { ?>
                        <option value="<?= $item["ID"]; ?>"><?= $item["Name"]; ?> - <?= $item["Price"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="id">Կոդ</label>
                <input type="text" id="id" class="form-control" autocomplete="off" placeholder="Կոդ" autofocus>
            </div>
            <div class="form-group col-md-12">
                <label for="quantity">Քանակ</label>
                <input type="number" min="1" id="quantity" class="form-control" autocomplete="off" placeholder="Քանակ">
            </div>
            <div class="form-group col-md-12 text-right">
                <button type="button" id="add-to-list" class="btn btn-primary">Ավելացնել</button>
            </div>
        </form>
    </div>
    <div class="row display">
        <ul id="item-list" class="list-group col-md-offset-1 col-md-10">
            <li class="list-group-item list-group-item-heading bold">
                <div class="col-xs-2">Անվանում</div>
                <div class="col-xs-2 text-right">Գին</div>
                <div class="col-xs-4 text-right">Քանակ</div>
                <div class="col-xs-2 text-right">Գումար</div>
                <div class="clearfix"></div>
            </li>
        </ul>
        <div id="total"></div>
    </div>
    <div class="row">
        <div class="col-md-offset-10 col-md-2 text-right">
            <button type="button" class="btn btn-success" id="sell">Վաճառել</button>
        </div>
    </div>
</article>
<script src="js/sell.js"></script>
<?php
include "footer.php";
?>
