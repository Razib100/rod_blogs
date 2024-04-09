<header>
    <a href="<?php echo BASE_URL ?>" class="logo">
    <img style="height:60px;margin: 3px;border-radius: 5px" src="<?php echo BASE_URL . '/assets/images/' . $logo['image'] ?>" alt="<?= $logo['title'] ?>" title="<?= $logo['title'] ?>">
    </a>
    <i class="fa fa-bars menu-toggle"></i>
    <ul class="nav">
      <li><a href="<?php echo BASE_URL ?>">Home</a></li>
      <?php if (isset($_SESSION['id'])): ?>
        <li>
          <a href="#">
            <i class="fa fa-user"></i>
            <?php echo $_SESSION['username']; ?>
            <i class="fa fa-chevron-down" style="font-size: .8em;"></i>
          </a>
          <ul>
            <?php if($_SESSION['admin']): ?>
              <li><a href="<?php echo BASE_URL . '/admin/dashboard.php' ?>">Dashboard</a></li>
            <?php elseif($_SESSION['id']): ?>
              <li><a href="<?php echo BASE_URL . '/user/dashboard.php' ?>">Dashboard</a></li>
            <?php endif; ?>
            <li><a href="<?php echo BASE_URL . '/logout.php' ?>" class="logout">Logout</a></li>
          </ul>
        </li>
      <?php else: ?>
        <li><a href="<?php echo BASE_URL . '/register.php' ?>">Sign Up</a></li>
        <li><a href="<?php echo BASE_URL . '/login.php' ?>">Login</a></li>
      <?php endif; ?>
    </ul>
</header>
<!--<section class="banner">-->
<!--    <div class="banner-content">-->
<!--        <h2 style="color: #fff !important;">Welcome to <span style="color: #05f7ff !important;">Rod</span>Blogs!</h2>-->
<!--        <p>Explore the latest and greatest content on our platform.</p>-->
<!--        <h2 style="color: #fff !important;">--><?php //echo $text['title'] ?><!--</h2>-->
<!--        <p>--><?php //echo $text['sub_title'] ?><!--</p>-->
<!--    </div>-->
<!--</section>-->
<section class="banner">
    <div class="banner-content">
		<?php
		// Assuming $text['title'] contains the title text
		$title = $text['title'];
		// Split the title into words
		$words = explode(' ', $title);
		// Initialize variables for the words before and after index 2
		$beforeThirdWord = '';
		$afterThirdWord = '';
		// Loop through each word and accumulate the words before and after index 2
		foreach ($words as $key => $word) {
			if ($key < 2) {
				$beforeThirdWord .= $word . ' ';
			} elseif ($key == 2) {
				$afterThirdWord .= '<span style="color: #05f7ff !important;">' . $word . ' </span>';
			} else {
				$afterThirdWord .= $word . ' ';
			}
		}
		?>
        <h2 style="color: #fff !important;"><?php echo $beforeThirdWord . $afterThirdWord; ?></h2>
        <p><?php echo $text['sub_title'] ?></p>
    </div>
</section>