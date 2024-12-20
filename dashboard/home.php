<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dormitory Management System</title>
    <link rel="shortcut icon" href="https://juniv.edu/images/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- Inline CSS Styles -->
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-image: url('../images/hust_background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            padding: 0;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        .slidebar {
            width: 20%;
            height: 100%;
            position: fixed;
            background-color: #2c3e50;
            padding-top: 20px;
            top: 0;
            left: 0;
            z-index: 100;
        }

        .slidebar header {
            padding: 30px 10px;
            text-align: center;
            font-size: 30px;
            font-weight: bolder;
            color: #ecf0f1;
        }

        .slidebar header span {
            font-size: 50px;
            color: #1abc9c;
        }

        .slidebar ul {
            padding: 0;
            list-style: none;
            margin: 0;
        }

        .slidebar ul li {
            padding: 10px;
            font-size: 18px;
            font-weight: bolder;
            color: #ecf0f1;
            margin-bottom: 10px;
        }

        .slidebar ul li:hover {
            transform: scale(1.05);
            transition: 0.3s;
            background-color: #1abc9c;
            margin-right: 20px;
            border-radius: 10px;
        }

        .slidebar ul li a {
            text-decoration: none;
            color: inherit;
        }

        /* Main Part */
        .mainpart {
            margin-left: 20%;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .infocard {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            text-align: center;
        }

        .cardspecific {
            width: 250px;
            height: 150px;
            background-color: #ecf0f1;
            border-radius: 10px;
            font-weight: bolder;
            color: #34495e;
            font-size: 20px;
            padding: 20px;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .cardspecific:hover {
            transform: scale(1.05);
            background: #16a085;
            color: white;
        }

        .number {
            font-size: 25px;
            color: #2980b9;
        }

        .logout-container {
            position: absolute;
            bottom: 70px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            text-align: center;
        }

        /* Logout Button */
        .logout {
            font-family: 'Roboto', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: #fff;
            background-color: #8e44ad;
            padding: 15px 30px;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            display: inline-block;
        }

        /* Hover effect */
        .logout:hover {
            transform: scale(1.1);
            color: #fff;
            background-color: #9b59b6;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
        }

        /* Active effect */
        .logout:active {
            transform: scale(1.05);
        }

        /* Header Title */
        #hall {
            font-size: 45px;
            color: #16a085;
            margin-bottom: 30px;
        }

        .status-text {
            font-size: 18px;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="slidebar">
        <header>
            <span><i class="fas fa-users-cog"></i></span>
            ADMIN
        </header>
        <ul>
            <li><a href="../Hall/DispHall.php"><i class="fas fa-building"></i> Tòa nhà</a></li>
            <li><a href="../Rent_fee/DispRentFee.php"><i class="fas fa-wallet"></i> Chi phí</a></li>
            <li><a href="../Student/DispStudent.php"><i class="fas fa-book-reader"></i> Sinh viên</a></li>
            <li><a href="../Floor/DispFloor.php"><i class="fas fa-layer-group"></i> Tầng</a></li>
            <li><a href="../Room/DispRoom.php"><i class="fa fa-bed"></i> Phòng</a></li>
            <li><a href="../FacilitiesProblem/DispFP.php"><i class="fas fa-exclamation-triangle"></i> Vấn đề về cơ sở vật chất</a></li>
            <li><a href="../message/DispMessage.php"><i class="fas fa-envelope-open"></i> Messages</a></li>
        </ul>
        <div class="logout-container">
            <a style="text-decoration: none;" href="../index.php">
                <div class="logout">Đăng xuất</div>
            </a>
        </div>
    </div>

    <!-- Main Part -->
    <div class="mainpart">
        <div class="infocard">
            <!-- Tòa nhà -->
            <a href="../Hall/DispHall.php" style="text-decoration:none">
                <div class="cardspecific">
                    Tòa nhà
                    <div class="number">
                        <?php
                        include '../CommonMethods/connection.php';
                        $sql_opened = "SELECT count(*) as total_opened FROM hall WHERE Status=1";
                        $result_opened = mysqli_query($conn, $sql_opened);
                        $data_opened = mysqli_fetch_assoc($result_opened);
                        $opened = $data_opened['total_opened'];
                        echo "<span class='status-text'>Đang mở:</span> " . $opened . "<br>";

                        $sql_closed = "SELECT count(*) as total_closed FROM hall WHERE Status=0";
                        $result_closed = mysqli_query($conn, $sql_closed);
                        $data_closed = mysqli_fetch_assoc($result_closed);
                        $closed = $data_closed['total_closed'];
                        echo "<span class='status-text'>Đóng cửa:</span> " . $closed . "<br>";
                        ?>
                    </div>
                </div>
            </a>

            <!-- Tầng -->
            <a href="../Floor/DispFloor.php" style="text-decoration:none">
                <div class="cardspecific">
                    Tầng
                    <div class="number">
                        <?php
                        include '../CommonMethods/connection.php';
                        $sql = "SELECT count(*) as total FROM floor";
                        $result = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_assoc($result);
                        echo $data['total'];
                        ?>
                    </div>
                </div>
            </a>

            <!-- Phòng -->
            <a href="../Room/DispRoom.php" style="text-decoration:none">
                <div class="cardspecific">
                    Phòng
                    <div class="number">
                        <?php
                        include '../CommonMethods/connection.php';

                        $sql_male = "SELECT count(*) as total_male FROM room WHERE Gender = 1";
                        $result_male = mysqli_query($conn, $sql_male);
                        $data_male = mysqli_fetch_assoc($result_male);
                        $male_rooms = $data_male['total_male'];
                        echo "<span class='status-text'>Nam: </span> " . $male_rooms . "<br>";

                        $sql_female = "SELECT count(*) as total_female FROM room WHERE Gender = 'Female'";
                        $result_female = mysqli_query($conn, $sql_female);
                        $data_female = mysqli_fetch_assoc($result_female);
                        $female_rooms = $data_female['total_female'];
                        echo "<span class='status-text'>Nữ: </span> " . $female_rooms . "<br>";
                        ?>
                    </div>
                </div>
            </a>

            <!-- Chi phí -->
            <a href="../Rent_fee/DispRentFee.php" style="text-decoration:none">
                <div class="cardspecific">
                    Chi phí
                    <div class="number">
                        <?php
                        $sql_uncompleted = "SELECT count(*) as total_uncompleted FROM rent_fee WHERE Status=0";
                        $result_uncompleted = mysqli_query($conn, $sql_uncompleted);
                        $data_uncompleted = mysqli_fetch_assoc($result_uncompleted);
                        $uncompleted = $data_uncompleted['total_uncompleted'];
                        echo "<span class='status-text'>Chưa hoàn thành:</span> " . $uncompleted . "<br>";

                        $sql_completed = "SELECT count(*) as total_completed FROM rent_fee WHERE Status=1";
                        $result_completed = mysqli_query($conn, $sql_completed);
                        $data_completed = mysqli_fetch_assoc($result_completed);
                        $completed = $data_completed['total_completed'];
                        echo "<span class='status-text'>Đã hoàn thành:</span> " . $completed . "<br>";
                        ?>
                    </div>
                </div>
            </a>

            <!-- Sinh viên -->
            <a href="../Student/DispStudent.php" style="text-decoration:none">
                <div class="cardspecific">
                    Sinh viên
                    <div class="number">
                        <?php
                        include '../CommonMethods/connection.php';
                        $sql = "SELECT count(*) as total FROM student";
                        $result = mysqli_query($conn, $sql);
                        $data = mysqli_fetch_assoc($result);
                        echo $data['total'];
                        ?>
                    </div>
                </div>
            </a>

            <!-- Vấn đề về cơ sở vật chất -->
            <a href="../FacilitiesProblem/DispFP.php" style="text-decoration:none">
                <div class="cardspecific">
                    Vấn đề về cơ sở vật chất
                    <div class="number">
                        <?php
                        include '../CommonMethods/connection.php';
                        $sql_uncompleted = "SELECT count(*) as total_uncompleted FROM facility_problem WHERE Status=0";
                        $result_uncompleted = mysqli_query($conn, $sql_uncompleted);
                        $data_uncompleted = mysqli_fetch_assoc($result_uncompleted);
                        $uncompleted = $data_uncompleted['total_uncompleted'];
                        echo "<span class='status-text'>Chưa xử lý:</span> " . $uncompleted . "<br>";

                        $sql_completed = "SELECT count(*) as total_completed FROM facility_problem WHERE Status=1";
                        $result_completed = mysqli_query($conn, $sql_completed);
                        $data_completed = mysqli_fetch_assoc($result_completed);
                        $completed = $data_completed['total_completed'];
                        echo "<span class='status-text'>Đã xử lý:</span> " . $completed . "<br>";
                        ?>
                    </div>
                </div>
            </a>
        </div>
    </div>
</body>

</html>