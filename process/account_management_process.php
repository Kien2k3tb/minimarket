<?php 
// Lấy dữ liệu bảng
function getDataaccount($conn, $role){
    $result=$conn->query("SELECT a.account_id, a.username, a.password, a.name, a.account_phone, a.address, a.point, a.account_status, r.role_name 
        FROM account a 
        INNER JOIN role r ON a.account_id = r.account_id
        WHERE r.role_name = '$role'");
    return $result;
}  
// Thêm tài khoản
if(isset($_POST['add_account_button'])){
    $_SESSION['add_account']='flex';
}
if(isset($_POST['account_cancel_button'])){
    $_SESSION['add_account']='none';
}
$_SESSION['add_account']=$_SESSION['add_account']??'none';
$display_addAccount=$_SESSION['add_account'];
//Ẩn hiện mật khẩu
function showhidePassword($conn){
    if(isset($_POST['password_status'])){
        $account_id=$_POST['password_status']; 
        $_SESSION['password_status'][$account_id]=($_SESSION['password_status'][$account_id]=='hide')?'show':'hide';   
    }
}
showhidePassword($conn);
//Sửa-lưu-hủy mật khẩu
if(isset($_POST['password_fix_button'])){
    $account_id=$_POST['password_fix_button'];
    $_SESSION['password_set'][$account_id]='able'; 
}
$_SESSION['placeholder_newpassword']=$_SESSION['placeholder_newpassword']??"Nhập mật khẩu mới";
$_SESSION['input_color']=$_SESSION['input_color']??"black";
if(isset($_POST['password_save_button'])){
    $account_id=$_POST['password_save_button'];
    $new_password=$_POST['new_password'];
    if(strlen($new_password)<8){
        $_SESSION['placeholder_newpassword']="Tối thiểu 8 kí tự";
        $_SESSION['input_color']="red";
    }else{
        $conn->query("UPDATE account SET password='$new_password' WHERE account_id=$account_id ");
        $_SESSION['placeholder_newpassword']="Nhập mật khẩu mới";
        $_SESSION['input_color']="black";
        $_SESSION['password_set'][$account_id]='unable'; 
    }
}

if(isset($_POST['password_cancel_button'])){
    $account_id=$_POST['password_cancel_button'];
    $_SESSION['password_set'][$account_id]='unable'; 
}

// Mở-khóa tài khoản
function openlockAccount($conn){
    if(isset($_POST['account_status'])){
        $account_id=$_POST['account_status']; 
        $result=$conn->query("SELECT account_status FROM account WHERE account_id=$account_id");
        if($result->num_rows > 0){
            $row=$result->fetch_assoc();
            $new_status = ($row['account_status']=='Active') ? 'Inactive' : 'Active';
            $conn->query("UPDATE account SET account_status='$new_status' WHERE account_id=$account_id");
        }
    }
}
openlockAccount($conn);

?>