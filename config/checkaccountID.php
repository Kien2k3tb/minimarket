<?php
 // Kiểm tra nếu người dùng đã đăng nhập và đang ở trang đăng nhập
 if (!isset($_SESSION['account_id'])) {
    // Nếu đã đăng nhập và đang ở trang đăng nhập, chuyển hướng tới trang dashboard
    header("Location: ../login-register/login.php");
    exit();
}
?>