document.getElementById('card_number').addEventListener('input', function (event) {
    let input = event.target.value.replace(/\D/g, ''); // 数字以外を削除
    event.target.value = input.match(/.{1,4}/g)?.join(' ') ?? ''; // 4桁ごとにスペースを挿入
});