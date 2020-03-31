function openAlert() {
      Swal.fire({
        icon: 'warning',
        text: 'This item already added to cart'
      }).then((result) => {
        if (result.value) {
            history.back();
        }
      })
}
function openAlert1() {
    
    Swal.fire({
      icon: 'success',
      text: 'Item added to cart successfully',
      showCancelButton: true,
      cancelButtonText: 'Continue to shopping',
      confirmButtonText: 'Checkout',
      cancelButtonColor: '#28a745',
      reverseButtons: true
    }).then((result) => {
      if (result.value) {
          window.location.assign("cart.php");
      }
      else{
          history.back();
      }
    })
}
