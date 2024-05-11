<?php
include("..\utils\utils.php");
include("..\db\dbhelper.php");
session_start();
if ($_SESSION['id'] == '' || trim($_SESSION['id']) == '' || $_COOKIE['user'] == '' || trim($_COOKIE['user']) == '') {
    header("Location:..\users\logout.php");
    exit();
}
// lay session id va hien thi ten dang nhap
if (!isset($_SESSION['username'])) {
    $val = $_SESSION['id'];
    $sql = "select * from account where acc_id = '$val'";
    $conn = connect_DB();
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['acc_username'];
}
// truy xuat Category de vao select box
$sql = "Select * from Category where cate_id <> 1 order by cate_id asc;";
$queryCate = mysqli_query(connect_DB(), $sql);
$cateList = array();
$cateList = $queryCate->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TakeNote</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../TakeNote/Css/homeNote.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <!-- Category part -->
            <div class="col-xl-3 category">
                <span class="cate_title"><b>Category</b></span>
                <p class="filter">Filter by</p>
                <div class="button-containter">
                    <?php
                    // Button category
                    echo '<br><button data-cid=1 class= "btn btn-warning cateBtn" id=' . 'btn_All' . '>' . 'ALL' . '</button><br>';
                    foreach ($cateList as $row_cate) {
                        // echo '<button class= "btn btn-warning" id=' . 'btn_' . $row_cate['cate_name'] . '>' . $row_cate['cate_name'] . '</button><br>';
                        echo '<button data-cid=' . $row_cate['cate_id'] . ' class= "btn btn-warning cateBtn" id=' . 'btn_' . $row_cate['cate_name'] . '>' . $row_cate['cate_name'] . '</button><br>';
                    }
                    ?>
                </div>

            </div>
            <!-- NOTE part -->
            <div class="col-xl note">
                <!-- Nav part -->
                <div class="row content">
                    <div class="col-xl-9 nav1">
                        <span class="note_title">NOTE</span>
                        <button class='btn btn-primary addbtn fa fa-plus' id='button_add_note'></button>
                        <span>
                            <form>
                                <input type="search" name="search_bar" id="search_bar" class="form-control" placeholder="Search title or description" style="border-radius: 8px;border: 2px solid black;">
                            </form>
                        </span>
                    </div>
                    <div class="col-xl nav2">
                        <span class="User_name"><?php if (isset($_SESSION['username'])) echo $_SESSION['username'] ?> <a class="log_out" href="..\users\logout.php">Log out</a></span>
                    </div>
                    <div id="noteList" class="col-10 mr-auto ml-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ------------Modal INSERT NOTE-------------  -->
    <div class="modal fade" id="addNoteModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">ADD NOTE</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form method='POST'>
                        <div class="form-group">
                            <label for="title"><b>Title</b></label>
                            <input type="text" name="title" id="title" placeholder="Enter title" size="45" required>
                        </div>
                        <div class="form-group">
                            <label for="desc"><b>Description</b></label>
                            <!-- <input type=" name="desc" id="desc" placeholder="Enter description"> -->
                            <textarea name="desc" id="desc" cols="60" rows="3" placeholder="Enter description"></textarea>
                            <select name="cateChoice" id="cateChoice" class="form-control">
                                <!-- Hien thi cac option category lay tu database -->
                                <?php
                                foreach ($cateList as $row_cate) {
                                    echo '<option value="' . $row_cate['cate_id'] . '">' . $row_cate['cate_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-primary" id="button_insert_note" value="Add" data-dismiss="modal">
                            <input type="button" class="btn btn-secondary" value="Close" data-dismiss="modal">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ------------Modal INSERT NOTE-------------  -->

    <!-- script -->
    <script src="../JS/logic.js"></script>
</body>

</html>