// ラジオボタン選択によって、別のformタグ(ここでは削除formから変更form)のinputに値を反映させる。
// ※削除ボタンと変更ボタンが同じラジオボタンの値を必要とした。
//   フォームタグを入れ子にはできないので、javascriptで対応
function updatePaymentDetailId(selectedId) {
    document.getElementById('payment-detail-id-input').value = selectedId;
}

function handlePaymentMethodChange(selectedId) {
    document.getElementById('payment-method-id-input').value = selectedId;
    // クレジットカードの詳細表示/非表示のトグル
    var detailsDiv = document.getElementById('credit-details');
    if (selectedId == 1) {
        detailsDiv.style.display = 'block';
    } else {
        detailsDiv.style.display = 'none';
    }
}