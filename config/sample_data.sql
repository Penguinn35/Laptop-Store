
USE laptop_store;

-- Dữ liệu bảng brands
INSERT INTO brands (name, logo, description) VALUES
('Dell', 'dell.png', 'Hãng máy tính đến từ Mỹ nổi tiếng về độ bền và hiệu năng.'),
('Asus', 'asus.png', 'Thương hiệu Đài Loan nổi bật với dòng laptop gaming.'),
('HP', 'hp.png', 'Thương hiệu máy tính nổi tiếng toàn cầu với nhiều dòng sản phẩm cao cấp.'),
('Acer', 'acer.png', 'Hãng sản xuất máy tính giá tốt, phù hợp học sinh sinh viên.');

-- Dữ liệu bảng laptops
INSERT INTO laptops (brand_id, name, description, cpu, ram, storage, gpu, screen, price, image, stock) VALUES
(1, 'Dell XPS 13', 'Laptop mỏng nhẹ cao cấp cho doanh nhân.', 'Intel Core i7-1360P', '16GB', '512GB SSD', 'Intel Iris Xe', '13.4"', 32000000, 'xps13.jpg', 10),
(2, 'Asus TUF Gaming F15', 'Laptop gaming mạnh mẽ, bền bỉ.', 'Intel Core i5-12450H', '16GB', '512GB SSD', 'RTX 3050', '15.6"', 25000000, 'tuf15.jpg', 5),
(3, 'HP Spectre x360', 'Laptop 2 trong 1 cao cấp, xoay gập linh hoạt.', 'Intel Core i7-1355U', '16GB', '1TB SSD', 'Intel Iris Xe', '13.5"', 34000000, 'spectre.jpg', 8),
(4, 'Acer Aspire 7', 'Laptop học tập và làm việc hiệu quả.', 'AMD Ryzen 5 5500U', '8GB', '512GB SSD', 'GTX 1650', '15.6"', 19000000, 'aspire7.jpg', 12);

-- Dữ liệu bảng users
INSERT INTO users (username, password, fullname, email, role) VALUES
('ad', '123456', 'Quản trị viên', 'admin@laptopstore.vn', 'admin'),
('nguyenvana', '123456', 'Nguyễn Văn A', 'a@gmail.com', 'customer'),
('lethib', '123456', 'Lê Thị B', 'b@gmail.com', 'customer');

-- Dữ liệu bảng news
INSERT INTO news (title, content, image) VALUES
('Khuyến mãi mùa tựu trường', 'Giảm giá đến 20% cho sinh viên khi mua laptop học tập.', 'sale1.jpg'),
('Dell ra mắt dòng XPS mới', 'Dòng Dell XPS 2025 với CPU Intel thế hệ 14 và màn OLED.', 'dellxps.jpg'),
('Top 5 laptop gaming 2025', 'Danh sách laptop gaming mạnh nhất đầu năm 2025.', 'gaming.jpg');

-- Dữ liệu bảng comments
INSERT INTO comments (user_id, laptop_id, content, rating) VALUES
(2, 1, 'Máy chạy rất mượt, pin trâu!', 5),
(3, 2, 'Chơi game ổn, nhưng hơi nặng.', 4);

-- Dữ liệu bảng contacts
INSERT INTO contacts (name, email, subject, message) VALUES
('Trần Minh', 'minh@gmail.com', 'Hỏi mua laptop Dell', 'Shop còn hàng Dell XPS 13 không?'),
('Phạm Lan', 'lanpham@gmail.com', 'Bảo hành', 'Laptop bị lỗi màn hình, bảo hành như thế nào?');

-- Dữ liệu bảng faqs
INSERT INTO faqs (question, answer) VALUES
('Laptop có được bảo hành chính hãng không?', 'Tất cả laptop đều được bảo hành chính hãng 12 tháng.'),
('Có hỗ trợ giao hàng toàn quốc không?', 'Chúng tôi giao hàng toàn quốc qua các đối tác uy tín.');

-- Dữ liệu bảng settings
INSERT INTO settings (`key`, `value`) VALUES
('company_name', 'Laptop Store Việt Nam'),
('address', '123 Nguyễn Văn Linh, Đà Nẵng'),
('phone', '0123 456 789'),
('email', 'contact@laptopstore.vn'),
('logo', 'logo.png');
