// This is your test secret API key.
const stripe = Stripe("pk_live_51MtSplHe23toRzexSa0W1OP004KXZzdCQSvkaqEatv90jpLWeQMGuRC70w5IE1NnoyOSoIhhBuOMWXj5X4EUBiZQ00odVqsFeY");

initialize();

// Create a Checkout Session
async function initialize() {
const fetchClientSecret = async () => {
    const response = await fetch("/ecosystem", {
        method: "POST",
    });
    const { clientSecret } = await response.json();
    return clientSecret;
};

const checkout = await stripe.initEmbeddedCheckout({
    fetchClientSecret,
});

// Mount Checkout
checkout.mount('#checkout');
}