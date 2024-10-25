/* 基本設定*/
const stripe_public_key = "{{ config('stripe.stripe_public_key') }}"
const stripe = Stripe(stripe_public_key);
const elements = stripe.elements();

let cardNumber = elements.create('cardNumber');
cardNumber.mount('#card_number');
cardNumber.on('change', function (event) {
    let displayError = document.getElementById('card_errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

let cardExpiry = elements.create('cardExpiry');
cardExpiry.mount('#card_expiry');
cardExpiry.on('change', function (event) {
    let displayError = document.getElementById('card_errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

let cardCvc = elements.create('cardCvc');
cardCvc.mount('#card_cvc');
cardCvc.on('change', function (event) {
    let displayError = document.getElementById('card_errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

let form = document.getElementById('card_form');
form.addEventListener('submit', function (event) {
    event.preventDefault();
    let errorElement = document.getElementById('card_errors');
    if (event.error) {
        errorElement.textContent = event.error.message;
    } else {
        errorElement.textContent = '';
    }

    stripe.createToken(cardNumber).then(function (result) {
        if (result.error) {
            errorElement.textContent = result.error.message;
        } else {
            stripeTokenHandler(result.token);
        }
    });
});

function stripeTokenHandler(token) {
    let form = document.getElementById('card_form');
    let hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
    form.submit();
}
