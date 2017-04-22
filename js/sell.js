$(document).ready(function () {
    var idTimeout = setTimeout(function () {}, 0),
        $items = $("#item"),
        $quantity = $("#quantity"),
        $itemsList = $("#item-list"),
        $addButton = $("#add-to-list"),
        $id = $("#id"),
        $total = $("#total"),
        itemsList = [];

    $id.on("keyup", function () {
        if(!this.value) {
            return;
        }

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
            var html = "<option value='' selected disabled>Ընտրեք ապրանքը</option>\n";

            if(result && result instanceof Array) {
                result.forEach(function (item) {
                    html += "<option value='" + item.ID + "'>" + item.Name + "</option>\n"
                });
            }

            $items.html(html);
        });
    });

    $addButton.click(add);
    $("form").on("keyup", function (e) {
        if(e.keyCode === 13) {
            add();
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
            if(item.id === id) {
                array.splice(index, 1);
                return true;
            }
        });
    });

    function getListItemTemplate(data) {
        return "<li id=\"item-" + data.id + "\" class=\"list-group-item\">" +
            "<div class='col-xs-2'>" + data.name + "</div>" +
            "<div class='col-xs-2 text-right price'>" + data.price + " դրամ</div>" +
            "<div class='col-xs-4 text-right quantity'>" + data.quantity + "</div>" +
            "<div class='col-xs-2 text-right sum'>" + data.quantity * data.price + " դրամ</div>" +
            "<span class=\"badge del\">X</span>" +
            "<div class='clearfix'></div>" +
            "</li>";
    }

    function changeListItem(id, quantity, price) {
        $("#item-" + id + ">div.quantity").text(quantity);
        $("#item-" + id + ">div.sum").text(quantity * price + " դրամ");
    }

    $("#sell").click(function () {
        $.ajax({
            url: "API.php/sell",
            method: "POST",
            data: {
                items: itemsList
            }
        }).done(function () {
            alert("Done");
            location.reload();
        }).fail(function () {
            alert("Fail");
        });
    });

    function add() {
        var id = $items.find("option:selected").val(),
            name = $items.find("option:selected").text().match(/^(.+) -/)[1],
            price = parseInt($items.find("option:selected").text().match(/- (\d+)$/)[1]),
            quantity = $quantity.val();

        if(!itemsList.some(find) && id && quantity) {
            itemsList.push({
                id: id,
                quantity: parseInt(quantity),
                price: price
            });

            $itemsList.append(getListItemTemplate({
                id: id,
                quantity: quantity,
                name: name,
                price: price
            }));
        }

        $quantity.val("");
        $id.val("");
        $items.find("option:selected").removeAttr("selected");
        $items.find("option:first").attr("selected", "true");
        $id.focus();

        resetTotal();

        function resetTotal () {
            var sum = 0;

            itemsList.forEach(function (item) {
                sum += item.quantity * item.price;
            });

            $total.text(sum + " դրամ");
        }

        function find(item) {
            if(item.id === id) {
                item.quantity += parseInt(quantity || 0);
                changeListItem(id, item.quantity, item.price);
                return true;
            }
        }
    }
});