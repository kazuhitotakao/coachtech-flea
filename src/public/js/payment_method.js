// ラジオボタン選択によって、別のformタグ(ここでは削除formから変更form)のinputに値を反映させる。
// ※削除ボタンと変更ボタンが同じラジオボタンの値を必要とした。
//   フォームタグを入れ子にはできないので、javascriptで対応
function handlePaymentMethodChange(selectedId) {
    document.getElementById('payment_method_id_input').value = selectedId;
}
