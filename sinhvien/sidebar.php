<!-- sidebar.php -->
<div class="sidebar">
    <header>
        <span><i class="fas fa-user-graduate"></i></span>
        SINH VIÊN
    </header>
    <ul>
        <li <?php if (basename($_SERVER['PHP_SELF']) == 'login.php') echo 'class="active"'; ?>><a href="login.php"><i class="fas fa-home"></i> Trang chủ</a></li>
        <li <?php if (basename($_SERVER['PHP_SELF']) == 'profile.php') echo 'class="active"'; ?>><a href="profile.php"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
        <li <?php if (basename($_SERVER['PHP_SELF']) == 'view_bill.php') echo 'class="active"'; ?>><a href="view_bill.php"><i class="fas fa-file-invoice-dollar"></i> Xem chi phí</a></li>
        <li <?php if (basename($_SERVER['PHP_SELF']) == 'send_message.php') echo 'class="active"'; ?>><a href="send_message.php"><i class="fas fa-envelope"></i> Gửi tin nhắn</a></li>
        <li <?php if (basename($_SERVER['PHP_SELF']) == 'report_issue.php') echo 'class="active"'; ?>><a href="report_issue.php"><i class="fas fa-exclamation-triangle"></i> Báo cáo vấn đề</a></li>
        <li <?php if (basename($_SERVER['PHP_SELF']) == 'change_password.php') echo 'class="active"'; ?>><a href="change_password.php"><i class="fas fa-key"></i> Đổi mật khẩu</a></li>
    </ul>
    <div class="logout-container">
        <a href="logout.php" class="logout">Đăng xuất</a>
    </div>
</div>