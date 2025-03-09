<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../assets/style.css?v=16">
    <?php include '../config/database.php'?>
    <?php include '../process/account_management_process.php' ?>
    <?php include '../process/login-register_process.php' ?>
    <style>
        .new_password::placeholder {
            color: <?php echo $_SESSION['input_color'] ?>;
        }
    </style>
</head>
<body class="page-index">
    <div class="container">
        <h1 class="title">Quản lí Tài khoản</h1>
        <div class="content">
        <form method="post" action="">
            <button type="submit" class="add_button" name="add_account_button">Thêm tài khoản</button>
        </form>
        <?php 
        echo'
        <div class="add_container" style="display:'.$display_addAccount.'">
        <form class="add" method="post" action="">
                <div class="box-title">Nhập thông tin</div>
                <div class="success_add">'.$msgRegisAdd["success"].'</div>
                <input name="register_username" type="text" placeholder="Nhập tên tài khoản">
                <div class="error_add">'.$msgRegisAdd["username"].'</div>
                <input name="register_password" type="password" placeholder="Nhập mật khẩu">
                <div class="error_add">'.$msgRegisAdd["password"].'</div>
                <input name="confirm_password" type="password" placeholder="Nhập lại mật khẩu">
                <div class="error_add">'.$msgRegisAdd["confirm_password"].'</div>
                <input name="name" type="text" placeholder="Nhập tên">
                <div class="error_add">'.$msgRegisAdd["name"].'</div>
                <input name="account_phone" type="text" placeholder="Nhập số điện thoại">
                <div class="error_add">'.$msgRegisAdd["account_phone"].'</div>
                <textarea name="address" placeholder="Nhập địa chỉ" rows="2"></textarea>
                <div class="error_add">'.$msgRegisAdd["address"].'</div>
                <select name="role" >
                    <option value="customer">Khách hàng</option>
                    <option value="staff">Nhân viên</option>     
                </select>
                <button class="set_btn" name="account_save_button">Lưu</button>
                <button class="set_btn" name="account_cancel_button">Thoát</button>
                
            </form></div>';
            function table($conn, $role){
                $result = getDataaccount($conn, $role,$_SESSION['placeholder_newpassword'],$_SESSION['input_color']);
                echo '
                <table class="data_table">
                    <tr>
                        <td style="width:50px">ID</td>
                        <td style="width:150px">Tài khoản</td>
                        <td style="width:250px">Mật khẩu</td>
                        <td style="width:80px">Tên</td>
                        <td style="width:150px">Số điện thoại</td>
                        <td>Địa chỉ</td>
                        <td style="width:80px">Điểm</td>
                        <td style="width:100px">Trạng thái</td>
                    </tr>';
                if ($result->num_rows > 0) {   
                    while ($row = $result->fetch_assoc()) {
                        $_SESSION['password_status'][$row["account_id"]]=$_SESSION['password_status'][$row["account_id"]] ?? 'hide'; 
                        $_SESSION['password_set'][$row["account_id"]]=$_SESSION['password_set'][$row["account_id"]] ?? 'unable'; 
                        echo '<form method="post" action=""><tr>
                            <td>'.$row["account_id"].'</td>
                            <td>'.$row["username"].'</td>
                            <td>';  
                            if($_SESSION['password_status'][$row["account_id"]] == 'hide'){
                                echo'<span class="td_container">
                                <span>******</span>
                                <span>
                                    <button type="submit" class="btn" name="password_status" value="'.$row["account_id"].'">Xem</button>
                                    <button type="submit" class="btn" name="password_fix_button" value="'.$row["account_id"].'">Sửa</button>
                                </span></span>' ;            
                            }else{ 
                                echo'<span class="td_container">
                                <span>'.$row["password"].'</span>
                                <span>
                                    <button type="submit" class="btn" name="password_status" value="'.$row["account_id"].'">Ẩn</button>
                                    <button type="submit" class="btn" name="password_fix_button" value="'.$row["account_id"].'">Sửa</button>
                                </span></span>';      
                            }
                            if($_SESSION['password_set'][$row["account_id"]]=='able'){
                                echo'<span class="td_container">
                                <input name="new_password" class="new_password" placeholder="'.$_SESSION['placeholder_newpassword'].'">
                                <span>
                                    <button type="submit" class="btn" name="password_save_button" value="'.$row["account_id"].'">Lưu</button>
                                    <button type="submit" class="btn" name="password_cancel_button" value="'.$row["account_id"].'">Hủy</button>
                                </span></span>';
                            }
                            echo '</td>
                            <td>'.$row["name"].'</td>
                            <td>'.$row["account_phone"].'</td>
                            <td>'.$row["address"].'</td>
                            <td>'.$row["point"].'</td>
                            <td><span class="td_container">'.$row["account_status"];
                            if($row["account_status"]== "Active"){
                                echo'<button type="submit" class="btn" name="account_status" value="'.$row["account_id"].'">Khóa</button>';
                            }else{
                                echo'<button type="submit" class="btn" name="account_status" value="'.$row["account_id"].'">Mở</button>';
                            }
                            echo'</span></td>
                        </tr></form>';
                    }
                }else {
                    echo '<tr><td colspan="8">Không có ai.</td></tr>';
                }
                echo'</table>';

            }?>
            <?php 
                echo '<h3>Nhân viên</h3>';
                table($conn,"staff",$_SESSION['placeholder_newpassword'],$_SESSION['input_color']);
                echo '<h3>Khách hàng</h3>';
                table($conn,"customer",$_SESSION['placeholder_newpassword'],$_SESSION['input_color']) ;
                 
            ?>
            
        </div>
        </div>
    </div>
    <?php include '../includes/sidebar-admin.php'; ?>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
