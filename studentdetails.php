<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pundra_cse_dept";
require_once('./lib/application/databaseconfig.php');

if (isset($_GET["reg_id"])) {
    $conn = connect_database($servername, $username, $password, $dbname);

    $reg_id = $_GET["reg_id"];

    if ($conn->connect_errno) {
        $msg = "<p class = 'alert alert-danger '><b>ERROR!</b> Database connection error occured <button class='close' data-dismiss='alert'>&times;</button></p>";
    } else {
        $sql = "SELECT * FROM st_info WHERE registration_id = '$reg_id'";
        $result = $conn->query($sql);
    }
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
                        <li>Student details</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Dashboard Content Start Here -->
                <!-- Student Details Area Start Here -->
                <?php while ($st_data = $result->fetch_assoc()) : ?>
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>About: <?php echo $st_data["first_name"] . " " . $st_data["last_name"]; ?></h3>
                                </div>
                            </div>
                            <div class="single-info-details">
                                <div class="item-img">
                                    <img src="./uploads/st_photo/<?php echo $st_data['profile_image'] ?>" alt="student">
                                </div>
                                <div class="item-content">
                                    <div class="header-inline item-header">
                                        <h3 class="text-dark-medium font-medium"><?php echo $st_data["first_name"] . " " . $st_data["last_name"]; ?></h3>
                                    </div>
                                    <div class="info-table table-responsive">
                                        <table class="table text-nowrap">
                                            <tbody>
                                                <tr>
                                                    <td>Name:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["first_name"] . " " . $st_data["last_name"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Gender:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["gender"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Date Of Birth:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["birth_date"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Religion:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["religion"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>E-mail:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["email"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Admission Date:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["time_stamp"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Year:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["year"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Session:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["session"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Roll:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["roll"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Phone:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["phone"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Registration Id:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["registration_id"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Blood Group:</td>
                                                    <td class="font-medium text-dark-medium"><?php echo $st_data["blood_group"]; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                <!-- Student Details Area End Here -->
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