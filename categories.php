<?php
include "Functions.php";
$navs = get_nav(2);
include "header.php";

$category = new Category($db);

if(count($_POST)) {
    $id = !empty($_POST["id"]) ? $_POST["id"] : null;
    $name = !empty($_POST["name"]) ? $_POST["name"] : null;
    $action= !empty($_POST["action"]) ? $_POST["action"] : null;

    if(!$name) {
        $_SESSION["error"] = "Input name";
        header("Location:categories.php");
    }

    $_SESSION["error"] = null;

    switch ($action) {
        case "insert":
            $category->add_category([
                "name" => $name
            ]);
            break;
        case "update":
            $category->change_category([
                "id" => $id,
                "name" => $name
            ]);
            break;
        case "delete":
            $category->delete_category($id);
            break;
    }

    header("Location:categories.php");
}

if (!isset($_GET["id"])) {
    $categories = $category->get_categories();
    $categories = $categories ? $categories : [];
?>
    <article class="container">
        <div class="row">
            <h3 class="col-md-offset-1 col-md-4">Նոր կատեգորիա</h3>
            <h5><?= !empty($_SESSION['error']) ? $_SESSION["error"] : ""; ?></h5>
        </div>
        <div class="row">
            <form class="col-md-offset-1 col-md-10" method="post" action="categories.php">
                <div class="form-group">
                    <label for="name">Անուն</label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="Անուն" required>
                </div>
                <input type="hidden" name="action" value="insert">
                <button type="submit" class="btn btn-primary">Ավելացնել</button>
            </form>
        </div>
        <div class="row">
            <div class="list-group">
                <?php foreach($categories as $category) { ?>
                    <a href="categories.php?id=<?= $category["ID"]; ?>" class="list-group-item"><?= $category["Name"]; ?></a>
                <?php } ?>
            </div>
        </div>
    </article>
<?php
} else {
    $id = $_GET["id"];

    $cat = $category->get_category($id);
?>
    <article class="container">
        <div class="row">
            <form class="col-md-offset-1 col-md-10" method="post" action="categories.php">
                <div class="form-group">
                    <label for="name">Անուն</label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="Անուն" required value="<?= $cat["Name"]; ?>">
                </div>
                <input type="hidden" name="id" placeholder="Անուն" value="<?= $cat["ID"]; ?>">
                <input type="hidden" name="action" value="update">
                <button type="submit" class="btn btn-success">Փոխել</button>
            </form>
        </div>
        <div class="row">
            <form class="col-md-offset-1 col-md-10" method="post" action="categories.php">
                <input type="hidden" name="id" placeholder="Անուն" value="<?= $cat["ID"]; ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn btn-danger">Հեռացնել</button>
            </form>
        </div>
    </article>
<?php
}
include "footer.php";
?>
