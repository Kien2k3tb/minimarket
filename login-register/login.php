<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="../assets/style.css?v=1">
    <?php include '../config/database.php' ?>
    <?php include '../process/login-register_process.php' ?>
</head>
<body class="page-auth">
    <div class="box-login">
        <div class="auth-header"><h1>Đăng Nhập</h1></div>
        <form class="auth-form" method="post">
            <input type="text" name="username_login" placeholder="Tên đăng nhập">
            <div class="error_auth"><?php echo $errorLogin["status"]??"" ?></div>
            <input type="password" name="password_login" placeholder="Mật khẩu" >
            <div class="error_auth"><?php echo $errorLogin["password"]??"" ?></div>
            <button type="submit" name="button_login">Đăng nhập</button>
        </form>
        <div class="auth-links">
            <div><a href="#">Quên mật khẩu</a></div>
            <div class="regis_button"><a href="../login-register/register.php">Đăng kí</a></div>
        </div>
    </div>

</body>
</html>