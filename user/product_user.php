<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../assets/style.css?v=38">
    <?php include '../config/database.php'; ?>
    <?php include '../config/checkaccountID.php'?>
    <?php include '../process/product_user_process.php'; ?>
</head>
<body class="page-index">
    <div class="container">
        <h1 class="title">MiniMarket</h1>
        <div class="content">
            <div class="content_container">
                <!-- Thông báo thêm sản phẩm vào giỏ hàng -->
                <div class="msgAddcart_container" style="display:<?php echo $_SESSION['msgAddcart_display']?>">
                    <form method="POST">
                        <div>
                            <?php echo $msgAddcart?>
                        </div>
                        <div>
                            <button type="submit" name="close_msgAddcart_button">Đóng</button>
                        </div>
                    </form>
                </div>
                <?php
                echo'
                <div class="search" >
                <form method="POST">
                    <select name="categories_select" onchange="this.form.submit();">
                        <option value="all"'.($_SESSION['categories_select']=='all' ? 'selected' : '').'>Tất cả</option>
                        <option value="nuocngot"'.($_SESSION['categories_select']=='nuocngot' ? 'selected' : '').'>Nước ngọt </option>
                        <option value="nuoctraicay"'.($_SESSION['categories_select']=='nuoctraicay' ? 'selected' : '').'>Nước trái cây</option>
                        <option value="nuoctinhkhiet"'.($_SESSION['categories_select']=='nuoctinhkhiet' ? 'selected' : '').'>Nước tinh khiết</option>
                        <option value="ruou"'.($_SESSION['categories_select']=='ruou' ? 'selected' : '').'>Rượu</option>
                        <option value="bia"'.($_SESSION['categories_select']=='bia' ? 'selected' : '').'>Bia</option>
                        <option value="sua"'.($_SESSION['categories_select']=='sua' ? 'selected' : '').'>Sữa</option>
                        <option value="dohop"'.($_SESSION['categories_select']=='dohop' ? 'selected' : '').'>Đồ hộp</option>
                    </select>
                </form>
                </div>';
                ?>
                <!-- Hiển thị các sản phẩm -->
                <div class="product_container">
                    <?php
                        if($_SESSION['categories_select'] =='all'){
                            $result = $conn->query("SELECT product_id, product_name, price, product_img FROM product");
                        }
                        else{
                            $result = $conn->query("SELECT product_id, product_name, price, product_img FROM product Where category ='{$categories[$_SESSION['categories_select']]}'");
                        };
                        if($result->num_rows>0){
                            While($row=$result->fetch_assoc()){
                                echo'
                                <div class="product">
                                    <form method="POST">
                                        <div class="product_img">
                                            <img src="'.$row['product_img'].'" >
                                        </div>
                                        <div class="product_name">
                                            '.$row['product_name'].'
                                        </div>
                                        <div class="product_price">
                                            '.number_format($row['price']).'
                                        </div>
                                        <input type="hidden" name="product_id" value="'.$row['product_id'].'">
                                        <input type="hidden" name="product_name" value="'.$row['product_name'].'">
                                        <input type="hidden" name="price" value="'.$row['price'].'">
                                        <div>
                                            <button type="submit" class="buyproduct_button" name="buy_button">Mua</button>
                                        </div>
                                    </form>
                                </div>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/sidebar-user.php'; ?>
</body>
</html>
