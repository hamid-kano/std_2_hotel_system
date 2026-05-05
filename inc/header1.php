<?php
  require_once('admin/inc/db_config.php');
  require_once('admin/inc/essentials.php');

  // Language switcher handler
  if(isset($_GET['set_lang'])){
      setLang($_GET['set_lang']);
      // redirect back without the query param
      $redirect = strtok($_SERVER['REQUEST_URI'], '?');
      header('Location: ' . $redirect);
      exit;
  }

  $contact_q  = "SELECT * FROM `contact_details` WHERE `sr_no`=?";
  $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
  $values     = [1];
  $contact_r  = mysqli_fetch_assoc(select($contact_q, $values, 'i'));
  $settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));

  $current_lang = $_SESSION['lang'] ?? 'ar';
  $lang_labels  = ['ar'=>'العربية 🇮🇶', 'en'=>'English 🇬🇧', 'ku'=>'کوردی 🏳'];
  $site_name    = 'Vana Hotel';
?>
<!-- Favicon -->
<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏨</text></svg>">

<!-- start header -->
<nav class="navbar navbar-expand-lg bg-body-tertiary px-lg-3 shadow-sm sticky-top" id="nav-bar">
    <div class="container-fluid">

      <a class="navbar-brand me-4 fw-bold fs-3 h-font" href="hotel.php"
         style="color:var(--teal);"><?php echo htmlspecialchars($site_name); ?></a>

      <button class="navbar-toggler shadow-none" type="button"
              data-bs-toggle="collapse" data-bs-target="#navbarMain"
              aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link me-2" href="hotel.php"><?php echo lang('home'); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="rooms.php"><?php echo lang('rooms'); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="facalites.php"><?php echo lang('facilities'); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="contact.php"><?php echo lang('contact'); ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php"><?php echo lang('about'); ?></a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-2" role="search">

          <!-- Dark Mode Toggle -->
          <button class="dark-toggle" id="darkToggle" aria-label="Toggle dark mode" title="Dark mode">🌙</button>

          <!-- Language Switcher -->
          <div class="dropdown lang-switcher">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle shadow-none" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
              <?php echo $lang_labels[$current_lang]; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
              <?php foreach($lang_labels as $code => $label): ?>
              <?php if($code !== $current_lang): ?>
              <li>
                <a class="dropdown-item" href="?set_lang=<?php echo $code; ?>">
                  <?php echo $label; ?>
                </a>
              </li>
              <?php endif; ?>
              <?php endforeach; ?>
            </ul>
          </div>

          <!-- User Menu -->
          <?php
            session_start();
            if(isset($_SESSION['login']) && $_SESSION['login']==true):
          ?>
            <div class="btn-group">
              <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle"
                      data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                <i class="bi bi-person-circle me-1"></i>
                <?php echo htmlspecialchars($_SESSION['uName']); ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-lg-end">
                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i><?php echo lang('profile'); ?></a></li>
                <li><a class="dropdown-item" href="bookings.php"><i class="bi bi-calendar-check me-2"></i><?php echo lang('bookings'); ?></a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="inc/logout.php"><i class="bi bi-box-arrow-right me-2"></i><?php echo lang('logout'); ?></a></li>
              </ul>
            </div>
          <?php else: ?>
            <button type="button" class="btn btn-outline-dark shadow-none"
                    data-bs-toggle="modal" data-bs-target="#LoginModal">
              <?php echo lang('login'); ?>
            </button>
            <button type="button" class="btn text-white custom-bg shadow-none"
                    data-bs-toggle="modal" data-bs-target="#RegisterModal">
              <?php echo lang('register'); ?>
            </button>
          <?php endif; ?>

        </div>
      </div>
    </div>
</nav>
<!-- end header -->

<!-- Modal Login -->
<div class="modal fade" id="LoginModal" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="login-form">
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center" id="loginModalLabel">
            <i class="bi bi-person-circle fs-3 me-2"></i>
            <?php echo lang('login'); ?>
          </h5>
          <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label"><?php echo lang('email'); ?> / Mobile</label>
            <input type="text" name="email_mob" required class="form-control shadow-none">
          </div>
          <div class="mb-4">
            <label class="form-label"><?php echo lang('password'); ?></label>
            <input type="password" required name="pass" class="form-control shadow-none">
          </div>
          <div class="d-flex align-items-center justify-content-between mb-2">
            <button type="submit" class="btn btn-dark shadow-none">
              <?php echo lang('login'); ?>
            </button>
            <a href="javascript:void(0)" class="text-secondary text-decoration-none small">Forgot Password?</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end Modal Login -->

<!-- Modal Register -->
<div class="modal fade" id="RegisterModal" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="register-form">
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center" id="registerModalLabel">
            <i class="bi bi-person-lines-fill fs-3 me-2"></i>
            <?php echo lang('register'); ?>
          </h5>
          <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <span class="badge rounded-pill text-bg-light text-dark mb-3 text-wrap lh-base">
            Note: your details must match your ID (passport, driving license, etc.) required at check-in.
          </span>
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 ps-0 mb-3">
                <label class="form-label"><?php echo lang('name'); ?></label>
                <input type="text" name="name" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 p-0 mb-3">
                <label class="form-label"><?php echo lang('email'); ?></label>
                <input type="email" name="email" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 ps-0 mb-3">
                <label class="form-label"><?php echo lang('phone'); ?></label>
                <input type="text" name="phonenum" class="form-control shadow-none" required>
              </div>
              <div class="col-md-12 p-0 mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
              </div>
              <div class="col-md-6 ps-0 mb-3">
                <label class="form-label">Pincode</label>
                <input name="pincode" type="text" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 p-0 mb-3">
                <label class="form-label">Date of birth</label>
                <input name="dob" type="date" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 ps-0 mb-3">
                <label class="form-label"><?php echo lang('password'); ?></label>
                <input name="pass" type="password" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 p-0 mb-3">
                <label class="form-label">Confirm Password</label>
                <input name="cpass" type="password" class="form-control shadow-none" required>
              </div>
            </div>
          </div>
          <div class="text-center my-1">
            <button type="submit" class="btn btn-dark shadow-none">
              <?php echo lang('register'); ?>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end Modal Register -->
