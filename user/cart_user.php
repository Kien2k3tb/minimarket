<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../assets/style.css?v=49">
    <?php include '../config/database.php'; ?>
    <?php include '../config/checkaccountID.php'?>
    <?php include '../process/cart_user_process.php'; ?>
</head>
<body class="page-index">
    <div class="container">
        <h1 class="title">MiniMarket</h1>
        <div class="content">
            <div class="cart_container">
                <form method="POST" id="cartForm">
                    <?php 
                        echo'<div class="label">Đơn hàng: </div>';
                        if (!empty($_SESSION['invoice'])) {
                            foreach ($_SESSION['invoice'] as $index => $key) {
                                echo '
                                <div class="cart_product" >
                                    <span class="cart_product_name">Sản phẩm: '.$key['product_name'].'</span>  
                                    <span class="price">Giá:'.number_format($key['price']).'VNĐ</span> 
                                    <span>Số lượng<span>
                                    <span class="quantity"><input type="number" name="quantity_input"  value="'.$_SESSION['cartproduct_quantity'].'" onchange="this.form.submit();"></span>
                                    <input type="text" name="product_id"  value="'.$key['product_id'].'">
                                    <span class="delete_product"><button type="submit" value="'.$key['product_name'].'" name="delete_product_button">Xóa</button></span>
                                </div>';
                            }
                            echo '
                                <span >Tổng: '.number_format($invoice_initial).'VNĐ</span><br> 
                                <input type="text" class="vouchercode_input" name="vouchercode" value="'.$_SESSION['vouchercode_input'].'"  placeholder="Nhập mã" onchange="this.form.submit();"><br>
                                <div class="error_add">'.$voucher_code_error.'</div>
                                <span >Giảm: '.number_format($invoice_discount).'VNĐ</span><br> 
                                <span >Thành tiền: '.number_format($invoice_total).'VNĐ</span><br> 
                                <span><button type="submit" name="cart_container_pay_button">Thanh toán</button></span>';
                        } else {
                            echo "Giỏ hàng trống!";
                        } 
                        // lỊCH SỬ
                        $result=$conn->query("SELECT order_id, order_date, total_amount, order_status FROM order_purchase");
                        echo'<div >
                                <span class="label">Lịch sử:<span> 
                                <span><button type="submit" name="showallDetail_display_button">Hiện hết</button></span>
                                <span><button type="submit" name="hideallDetail_display_button">Ẩn hết</button></span>
                            </div>';
                        if($result->num_rows == 0){
                            echo'<div>Không có đơn hàng nào được giao</div>';
                        }else{
                            While($row = $result->fetch_assoc()){
                                $_SESSION['detail_order_id'][$row['order_id']]=$_SESSION['detail_order_id'][$row['order_id']]??"none";
                                echo '
                                <div class="history_order">
                                    <div><span class="order_id_label">Mã đơn hàng </span><span>: '.$row['order_id'].'</span> </div> 
                                    <span class="order_date">Thời gian: '.$row['order_date'].'</span>
                                    <span class="status">Trạng thái: ';
                                    if($row['order_status']=='pending'){
                                        echo 'Đang chờ';
                                    }elseif($row['order_status']=='delivered'){
                                        echo 'Đã giao';
                                    }elseif($row['order_status']=='completed'){
                                        echo 'Hoàn thành';
                                    }else{
                                        echo 'Đã hủy';
                                    }
                                    echo'</span>
                                    <span class="total_amount">Tổng tiền: '.number_format($row['total_amount']).' </span> '
                                    ;
                                    if($_SESSION['detail_order_id'][$row['order_id']]=="none"){
                                        echo'<span><button type="submit" value="'.$row['order_id'].'" name="viewDetail_display_button">Xem</button></span>';
                                    }else{
                                        echo'<span><button type="submit" value="'.$row['order_id'].'" name="viewDetail_display_button">Ẩn</button></span>';
                                    }
                                    $result1=$conn->query(
                                        "SELECT p.product_id, p.product_name, d.quantity, d.price 
                                        FROM order_detail d INNER JOIN product p
                                        ON p.product_id = d.product_id
                                        WHERE order_id={$row['order_id']}");
                                    While($row1 = $result1->fetch_assoc()){
                                    echo'<div class="viewDetail_container" style="display:'.$_SESSION['detail_order_id'][$row['order_id']].'">   
                                        <span class="product_name">Sản phẩm: '.$row1['product_name'].'</span> 
                                        <span class="quantity">Số lượng: '.$row1['quantity'].'</span> 
                                        <span class="price">Giá: '.number_format($row1['price']).'</span> 
                                    </div>';
                                    }
                                echo'
                                </div>';
                            }
                        }
                        
                    ?>
                </form>
            </div>
        </div>
    </div>

    <?php include '../includes/sidebar-user.php'; ?>
</body>
</html>
