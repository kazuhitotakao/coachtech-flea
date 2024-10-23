document.getElementById('sale_price').addEventListener('input', function (event) {
    let input = event.target.value.replace(/\D/g, ''); // 数字以外を削除
    event.target.value = input.replace(/\B(?=(\d{3})+(?!\d))/g, ','); // 3桁ごとにカンマを挿入
});
