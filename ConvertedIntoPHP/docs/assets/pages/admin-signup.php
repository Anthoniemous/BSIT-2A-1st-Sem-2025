<?php
echo '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log in Form</title>
    <link rel="stylesheet" href="assets/css/index.css" />
  </head>
  <body>
    <div class="wrapper">
      <section class="texts-logo">
        <div class="welcome-icons">
          <h1>Welcome!</h1>
          <h1>to our homepage</h1>
          <p>This page is intended for school project</p>
          <ul class="icons">
            <li>
              <img src="assets/images/icons/facebook.png" alt="facebook" />
            </li>
            <li>
              <img src="assets/images/icons/instagram.png" alt="instagram" />
            </li>
            <li>
              <img src="assets/images/icons/linkedin.png" alt="linkedin" />
            </li>
            <li>
              <img src="assets/images/icons/youtube.png" alt="youtube" />
            </li>
          </ul>
        </div>
      </section>
      <section class="inputs">
        <form class="forms" method="POST" action="login.php">
          <h2>Sign In</h2>
          <div class="boxes">
            <div class="box">
              <input type="email" name="email" required placeholder="Email" />
              <span>
                <img
                  src="assets/images/icons/icons8-email-100.png"
                  alt="email icon"
                />
              </span>
            </div>
            <div class="box">
              <input
                type="password"
                name="password"
                required
                placeholder="Password"
              />
              <span>
                <img
                  src="assets/images/icons/icons8-lock-100.png"
                  alt="lock icon"
                />
              </span>
            </div>
          </div>
          <section class="remember">
            <div class="check-remember">
              <input type="checkbox" id="checkbox" name="remember" />
              <label for="checkbox">Remember me</label>
            </div>
            <a href="#">Forget Password</a>
          </section>
          <button type="submit">Log in</button>
          <section class="create-account">
            <a href="#">Create Account?</a>
            <a href="#">Sign Up</a>
          </section>
        </form>
      </section>
    </div>
  </body>
</html>
'; ?>
