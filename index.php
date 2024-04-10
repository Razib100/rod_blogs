<?php
include("path.php");
include(ROOT_PATH . "/app/controllers/topics.php");

$posts = array();
$postsTitle = 'Recent Posts';

$pageNumber = isset($_GET['page']) ? $_GET['page'] : 1; // Get the page number from the URL parameter
$perPage = 10; // Number of items per page

if (isset($_GET['t_id'])) {
  $id = $_GET['t_id'];
  $trendingPosts = getTendingPosts($id);
  $posts = getPostsByTopicId($_GET['t_id']);
  $paginationPosts = getPostsByTopicIdPagination($_GET['t_id'], $pageNumber, $perPage);
  $postsTitle = "You searched for posts under '" . $_GET['name'] . "'";
} else if (isset($_POST['search-term'])) {
  $postsTitle = "You searched for '" . $_POST['search-term'] . "'";
  $posts = searchPosts($_POST['search-term']);
  $paginationPosts = searchPostsPagination($_POST['search-term'], $pageNumber, $perPage);
  $trendingPosts = getTendingPosts(null);
} else {
  $posts = getPublishedPosts();
  $paginationPosts = getPublishedPostsPagination($pageNumber, $perPage);
  $trendingPosts = getTendingPosts(null);
}

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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

  <!-- Custom Styling -->
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
      .banner {
          background: url('<?php echo BASE_URL . '/assets/images/' . $banner['image'] ?>') no-repeat center/cover;
          height: 50vh;
      }
  </style>
  <title>Blog</title>
</head>

<body>

  <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
  <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>



  <!-- Page Wrapper -->
  <div class="page-wrapper">

    <!-- Post Slider -->
    <?php if(count($trendingPosts) > 0): ?>
    <div class="post-slider">
      <h1 class="slider-title">Trending Posts</h1>
      <i class="fas fa-chevron-left prev"></i>
      <i class="fas fa-chevron-right next"></i>

      <div class="post-wrapper">
        <?php foreach ($trendingPosts as $post):
           // Convert the string to lowercase
           $lowercaseString = strtolower($post['title']);
              
           // Replace spaces and non-alphanumeric characters with an empty string
           $post['seo_url'] = preg_replace('/[^a-z0-9]+/', '-', $lowercaseString);
          ?>
          <div class="post">
              <?php
              // Assuming BASE_URL is defined somewhere in your code
              $defaultImage = BASE_URL . '/assets/default.jpg';
              $imageUrl = isset($post['image']) && !empty($post['image']) ? BASE_URL . '/assets/images/' . $post['image'] : $defaultImage;
              ?>
              <a href="single.php/<?php echo $post['seo_url'].'-'.$post['id']; ?>"><img src="<?php echo $imageUrl; ?>" alt="" class="slider-image"></a>
            <div class="post-info">
              <h4><a href="single.php/<?php echo $post['seo_url'].'-'.$post['id']; ?>">
                      <?php echo html_entity_decode(substr($post['title'], 0, 100) . '...'); ?>
                  </a></h4>
              <i class="far fa-user"> <?php echo $post['username']; ?></i>
              &nbsp;
              <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
                <i class="fas fa-eye"> <?php echo $post['view_count']; ?></i>

            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
    <?php endif; ?>
    <!-- // Post Slider -->

    <!-- Content -->
    <div class="content clearfix">

      <!-- Main Content -->
      <div class="main-content">
        <h1 class="recent-post-title"><?php echo $postsTitle ?></h1>

        <?php foreach ($paginationPosts as $post): 
          // Convert the string to lowercase
          $lowercaseString = strtolower($post['title']);
              
          // Replace spaces and non-alphanumeric characters with an empty string
          $post['seo_url'] = preg_replace('/[^a-z0-9]+/', '-', $lowercaseString);
          ?>
          <div class="post clearfix">
              <?php
              // Assuming BASE_URL is defined somewhere in your code
              $defaultImage = BASE_URL . '/assets/default.jpg';
              $imageUrl = isset($post['image']) && !empty($post['image']) ? BASE_URL . '/assets/images/' . $post['image'] : $defaultImage;
              ?>

              <a href="single.php/<?php echo $post['seo_url'].'-'.$post['id']; ?>"><img src="<?php echo $imageUrl; ?>" alt="" class="post-image"></a>
            <div class="post-preview">
              <h2><a href="single.php/<?php echo $post['seo_url'].'-'.$post['id']; ?>"><?php echo $post['title']; ?></a></h2>
              <i class="far fa-user"> <?php echo $post['username']; ?></i>
              &nbsp;
              <i class="far fa-calendar"> <?php echo date('F j, Y', strtotime($post['created_at'])); ?></i>
                <i class="fas fa-eye"> <?php echo $post['view_count']; ?></i>
              <p class="preview-text">
                <?php echo strip_tags(html_entity_decode(substr($post['body'], 0, 150) . '...'), '<b><i>'); ?>
              </p>
              <a href="single.php/<?php echo $post['seo_url'].'-'.$post['id']; ?>" class="btn read-more">Read More</a>
            </div>
          </div>    
        <?php endforeach; ?>
        <!-- Pagination links -->
        <?php
        // Assuming $pageNumber and $perPage are already defined
        $totalRecords = count($posts); // Get total records
        $totalPages = ceil($totalRecords / $perPage); // Calculate total pages

        echo "<div class='pagination'>";
        if ($pageNumber > 1) {
            echo "<a href='?page=1'>First</a>";
            echo "<a href='?page=" . ($pageNumber - 1) . "'>Previous</a>";
        }
        echo "<span> Page $pageNumber of $totalPages </span>";
        if ($pageNumber < $totalPages) {
            echo "<a href='?page=" . ($pageNumber + 1) . "'>Next</a>";
            echo "<a href='?page=$totalPages'>Last</a>";
        }
        echo "</div>";
        ?>
      </div>
      <!-- // Main Content -->

      <div class="sidebar">

        <div class="section search">
          <h2 class="section-title">Search</h2>
          <form action="index.php" method="post">
            <input type="text" name="search-term" class="text-input" placeholder="Search...">
          </form>
        </div>


        <div class="section topics">
          <h2 class="section-title">Category</h2>
          <ul>
            <?php foreach ($topics as $key => $topic): 
               // Convert the string to lowercase
              $lowercaseString = strtolower($topic['name']);
              
              // Replace spaces and non-alphanumeric characters with an empty string
              $topic['name_url'] = preg_replace('/[^a-z0-9]+/', '', $lowercaseString);
              ?>
              <li><a href="<?php echo BASE_URL . '/index.php?t_id=' . $topic['id'] . '&name=' . $topic['name_url'] ?>"><?php echo $topic['name']; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

      </div>

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