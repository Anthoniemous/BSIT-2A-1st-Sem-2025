<?php
echo '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../css/forgot-pass.css" />
  </head>
  <body>
    <div class="wrapper">
      <section class="fingerprint-email">
        <div class="icon-header">
          <img src="../images/icons/forgot-password/fingerprint.png" alt="" />
          <header>
            <h1>Forgot Password?</h1>
            <p>Enter your email for instructions</p>
          </header>
          <input type="email" placeholder="Enter your email" required />
        </div>
      </section>
      <section>
        <button>Send 4-digit code</button>
      </section>
    </div>
  </body>
</html>
';
?>
