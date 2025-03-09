<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../assets/style.css?v=61">
    <?php include '../config/database.php'; ?>
    <?php include '../config/checkaccountID.php'?>
    <?php include '../process/order_management_process.php'; ?>
</head>
<body class="page-index">
    <div class="container">
        <h1 class="title">Quản lí đơn hàng</h1>
        <div class="content">
            <div class="order_container">
                <table  class="data_table">
                <tr>
                    <td style="width:50px">ID</td>
                    <td style="width:70px">ID khách </td>
                    <td style="width:80px">Tên khách</td>
                    <td style="width:100px">Số điện thoại</td>
                    <td style="width:120px">Địa chỉ</td>
                    <td>Sản phẩm</td>
                    <td style="width:80px">Tổng tiền</td>
                    <td style="width:100px">Thời gian</td>
                    <td style="width:190px">Trạng thái</td>
                </tr>
            <?php
            $result = $conn->query(
                "SELECT o.order_id ,a.account_id, a.name, a.account_phone, a.address, o.total_amount, o.order_date, o.order_status
            FROM account a 
            INNER JOIN order_purchase o ON a.account_id = o.account_id
            ");
                if($result->num_rows == 0){
                    echo '<tr><td colspan="9">Không có đơn hàng nào.</td></tr>';
                }else{
                    while($row=$result->fetch_assoc()){
                        echo '
                        <tr class="order_td">
                            <td>
                                <div class="center">'.$row['order_id'].'</div>
                            </td>
                            <td>
                                <div class="center">'.$row['account_id'].'</div>     
                            </td>
                            <td>
                                <div class="center">'.$row['name'].'</div>
                            </td>
                            <td>
                                <div class="center">'.$row['account_phone'].'</div>
                            </td>
                            <td>
                                <div>'.$row['address'].'</div>
                            </td>
                            <td>
                                <div>';
                                $result1 = $conn->query(
                                    "SELECT o.quantity, p.product_name
                                    FROM product p
                                    INNER JOIN order_detail o ON p.product_id = o.product_id
                                    Where order_id = '{$row['order_id']}'
                                ");
                                while($row1=$result1->fetch_assoc()){
                                    echo $row1["product_name"].' x'. $row1["quantity"].'.';
                                }
                                
                                echo'</div>
                            </td>
                            <td>
                                <div class="center">'.number_format($row['total_amount']).'</div>
                            </td>
                            <td>
                                <div class="center">'.$row['order_date'].'</div>
                            </td>
                            <td >
                                <form method="post" action="" id ="order_status_form">
                                    <input type="hidden" name="account_id"  value="'.$row['account_id'].'" >
                                    <input type="hidden" name="total_amount"  value="'.$row['total_amount'].'" >
                                    <input type="hidden" name="order_id"  value="'.$row['order_id'].'" >
                                    <div class="status_td">
                                    <span class="status_label">';
                                    foreach($order_status as $key => $value){
                                    if($row['order_status']== $key){
                                        echo $value;
                                        }
                                    };
                                    $_SESSION['status_selectdisplay'][$row['order_id']]=$_SESSION['status_selectdisplay'][$row['order_id']]??"inline";
                                    $_SESSION['order_status_select'][$row['order_id']]=$_SESSION['order_status_select'][$row['order_id']]?? $row['order_status'];
                                    if($row['order_status']=="completed"){
                                        $_SESSION['status_selectdisplay'][$row['order_id']]="none";
                                    }
                                    echo'</span>
                                    <span style="display:'.$_SESSION['status_selectdisplay'][$row['order_id']].'">
                                    <select name="order_status_select" onchange="this.form.submit();">
                                        <option selected disabled>--Chọn--</option>
                                        <option value="pending"'.($_SESSION['order_status_select'][$row['order_id']]== "pending" ? 'selected' : '').'>Đang chờ</option>
                                        <option value="delivered"'.($_SESSION['order_status_select'][$row['order_id']]== "delivered" ? 'selected' : '').'>Đã giao</option>
                                        <option value="completed"'.($_SESSION['order_status_select'][$row['order_id']]== "completed" ? 'selected' : '').'>Hoàn thành</option>
                                        <option value="canceled"'.($_SESSION['order_status_select'][$row['order_id']]== "canceled" ? 'selected' : '').'>Hủy đơn</option>
                                    </select>
                                    </span>
                                    </div>
                                 </form>
                            </td>
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