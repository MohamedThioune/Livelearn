 // This is your test secret API key.
 const stripe = Stripe("pk_test_51JyijWEuOtOzwPYXpQ5PQzJGMroshnARkLBNWWJK2ZOsGaaJvF0tmh96eVkAgklzjB8L3usvqvP3229HTXx796nt00qw0X8k7y");

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