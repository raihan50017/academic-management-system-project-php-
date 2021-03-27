<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pundra_cse_dept";
require_once('./lib/application/databaseconfig.php');

if (isset($_GET["roll"])) {
    $conn = connect_database($servername, $username, $password, $dbname);

    $roll = $_GET["roll"];

    if ($conn->connect_errno) {
        $msg = "<p class = 'alert alert-danger '><b>ERROR!</b> Database connection error occured <button class='close' data-dismiss='alert'>&times;</button></p>";
    } else {
        $sql = "SELECT * FROM st_info WHERE roll = '$roll'";
        $result = $conn->query($sql);
        while ($st_data = $result->fetch_assoc()) {
            $firstname =  $st_data["first_name"];
            $lastname = $st_data["last_name"];
            $gender = $st_data["gender"];
            $birthdate = $st_data["birth_date"];
            $roll = $st_data["roll"];
            $bloodgroup = $st_data["blood_group"];
            $religion = $st_data["religion"];
            $session = $st_data["session"];
            $year = $st_data["year"];
            $registrationid = $st_data["registration_id"];
            $phone = $st_data["phone"];
            $email = $st_data["email"];
            $u_profileimage = $st_data["profile_image"];
            $initbirthdate = date("d/m/Y", strtotime($birthdate));
        }
        $firstnameError = $lastnameError = $genderError =  $birthdateError = $bloodgroupError = $religionError = $sessionError = $yearError = $phoneError = $profileimageError = $imgError = $msg = "";
        $conn->close();

        if (isset($_POST["submit"])) {

            if (empty($_POST["firstname"])) {
                $firstnameError = "Field required";
                $firstname = "";
            } else {
                $firstname = test_input($_POST["firstname"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
                    $firstnameError = "Invalid input";
                    $firstname = "";
                }
            }

            if (empty($_POST["lastname"])) {
                $lastnameError = "Field required";
                $lastname = "";
            } else {
                $lastname = test_input($_POST["lastname"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
                    $lastnameError = "Invalid input";
                    $lastname = "";
                }
            }

            if (empty($_POST["gender"])) {
                $genderError = "Field required";
                $gender = "";
            } else {
                $gender = $_POST["gender"];
            }

            if (empty($_POST["birthdate"])) {
                $birthdateError = "Field required";
                $birthdate = "";
                $birthdateformate = "";
                $initbirthdate = "";
            } else {
                $birthdate = $_POST["birthdate"];
                $birthdateformate = date("Y-m-d", strtotime($birthdate));
            }

            if (empty($_POST["bloodgroup"])) {
                $bloodgroupError = "Field required";
                $bloodgroup = "";
            } else {
                $bloodgroup = $_POST["bloodgroup"];
                $bloodgroupError = "";
            }

            if (empty($_POST["religion"])) {
                $religionError = "Field required";
                $registrationid = "";
            } else {
                $religion = $_POST["religion"];
                $religionError = "";
            }


            if (empty($_POST["session"])) {
                $sessionError = "Field required";
                $session = "";
            } else {
                $session = $_POST["session"];
                $sessionError = "";
            }

            if (empty($_POST["year"])) {
                $yearError = "Field required";
                $year = "";
            } else {
                $year = $_POST["year"];
                $yearError = "";
            }


            if (empty($_POST["phone"])) {
                $phoneError = "Field required";
                $phone = "";
            } else {
                $phone = test_input($_POST["phone"]);
                // check if name only contains letters and whitespace
                if (!preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $phone)) {
                    $phoneError = "Invalid input";
                    $phone = "";
                }
            }



            if (!empty($_FILES['profileimage']['name'])) {
                $profileimage = $_FILES['profileimage']['name'];
                $profileimage_tmp = $_FILES['profileimage']['tmp_name'];
                $ext = strtolower(pathinfo($profileimage, PATHINFO_EXTENSION));
                $u_profileimage = "";
                if ((in_array($ext, ['jpg', 'jpeg', 'png']) == true)) {
                    $u_profileimage = md5(time() . $profileimage) . "." . $ext;
                    $imgError = "";
                    $profileimageError = "";
                } else {
                    $imgError = "<p class = 'alert alert-danger '><b>ERROR!</b> Only jpeg, jpg or png file are allowed <button class='close' data-dismiss='alert'>&times;</button></p>";
                    $profileimageError = "Field required";
                    $u_profileimage = "";
                }
            }

            //End form data validation//

            if (!empty($firstname) && !empty($lastname) && !empty($gender) && !empty($birthdate) && !empty($roll) && !empty($bloodgroup) && !empty($religion) && !empty($email) && !empty($session) && !empty($registrationid) && !empty($phone) && !empty($u_profileimage)) {


                $conn = connect_database($servername, $username, $password, $dbname);

                if ($conn->connect_errno) {
                    $msg = "<p class = 'alert alert-danger '><b>ERROR!</b> Database connection error occured <button class='close' data-dismiss='alert'>&times;</button></p>";
                } else {
                    // echo "Database connected successfuffy";

                    $sql = "UPDATE st_info SET first_name='$firstname', last_name='$lastname', gender='$gender',birth_date='$birthdateformate', blood_group='$bloodgroup', religion='$religion',session='$session', year='$year', phone='$phone',profile_image='$u_profileimage' WHERE roll ='$roll'";

                    if ($conn->query($sql) === TRUE) {
                        $msg = "<p class = 'alert alert-success '><b>SUCCESS!</b> Data updated Successfully <button class='close' data-dismiss='alert'>&times;</button></p>";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                    $conn->close();


                    if (!empty($_FILES['profileimage']['name'])) {
                        if ($u_profileimage) {
                            move_uploaded_file($profileimage_tmp, 'uploads/st_photo/' . $u_profileimage);
                        }
                    }

                    $firstnameError = $lastnameError = $genderError =  $birthdateError = $rollError = $bloodgroupError = $religionError = $emailError = $sessionError = $yearError = $registrationidError = $phoneError = $profileimageError = $imgError = $emailExistError = $rollExistError = $regExistError = "";
                }
            } else {
                $msg = "<p class = 'alert alert-danger '><b>ERROR!</b> Any required field Must Not Be Empty <button class='close' data-dismiss='alert'>&times;</button></p>";
            }
        }
    }
}

// Validate input data

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
    <!-- Select 2 CSS -->
    <link rel="stylesheet" href="assets/css/select2.min.css">
    <!-- Date picket CSS -->
    <link rel="stylesheet" href="assets/css/datepicker.min.css">
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
                        <li>Update Student Information</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Dashboard Content Start Here -->
                <!-- Student Details Area Start Here -->
                <?php echo $msg; ?>
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title d-block">
                                <h3>Update Information </h3>
                            </div>
                        </div>
                        <div class="single-info-details">
                            <div class="item-img">
                                <h5>Roll: <?php echo $roll ?></h5>
                                <h5>Registration Id: <?php echo $registrationid ?></h5>
                                <h5>Email: <?php echo $email ?></h5>
                                <img src="./uploads/st_photo/<?php echo $u_profileimage ?>" alt="Uploading new photo...">
                            </div>
                            <div class="item-content">
                                <div class="header-inline item-header">
                                    <h3 class="text-dark-medium font-medium">You Can Change The Following Information<h3>
                                </div>
                                <div class="info-table table-responsive">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?roll=<?php echo $_GET["roll"]; ?>" enctype="multipart/form-data">
                                        <table class="table text-nowrap">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <label>First Name <span class="error">* <?php echo $firstnameError ?></span></label>
                                                            <input name="firstname" type="text" placeholder="" class="form-control" value="<?php echo $firstname ?>">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <label>Last Name <span class="error">* <?php echo $lastnameError ?></span></label>
                                                            <input name="lastname" type="text" placeholder="" class="form-control" value="<?php echo $lastname ?>">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <label>Gender <span class="error">* <?php echo $genderError ?></span></label><br>
                                                            <select class="select2" name="gender">
                                                                <option value="">Please Select Gender *</option>
                                                                <option value="male" <?php if ($gender === "male") {
                                                                                            echo "selected";
                                                                                        } ?>>Male</option>
                                                                <option value="female" <?php if ($gender === "female") {
                                                                                            echo "selected";
                                                                                        } ?>>Female</option>
                                                                <option value="others" <?php if ($gender === 'others') {
                                                                                            echo "selected";
                                                                                        } ?>>Others</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <label>Date Of Birth <span class="error">* <?php echo $birthdateError ?></span></label>
                                                            <input name="birthdate" type="text" placeholder="dd/mm/yyyy" class="form-control air-datepicker" data-position='bottom right' value="<?php echo $initbirthdate; ?>">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <label>Blood Group <span class="error">* <?php echo $bloodgroupError ?></span></label><br>
                                                            <select name="bloodgroup" class="select2">
                                                                <option value="">Please Select Group *</option>
                                                                <option value="A+" <?php if ($bloodgroup === "A+") {
                                                                                        echo "selected";
                                                                                    } ?>>A+</option>
                                                                <option value="A-" <?php if ($bloodgroup === "A-") {
                                                                                        echo "selected";
                                                                                    } ?>>A-</option>
                                                                <option value="B+" <?php if ($bloodgroup === "B+") {
                                                                                        echo "selected";
                                                                                    } ?>>B+</option>
                                                                <option value="B-" <?php if ($bloodgroup === "B-") {
                                                                                        echo "selected";
                                                                                    } ?>>B-</option>
                                                                <option value="O+" <?php if ($bloodgroup === "O+") {
                                                                                        echo "selected";
                                                                                    } ?>>O+</option>
                                                                <option value="O-" <?php if ($bloodgroup === "O-") {
                                                                                        echo "selected";
                                                                                    } ?>>O-</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <label>Religion <span class="error">* <?php echo $religionError ?></span></label><br>
                                                            <select name="religion" class="select2">
                                                                <option value="">Please Select Religion *</option>
                                                                <option value="islam" <?php if ($religion === "islam") {
                                                                                            echo "selected";
                                                                                        } ?>>Islam</option>
                                                                <option value="hindu" <?php if ($religion === "hindu") {
                                                                                            echo "selected";
                                                                                        } ?>>Hindu</option>
                                                                <option value="christian" <?php if ($religion === "christian") {
                                                                                                echo "selected";
                                                                                            } ?>>Christian</option>
                                                                <option value="boddish" <?php if ($religion === "boddish") {
                                                                                            echo "selected";
                                                                                        } ?>>Buddish</option>
                                                                <option value="others" <?php if ($religion === "others") {
                                                                                            echo "selected";
                                                                                        } ?>>Others</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <label>Session <span class="error">* <?php echo $sessionError ?></span></label><br>
                                                            <select name="session" class="select2">
                                                                <option value="">Please Select Session *</option>
                                                                <option value="2017-18" <?php if ($session === "2017-18") {
                                                                                            echo "selected";
                                                                                        } ?>>2017-18</option>
                                                                <option value="2018-19" <?php if ($session === "2018-19") {
                                                                                            echo "selected";
                                                                                        } ?>>2018-19</option>
                                                                <option value="2019-20" <?php if ($session === "2019-20") {
                                                                                            echo "selected";
                                                                                        } ?>>2019-20</option>
                                                                <option value="2020-21" <?php if ($session === "2020-21") {
                                                                                            echo "selected";
                                                                                        } ?>>2020-21</option>
                                                                <option value="2021-22" <?php if ($session === "2021-22") {
                                                                                            echo "selected";
                                                                                        } ?>>2021-22</option>
                                                                <option value="2022-23" <?php if ($session === "2022-23") {
                                                                                            echo "selected";
                                                                                        } ?>>2022-23</option>
                                                                <option value="2023-24" <?php if ($session === "2023-24") {
                                                                                            echo "selected";
                                                                                        } ?>>2023-24</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <label>Year <span class="error">* <?php echo $yearError ?></span></label><br>
                                                            <select name="year" class="select2">
                                                                <option value="">Please Select Year *</option>
                                                                <option value="1" <?php if ($year === "1") {
                                                                                        echo "selected";
                                                                                    } ?>>First Year</option>
                                                                <option value="2" <?php if ($year === "2") {
                                                                                        echo "selected";
                                                                                    } ?>>Second Year</option>
                                                                <option value="3" <?php if ($year === "3") {
                                                                                        echo "selected";
                                                                                    } ?>>Third Year</option>
                                                                <option value="4" <?php if ($year === "4") {
                                                                                        echo "selected";
                                                                                    } ?>>Fourth Year</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group">
                                                            <label>Phone <span class="error">* <?php echo $phoneError ?></span></label>
                                                            <input name="phone" type="text" placeholder="" class="form-control" value="<?php echo $phone; ?>">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="form-group mg-t-30">
                                                            <label class="text-dark-medium">Upload Student Photo <span class="error">* <?php echo $profileimageError ?></span></label>
                                                            <?php echo $imgError ?>
                                                            <input name="profileimage" type="file" class="form-control-file">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>

                                                        <div class="form-group mg-t-8">
                                                            <button name="submit" type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        <!-- Select 2 Js -->
        <script src="assets/js/select2.min.js"></script>
        <!-- Date Picker Js -->
        <script src="assets/js/datepicker.min.js"></script>
        <!-- Waypoints Js -->
        <script src="assets/js/jquery.waypoints.min.js"></script>
        <!-- Custom Js -->
        <script src="assets/js/main.js"></script>

</body>

</html>