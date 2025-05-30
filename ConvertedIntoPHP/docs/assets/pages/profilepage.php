<?php
echo '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Page</title>
    <link rel="stylesheet" href="../css/profilepage.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Geist+Mono:wght@100..900&family=Itim&family=Jaro:opsz@6..72&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Mona+Sans:ital,wght@0,200..900;1,200..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Sans+JP:wght@100..900&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Nova+Mono&family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Parkinsans:wght@300..800&family=Playwrite+AU+SA:wght@100..400&family=Playwrite+AU+VIC+Guides&family=Playwrite+MX+Guides&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Rubik+Vinyl&family=Rubik+Wet+Paint&family=Rubik:ital,wght@0,300..900;1,300..900&family=Sour+Gummy:ital,wght@0,100..900;1,100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <nav class="navbars">
      <span class="shutter">
        <img src="../images/icons/profile-page/lens.png" alt="shutter" />
      </span>
      <ul class="navigations">
        <li>
          <img src="../images/icons/profile-page/settings.png" alt="settings" />
        </li>
        <li>
          <img
            src="../images/icons/profile-page/active.png"
            alt="notifications"
          />
        </li>
        <li>
          <img
            src="../images/icons/profile-page/mini-profile.png"
            alt="mini-profile"
            id="mini-profile"
          />
        </li>
      </ul>
    </nav>
    <main>
      <div class="box">
        <span>
          <img src="../images/icons/profile-page/circle.png" alt="" />
        </span>
        <h3>Profile</h3>
      </div>
      <div class="navbar-personal">
        <nav>
          <ul>
            <li>
              <img
                src="../images/icons/profile-page/navbars/budget.png"
                alt=""
              />
            </li>
            <li>
              <img src="../images/icons/profile-page/navbars/card.png" alt="" />
            </li>
            <li>
              <img src="../images/icons/profile-page/navbars/home.png" alt="" />
            </li>
          </ul>
        </nav>
        <section class="personal-info">
          <div class="profile-parent">
            <div class="large-profile">
              <span class="camera">
                <img src="../images/icons/profile-page/camera.png" alt="" />
              </span>
              <img
                src="../images/icons/profile-page/large-profile.svg"
                alt=""
              />
            </div>
            <button>Edit Profile</button>
          </div>
          <section class="infos">
            <div class="info">
              <div class="boxes">
                <label for="name">Name:</label>
                <input type="text" value="User name" readonly />
              </div>
              <div class="boxes">
                <label for="email">Email:</label>
                <input type="email" value="human@gmail.com" readonly />
              </div>
            </div>
            <div class="info">
              <div class="boxes">
                <label for="number">Phone Number:</label>
                <input type="text" value="+63908201954" />
              </div>
              <div class="boxes">
                <label for="address">Address:</label>
                <input type="text" value="San juan 2 bagumbayan" readonly />
              </div>
            </div>
          </section>
        </section>
      </div>
    </main>
  </body>
</html>
'; ?>
