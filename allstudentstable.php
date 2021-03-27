<div class="card height-auto">
    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>All Students Data</h3>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table display data-table text-nowrap">
                <thead>
                    <tr>
                        <th>Roll</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Session</th>
                        <th>Year</th>
                        <!-- <th>Parents</th>
                        <th>Address</th> -->
                        <th>Date Of Birth</th>
                        <th>Phone</th>
                        <th>E-mail</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="studentData">
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "pundra_cse_dept";
                    require_once('./lib/application/databaseconfig.php');

                    $conn = connect_database($servername, $username, $password, $dbname);

                    $sql = "SELECT * FROM st_info ORDER BY id DESC";
                    $com_data = $conn->query($sql);
                    while ($st_data = $com_data->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $st_data['roll'] ?></td>
                            <td class="text-center">
                                <div style="height:30px;width:30px; border-radius:50%; overflow:hidden"><img src="./uploads/st_photo/<?php echo $st_data['profile_image']; ?>" alt="student"></div>
                            </td>
                            <td><?php echo $st_data["first_name"] . " " . $st_data["last_name"]; ?></td>
                            <td><?php echo $st_data['gender'] ?></td>
                            <td><?php echo $st_data['session'] ?></td>
                            <td><?php echo $st_data['year'] ?></td>
                            <!-- <td>Jack Sparrow </td>
                            <td>TA-107 Newyork</td> -->
                            <td><?php echo $st_data['birth_date'] ?></td>
                            <td><?php echo $st_data['phone'] ?></td>
                            <td><?php echo $st_data['email'] ?></td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        <!-- <span class="flaticon-more-button-of-three-dots"></span> -->
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="studentdetails.php?reg_id=<?php echo $st_data['registration_id']; ?>"><i class="fa fa-user text-dark-pastel-green"></i>View Profile</a>
                                        <a class="dropdown-item" href="updatestudentdata.php?roll=<?php echo $st_data["roll"] ?>"><i class="fa fa-cogs text-dark-pastel-green"></i>Edit</a>
                                        <p style="cursor:pointer" class="dropdown-item" href="#" onclick="delete_student(<?php echo $st_data['id']; ?>)"><i class="fa fa-trash text-orange-red text-dark-pastel-green"></i>Delete Student</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>