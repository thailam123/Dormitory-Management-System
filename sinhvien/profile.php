<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student' || !isset($_SESSION['student_id'])) {
    header("Location: ../login.php"); // Redirect to the main login page
    exit();
}

$student_id = $_SESSION['student_id'];
include '../CommonMethods/connection.php';

// Fetch student information
$sql = "SELECT s.*, r.R_Name, r.Num_of_Bed, r.Num_of_Table, f.Floor_Number, h.H_Name 
        FROM student s
        INNER JOIN room r ON s.R_ID = r.R_ID
        INNER JOIN floor f ON r.F_ID = f.F_ID
        INNER JOIN hall h ON f.H_ID = h.H_ID
        WHERE s.Stu_id = '$student_id'";

$result = mysqli_query($conn, $sql);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Student information not found.";
    exit();
}

$student = mysqli_fetch_assoc($result);

// Handle profile update
$profile_updated = false;
$edit_mode = false; // Flag for edit mode

if (isset($_POST['update_profile'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $update_sql = "UPDATE student SET 
                   Name = '$name', 
                   DOB = '$dob', 
                   Phone_number = '$phone_number', 
                   Email = '$email'
                   WHERE Stu_id = '$student_id'";

    if (mysqli_query($conn, $update_sql)) {
        $profile_updated = true;
        // Update session variable if email is changed
        if ($email != $student['Email']) {
            $_SESSION['username'] = $email;
        }
        // Refresh data after update
        $result = mysqli_query($conn, $sql);
        $student = mysqli_fetch_assoc($result);
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
} elseif (isset($_POST['edit_profile'])) {
    $edit_mode = true; // Enable edit mode
}

// Fetch messages and rent fee information
$messages_sql = "SELECT Messages, Name FROM message_table WHERE ID_student = '$student_id'";
$messages_result = mysqli_query($conn, $messages_sql);

$rent_sql = "SELECT rf.* 
             FROM rent_fee rf
             INNER JOIN room r ON rf.R_ID = r.R_ID
             INNER JOIN student s ON r.R_ID = s.R_ID
             WHERE s.Stu_id = '$student_id'";
$rent_result = mysqli_query($conn, $rent_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link rel="shortcut icon" href="https://juniv.edu/images/favicon.ico">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">

    <!-- Include your external CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h1>Thông tin cá nhân</h1>
        <div class="profile-container">
            <?php if ($profile_updated) : ?>
                <div class="success-message">Thông tin cá nhân đã được cập nhật thành công!</div>
            <?php endif; ?>

            <form method="post">
                <div class="info-grid">
                    <div class="info-section">
                        <h3>Thông tin sinh viên</h3>
                        <div class="form-group">
                            <label for="id">Mã số sinh viên:</label>
                            <input type="text" id="id" name="id" value="<?php echo $student['Stu_id']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="name">Họ và tên:</label>
                            <input type="text" id="name" name="name" value="<?php echo $student['Name']; ?>" <?php echo $edit_mode ? '' : 'disabled'; ?>>
                        </div>

                        <div class="form-group">
                            <label for="dob">Ngày sinh:</label>
                            <input type="date" id="dob" name="dob" value="<?php echo $student['DOB']; ?>" <?php echo $edit_mode ? '' : 'disabled'; ?>>
                        </div>

                        <div class="form-group">
                            <label for="gender">Giới tính:</label>
                            <input type="text" id="gender" name="gender" value="<?php echo ($student['Gender'] == 1) ? "Nam" : "Nữ"; ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Số điện thoại:</label>
                            <input type="tel" id="phone_number" name="phone_number" value="<?php echo $student['Phone_number']; ?>" <?php echo $edit_mode ? '' : 'disabled'; ?>>
                        </div>

                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" value="<?php echo $student['Email']; ?>" <?php echo $edit_mode ? '' : 'disabled'; ?>>
                        </div>
                    </div>

                    <!-- ... (Thông tin phòng - giữ nguyên) ... -->
                    <div class="info-section">
                        <h3>Thông tin phòng</h3>
                        <div class="form-group">
                            <label for="room_name">Tên phòng:</label>
                            <input type="text" id="room_name" name="room_name" value="<?php echo $student['R_Name']; ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="hall_name">Tòa nhà:</label>
                            <input type="text" id="hall_name" name="hall_name" value="<?php echo $student['H_Name']; ?>" disabled>
                        </div>

                        <div class="form-group">
                            <label for="floor_number">Tầng:</label>
                            <input type="text" id="floor_number" name="floor_number" value="<?php echo $student['Floor_Number']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="num_of_bed">Số giường:</label>
                            <input type="text" id="num_of_bed" name="num_of_bed" value="<?php echo $student['Num_of_Bed']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="num_of_table">Số bàn:</label>
                            <input type="text" id="num_of_table" name="num_of_table" value="<?php echo $student['Num_of_Table']; ?>" disabled>
                        </div>
                    </div>
                </div>

                <?php if (!$edit_mode) : ?>
                    <button type="submit" name="edit_profile" class="edit-button">Cập nhật thông tin</button>
                <?php else : ?>
                    <button type="submit" name="update_profile" class="update-button">Lưu thay đổi</button>
                <?php endif; ?>
                <button type="button" id="change-password-btn" class="change-password-button">Đổi Mật Khẩu</button>
            </form>

            <!-- ... (Messages Section and Rent Fee Section - giữ nguyên) ... -->
            <div class="messages-section">
                <h3>Tin nhắn đã gửi</h3>
                <?php if (mysqli_num_rows($messages_result) > 0) : ?>
                    <?php while ($message = mysqli_fetch_assoc($messages_result)) : ?>
                        <div class="message-item">
                            <p>
                                <?php echo $message['Messages']; ?>
                            </p>
                            <p style="font-size: smaller; text-align: right; margin-top: 5px;">
                                <em>- <?php echo $message['Name']; ?></em>
                            </p>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>Không có tin nhắn nào.</p>
                <?php endif; ?>
            </div>

            <!-- Rent Fee Section -->
            <div class="rent-section">
                <h3>Thông tin hóa đơn</h3>
                <?php if (mysqli_num_rows($rent_result) > 0) : ?>
                    <table class="rent-table">
                        <thead>
                            <tr>
                                <th>Kỳ Thanh Toán</th>
                                <th>Tiền Phòng</th>
                                <th>Tiền Điện</th>
                                <th>Tiền Internet</th>
                                <th>Tiền Nước</th>
                                <th>Trạng Thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($rent = mysqli_fetch_assoc($rent_result)) : ?>
                                <tr>
                                    <td>
                                        <?php echo $rent['Period']; ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($rent['Room_Bill']); ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($rent['Elec_Bill']); ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($rent['Internet_Bill']); ?>
                                    </td>
                                    <td>
                                        <?php echo number_format($rent['Water_Bill']); ?>
                                    </td>
                                    <td>
                                        <?php echo ($rent['Status'] == 1) ? "Đã thanh toán" : "Chưa thanh toán"; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>Không có thông tin hóa đơn.</p>
                <?php endif; ?>
            </div>

            <!-- Change Password Modal -->
            <div id="change-password-modal" class="modal">
                <div class="modal-content">
                    <span class="close-button">×</span>
                    <h2>Đổi Mật Khẩu</h2>
                    <form id="change-password-form" method="post">
                        <div class="form-group">
                            <label for="old_password">Mật khẩu cũ:</label>
                            <input type="password" id="old_password" name="old_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Mật khẩu mới:</label>
                            <input type="password" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_new_password">Xác nhận mật khẩu mới:</label>
                            <input type="password" id="confirm_new_password" name="confirm_new_password" required>
                        </div>
                        <button type="submit" name="change_password" class="change-password-button">Đổi Mật Khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("change-password-modal");

        // Get the button that opens the modal
        var btn = document.getElementById("change-password-btn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close-button")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        document.getElementById('change-password-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Get form data
            var formData = new FormData(this);
            formData.append('change_password', 'true');

            // Send AJAX request to change_password.php
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'change_password.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Handle response
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert('Mật khẩu đã được thay đổi thành công!');
                        modal.style.display = "none"; // Close the modal
                    } else {
                        alert(response.message); // Display error message
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            };
            xhr.send(formData);
        });
    </script>
</body>

</html>