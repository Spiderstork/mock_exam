<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>booking</title>
  </head>
  <body>

    <form action='backend/payment/confirm_payment.php' method='post'>
        <label for='card_number'>card number:</label><br>
        <input type='text' id='card_number' name='card_number' placeholder='Card Number' minlength="15" maxlength="16" required><br>

        <label for='expiry_month'>expiry month:</label><br>
        <input type='text' id='expiry_month' name='expiry_month' placeholder='MM' minlength="2" maxlength="2" required><br>

        <label for='expiry_year'>expiry year:</label><br>
        <input type='text' id='expiry_year' name='expiry_year' placeholder='YY' minlength="2" maxlength="2" required><br>

        <label for='cvv'>cvv:</label><br>
        <input type='text' id='cvv' name='cvv' placeholder='CVV (3 digits)' minlength="3" maxlength="3" required><br>

        <label for='booking_name'>booking name:</label><br>
        <input type='text' id='booking_name' name='booking_name' placeholder='Booking Name' required><br>

        <label for='email'>email:</label><br>
        <input type='email' name='email' placeholder='Email' required><br>

        <input type='submit' value='Confirm Payment'>
      </form>
    </body>
</html>
<script>
    document.getElementById('card_number').addEventListener('input', function (event) {
        var input = event.target;
        var value = input.value;
        if (value.length >= 16) {
            input.value = value.slice(0, 16);
            document.getElementById("expiry_month").focus(); 
        }
    });
    document.getElementById('expiry_month').addEventListener('input', function (event) {
        var input = event.target;
        var value = input.value;
        if (value.length >= 2) {
            input.value = value.slice(0, 2);
            document.getElementById("expiry_year").focus(); 
        }
    });
    document.getElementById('expiry_year').addEventListener('input', function (event) {
        var input = event.target;
        var value = input.value;
        if (value.length >= 2) {
            input.value = value.slice(0, 2);
            document.getElementById("cvv").focus(); 
        }
    });
    document.getElementById('cvv').addEventListener('input', function (event) {
        var input = event.target;
        var value = input.value;
        if (value.length >= 3) {
            input.value = value.slice(0, 3);
            document.getElementById("booking_name").focus(); 
        }
    });
</script>

