<?php
    $order_status = [
        "pending" => "Đang chờ",
        "delivered" => "Đã giao",
        "completed" => "Hoàn thành",
        "canceled" => "Hủy đơn"
    ];
 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['order_status_select']) ){
            $conn->query("UPDATE order_purchase SET order_status= '{$_POST['order_status_select']}' where order_id = '{$_POST['order_id']}'");
            $_SESSION['order_status_select'][$_POST['order_id']]=$_POST['order_status_select'];
            if($_POST['order_status_select']=="completed"){
                $_SESSION['status_selectdisplay'][$_POST['order_id']]='none';
                $conn->query("UPDATE account SET point= '{$_POST['total_amount']}' where account_id = '{$_POST['account_id']}'");
            }
        }
}
 

?>