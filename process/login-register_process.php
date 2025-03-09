
<!-- login -->
<?php 
function login($conn){
    $errorLogin=["password" => "", "status" => ""];
    if (isset($_POST['button_login'])) {
        $username = $_POST['username_login'];
        $password = $_POST['password_login'];
        $result = $conn->query(
            "SELECT a.account_id, a.password, a.account_status, r.role_name 
            FROM account a INNER JOIN role r 
            ON a.account_id = r .account_id
            WHERE username = '$username'");
        if ($row = $result->fetch_assoc()) {
            if ($password == $row["password"]) { 
                $_SESSION["username"] = $username;
                $_SESSION["account_id"] = $row["account_id"];
                if($row["account_status"] == "Active"){
                    if($row["role_name"] == "admin"){
                        header("Location: ../admin/product-management.php");
                        exit;
                    }if($row["role_name"] == "customer"){
                        header("Location: ../user/product_user.php");
                        exit;
                    }
                }else{
                    $errorLogin["status"]="Tài khoản của bạn bị khóa";
                }
            }else{
                $errorLogin["password"]="Sai mật khẩu";
            }
        }else{
            $errorLogin["status"]="Không tìm thấy tài khoản";
        }
    }
    return $errorLogin;
}
$errorLogin = login($conn);
// Đăng kí
function register($conn, $register_button){
    $msgRegis=["username" => "", "password" => "","confirm_password" => "","name" => "","account_phone" => "","address" => "", "success" => ""];
    if (isset($_POST[$register_button])) {
        $username_register = $_POST['register_username'];
        $password_register = trim($_POST['register_password']);
        $password_confirm = $_POST['confirm_password'];
        $name =  $_POST['name'];
        $account_phone = $_POST['account_phone'];
        $address = $_POST['address'];
        $role= $_POST['role'] ?? 'customer';
        $check_username = $conn->query("SELECT username FROM account WHERE username = '$username_register'");
        if($check_username->num_rows > 0 ){
            $msgRegis["username"]="Tên tài khoản đã tồn tại";
        }if ($password_register != $password_confirm) {
            $msgRegis["password"]="Hai mật khẩu không khớp";
        }if(strlen($password_register)<8){
            $msgRegis["password"]="Mật khẩu phải có ít nhất 8 kí tự";
        }if (empty($username_register)) {
            $msgRegis["username"] = "Tên tài khoản không được để trống";
        }if (empty($password_register)) {
            $msgRegis["password"] = "Mật khẩu không được để trống";
        }if (empty($password_confirm)) {
            $msgRegis["confirm_password"] = "Xác nhận mật khẩu không được để trống";
        }if (empty($name)) {
            $msgRegis["name"] = "Tên không được để trống";
        }if (empty($account_phone)) {
            $msgRegis["account_phone"] = "Số điện thoại không được để trống";
        }if (empty($address)) {
            $msgRegis["address"] = "Địa chỉ không được để trống";
        }
        if($msgRegis["username"]=="" && $msgRegis["password"]=="" && $msgRegis["confirm_password"]=="" && $msgRegis["name"]=="" && $msgRegis[ "account_phone"]=="" && $msgRegis["address"]==""){
            $conn->query("INSERT INTO account(username, password, point, name, account_phone, address) 
            VALUES ('$username_register', '$password_register', 0, '$name', '$account_phone', '$address')");
            $account_id = $conn->insert_id; 
            $conn->query($sql2 = "INSERT INTO role(role_name,  account_id) VALUES ('$role', $account_id)");
            $msgRegis["success"]="Tạo tài khoản thành công";
            if($register_button=='register_button'){
                $_SESSION["username"] = $username_register;
                $_SESSION["account_id"] = $account_id ;
                header("Location: ../user/product_user.php");
                exit;
            }         
        }    
    }
    return $msgRegis;
}  
$msgRegis=register($conn,'register_button');
$msgRegisAdd=register($conn,'account_save_button')
?>