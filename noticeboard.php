<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pundra_cse_dept";
$msg = "";
require_once('./lib/application/databaseconfig.php');

$noticeTitle = $noticePdf = $msg = "";
$noticePdfError = $imgError = $noticeTitleError = "";

if (isset($_POST["submit"])) {
    if (empty($_POST["notice_title"])) {
        $noticeTitleError = "Field required";
        $noticeTitle = "";
    } else {
        $noticeTitle = test_input($_POST["notice_title"]);
        $noticeTitleError = "";
    }

    $noticePdf = $_FILES['notice_pdf']['name'];
    if (!empty($noticePdf)) {
        $pdf_tmp = $_FILES['notice_pdf']['tmp_name'];
        $ext = strtolower(pathinfo($noticePdf, PATHINFO_EXTENSION));
        if ((in_array($ext, ['pdf']) == true)) {
            $u_noticePdf = md5(time() . $noticePdf) . "." . $ext;
            $imgError = "";
            $noticePdfError = "";
        } else {
            $imgError = "<p class = 'alert alert-danger '><b>ERROR!</b> Only pdf file is allowed <button class='close' data-dismiss='alert'>&times;</button></p>";
            $noticePdfError = "Field required";
            $u_noticePdf = "";
        }
    } else {
        $noticePdfError = "Field required";
        $u_noticePdf = "";
    }

    if (!empty($noticeTitle) && !empty($u_noticePdf)) {
        $conn = connect_database($servername, $username, $password, $dbname);

        if ($conn->connect_errno) {
            $msg = "<p class = 'alert alert-danger '><b>ERROR!</b> Database connection error occured <button class='close' data-dismiss='alert'>&times;</button></p>";
        } else {

            $sql = "INSERT INTO notice(notice_title, notice_pdf)VALUES('$noticeTitle', '$u_noticePdf')";

            if ($conn->query($sql) === TRUE) {
                $msg = "<p class = 'alert alert-success '><b>SUCCESS!</b> Data Inserted Successfully <button class='close' data-dismiss='alert'>&times;</button></p>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();


            if ($u_noticePdf) {
                move_uploaded_file($pdf_tmp, 'uploads/notice/' . $u_noticePdf);
            }
            $noticeTitle = $u_noticePdf = "";
        };
    } else {
        $msg = "<p class = 'alert alert-danger '><b>ERROR!</b> Any required field Must Not Be Empty <button class='close' data-dismiss='alert'>&times;</button></p>";
    }
}

function get_all_notice()
{
    global $servername;
    global $username;
    global $password;
    global $dbname;
    $conn = connect_database($servername, $username, $password, $dbname);

    if ($conn->connect_errno) {
        $msg = "<p class = 'alert alert-danger '><b>ERROR!</b> Database connection error occured <button class='close' data-dismiss='alert'>&times;</button></p>";
    } else {
        $sql = "SELECT * FROM notice ORDER BY id DESC ";
        $result = $conn->query($sql);
        return $result;
    }
}

$all_notice = get_all_notice();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- Fontwosome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    </link>
    <!--Flaticon -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/flaticon.css">
    <!-- Normalize CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/normalize.css">
    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!-- custom CSS -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <!-- Fontawesome CSS -->
    <!-- <link rel="stylesheet" href="assets/css/all.min.css"> -->
    </link>
    </link>
</head>

<body>
    <div id="wrapper" class="wrapper bg-ash">
        <!-- Header Menu Area Start Here -->
        <?php
        include('header.php');
        ?>
        <!-- Header Menu Area End Here -->
        <!-- Page Area Start Here -->
        <div class="dashboard-page-one">
            <!-- Sidebar Area Start Here -->
            <?php
            include('sidebar.php');
            ?>
            <!-- Sidebar Area End Here -->
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>Admin Dashboard</h3>
                    <ul>
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>Notice</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Dashboard Content Start Here -->
                <div class="row">
                    <!-- Add Notice Area Start Here -->
                    <div class="col-4-xxxl col-12">
                        <div class="card height-auto">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Create A Notice</h3>
                                    </div>
                                </div>
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="new-added-form" enctype="multipart/form-data">
                                    <?php echo $msg ?>
                                    <div class="row">
                                        <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                            <label>Notice Title<span class="error">* <?php echo $noticeTitleError ?></span></label>
                                            <input value="<?php echo $noticeTitle; ?>" name="notice_title" type="text" placeholder="" class="form-control">
                                        </div>
                                        <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                            <label>Upload pdf file <span class="error">* <?php echo $noticePdfError ?></span></label>
                                            <?php echo $imgError ?>
                                            <input name="notice_pdf" type="file" class="form-control-file">
                                        </div>
                                        <div class="col-12 form-group mg-t-8">
                                            <button name="submit" type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Add Notice Area End Here -->
                    <!-- All Notice Area Start Here -->
                    <div class="col-8-xxxl col-12">
                        <div class="card height-auto">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Notice Board</h3>
                                    </div>
                                </div>
                                <hr>
                                <div class="notice-board-wrap">
                                    <?php while ($notice_data = $all_notice->fetch_assoc()) : ?>
                                        <div class="notice-list">
                                            <div class="post-date bg-skyblue"><?php echo  date('d', strtotime($notice_data["time_stamp"])) . " " . date('F', mktime(0, 0, 0, date('m', strtotime($notice_data["time_stamp"])), 10)) . " " . date('Y', strtotime($notice_data["time_stamp"])); ?></div>
                                            <h6 class="notice-title"><a href="#"><?php echo $notice_data["notice_title"]; ?></a></h6>
                                            <div class="entry-meta"> by admin / <span><?php echo date('h:i:s a', strtotime($notice_data["time_stamp"])); ?></span></div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- All Notice Area End Here -->
                </div>
                <!-- Dashboard Content End Here -->
                <!-- Social Media Start Here -->
                <?php
                include('socialmedia.php');
                ?>
                <!-- Social Media End Here -->

            </div>
        </div>

        <!-- jquery-->
        <script src="assets/js/jquery-3.3.1.min.js"></script>
        <!-- proper js -->
        <script src="assets/js/popper.min.js"></script>
        <!-- Counterup Js -->
        <script src="assets/js/jquery.counterup.min.js"></script>
        <!-- Bootstrap js -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- Moment Js -->
        <script src="assets/js/moment.min.js"></script>
        <!-- Chart Js -->
        <script src="assets/js/Chart.min.js"></script>
        <!-- Waypoints Js -->
        <script src="assets/js/jquery.waypoints.min.js"></script>
        <!-- Custom Js -->
        <script src="assets/js/main.js"></script>

</body>

</html>