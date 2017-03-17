$(document).ready(function () {
    var idTimeout = setTimeout(function () {}, 0),
        $purItems = $("#pur-item"),
        $saleItems = $("#sale-item"),
        $profitItems = $("#profit-item"),
        $quantity = $("#quantity");

    $("#pur-id").on("keyup", function () {
        idSearch.bind(this)($purItems);
    });

    $("#sale-id").on("keyup", function () {
        idSearch.bind(this)($saleItems);
    });

    $("#profit-id").on("keyup", function () {
        idSearch.bind(this)($profitItems);
    });

    function idSearch($items) {
        clearTimeout(idTimeout);

        idTimeout = setTimeout(function () {
            $.ajax({
                method: "GET",
                url: "API.php/items/" + this.value,
                dataType: "json"
            }).done(function (result) {
                if(result) {
                    $items.find("option:selected").removeAttr("selected");
                    $items.find("option[value='" + result.ID + "']").attr("selected", "true");
                }
            });
        }.bind(this), 300);
    }

    $("#category").change(function () {
        $.ajax({
            method: "GET",
            url: "API.php/items/" + (parseInt(this.value) ? "?category=" + this.value : ""),
            dataType: "json"
        }).done(function (result) {
            var html = "<option value='' selected disabled>Ընտրեք ապրանքը</option>";

            if(result && result instanceof Array) {
                result.forEach(function (item) {
                    html += "<option value='" + item.ID + "'>" + item.Name + "</option>"
                });
            }

            $items.html(html);
        });
    });
});