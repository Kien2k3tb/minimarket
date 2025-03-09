<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../assets/style.css?v=42">
    <?php include '../config/database.php'; ?>
    <?php include '../config/checkaccountID.php'?>
    <?php include '../process/setting_user_process.php'; ?>
</head>
<body class="page-index">
    <div class="container">
        <h1 class="title">Tài khoản</h1>
        <div class="content">
            <div class="box_container">
                <?php $result = $conn->query("SELECT username, password, name, account_phone, address, point, coin FROM account WHERE username = '$_SESSION[username]'");
                if ($row = $result->fetch_assoc()) {
                echo '<div class="box_set">
                    <form method="post">
                        <div class="setPassword_success">'.$setPasswordmsg['success'].'</div>
                        <div>
                            <span class="label">Tên tài khoản</span>
                            <span class="value">: '.$row['username'].'</span></div>   
                        <div>
                        <div>
                            <span class="label">Mật khẩu</span>
                            <span class="value">: ******** </span>
                            <button type="submit" name="password_set_button">Sửa</button>
                        </div>';
                    if($_SESSION['status_name'] == 'text') {
                        echo'
                        <div>
                            <span class="label">Tên</span>
                            <span class="value">: '.$row['name'].'</span>
                            <button type="submit" name="name_set_button">Sửa</button>
                        </div>';
                    }else{
                        echo'
                        <div>
                            <span class="label">Tên</span>
                            <span class="value">: <input type="text" name="name_set" value="'.$row['name'].'"></span>
                            <button type="submit" name="name_ok_button">OK</button>
                            <button type="submit" name="name_cancel_button">Hủy</button>
                        </div>';
                    }
                    if($_SESSION['status_account_phone'] == 'text') {
                        echo'
                        <div>
                            <span class="label">Số điện thoại</span>
                            <span class="value">: '.$row['account_phone'].'</span>
                            <button type="submit" name="account_phone_set_button">Sửa</button>
                        </div>';
                    }else{
                        echo'
                        <div>
                            <span class="label">Số điện thoại</span>
                            <span class="value">: <input type="text" name="account_phone_set" value="'.$row['account_phone'].'"></span>
                            <button type="submit" name="account_phone_ok_button">OK</button>
                            <button type="submit" name="account_phone_cancel_button">Hủy</button>
                        </div>';
                    }
                    if($_SESSION['status_address'] == 'text') {
                        echo'
                        <div>
                            <span class="label">Địa chỉ</span>
                            <span class="value">: '.$row['address'].'</span>
                            <button type="submit" name="address_set_button">Sửa</button> 
                        </div>';
                    }else{
                        echo'
                        <div>
                            <span class="label">Địa chỉ</span>
                            <span class="value"><textarea name="address_set">'.$row['address'].'</textarea></span>
                            <button type="submit" name="address_ok_button">OK</button>
                            <button type="submit" name="address_cancel_button">Hủy</button>
                            
                        </div>';
                    }
                        echo '
                        <div>
                            <span class="label">Số dư tài khoản</span>
                            <span class="value">: '.number_format($row['coin']).' VNĐ</span>
                            <button type="submit" name="deposit_button">Nạp</button>
                        </div>
                        <div>
                            <span class="label">Điểm mua sắm</span>
                            <span class="value">: '.number_format($row['point']).' điểm</span>
                        </div>
                </form>
                </div>';
                };?>
            </div>
            <div class="setPassword_container" style="display:<?php echo $setPassword_display ?>">
            <form method="post">
                <div>Mật khẩu cũ</div>
                <input type="text" name="password">
                <div class="setPassword_error"><?php echo $setPasswordmsg['password']?></div>
                <div>Mật khẩu mới</div>
                <input type="password" name="new_password">
                <div class="setPassword_error"><?php echo $setPasswordmsg['new_password']?></div>
                <div>Xác nhận mật khẩu</div>
                <input type="password" name="confirm_password">
                <div class="setPassword_error"><?php echo $setPasswordmsg['confirm_password']?></div>
                <div>
                    <button type="submit" name="password_ok_button">Lưu</button>
                    <button type="submit" name="password_cancel_button">Hủy</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <?php include '../includes/sidebar-user.php'; ?>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
