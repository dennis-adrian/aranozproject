<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay for something</title>
</head>

<body>
    <div class="payment-container">
        <h2 class="header">Pay for something</h2>
        <form action="checkout.php" method="post" autocomplete="off">
            <label for="item">
                Product
                <input type="text" name="product">
            </label>
            <label for="amount">
                Price
                <input type="text" name="price">
            </label>
            <input type="submit" value="Pay">
        </form>
        <p>You'll be taken to PayPal to complete your payment.</p>
    </div>
    <!-- Set up a container element for the button -->
    <!-- <div id="paypal-button-container"></div> -->

    <!-- Include the PayPal JavaScript SDK -->
    <!-- <script src="https://www.paypal.com/sdk/js?client-id=AQ-2Og_yAGyWU8-Hieuoa9FsrtfsElnaPVsEjsTo71qkjAxiOKhUtS_XKHtlLCSBUF24B7oQZIEC0cPy&currency=USD"></script> -->

    <!-- <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({
            style: {
                layout: 'horizontal'
            }
        }).render('#paypal-button-container');
    </script> -->
</body>

</html>