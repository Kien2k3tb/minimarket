<?php 
    // Sửa thông tin
    $status = ['status_name','status_account_phone','status_address'];
    $input_set=['name_set','account_phone_set','address_set'];
    $set_button = ['name_set_button','account_phone_set_button','address_set_button'];
    $ok_button = ['name_ok_button','account_phone_ok_button','address_ok_button'];
    $cancel_button = ['name_cancel_button','account_phone_cancel_button','address_cancel_button'];
    $field = [
        'name'=>[
            'status'=>'status_name',
            'input'=>'name_set',
            'set_button'=>'name_set_button',
            'ok_button'=>'name_ok_button',
            'cancel_button'=>'name_cancel_button',
        ],
        'account_phone'=>[
            'status'=>'status_account_phone',
            'input'=>'account_phone_set',
            'set_button'=>'account_phone_set_button',
            'ok_button'=>'account_phone_ok_button',
            'cancel_button'=>'account_phone_cancel_button',
        ],
        'address'=>[
            'status'=>'status_address',
            'input'=>'address_set',
            'set_button'=>'address_set_button',
            'ok_button'=>'address_ok_button',
            'cancel_button'=>'address_cancel_button',
        ],
    ];
    foreach ($field as $column => $data) {
        $value_status=$data['status'];
        $value_input_set=$data['input'];
        $value_set_button=$data['set_button'];
        $value_ok_button=$data['ok_button'];
        $value_cancel_button=$data['cancel_button'];
        // Set session
        $_SESSION[$value_status] = "text" ;      
        // Sửa thông tin
        if (isset($_POST[$value_set_button])) {
            $_SESSION[$value_status] = ($_SESSION[$value_status] == "text") ? "input" : "text";
        }
        if (isset($_POST[$value_ok_button])) {
            $conn->query("UPDATE account SET $column = '$_POST[$value_input_set]' WHERE username = '{$_SESSION['username']}' ");
            $_SESSION[$value_status] = "text";
        }
        if (isset($_POST[$value_cancel_button])) {
            $_SESSION[$value_status] = "text";
        } 
    }
    // Sửa mật khẩu
    $_SESSION['setPassword'] = "none";
    $setPasswordmsg=["success"=>"", "password"=>"", "new_password"=>"","confirm_password"=>""];
    if (isset($_POST['password_set_button'])) {
        $_SESSION['setPassword'] = "flex";
    }
    if (isset($_POST['password_ok_button'])) {
        $result=$conn->query("SELECT password FROM account WHERE username='{$_SESSION['username']}'");
        if($row=$result->fetch_assoc()){
            if($_POST['password']!=$row['password']){
                $setPasswordmsg['password']="Sai mật khẩu";
            }
            if(strlen($_POST['new_password'])<8){
                $setPasswordmsg['new_password']="Mật khẩu mới ít nhất 8 kí tự";
            }
            if(!$_POST['password']){
                $setPasswordmsg['password']="Không được để trống";
            }
            if(!$_POST['new_password']){
                $setPasswordmsg['new_password']="Không được để trống";
            }
            if(!$_POST['confirm_password']){
                $setPasswordmsg['confirm_password']="Không được để trống";
            }
            if($_POST['new_password']!=$_POST['confirm_password']){
                $setPasswordmsg['new_password']="Hai mật khẩu không trùng khớp";
            }
            if($setPasswordmsg["password"]=="" && $setPasswordmsg["new_password"]=="" && $setPasswordmsg["confirm_password"]==""){
                $conn->query("UPDATE account SET password = '{$_POST['new_password']}' WHERE username='{$_SESSION['username']}'");
                $setPasswordmsg['success']="Thay đổi mật khẩu thành công";
                $_SESSION['setPassword'] = "none";
            }
        }
    }
    if (isset($_POST['password_cancel_button'])) {
        $_SESSION['setPassword'] = "none";
    }
    $setPassword_display=($_SESSION['setPassword']=='flex')?'flex':'none';
    ?>
    