
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

function logoutLink(){
    Swal.fire({
        text: 'Are you sure you want to log out?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, log out!'
      }).then((result) => {
        if (result.value) {
            Swal.fire({
                icon: 'success',
                title: 'Successfully logged out!',
                text: 'Redirect to login page',
                confirmButtonText: 'OK'
              }).then((result) => {
                if (result.value) {
                    window.location='logout.php';
                }
              })
        }
      })
    }

function loginLink(){
  window.location = 'index.php';
}

function openAlertOrdersuccess(orderNumber){
  var order = orderNumber;
  console.log(order);
  Swal.fire({
    title: 'Your order has been placed!',
    text: "Your order number is: "+ order,
    icon: 'success',
    confirmButtonText: 'OK'
  }).then((result) => {
    if (result.value) {
      window.location = 'order-status.php?id='+order;
    }
  })
}