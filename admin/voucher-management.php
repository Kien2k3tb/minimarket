<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../assets/style.css?v=51">
    <?php include '../config/database.php'; ?>
    <?php include '../process/voucher_management_process.php'; ?>
</head>
<body class="page-index">
    <div class="container">
        <h1 class="title">Quản lí khuyến mãi</h1>
        <div class="content">
            <form method="post" action="">
                <button type="submit" class="add_button" name="add_voucher_button">Thêm mã khuyến mại</button>
            </form>
            <?php 
            echo'
            <div class="add_voucher_container" style="display:'.$_SESSION['addvoucher_display'].'">
                <div>
                <div class="box-title">Nhập thông tin</div> 
                <div class="success_add">'.$msg_voucheradd_container["success"].'</div>
                <form method="post" action="">
                    <div class="addvoucher_label">Khách hàng nhập:</div>
                    <select name="voucher_account_select" onchange="this.form.submit();">
                        <option selected disabled>--Chọn--</option>
                        <option value="all"'. ($_SESSION['voucher_account_select'] == 'all' ? 'selected' : '') .'>Tất cả</option>
                        <option value="account_id"'. ($_SESSION['voucher_account_select'] == 'account_id' ? 'selected' : '') .'>ID khách</option>
                    </select>'; 
                    if($_SESSION['voucher_account_select']== 'account_id'){
                        echo'<input type="text" name="account_id_input" value="'.$_SESSION['account_id_input'].'" placeholder="Nhập ID khách hàng">
                        <div class="error_add">'.$msg_voucheradd_container["account_id_error"].'</div>';
                    };      
                echo'
                    <select name="voucher_type_select" onchange="this.form.submit();">
                        <option selected disabled>--Loại mã--</option>
                        <option value="discount_amount"'. ($_SESSION['voucher_type_select'] == 'discount_amount' ? 'selected' : '') .'>Giảm trực tiếp</option>
                        <option value="discount_percent"'. ($_SESSION['voucher_type_select'] == 'discount_percent' ? 'selected' : '') .'>Giảm phần trăm</option>
                    </select>';
                    if($_SESSION['voucher_type_select']=='discount_amount'){
                        echo'<input type="text" name="voucher_type_input" value="'.$_SESSION['voucher_type_input'].'" placeholder="Nhập số tiền giảm">';
                    }else{
                        echo'<input type="text" name="voucher_type_input" value="'.$_SESSION['voucher_type_input'].'"placeholder="Nhập phần trăm giảm">';
                    }
                echo'
                <div class="error_add" name="discount">'.$msg_voucheradd_container["discount_error"].'</div>
                <input type="text" name="voucher_code" placeholder="Nhập mã khuyến mại">
                <div class="error_add">'.$msg_voucheradd_container["code_error"].$msg_voucheradd_container["account_id_error"].'</div>
                <input type="text" name="min_order_value" placeholder="Nhập số tiền đơn tối thiểu">
                <div class="error_add" >'.$msg_voucheradd_container["min_order_error"].'</div>
                <div class="addvoucher_label">Ngày hết hạn:</div>
                <input type="datetime-local" name="expiration_date">
                <div class="error_add" >'.$msg_voucheradd_container["datetime_error"].'</div>
                <button type="submit" name="add_codevoucher_button">Tạo mã</button>
                <button type="submit" name="cancel_voucher_button">Thoát</button>
                </form>
                </div>
            </div>';
                ?>
            <!-- Bảng voucher -->
            <div class="order_container">
                <table  class="data_table">
                <tr>
                    <td style="width:50px">ID</td>
                    <td style="width:150px">Mã khuyến mãi </td>
                    <td style="width:120px">Giảm trực tiếp</td>
                    <td style="width:120px">Giảm phần trăm</td>
                    <td style="width:150px">Đơn áp dụng</td>
                    <td>Ngày hết hạn</td>
                    <td style="width:190px">Trạng thái</td>
                    <td style="width:90px">ID khách</td>
                </tr>
                <?php
                    $result = $conn->query("SELECT * FROM voucher");
                    if($result->num_rows == 0){
                        echo '<tr><td colspan="8">Không có sản phẩm nào.</td></tr>';
                    }else{
                        while($row=$result->fetch_assoc()){
                            echo '
                            <tr>
                                <td>'.$row['voucher_id'].'</td>
                                <td>'.$row['voucher_code'].'</td>
                                <td>'.number_format($row['discount_amount']).'</td>
                                <td>'.number_format($row['discount_percent']).'</td>
                                <td>'.number_format($row['min_order_value']).'</td>
                                <td>'.$row['expiration_date'].'</td>
                                <td>'.$row['voucher_status'].'</td>
                                <td>'.$row['account_id'].'</td>
                            </tr>';
                        }
                    }
                ?>
                </table>
            </div>
        </div>
    </div>
    <?php include '../includes/sidebar-admin.php'; ?>
</body>
</html>
