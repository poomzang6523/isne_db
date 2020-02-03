
function sum()
{
    $("#cart-summary").children(".summary-table").find(".priceNum").text("0")
    $("#cartItems").children("tr").each(function(){
        var x = $("#cart-summary").children(".summary-table").find(".priceNum").text();
        $("#cart-summary").children(".summary-table").find(".priceNum").text(parseInt(x) + $(this).children(".price").children(".priceNum").text() * $(this).children(".qty").children(".qty-btn").children(".quantity").children(".qty-text").val());
    });
}

$(".qty-minus").click(function (){
    sum();
})

$(".qty-plus").click(function (){
    sum();
})


sum();