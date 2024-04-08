<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/logo.php");
adminOnly();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
          crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Candal|Lora"
          rel="stylesheet">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="../../assets/css/style.css">

    <!-- Admin Styling -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <title>Admin Section - Manage Banner</title>
</head>

<body>

<?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

<!-- Admin Page Wrapper -->
<div class="admin-wrapper">

    <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>


    <!-- Admin Content -->
    <div class="admin-content">
        <div class="button-group">
            <a href="create.php" class="btn btn-big">Add Logo</a>
            <a href="index.php" class="btn btn-big">Manage Logo</a>
        </div>


        <div class="content">

            <h2 class="page-title">Manage Logo</h2>

            <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

            <table>
                <thead>
                <th>SN</th>
                <th>Title</th>
                <th>Image</th>
                <th>Status</th>
                <th colspan="3">Action</th>
                </thead>
                <tbody>
                <?php foreach ($logos as $key => $logo): ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $logo['title'] ?></td>
                        <td class="imagePreviewContainer">
                            <img id="imagePreview" src="<?php echo BASE_URL . '/assets/images/' . $logo['image'] ?>" style="max-width: 45%; max-height: 100px; padding-top: 10px;">
                        </td>
                        <td><?php echo $logo['status'] == 1? 'Active' : 'Inactive'; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $logo['id']; ?>" class="edit hover-text"><span class="tooltip-text" id="top">Edit</span><i class="fas fa-edit"></i></a>
                            <a href="edit.php?delete_id=<?php echo $logo['id']; ?>" class="delete hover-text"><span class="tooltip-text" id="top">Delete</span><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>

                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>

        </div>

    </div>
    <!-- // Admin Content -->

</div>
<!-- // Page Wrapper -->



<!-- JQuery -->
<script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Ckeditor -->
<script
        src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>
<!-- Custom Script -->
<script src="../../assets/js/scripts.js"></script>

</body>

</html>