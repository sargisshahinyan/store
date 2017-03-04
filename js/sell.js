/**
 * Created by shahi on 27.02.2017.
 */
$(document).ready(function () {
    var idTimeout = setTimeout(function () {}, 0),
        $items = $("#item"),
        $quantity = $("#quantity"),
        $itemsList = $("#item-list"),
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
                    $items.find("option:selected").removeAttr("selected");
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

    $("#add-to-list").click(function () {
        var id = $items.find("option:selected").val(),
            name = $items.find("option:selected").text(),
            quantity = $quantity.val();

        if(!itemsList.some(find) && id && quantity) {
            itemsList.push({
                id: id,
                quantity: parseInt(quantity)
            });

            $itemsList.append(getListItemTemplate({
                id: id,
                quantity: quantity,
                name: name
            }));
        }

        $quantity.val("");
        $items.find("option:selected").removeAttr("selected");
        $items.find("option:first").prop("selected", "selected");

        function find(item) {
            if(item.id == id) {
                item.quantity += parseInt(quantity || 0);
                changeListItem(id, item.quantity);
                return true;
            }
        }
    });

    $itemsList.click(function (event) {
        var $target = $(event.target),
            id;

        if(!$target.hasClass("del")) {
            return false;
        }

        id = $target.parents("li").prop("id").substr(5);

        $("#item-" + id).remove();

        itemsList.some(function (item, index, array) {
            if(item.id == id) {
                array.splice(index, 1);
                return true;
            }
        });
    });

    function getListItemTemplate(data) {
        return "<li id=\"item-" + data.id + "\" class=\"list-group-item\">" +
        "<span>" + data.name + "</span>" +
        "<span class=\"badge del\">X</span>" +
        "<span class=\"badge\">" + data.quantity + "</span>" +
        "</li>"
    }

    function changeListItem(id, quantity) {
        $("#item-" + id + ">span:last").text(quantity);
    }

    $("#sell").click(function () {
        $.ajax({
            url: "API.php/sell",
            method: "POST",
            data: {
                items: itemsList
            }
        }).done(function () {
            alert("OK");
            location.reload();
        }).fail(function () {
            alert("idiot");
        });
    });
});