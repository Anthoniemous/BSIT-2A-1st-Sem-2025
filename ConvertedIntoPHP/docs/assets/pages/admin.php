<?php
echo '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dasboard</title>
    <link rel="stylesheet" href="../css/admin.css" />
  </head>
  <body>
    <div class="outer-parent">
      <nav>
        <span id="logo">
          <img src="../images/icons/admin/student.png" alt="" />
        </span>
        <div class="links">
          <div class="nav-holder">
            <span class="nav-icon">
              <img src="../images/icons/admin/dashboard.png" alt="" />
            </span>
            <li>Dashboard</li>
          </div>
          <div class="nav-holder">
            <span class="nav-icon">
              <img src="../images/icons/admin/credit-card-payment.png" alt="" />
            </span>
            <li>Payment Info</li>
          </div>
          <div class="nav-holder">
            <span class="nav-icon">
              <img src="../images/icons/admin/registration.png" alt="" />
            </span>
            <li>Registration</li>
          </div>
          <div class="nav-holder">
            <span class="nav-icon">
              <img src="../images/icons/admin/classroom.png" alt="" />
            </span>
            <li>Courses</li>
          </div>
          <div class="nav-holder">
            <span class="nav-icon">
              <img src="../images/icons/admin/log-out.png" alt="" />
            </span>
            <li>Logout</li>
          </div>
        </div>
      </nav>
      <main>
        <section class="search-profile">
          <input type="search" placeholder="Search" />
          <div class="notif-profile">
            <div class="image-profile">
              <img src="../images/icons/admin/admin.png" alt="" />
              <div class="profile">
                <p>John Doe</p>
                <p style="opacity: 0.7">Admin</p>
              </div>
            </div>
            <span>
              <img src="../images/icons/admin/active.png" alt="" />
            </span>
          </div>
        </section>
        <section>
          <!-- From Uiverse.io by SouravBandyopadhyay -->
          <div class="notification">
            <div class="notiglow"></div>
            <div class="notiborderglow"></div>
            <div class="notititle">Welcome Back John!</div>
          </div>
        </section>
      </main>
    </div>
  </body>
</html>
'; ?>
