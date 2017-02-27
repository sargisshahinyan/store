/**
 * Created by shahi on 27.02.2017.
 */
$(document).ready(function () {
    var idTimeout = setTimeout(function () {}, 0),
        $items = $("#item"),
        itemsList = [];

    $("#id").on("keyup", function () {
        clearTimeout(idTimeout);

        idTimeout = setTimeout(function () {
            $.ajax({
                method: "GET",
                url: "API.php/items/" + this.value,
                dataType: "json"
            }).done(function (result) {
                if(result) {
                    $items.find("option[value='" + result.ID + "']").attr("selected", "true");
                }
            });
        }.bind(this), 300);
    });

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