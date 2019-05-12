$(document).ready(function(){
    $(".add-to-cart").click(function () {
        var id = $(this).attr("data-id");
        $.post("/cart/addAjax/"+id, {}, function (data) {
            if (data !== "Не хватает")
            {
                $("#cart-count").html(data);
                $("#small-cart-count").html(data);  
            } else {
                $("#parent_popup").css("display", "unset");
            }
        });
        $.post("/cart/countAjax/", {}, function (data) {
            $("#price-count").html(data);
            $("#left-price-count").html(data);
        });
        return false;
    });

    $(".add-number-to-cart").click(function() {
        var id = $(this).attr("data-id");
        var number = $('#productNumber').val();
        
        if (number) {
            var posting = $.post( "/cart/addNumber/"+id+"/"+number, { }, function(data) {
                if (data !== "Не хватает")
                {
                    $("#cart-count").html(data);
                    $("#small-cart-count").html(data);  
                } else {
                    $("#parent_popup").css("display", "unset");
                }
            });
            var counting = $.post( "/cart/countAjax/", { }, function(data) {
                $("#price-count").html(data);
                $("#left-price-count").html(data);
            });            
        }
        return false;
    });

    $(".change-number-from-cart").click(function() {
        var id = $(this).attr("data-id");
        var seeknumber = "#productNumber"+"-"+id
        var number = $(seeknumber).val();
        
        var posting = $.post( "/cart/changeNumber/"+id+"/"+number, { }, function(data) {
            if (data !== "Не хватает")
            {
                $("#cart-count").html(data);
                $("#small-cart-count").html(data);  
                $("#total-cart-amount").html(data);  
            } else {
                $("#parent_popup").css("display", "unset");
            }
        });
        var counting = $.post( "/cart/countAjax/", { }, function(data) {
            $("#price-count").html(data);
            $("#left-price-count").html(data);
            $("#total-price").html(data);
        });
        var costing = $.post( "/cart/countCost/"+id+"/"+number, { }, function(data) {
            if (data !== "Не хватает")
            {
                $("#products-cost-"+id).html(data);
            }            
        });
        return false;
    });
});