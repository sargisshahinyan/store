<?php
/**
 * Created by IntelliJ IDEA.
 * User: shahi
 * Date: 26.02.2017
 * Time: 20:54
 */
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
        <form class="col-md-offset-1 col-md-10" method="post" action="categories.php">
            <div class="form-group">
                <label for="id">Կոդ</label>
                <input type="text" id="id" class="form-control" name="id" placeholder="Կոդ">
            </div>
            <div class="form-group">
                <label for="category">Կատեգորիա</label>
                <select id="category" class="form-control" name="category" required>
                    <option selected value="">Ընտրված չէ</option>
                    <?php foreach($categories as $category) { ?>
                        <option value="<?= $category["ID"]; ?>"><?= $category["Name"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="item">Ապրանք</label>
                <select id="item" class="form-control" name="item" required>
                    <option selected disabled value="">Ընտրեք ապրանքը</option>
                    <?php foreach($items as $item) { ?>
                        <option value="<?= $item["ID"]; ?>"><?= $item["Name"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <input type="hidden" name="action" value="insert">
            <button type="submit" class="btn btn-primary">Ավելացնել</button>
        </form>
    </div>
    <div class="row">

    </div>
</article>
<script src="js/search.js"></script>
<?php
include "footer.php";
?>
