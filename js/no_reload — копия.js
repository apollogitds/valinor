var form = document.querySelector('#add');
//alert('7777777Ваша заявка успешно отправлена!');
form.addEventListener('submit', function (evt) {
    evt.preventDefault();
    var item_id = document.querySelector('button[name="item_id"]').value

    var request = new XMLHttpRequest();

    request.addEventListener('load', function () {
        // В этой части кода можно обрабатывать ответ от сервера
        console.log(request.response);
        alert(item_id + 'Ваша заявка успешно отправлена!');
        //document.getElementById('cq').innerHTML;
    });
    //var angmar = $test;
    request.open('POST', '/1.php', true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    request.send('item_id=' + item_id);
    //var angmar = document.getElementById('cq').innerHTML;
    let promise = fetch('1.php');
    promise.then(
        response => {
            return response.text();
        }
    ).then(
        text => {
            result.innerHTML = text;
        }
    );
    document.getElementById('cq').innerHTML = promise;

});


