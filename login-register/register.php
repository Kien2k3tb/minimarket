<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng kí</title>
    <link rel="stylesheet" href="../assets/style.css?v=1">
    <?php include '../config/database.php' ?>
    <?php include '../process/login-register_process.php' ?>
</head>
<body  class="page-auth">
    <div class="box-register">
        <div class="auth-header"><h1>Đăng kí</h1></div>
        <form class="auth-form" method="post">
            <input type="text" name="register_username" placeholder="Tên đăng nhập" >
            <div class="error_auth"><?php echo $msgRegis["username"] ?></div>
            <input type="password" name="register_password" placeholder="Mật khẩu" >
            <div class="error_auth"><?php echo $msgRegis["password"] ?></div>
            <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" >
            <div class="error_auth"><?php echo $msgRegis["confirm_password"] ?></div>
            <input name="name" type="text" placeholder="Nhập tên">
            <div class="error_auth"><?php echo $msgRegis["name"] ?></div>
            <input name="account_phone" type="text" placeholder="Nhập số điện thoại">
            <div class="error_auth"><?php echo $msgRegis["account_phone"] ?></div>
            <textarea name="address" placeholder="Nhập địa chỉ" rows="2"></textarea>
            <div class="error_auth"><?php echo $msgRegis["address"] ?></div>
            <button type="submit" name="register_button">Đăng kí</button>
        </form>
        <div class="auth-links">
            <div><a href="../login-register/login.php">Đăng nhập</a></div>
        </div>
    </div>
</body>
</html>
