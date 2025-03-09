<?php
    // Tìm sp
    $categories = [
        "all" => "Tất cả",
        "nuocngot" => "Nước ngọt",
        "nuoctraicay" => "Nước trái cây",
        "nuoctinhkhiet" => "Nước tinh khiết",
        "ruou" => "Rượu",
        "bia" => "Bia",
        "sua" => "Sữa",
        "dohop" => "Đồ hộp"
    ];
    if (isset($_POST['categories_select'])) {
        $_SESSION['categories_select'] = $_POST['categories_select']; 
    }

    // Hiển thị thông báo và thêm sp vào gior
    $msgAddcart = ""; 
    if (!isset($_SESSION['invoice']) || !is_array($_SESSION['invoice'])) {
        $_SESSION['invoice'] = [];
    }
    if (isset($_POST['buy_button'])) {  
        $exists = false;
        foreach ($_SESSION['invoice'] as $invoice) {
            if ($_POST['product_name'] === $invoice['product_name']) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            $msgAddcart = "Sản phẩm đã có trong giỏ hàng :((";
        } else {
            $_SESSION['invoice'][] = [
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'price' => $_POST['price'],
                'quantity' => 1
            ];
            $msgAddcart = "Đã thêm sản phẩm vào giỏ hàng!";
        }
        $_SESSION['msgAddcart_display']='flex';
    }

    // ĐóngTHông báo box

    if(isset($_POST['close_msgAddcart_button'])){
        $_SESSION['msgAddcart_display']="none";
    }
    $category_name=$category_name??"";
    $_SESSION['msgAddcart_display']=$_SESSION['msgAddcart_display']??"none";
    $_SESSION['categories_select']=$_SESSION['categories_select']??"all";
?>