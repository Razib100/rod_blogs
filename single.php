<?php include("path.php"); ?>
<?php  include(ROOT_PATH . '/app/controllers/posts.php');


if (isset($_GET['id'])) {
  $post = selectOne('posts', ['id' => $_GET['id']]);
  $currentViewCount = $post['view_count'];
  // Update the view_count by incrementing it by 1
  $updatedViewCount = $currentViewCount + 1;
  update('posts', $_GET['id'], ['view_count' => $updatedViewCount]);
  // Fetch the updated post data
  $post = selectOne('posts', ['id' => $_GET['id']]);
}
$topics = selectAll('topics');
$posts = selectAll('posts', ['published' => 1]);
$text = getBannerText();
$banner = getBanner();
$logo = getLogo();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

  <!-- Custom Styling -->
  <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/style.css'; ?>">
  <style>
    .banner {
      /*display: none;*/
      background: url('<?php echo BASE_URL . '/assets/images/' . $banner['image'] ?>') no-repeat center/cover;
      height: 50vh;
    }
  </style>
  <title><?php echo $post['title']; ?> | Rod Blogs</title>
  <meta name="description" content="<?php echo $post['title']; ?>">
  <meta name="keywords" content="<?= $post['tag']; ?>">
  <link rel="canonical" href="<?= BASE_URL . '/assets/images/' . $post['image']; ?>">
</head>

<body>
  <!-- Facebook Page Plugin SDK -->
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2&appId=285071545181837&autoLogAppEvents=1">
  </script>

  <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

  <!-- Page Wrapper -->
  <div class="page-wrapper">

    <!-- Content -->
    <div class="content clearfix">

      <!-- Main Content Wrapper -->
      <div class="main-content-wrapper">
        <div class="main-content single">
          <h1 class="post-title"><?php echo $post['title']; ?></h1>

          <?php
          if (isset($post['image'])) {
            echo '<div class="single-image">
            <img id="imagePreview" src="' . BASE_URL . '/assets/images/' . $post['image'] . '" />
          </div>';
          }
          ?>

          <div class="post-content">
            <?php echo html_entity_decode($post['body']); ?>
          </div>
          <div>
            <span>Total views: <i class="fas fa-eye"> <?php echo $post['view_count']; ?></i></span>
          </div>
            <div>
                <span>SEO tag: <?php echo $post['tag']; ?></i></span>
            </div>
        </div>
      </div>
      <!-- // Main Content -->

      <!-- Sidebar -->
      <div class="sidebar single">
        <div class="section popular">
          <h2 class="section-title">Popular</h2>

          <?php foreach ($posts as $p) : 
            // Convert the string to lowercase
           $lowercaseString = strtolower($p['title']);
              
           // Replace spaces and non-alphanumeric characters with an empty string
           $p['seo_url'] = preg_replace('/[^a-z0-9]+/', '-', $lowercaseString);
            ?>
            <div class="post clearfix">
              <a href="<?php echo BASE_URL .'/single.php/'. $p['seo_url'].'-'.$p['id']; ?>" class="title">
                <h4><?php echo $p['title'] ?></h4>
              </a>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="section topics">
          <h2 class="section-title">Category</h2>
          <ul>
            <?php foreach ($topics as $topic) : 
              // Convert the string to lowercase
              $lowercaseString = strtolower($topic['name']);
              
              // Replace spaces and non-alphanumeric characters with an empty string
              $topic['name_url'] = preg_replace('/[^a-z0-9]+/', '-', $lowercaseString).'-'.$topic['id'];
              ?>
              <li><a href="<?php echo BASE_URL . '/index.php/category/'. $topic['name_url'] ?>"><?php echo $topic['name']; ?></a></li>
            <?php endforeach; ?>

          </ul>
        </div>
      </div>
      <!-- // Sidebar -->

    </div>
    <!-- // Content -->

  </div>
  <!-- // Page Wrapper -->

  <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>


  <!-- JQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Slick Carousel -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

  <!-- Custom Script -->
  <script src="assets/js/scripts.js"></script>

</body>

</html>