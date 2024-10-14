// 画像アプロード時のファイル名表示
document.getElementById('images').addEventListener('change', function () {
    const fileNames = [];
    for (let i = 0; i < this.files.length; i++) {
        fileNames.push(this.files[i].name);
    }
    document.getElementById('file-names').textContent = fileNames.join(', ') || '選択されたファイルはありません。';
});

// ラジオボタン選択によって、別のformのinputに値を反映させる。
function updateThumbNailId(selectedId) {
    document.getElementById('item-image-thumbnail-id').value = selectedId;
}

// サムネイル画像の切り替え
const thumbnail = document.querySelector('.item-image-thumbnail img');
const images = document.querySelectorAll('.item-images img');
images.forEach((image) => {
    image.addEventListener('click', (event) => {
        thumbnail.src = event.target.src;
        thumbnail.animate({
            opacity: [0, 1]
        }, 100);
    });
});

// サムネイル画像選択時にギャラリーの中かから目立たせる
document.addEventListener('DOMContentLoaded', function () {
    const images = document.querySelectorAll('.item-images_image');
    console.log(images);
    images.forEach(image => {
        image.addEventListener('click', function () {
            // すべての画像から 'selected-image' クラスを削除
            images.forEach(img => img.classList.remove('selected-image'));
            // クリックされた画像に 'selected-image' クラスを追加
            this.classList.add('selected-image');
        });
    });
});
