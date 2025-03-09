<?php  
    $_SESSION['invoice'] = $_SESSION['invoice']?? [];
    $_SESSION['detail_order_id']=$_SESSION['detail_order_id']??[];
    //Xóa sản phẩm
    if(isset($_POST['delete_product_button'])){
        foreach($_SESSION['invoice'] as $index => $key){
            if($key['product_name'] === $_POST['delete_product_button']){
                unset($_SESSION['invoice'][$index]);
            }
        }
        $_SESSION['invoice'] = array_values($_SESSION['invoice']);
    }
    // Thay đổi số lượng
    if(isset($_POST['quantity_input'])){
        $_SESSION['cartproduct_quantity'] = $_POST['quantity_input']??"1";
        foreach($_SESSION['invoice'] as $index => $key){
            if($_SESSION['invoice'][$index]['product_id']==$_POST['product_id']){
                $_SESSION['invoice'][$index]['quantity']=$_POST['quantity_input'];
            }
            
        }
    }
    // Tính tổng hóa đơn
    $invoice_initial=0;
    foreach($_SESSION['invoice'] as $index => $key){
        $invoice_initial+=((int)$key['price'])* $key['quantity'];
    }
    // nhập code
    $invoice_discount=0;
    if(isset($_POST['vouchercode'])){
        $_SESSION['vouchercode_input'] = $_POST['vouchercode']??"";
        $result = $conn->query("SELECT voucher_id,voucher_code,discount_amount, discount_percent,voucher_status, account_id from voucher where  voucher_code = '{$_POST['vouchercode']}'");
        if($row = $result->fetch_assoc()){
            if($row['voucher_status']=='Active') {
                if($row['account_id']==$_SESSION['account_id']||$row['account_id']==""){
                    $invoice_discount = ($row['discount_amount']== NULL) 
                    ?
                    $invoice_initial*$row['discount_percent']/100 
                    :
                    $row['discount_amount'];
                    $conn->query("UPDATE voucher SET voucher_status ='Used' WHERE voucher_id = '{$row['voucher_id']}'");
                }
            }
        }else{
            $voucher_code_error="Mã không hợp lệ";
        }
    }
    $invoice_total=$invoice_initial-$invoice_discount;
    // Thanh toán
    if(isset($_POST['cart_container_pay_button'])){
        if($_SESSION['invoice']!=[]){
            $account_id=(int)$_SESSION['account_id'];
            $conn->query("INSERT INTO order_purchase(account_id, total_amount, order_status) 
            VALUES ($account_id, $invoice_total, 'pending')");
            $order_id = $conn->insert_id; 
            foreach($_SESSION['invoice'] as $index => $key){
                $product_id=(int)$key['product_id'];
                $quantity=(int)$key['quantity'];
                $price=(int)$key['price'];
                $conn->query("INSERT INTO order_detail(order_id, product_id, quantity, price) 
                VALUES ($order_id, $product_id, $quantity, $price)");
            }
            unset($_SESSION['invoice']);
        }
    }
    // Hiển thị chi tiết đơn hàng
    if (isset($_POST['hideallDetail_display_button'])) {
        foreach ($_SESSION['detail_order_id'] as $key => $value) {
            $_SESSION['detail_order_id'][$key] = "none";
        }
    }
    if (isset($_POST['showallDetail_display_button'])) {
        foreach ($_SESSION['detail_order_id'] as $key => $value) {
            $_SESSION['detail_order_id'][$key] = "flex";
        }
    }
    
    if( isset($_POST['viewDetail_display_button'])){
        $order_id=$_POST['viewDetail_display_button'];
        $_SESSION['detail_order_id'][$order_id]=($_SESSION['detail_order_id'][$order_id]=="flex")?"none":"flex";
    }
    $voucher_code_error=$voucher_code_error??"";
    $_SESSION['vouchercode_input'] =$_SESSION['vouchercode_input'] ?? "";
    $_SESSION['cartproduct_quantity'] = $_SESSION['cartproduct_quantity'] ?? "1"
?>