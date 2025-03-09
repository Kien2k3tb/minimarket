<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../assets/style.css?v=67">
    <?php include '../config/database.php'; ?>
    <?php include '../process/product_management_process.php' ?>
    
</head>
<body class="page-index">
    <div class="container">
        <h1 class="title">Quản lí sản phẩm</h1>
        <div class="content">
        <form method="post" action="">
            <button type="submit" class="add_button" name="add_newproduct_button">Thêm sản phẩm mới</button>
        </form>
        <?php 
        echo'
        <div class="add_container" style="display:'.$display_addnewproduct.'">
            <form class="add" method="post" action="">
            <div class="box-title">Nhập thông tin</div>            
            <div class="success_add">'.$msgAddnewproduct["success"].'</div>         
            <input name="add_product_name" type="text" placeholder="Nhập tên sản phẩm">
            <div class="error_add">'.$msgAddnewproduct["product_name"].'</div>
            <input name="add_quantity" type="text" placeholder="Nhập số lượng">
            <div class="error_add">'.$msgAddnewproduct["quantity"].'</div>
            <input name="add_price" type="text" placeholder="Nhập giá">
            <div class="error_add">'.$msgAddnewproduct["price"].'</div>
            <input name="add_product_img" type="text" placeholder="Nhập link hình ảnh">
            <div class="error_add">'.$msgAddnewproduct["product_img"].'</div>
            <input name="add_category" type="text" placeholder="Nhập tên danh mục">
            <div class="error_add">'.$msgAddnewproduct["category"].'</div>
            <input name="add_supplier" type="text" placeholder="Nhập tên nhà cung cấp">
            <div class="error_add">'.$msgAddnewproduct["supplier"].'</div>
            <button class="set_btn" name="newproduct_save_button">Lưu</button>   
            <button class="set_btn" name="newproduct_cancel_button">Thoát</button>    
            </form>
        </div>';
        ?>
        <table class="data_table">
            <tr>
                <td style="width:70px">ID</td>
                <td style="width:220px">Tên sản phẩm</td>
                <td style="width:120px">Số lượng</td>
                <td style="width:150px">Giá</td>
                <td>Danh mục</td>
                <td style="width:150px">Nhà cung cấp</td>
                <td style="width:320px">Link hình ảnh</td>
            </tr>
        <?php
            $result = $conn->query("SELECT product_id, product_name, stock_quantity, price, category, supplier, product_img FROM product");
            if($result->num_rows == 0){
                echo '<tr><td colspan="8">Không có sản phẩm nào.</td></tr>';
            }else{
                while($row=$result->fetch_assoc()){
                    foreach ($product_field['data'] as  $key => $value) {
                        $_SESSION[$value][$row["product_id"]]=$_SESSION[$value][$row["product_id"]] ?? 'text'; 
                    }
                    echo'
                    <tr>
                        <td>'.$row['product_id'].'</td>';
                        foreach ($product_field['data'] as  $key => $value) {
                        echo '<form method="post" action="">
                        <td>
                            <div class="product_td">';
                                if($_SESSION[$value][$row["product_id"]]=="text"){   
                                    echo '
                                    <div>';
                                        if (is_numeric($row[$value])){
                                            echo number_format($row[$value]);
                                        }else{
                                            echo $row[$value];
                                        };
                                    echo'
                                    </div>
                                    <div>
                                        <button type="submit" name="'.$product_field['set_button'][$value].'" value="'.$row['product_id'].'">Sửa</button>
                                    </div>';
                                }else{
                                    echo '
                                    <div >
                                        <input  class="'.$value.'_input" name="'.$product_field['input'][$value].'" value="'.$row[$value].'">
                                    </div>
                                    <div >
                                        <button type="submit" name="'.$product_field['save_button'][$value].'" value="'.$row['product_id'].'">Lưu</button>
                                        <button type="submit" name="'.$product_field['cancel_button'][$value].'" value="'.$row['product_id'].'">Hủy</button>
                                    </div>';
                                } 
   
                            echo'
                            </div>
                        </td></form>';
                        } 
                        echo'</tr>';
                }
            }
        ?>   
            

        </table>;
        </div>
    </div>
    <?php include '../includes/sidebar-admin.php'; ?>

</body>
</html>
