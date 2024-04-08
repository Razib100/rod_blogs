<?php include("../../path.php"); ?>
<?php include(ROOT_PATH . "/app/controllers/topics.php"); 
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

        <title>Admin Section - Manage Topics</title>
    </head>

    <body>
        
    <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">

        <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>


            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create.php" class="btn btn-big">Add Topic</a>
                    <a href="index.php" class="btn btn-big">Manage Topics</a>
                </div>


                <div class="content">

                    <h2 class="page-title">Manage Topics</h2>

                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                    <table>
                        <thead>
                            <th>SN</th>
                            <th>Name</th>
                            <th colspan="2">Action</th>
                        </thead>
                        <tbody>
                            <?php
                            // Define pagination variables
                            $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
                            $perPage = 10;

                            // Fetch records
                            $conditions = []; // Optional conditions
                            $records = getPagination($table, $conditions, $pageNumber, $perPage);
                            // Calculate starting serial number
                            $startingSerial = ($pageNumber - 1) * $perPage + 1;
                            foreach ($topics as $key => $topic): ?>
                               <tr>
                                    <td><?php echo ($startingSerial + $key); ?></td>
                                    <td><?php echo $topic['name']; ?></td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $topic['id']; ?>" class="edit hover-text"><span class="tooltip-text" id="top">Edit</span><i class="fas fa-edit"></i></a>
                                        <a href="index.php?del_id=<?php echo $topic['id']; ?>" class="delete hover-text"><span class="tooltip-text" id="top">Delete</span><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr> 
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                    // Assuming $pageNumber and $perPage are already defined
                    $totalRecords = count(selectAll($table, $conditions)); // Get total records
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