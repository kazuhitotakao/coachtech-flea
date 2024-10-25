document.getElementById('condition').addEventListener('focus', function () {
    this.children[0].style.display = 'none';
});

document.getElementById('condition').addEventListener('blur', function () {
    if (this.value === "") {
        this.children[0].style.display = 'block';
    }
});

document.getElementById('brand').addEventListener('focus', function () {
    this.children[0].style.display = 'none';
});

document.getElementById('brand').addEventListener('blur', function () {
    if (this.value === "") {
        this.children[0].style.display = 'block';
    }
});
