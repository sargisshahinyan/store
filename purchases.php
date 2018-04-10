<?php
include "Functions.php";
$navs = get_nav(4);
include "header.php";

if(count($_POST)) {
    $keys = ["item", "quantity", "price"];

    $error = null;

    foreach ($keys as $key) {
        if(!array_key_exists($key, $_POST)) {
            $error = "Որևէ տվյալ կիսատ է";
            break;
        }
    }

    if(!$error) {
        foreach ($_POST as $key => $datum) {
            if(empty($datum)) {
                switch ($key) {
                    case "item":
                        $error = "Ապրանքը նշված չէ";
                        break(2);
                    case "quantity":
                        $error = "Քանակը նշված չէ";
                        break(2);
                    case "price":
                        $error = "Գինը նշված չէ";
                        break(2);
                }
            }
        }
    }

    if(!$error) {
        $deal = new Deal($db);

        $deal->purchase($_POST);

        header("Location:purchases.php");
    } else {
        $error = "Մուտք չի պատարվել";
    }
}

$category = new Category($db);
$item = new Item($db);

$categories = $category->get_categories();
$items = $item->get_items();
?>
<article class="container">
    <div class="row">
        <h1><?= isset($error) ? $error : ""; ?></h1>
    </div>
    <div class="row">
        <form class="col-md-offset-2 col-md-8" method="post">
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
                        <option value="<?= $item["ID"]; ?>"><?= $item["Name"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="id">Կոդ</label>
                <input type="text" id="id" class="form-control" autocomplete="off" placeholder="Կոդ" autofocus>
            </div>
            <div class="form-group col-md-6">
                <label for="quantity">Քանակ</label>
                <input type="number" min="1" id="quantity" name="quantity" class="form-control" autocomplete="off" placeholder="Քանակ" required>
            </div>
            <div class="form-group col-md-6">
                <label for="price">Գին</label>
                <input type="number" min="0" id="price" name="price" class="form-control" autocomplete="off" placeholder="Գին" required>
            </div>
            <div class="form-group col-md-12 text-right">
                <button type="submit" class="btn btn-primary">Մուտագրել</button>
            </div>
        </form>
    </div>
</article>
<script src="js/sell.js"></script>
<?php
include "footer.php";
?>
