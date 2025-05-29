<?php
echo <<<HTML
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In Form</title>
    <link rel="stylesheet" href="../css/signIn.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Geist+Mono:wght@100..900&family=Itim&family=Jaro:opsz@6..72&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Mona+Sans:ital,wght@0,200..900;1,200..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+JP:wght@100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Nova+Mono&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Parkinsans:wght@300..800&family=Playwrite+AU+SA:wght@100..400&family=Playwrite+AU+VIC+Guides&family=Playwrite+MX+Guides&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik+Vinyl&family=Rubik+Wet+Paint&family=Rubik:ital,wght@0,300..900;1,300..900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="wrapper">
      <section class="human-illustration">
        <span
          ><img
            src="../images/illustrations/human.svg"
            alt="Human illustration"
        /></span>
      </section>
      <section class="forms-headers">
        <section class="form-header">
          <header class="header-icon">
            <h1>Create an account</h1>
          </header>
        </section>
        <main>
          <section class="forms">
            <form class="form" method="POST" action="register.php">
              <div class="separate">
                <div class="box">
                  <input
                    type="text"
                    name="new_id"
                    placeholder="New ID"
                    required
                  />
                </div>
                <div class="box">
                  <input
                    type="text"
                    name="username"
                    placeholder="New Username"
                    required
                  />
                </div>
              </div>
              <div class="separate">
                <div class="box">
                  <input
                    type="password"
                    name="password"
                    placeholder="New Password"
                    required
                  />
                </div>
                <div class="box">
                  <input
                    type="text"
                    name="salt"
                    placeholder="Password Salt"
                    readonly
                  />
                </div>
              </div>
              <div class="separate">
                <div class="box">
                  <input
                    type="text"
                    name="firstname"
                    placeholder="Firstname"
                    required
                  />
                </div>
                <div class="box">
                  <input
                    type="text"
                    name="lastname"
                    placeholder="Lastname"
                    required
                  />
                </div>
              </div>
              <div class="separate">
                <div class="box">
                  <input
                    type="email"
                    name="primary_email"
                    placeholder="Primary email"
                    required
                  />
                </div>
                <div class="box">
                  <input
                    type="email"
                    name="secondary_email"
                    placeholder="Secondary email"
                    required
                  />
                </div>
              </div>
              <div class="separate">
                <div class="box">
                  <input type="date" name="birthday" id="bday" required />
                </div>
                <div class="box">
                  <input
                    type="text"
                    name="address"
                    placeholder="Address"
                    required
                  />
                </div>
              </div>
              <section class="buttons">
                <button type="submit" id="btn-con">
                  REGISTER
                  <div class="arrow-wrapper">
                    <div class="arrow"></div>
                  </div>
                </button>
                <button type="button" id="btn-2">SIGN IN</button>
              </section>
            </form>
          </section>
        </main>
      </section>
    </div>
  </body>
</html>
HTML; ?>
