<?php
    $msg_voucheradd_container=["success"=>"","code_error"=>"","discount_error"=>"","min_order_error"=>"","datetime_error"=>"","account_id_error"=>""];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['voucher_account_select'])){
            $_SESSION['voucher_account_select']= $_POST['voucher_account_select'];
            if ($_SESSION['voucher_account_select'] == 'account_id') {
                $_SESSION['account_id_input'] = $_POST['account_id_input'] ?? '';
            } else {
                $_SESSION['account_id_input'] = ''; // Nếu chọn "Tất cả", xóa ID khách
            }
        }
        if(isset($_POST['voucher_type_select'])){
            $_SESSION['voucher_type_select']= $_POST['voucher_type_select'];
            $_SESSION['voucher_type_input']= $_POST['voucher_type_input']?? "";
        }
        if(isset($_POST['add_codevoucher_button'])){
            if($_SESSION['voucher_account_select']== 'account_id' && empty($_POST['account_id_input'])){
                $msg_voucheradd_container["account_id_error"]="Id khách không được trống";
            }elseif($_SESSION['voucher_account_select']== 'account_id' && !is_numeric($_POST['account_id_input'])){
                $msg_voucheradd_container["account_id_error"]="Id khách phải là số";
            }
            if(empty($_POST['voucher_type_input'])){
                $msg_voucheradd_container["discount_error"]="Giá trị giảm không được trống";
            }elseif(!is_numeric($_POST['voucher_type_input'])){
                $msg_voucheradd_container["discount_error"]="Giá trị giảm phải là số";
            }elseif($_SESSION['voucher_type_select']=='discount_percent' && $_POST['voucher_type_input']>= 100){
                $msg_voucheradd_container["discount_error"]="Không lớn hơn 100%";
            }
            if(empty($_POST['voucher_code'])){
                $msg_voucheradd_container["code_error"]="Mã khuyến mại không được trống";
            }if(empty($_POST['min_order_value'])){
                $msg_voucheradd_container["min_order_error"]="Đơn tối thiểu không được trống";
            }if(empty($_POST['expiration_date'])){
                $msg_voucheradd_container["datetime_error"]="Hạn sử dụng không được để trống";
            }
            if($msg_voucheradd_container["code_error"]=="" && $msg_voucheradd_container["discount_error"]=="" 
            && $msg_voucheradd_container["min_order_error"]=="" && $msg_voucheradd_container["account_id_error"]=="" 
            && $msg_voucheradd_container["datetime_error"]==""){
                $msg_voucheradd_container["success"]="Tạo mã thành công";
                $account_id = empty($_POST['account_id_input']) ? "NULL" : "'{$_POST['account_id_input']}'";

                $query = ($_SESSION['voucher_type_select'] == 'discount_amount') ?
                    "INSERT INTO voucher(voucher_code, discount_amount, min_order_value, expiration_date, account_id)
                    VALUES('{$_POST['voucher_code']}', '{$_POST['voucher_type_input']}', '{$_POST['min_order_value']}', '{$_POST['expiration_date']}', $account_id)"
                    :
                    "INSERT INTO voucher(voucher_code, discount_percent, min_order_value, expiration_date, account_id)
                    VALUES('{$_POST['voucher_code']}', '{$_POST['voucher_type_input']}', '{$_POST['min_order_value']}', '{$_POST['expiration_date']}', $account_id)";
                $conn->query($query)   ;          
            }   
        }
    }
    if(isset($_POST['add_voucher_button'])){
        $_SESSION['addvoucher_display']= "flex";
    }
    if(isset($_POST['cancel_voucher_button'])){
        $_SESSION['addvoucher_display']= "none";
    }
    $_SESSION['addvoucher_display']=$_SESSION['addvoucher_display']?? "none";
    $_SESSION['voucher_type_select']=$_SESSION['voucher_type_select']??'discount_amount';
    $_SESSION['voucher_account_select']= $_SESSION['voucher_account_select']??'all';
    $_SESSION['account_id_input']= $_SESSION['account_id_input']??'';
    $_SESSION['voucher_type_input']= $_SESSION['voucher_type_input']??'';

?>