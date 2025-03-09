<?php
// Thêm sản phẩm mới
if(isset($_POST['add_newproduct_button'])){
    $_SESSION['add_newproduct']='flex';
}
$msgAddnewproduct=["success"=>"","product_name"=>"","quantity"=>"","price"=>"","product_img"=>"","category"=>"","supplier"=>""];
if(isset($_POST['newproduct_save_button'])){
    if(!$_POST['add_product_name']){
        $msgAddnewproduct["product_name"]="Tên sản phẩm không được để trống";
    }
    if($_POST['add_quantity']===""){
        $msgAddnewproduct["quantity"]="Số lượng sản phẩm không được để trống";
    }if (!is_numeric($_POST['add_quantity'])) {
        $msgAddnewproduct["quantity"] = "Số lượng phẩm phải là số";
    }
    if($_POST['add_price']===""){
        $msgAddnewproduct["price"]="Giá sản phẩm không được để trống";
    }if (!is_numeric($_POST['add_price'])) {
        $msgAddnewproduct["price"] = "Giá sản phẩm phải là số";
    }
    if(!$_POST['add_product_img']){
        $msgAddnewproduct["product_img"]="Hình ảnh sản phẩm không được để trống";
    }
    if(!$_POST['add_category']){
        $msgAddnewproduct["category"]="Danh mục sản phẩm không được để trống";
    }
    if(!$_POST['add_supplier']){
        $msgAddnewproduct["supplier"]="Nhà cung cấp không được để trống";
    }
    if($msgAddnewproduct["product_name"]=="" && $msgAddnewproduct["quantity"]=="" && $msgAddnewproduct["price"]=="" && $msgAddnewproduct["product_img"]=="" && $msgAddnewproduct["category"]=="" && $msgAddnewproduct["supplier"]==""){
        $query=$conn->query("INSERT INTO product(product_name,stock_quantity,price,product_img,category,supplier) 
        VALUES('{$_POST['add_product_name']}','{$_POST['add_quantity']}','{$_POST['add_price']}','{$_POST['add_product_img']}','{$_POST['add_category']}','{$_POST['add_supplier']}')");
        $msgAddnewproduct["success"]="Thêm sản phẩm thành công";
    }
}
if(isset($_POST['newproduct_cancel_button'])){
    $_SESSION['add_newproduct']='none';
}
$_SESSION['add_newproduct']=$_SESSION['add_newproduct']??'none';
$display_addnewproduct=$_SESSION['add_newproduct'];
//Sửa sản phẩm
$product_field=[
    'data'=>[
        'product_name'=>'product_name',
        'stock_quantity'=>'stock_quantity',
        'price'=>'price',
        'category'=>'category',
        'supplier'=>'supplier',
        'product_img'=>'product_img',
    ],
    'input'=>[
        'product_name'=>'product_name_input',
        'stock_quantity'=>'stock_quantity_input',
        'price'=>'price_input',
        'category'=>'category_input',
        'supplier'=>'supplier_input',
        'product_img'=>'product_img_input',
    ],
    'set_button'=>[
        'product_name'=>'product_name_set_button',
        'stock_quantity'=>'stock_quantity_set_button',
        'price'=>'price_set_button',
        'category'=>'category_set_button',
        'supplier'=>'supplier_set_button',
        'product_img'=>'product_img_set_button',
    ],
    'save_button'=>[
        'product_name'=>'product_name_save_button',
        'stock_quantity'=>'stock_quantity_save_button',
        'price'=>'price_save_button',
        'category'=>'category_save_button',
        'supplier'=>'supplier_save_button',
        'product_img'=>'product_img_save_button',
    ],
    'cancel_button'=>[
        'product_name'=>'product_name_cancel_button',
        'stock_quantity'=>'stock_quantity_cancel_button',
        'price'=>'price_cancel_button',
        'category'=>'category_cancel_button',
        'supplier'=>'supplier_cancel_button',
        'product_img'=>'product_img_cancel_button',
    ],
];
foreach ($product_field['set_button'] as  $key => $value) {
        if(isset($_POST[$value])){
            $product_id=$_POST[$value];
            $_SESSION[$key][$product_id] = 'input'; 
        }
}
foreach ($product_field['save_button'] as  $key => $value) {
    if(isset($_POST[$value])){
        $product_id = $_POST[$value];
        $product_input = $_POST[$product_field['input'][$key]];
        $conn->query("UPDATE product SET $key= '$product_input' WHERE product_id = '$product_id'");
        $_SESSION[$key][$product_id] = 'text'; 
    }
}
foreach ($product_field['cancel_button'] as  $key => $value) {
    if(isset($_POST[$value])){
        $product_id=$_POST[$value];
        $_SESSION[$key][$product_id] = 'text'; 
    }
}

?>