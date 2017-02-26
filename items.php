<?php
/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 26.02.2017
 * Time: 20:54
 */
include "Functions.php";
$navs = get_nav(3);
include "header.php";

$category = new Category($db);
$item = new Item($db);

$categories = $category->get_categories();

if(count($_POST)) {
    $id = !empty($_POST["id"]) ? $_POST["id"] : null;
    $name = !empty($_POST["name"]) ? $_POST["name"] : null;
    $price = !empty($_POST["price"]) ? $_POST["price"] : null;
    $categoryID = !empty($_POST["categoryID"]) ? $_POST["categoryID"] : null;
    $quantity = !empty($_POST["quantity"]) ? $_POST["quantity"] : null;
    $action= !empty($_POST["action"]) ? $_POST["action"] : null;

    $_SESSION["error"] = null;

    switch ($action) {
        case "insert":
            $item->add_item([
                "name" => $name,
                "price" => $price,
                "category" => $categoryID,
                "quantity" => $quantity,
            ]);
            break;
        case "update":
            $item->change_item([
                "id" => $id,
                "name" => $name,
                "price" => $price,
                "category" => $categoryID,
                "quantity" => $quantity,
            ]);
            break;
        case "delete":
            $item->delete_item($id);
            break;
    }

    header("Location:items.php");
}

if (!isset($_GET["id"])) {
    $items = $item->get_items();
    $items = $items ? $items : [];
?>
    <article class="container">
        <div class="row">
            <h3 class="col-md-offset-1 col-md-4">Նոր կատեգորիա</h3>
            <h5><?= !empty($_SESSION['error']) ? $_SESSION["error"] : ""; ?></h5>
        </div>
        <div class="row">
            <form class="col-md-offset-1 col-md-10" method="post" action="items.php">
                <div class="form-group">
                    <label for="name">Անուն</label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="Անուն" required>
                </div>
                <div class="form-group">
                    <label for="պռիցե">Գին</label>
                    <input type="text" id="պռիցե" class="form-control" name="price" placeholder="Գին" required>
                </div>
                <div class="form-group">
                    <label for="categoryID">Կատեգորիա</label>
                    <select id="categoryID" class="form-control" name="categoryID" required>
                        <option selected disabled value="">Ընտրեք կատեգորիան</option>
                        <?php foreach($categories as $category) { ?>
                            <option value="<?= $category["ID"]; ?>"><?= $category["Name"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Քանակ</label>
                    <input type="number" id="quantity" class="form-control" name="quantity" placeholder="Քանակ" required>
                </div>
                <input type="hidden" name="action" value="insert">
                <button type="submit" class="btn btn-primary">Ավելացնել</button>
            </form>
        </div>
        <div class="row">
            <div class="list-group">
                <?php foreach($items as $item) { ?>
                    <a href="items.php?id=<?= $item["ID"]; ?>" class="list-group-item"><?= $item["Name"]; ?></a>
                <?php } ?>
            </div>
        </div>
    </article>
<?php
} else {
    $id = $_GET["id"];

    $it = $item->get_item($id);
?>
    <article class="container">
        <div class="row">
            <form class="col-md-offset-1 col-md-10" method="post" action="items.php">
                <div class="form-group">
                    <label for="name">Անուն</label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="Անուն" required value="<?= $it["Name"]; ?>">
                </div>
                <div class="form-group">
                    <label for="պռիցե">Գին</label>
                    <input type="text" id="պռիցե" class="form-control" name="price" placeholder="Գին" required value="<?= $it["Price"]; ?>">
                </div>
                <div class="form-group">
                    <label for="categoryID">Կատեգորիա</label>
                    <select id="categoryID" class="form-control" name="categoryID" required>
                        <option selected disabled value="">Ընտրեք կատեգորիան</option>
                        <?php foreach($categories as $category) { ?>
                            <option <?= $category["ID"] == $it["CategoryID"] ? "selected" : ""; ?> value="<?= $category["ID"]; ?>"><?= $category["Name"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Քանակ</label>
                    <input type="number" id="quantity" class="form-control" name="quantity" placeholder="Քանակ" required value="<?= $it["Quantity"]; ?>">
                </div>
                <input type="hidden" name="id" placeholder="Անուն" value="<?= $it["ID"]; ?>">
                <input type="hidden" name="action" value="update">
                <button type="submit" class="btn btn-primary">Փոխել</button>
            </form>
        </div>
        <div class="row">
            <form class="col-md-offset-1 col-md-10" method="post" action="items.php">
                <input type="hidden" name="id" placeholder="Անուն" value="<?= $it["ID"]; ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger">Հեռացնել</button>
            </form>
        </div>
    </article>
<?php
}
include "footer.php";
?>
