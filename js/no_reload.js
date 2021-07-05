$('.add_to_cart').on('click', addToCart);
function addToCart(evt) {
    var id = $(this).attr('id');
    evt.preventDefault();

    var data = ('item_id=' + id);
    $.ajax({
        type: "POST",
        url: document.URL,
        data: data,
        // success: function (result) {
        //     find('#cq').html(result);
        // }
    });
    $('#qwe').load('');

}

