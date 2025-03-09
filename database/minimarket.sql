-- Tạo database minimarket
DROP DATABASE IF EXISTS minimarket;
CREATE DATABASE minimarket;
USE minimarket;

-- Bảng account (Tài khoản người dùng)
CREATE TABLE account (
    account_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NULL,
    account_phone VARCHAR(15) ,
    address VARCHAR(100) NULL,
    point INT DEFAULT 0,
    coin INT DEFAULT 0,
    account_status ENUM('Active', 'Inactive') DEFAULT 'Active'
);

-- Bảng role (Vai trò người dùng)
CREATE TABLE role (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL,
    account_id INT,
    FOREIGN KEY (account_id) REFERENCES account(account_id) ON DELETE CASCADE
);

-- Bảng product (Sản phẩm)
CREATE TABLE product (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
	product_name VARCHAR(100) NOT NULL,
	stock_quantity INT DEFAULT 0,
    price INT NOT NULL,
    product_img VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    supplier VARCHAR(100) NOT NULL
);

-- Bảng stock_history (Lịch sử nhập hàng)
CREATE TABLE stock_history (
    stock_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    in_quantity INT NOT NULL,
    in_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    supplier_id INT,
    FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE
);

-- Bảng order_purchase (Đơn hàng)
CREATE TABLE order_purchase (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    account_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount INT NOT NULL,
    order_status ENUM('pending', 'delivered', 'completed', 'canceled') DEFAULT 'pending',
    FOREIGN KEY (account_id) REFERENCES account(account_id) ON DELETE SET NULL
);

-- Bảng order_detail (Chi tiết đơn hàng)
CREATE TABLE order_detail (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES order_purchase(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE
);

-- Bảng sale_history (Lịch sử bán hàng)
CREATE TABLE sale_history (
    sale_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    order_id INT,
    stock_quantity INT NOT NULL,
    sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES order_purchase(order_id) ON DELETE CASCADE
);


-- Bảng voucher (Mã giảm giá)
CREATE TABLE voucher (
    voucher_id INT AUTO_INCREMENT PRIMARY KEY,
    voucher_code VARCHAR(50) UNIQUE NOT NULL,
    discount_amount INT,
    discount_percent INT,
    min_order_value INT,
    expiration_date DATE,
    voucher_status ENUM('Active', 'Expired', 'Used') DEFAULT 'Active',
    account_id INT NULL,
    FOREIGN KEY (account_id) REFERENCES account(account_id)
);


INSERT INTO account(username, password, name, account_phone, address, coin, point) 
VALUES 
('admin', 1, 'Kiên', '0869336216', 'Số 27 Cầu Giấy', 1000000, 1000),
('kh1', 1, 'Kiên', '0869336216', 'Số 27 Cầu Giấy', 1000000, 1000),
('kh2', '123456', 'Bá', '0987654321', 'Số 15 Trần Duy Hưng', 500000, 3000),
('kh3', '123456', 'Châu', '0971234567', 'Số 20 Nguyễn Trãi', 300000, 700),
('kh4', '123456', 'Dung', '0962345678', 'Số 8 Giải Phóng', 700000, 5000),
('kh5', '123456', 'Hải', '0953456789', 'Số 12 Kim Mã', 450000, 100);

INSERT INTO role(role_name, account_id) 
VALUES 
('admin', (SELECT account_id FROM account WHERE username = 'admin')),
('customer', (SELECT account_id FROM account WHERE username = 'kh1')),
('customer', (SELECT account_id FROM account WHERE username = 'kh2')),
('customer', (SELECT account_id FROM account WHERE username = 'kh3')),
('customer', (SELECT account_id FROM account WHERE username = 'kh4')),
('customer', (SELECT account_id FROM account WHERE username = 'kh5'));

INSERT INTO product(product_name, stock_quantity, price, product_img, category, supplier) 
VALUES 
('Cocacola ít đường', 1000, 21000, '../img/cocacolalesssugar.png', 'Nước ngọt', 'Cocacola'),
('Cocacola không đường', 1000, 21000, '../img/cocacolanosugar.png', 'Nước ngọt', 'Cocacola'),
('Fanta cam', 1000, 21000, '../img/fantacam.png', 'Nước ngọt', 'Fanta'),
('Fanta nho', 1000, 21000, '../img/fantanho.png', 'Nước ngọt', 'Fanta'),
('Cocktail dâu', 1000, 21000, '../img/cocktaildau.png', 'Nước trái cây', 'Cocktail'),
('Cocktail việt quất', 1000, 21000, '../img/cocktailvietquat.png', 'Nước trái cây', 'Cocktail'),
('Nước tinh khiết Jovita', 1000, 21000, '../img/jovita.png', 'Nước tinh khiết', 'Jovita'),
('Nước tinh khiết Tavi', 1000, 21000, '../img/tavi.png', 'Nước tinh khiết', 'Tavi'),
('Nước tinh khiết Lama', 1000, 21000, '../img/lama.png', 'Nước tinh khiết', 'Lama'),
('Nước tinh khiết Vikoda', 1000, 21000, '../img/vikoda.png', 'Nước tinh khiết', 'Vikoda'),
('Bia Tiger', 1000, 15000, '../img/tiger.png', 'Bia', 'Tiger'),
('Bia Blanc', 1000, 20000, '../img/blanc.png', 'Bia', 'Blanc'),
('Bia Red Ruby', 1000, 12000, '../img/redruby.png', 'Bia', 'Red Ruby'),
('Bia Budweiser', 1000, 17000, '../img/budweiser.png', 'Bia', 'Budweiser'),
('Bia Pilsner', 1000, 15000, '../img/pilsner.png', 'Bia', 'Pilsner'),
('Bia Sapporo', 1000, 30000, '../img/sapporo.png', 'Bia', 'Sapporo'),
('Rượu Soju Heejin dâu ', 1000, 45000, '../img/sojuheejindau.png', 'Rượu', 'Heejin'),
('Rượu Soju Heejin việt quất', 1000, 45000, '../img/sojuheejinvietquat.png', 'Rượu', 'Heejin'),
('TH TRUE MILK có đường ', 1000, 45000, '../img/thtruemilksugar.png', 'Sữa', 'TH True Milk'),
('TH TRUE MILK ít đường ', 1000, 45000, '../img/thtruemilklesssugar.png', 'Sữa', 'TH True Milk'),
('TH TRUE MILK không đường ', 1000, 45000, '../img/thtruemilknosugar.png', 'Sữa', 'TH True Milk'),
('Vinamilk có đường', 1000, 45000, '../img/vinamilksugar.png', 'Sữa', 'Vinamilk'),
('Vinamilk ít đường', 1000, 45000, '../img/vinamilklesssugar.png', 'Sữa', 'vinamilk'),
('Heo hai lát 3 bông mai', 1000, 45000, '../img/heohailat3bongmai.png', 'Đồ hộp', '3 Bông Mai'),
('Heo hai lát Hạ long', 1000, 45000, '../img/heohailathalong.png', 'Đồ hộp', 'Hạ Long'),
('Heo hai lát Vissan', 1000, 45000, '../img/heohailatvissan.png', 'Đồ hộp', 'Vissan'),
('Pate thịt heo Vissan', 1000, 45000, '../img/patethitheovissan.png', 'Đồ hộp', 'Vissan'),
('Pate gan Hạ Long', 1000, 45000, '../img/pateganhalong.png', 'Đồ hộp', 'Hạ Long'),
('Thịt heo hầm Vissan', 1000, 45000, '../img/thitheohamvissan.png', 'Đồ hộp', 'Vissan'),
('Bò hai lát Vissan', 1000, 45000, '../img/bohailatvissan.png', 'Đồ hộp', 'Vissan'),
('Bò hai lát', 1000, 45000, '../img/bohailathalong.png', 'Đồ hộp', 'Hạ Long'),
('Cá trích xốt cà Lilly', 1000, 45000, '../img/canuckhotieuseacrowm.png', 'Đồ hộp', 'Lilly'),
('Cá nục kho tiêu Sea Crown', 1000, 45000, '../img/canuckhotieuseacrowm.png', 'Đồ hộp', 'Sea Crown'),
('Cá nục xốt cà Sea Crown', 1000, 45000, '../img/canuckhotieuseacrowm.png', 'Đồ hộp', 'Sea Crown'),
('Cá trích xốt cà Sea Crown', 1000, 45000, '../img/catrichxotcaseacrowm.png', 'Đồ hộp', 'Sea Crown'),
('Cá ngừ xốt tương Tuna', 1000, 45000, '../img/canguxottuongtuna.png', 'Đồ hộp', 'Tuna'),
('Gạp lứt đỏ Vinh Hiển', 1000, 45000, '../img/gaolutdovinhhien.png', 'Gạo', 'Vinh Hiển'),
('Gạp lứt hỗn hợp Ông Cụ', 1000, 45000, '../img/gaoluthonhopongcu.png', 'Gạo', 'Ông Cụ'),
('Gạo Meizan nàng thơn', 1000, 45000, '../img/gaomeizannangthom.png', 'Gạo', 'Meizan'),
('Gạo nếp cái hoa vàng Vinh Hiển', 1000, 45000, '../img/gaonepcaihoavangvinhhien.png', 'Gạo', 'Vinh Hiển'),
('Gạo nếp chùm Vinh Hiển', 1000, 45000, '../img/gaonepchumvinhhien.png', 'Gạo', 'Vinh Hiển'),
('Gạo nếp sáp Vinh Hiển', 1000, 45000, '../img/gaonepsapvinhhien.png', 'Gạo', 'Vinh Hiển'),
('Gạo Thơm Lài', 1000, 45000, '../img/gaothomlai.png', 'Gạo', 'Thơm Lài'),
('Gạo thơm ST21', 1000, 45000, '../img/gaothomst21.png', 'Gạo', 'ST'),
('Gạo thơm ST25', 1000, 45000, '../img/gaothomst25.png', 'Gạo', 'ST'),
('Bánh gạo cốm sen', 1000, 45000, '../img/banhgaocomsen.png', 'Bánh kẹo', 'Cốm sen'),
('Bánh gạo gà khô lá chanh', 1000, 45000, '../img/banhgaogakholachanh.png', 'Bánh kẹo', 'Play'),
('Bánh gạo mật ong', 1000, 45000, '../img/banhgaomatong.png', 'Bánh kẹo', 'Ichi'),
('Bánh gạo phô mai', 1000, 45000, '../img/banhgaophomai.png', 'Bánh kẹo', 'Play'),
('Bánh gạo rong biển', 1000, 45000, '../img/banhgaorongbien.png', 'Bánh kẹo', 'Play'),
('Bánh phô mai chà bông', 1000, 45000, '../img/banhphomaichabong.png', 'Bánh kẹo', 'Sandwitch'),
('Bánh phô mai dứa', 1000, 45000, '../img/banhphomaidua.png', 'Bánh kẹo', 'Hura'),
('Bánh phô mai kem trứng', 1000, 45000, '../img/banhphomaikemtrung.png', 'Bánh kẹo', 'Lava'),
('Bánh phô mai trứng muối', 1000, 45000, '../img/banhphomaitrungmuoi.png', 'Bánh kẹo', 'Hura'),
('Bột baking soda Caster Daily', 1000, 45000, '../img/botbakingsodacasterdaily.png', 'Bột', 'Tần Sang'),
('Bột bắp Tần Sang', 1000, 45000, '../img/botbaptansang.png', 'Bột', 'Tần Sang'),
('Bột chiên gà giòn Taky', 1000, 45000, '../img/botchiengagiontaky.png', 'Bột', 'Taky'),
('Bột chiên giòn cay Daily Food', 1000, 45000, '../img/botchiengioncaydailyfood.png', 'Bột', 'Daily Food'),
('Bột chiên giòn Daily Food', 1000, 45000, '../img/botchiengiondailyfood.png', 'Bột', 'Daily Food'),
('Bột chiên giòn Ofood', 1000, 45000, '../img/botchiengionofood.png', 'Bột', 'Ofood'),
('Bột chiên giòn Tần Sang', 1000, 45000, '../img/botchiengiontansang.png', 'Bột', 'Tần Sang'),
('Bột năng Tần Sang', 1000, 45000, '../img/botnangtansang.png', 'Bột', 'Tần Sang'),
('Bột phô mai Ottogi', 1000, 45000, '../img/botphomaiottogi.png', 'Bột', 'Ottogi'),
('Bột phô mai ST Food', 1000, 45000, '../img/botphomaistfood.png', 'Bột', 'ST Food'),
('Bột rau câu dẻo Bà Bảy', 1000, 45000, '../img/botraucaudeobabay.png', 'Bột', 'Bà Bảy'),
('Bột rau câu dẻo Kokkon', 1000, 45000, '../img/botraucaudeokokkon.png', 'Bột', 'Kokkon'),
('Bột rau câu giòn Bà Bảy', 1000, 45000, '../img/botraucaugionbabay.png', 'Bột', 'Bà Bảyd');


-- Chèn hóa đơn vào bảng order_purchase
INSERT INTO order_purchase (account_id, order_date, total_amount, order_status)
VALUES 
(2, '2024-02-03 09:00:00', 84000, 'completed'),
(2, '2024-02-08 16:20:00', 157000, 'delivered'),
(2, '2024-02-14 13:45:00', 225000, 'completed'),
(2, '2024-02-20 19:10:00', 180000, 'pending'),
(2, '2024-02-27 08:30:00', 105000, 'completed');

-- Chèn chi tiết hóa đơn vào bảng order_detail
INSERT INTO order_detail (order_id, product_id, quantity, price)
VALUES 
(1, 1, 2, 21000), 
(1, 3, 2, 21000), 
(2, 11, 3, 15000),
(2, 12, 4, 20000),
(2, 20, 2, 45000),
(3, 27, 3, 45000), 
(3, 28, 2, 45000),
(3, 35, 2, 45000),
(4, 41, 4, 45000), 
(4, 45, 2, 45000),
(5, 50, 3, 45000), 
(5, 55, 2, 45000); 

INSERT INTO voucher (voucher_code, discount_amount, discount_percent, min_order_value, expiration_date, voucher_status) 
VALUES 
('DISCOUNT10', 10000, NULL, 50000, '2024-12-31', 'Active'),
('SALE20', 20000, NULL, 100000, '2024-11-30', 'Active'),
('FREESHIP50', NULL, 10.00, 200000, '2024-12-15', 'Active'),
('BIGSALE30', NULL, 30.00, 500000, '2024-12-25', 'Active'),
('HOLIDAY50', 50000, NULL, 300000, '2025-01-01', 'Active');

