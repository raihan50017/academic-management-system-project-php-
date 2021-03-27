<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pundra_cse_dept";
$data = "";
require_once('./lib/application/databaseconfig.php');

if (isset($_POST["update_student_table"])) {

    $conn = connect_database($servername, $username, $password, $dbname);
    $sql = "SELECT * FROM st_info ORDER BY id DESC";
    $com_data = $conn->query($sql);
    $data = "";

    while ($st_data = $com_data->fetch_assoc()) {
        $data .= '<tr>
        <td>' . $st_data["roll"] . '</td>
        <td class="text-center">
            <div style="height:30px;width:30px; border-radius:50%; overflow:hidden"><img src="./uploads/st_photo/' . $st_data['profile_image'] . '" alt="student"></div>
        </td>
        <td>' . $st_data["first_name"] . " " . $st_data["last_name"] . '</td>
        <td>' . $st_data['gender'] . '</td>
        <td>' . $st_data['session'] . '</td>
        <td>' . $st_data['year'] . '</td>
        <!-- <td>Jack Sparrow </td>
        <td>TA-107 Newyork</td> -->
        <td>' . $st_data['birth_date'] . '</td>
        <td>' . $st_data['phone'] . '</td>
        <td>' . $st_data['email'] . '</td>
        <td>
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                    <!-- <span class="flaticon-more-button-of-three-dots"></span> -->
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="studentdetails.php?reg_id=' . $st_data['registration_id'] . '"><i class="fa fa-user text-dark-pastel-green"></i>View Profile</a>
                    <a class="dropdown-item" href="updatestudentdata.php?roll=' . $st_data["roll"] . '"><i class="fa fa-cogs text-dark-pastel-green"></i>Edit</a>
                    <p style="cursor:pointer" class="dropdown-item" onclick="delete_student(' . $st_data['id'] . ')" ><i class="fa fa-trash text-orange-red text-dark-pastel-green"></i>Delete Student</p>
                </div>
            </div>
        </td>
    </tr>';
    }
    echo $data;
    $conn->close();
}

if (isset($_POST["delete_student_id"])) {
    $conn = connect_database($servername, $username, $password, $dbname);
    $delete_student_id = $_POST["delete_student_id"];
    if ($conn->connect_errno) {
        $msg = "<p class = 'alert alert-danger '><b>ERROR!</b> Database connection error occured <button class='close' data-dismiss='alert'>&times;</button></p>";
    } else {
        $sql = "DELETE FROM st_info WHERE id=$delete_student_id ";
        $result = $conn->query($sql);
    }
    $conn->close();
}

if (isset($_POST["update"])) {
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
        $conn->close();
    }

    $all_notice = get_all_notice();


    while ($notice_data = $all_notice->fetch_assoc()) {

        $post_time = date('d', strtotime($notice_data["time_stamp"])) . " " . date('F', mktime(0, 0, 0, date('m', strtotime($notice_data["time_stamp"])), 10)) . " " . date('Y', strtotime($notice_data["time_stamp"]));

        $data .= '<div class="notice-list row">
        <div class="col-11">
            <div class="post-date bg-skyblue">' . date('d', strtotime($notice_data["time_stamp"])) . " " . date('F', mktime(0, 0, 0, date('m', strtotime($notice_data["time_stamp"])), 10)) . " " . date('Y', strtotime($notice_data["time_stamp"])) . '</div>
            <h6 class="notice-title"><a href="#">' . $notice_data["notice_title"] . '</a></h6>
            <div class="entry-meta"> by admin / <span>' . date('h:i:s a', strtotime($notice_data["time_stamp"])) . '</span></div>
        </div>
        <div class="col-1"><button onclick="delete_notice(' . $notice_data['id'] . ')" class="btn btn-danger">Delete</button></div>
    </div>';
    }


    echo $data;
}

if (isset($_POST["delete_id"])) {

    $conn = connect_database($servername, $username, $password, $dbname);
    $delete_id = $_POST["delete_id"];

    if ($conn->connect_errno) {
        $msg = "<p class = 'alert alert-danger '><b>ERROR!</b> Database connection error occured <button class='close' data-dismiss='alert'>&times;</button></p>";
    } else {
        $sql = "DELETE FROM notice WHERE id=$delete_id ";
        $result = $conn->query($sql);
    }
    $conn->close();
}
