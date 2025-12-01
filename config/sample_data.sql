
USE laptop_store;

-- Dữ liệu bảng brands
INSERT INTO brands (id, name, logo, description) VALUES
(1,'Dell', 'dell.png', 'Hãng máy tính đến từ Mỹ nổi tiếng về độ bền và hiệu năng.'),
(2,'Asus', 'asus.png', 'Thương hiệu Đài Loan nổi bật với dòng laptop gaming.'),
(3,'HP', 'hp.png', 'Thương hiệu máy tính nổi tiếng toàn cầu với nhiều dòng sản phẩm cao cấp.'),
(4,'Acer', 'acer.png', 'Hãng sản xuất máy tính giá tốt, phù hợp học sinh sinh viên.');

-- Dữ liệu bảng laptops
INSERT INTO laptops (brand_id, name, description, cpu, ram, storage, gpu, screen, price, image, stock) VALUES
(1, 'Dell XPS 13', 'Laptop mỏng nhẹ cao cấp cho doanh nhân.', 'Intel Core i7-1360P', '16GB', '512GB SSD', 'Intel Iris Xe', '13.4"', 32000000, 'xps13.jpg', 10),
(2, 'Asus TUF Gaming F15', 'Laptop gaming mạnh mẽ, bền bỉ.', 'Intel Core i5-12450H', '16GB', '512GB SSD', 'RTX 3050', '15.6"', 25000000, 'tuff15.png', 5),
(3, 'HP Spectre x360', 'Laptop 2 trong 1 cao cấp, xoay gập linh hoạt.', 'Intel Core i7-1355U', '16GB', '1TB SSD', 'Intel Iris Xe', '13.5"', 34000000, 'spectre.jpg', 8),
(4, 'Acer Aspire 7', 'Laptop học tập và làm việc hiệu quả.', 'AMD Ryzen 5 5500U', '8GB', '512GB SSD', 'GTX 1650', '15.6"', 19000000, 'aspire7.png', 12);

-- Dữ liệu bảng users
INSERT INTO users (username, password, fullname, email, role) VALUES


-- Dữ liệu bảng posts
INSERT INTO posts (title, slug, description, content, thumbnail, keywords, created_at) VALUES
(
    'TOP 5 mẫu Laptop Văn Phòng đáng mua nhất năm 2025',
    'top-5-laptop-van-phong-2025',
    'Xem ngay danh sách 5 mẫu laptop mỏng nhẹ, hiệu năng ổn định, phù hợp cho công việc văn phòng và học tập.',
    '<p>Năm 2025 đánh dấu sự ra đời của nhiều mẫu laptop văn phòng với thiết kế đột phá và hiệu năng vượt trội. Các tiêu chí hàng đầu vẫn là mỏng nhẹ, pin trâu và bảo mật cao.</p>
    <ul>
        <li>Lenovo ThinkPad X1 Carbon Gen 12</li>
        <li>Dell XPS 13 9360</li>
        <li>HP Spectre x360</li>
    </ul>
    <p>Hãy chọn cho mình chiếc máy phù hợp nhất!</p>',
    'thumbnail_1.jpg',
    'laptop van phong, laptop 2025, thinkpad, xps',
    '2025-11-20 09:30:00'
),
(
    'Đánh Giá Chi Tiết Chip Intel Core Ultra: Hiệu Năng AI Bùng Nổ',
    'danh-gia-chip-intel-core-ultra-ai',
    'Thế hệ chip mới của Intel mang lại hiệu năng xử lý đồ họa và trí tuệ nhân tạo (AI) đáng kinh ngạc cho người dùng laptop.',
    '<p>Intel Core Ultra không chỉ là một bản nâng cấp về CPU và GPU mà còn tích hợp NPU (Neural Processing Unit) chuyên dụng. Điều này mở ra cánh cửa cho các ứng dụng AI chạy trực tiếp trên thiết bị của bạn.</p>
    <p>Các bài kiểm tra cho thấy sự cải thiện rõ rệt về thời lượng pin và khả năng xử lý các tác vụ nặng liên quan đến machine learning.</p>',
    'thumbnail_2.jpg',
    'intel core ultra, chip laptop, danh gia cpu, hieu nang ai',
    '2025-11-22 14:45:00'
),
(
    'Hướng Dẫn Tối Ưu Hóa Tốc Độ Máy Tính Windows 11',
    'toi-uu-hoa-toc-do-windows-11',
    'Máy tính của bạn chạy chậm? Thực hiện ngay 7 bước đơn giản này để cải thiện tốc độ đáng kể cho hệ điều hành Windows 11.',
    '<p>Windows 11 đôi khi có thể hoạt động ì ạch nếu bạn không biết cách tối ưu hóa. Dưới đây là 7 mẹo nhỏ nhưng hiệu quả:</p>
    <ol>
        <li>Tắt các ứng dụng khởi động cùng hệ thống.</li>
        <li>Dọn dẹp các tệp tạm thời.</li>
        <li>Sử dụng tính năng chống phân mảnh ổ đĩa (nếu dùng HDD).</li>
    </ol>
    <p>Áp dụng ngay và cảm nhận sự khác biệt!</p>',
    'thumbnail_3.jpg',
    'toi uu windows, windows 11, tang toc may tinh, meo su dung',
    '2025-11-24 10:00:00'
),
(
    'Bảng Giá Laptop Gaming Cao Cấp Cập Nhật Tháng 11/2025',
    'bang-gia-laptop-gaming-thang-11-2025',
    'Tổng hợp các mẫu laptop gaming mạnh mẽ nhất từ ASUS, MSI, Acer với mức giá ưu đãi đặc biệt trong tháng này.',
    '<p>Thị trường laptop gaming cuối năm luôn sôi động với nhiều chương trình khuyến mãi. Các dòng máy trang bị RTX 40 series đang có giá tốt nhất.</p>
    <p>Đừng bỏ lỡ cơ hội sở hữu chiếc máy mơ ước với cấu hình khủng và màn hình tần số quét cao.</p>',
    'thumbnail_4.jpg',
    'laptop gaming, asus rog, msi titan, gia laptop gaming',
    '2025-11-25 16:20:00'
),
(
    'Cảnh báo: Cách nhận biết và phòng tránh lừa đảo qua email liên quan đến laptop',
    'canh-bao-lua-dao-qua-email',
    'Hàng loạt email giả mạo đang được gửi đến khách hàng với thông tin khuyến mãi giả để chiếm đoạt tài khoản.',
    '<p>Luôn kiểm tra địa chỉ email của người gửi và không bao giờ click vào các liên kết đáng ngờ. Chúng tôi không bao giờ yêu cầu bạn cung cấp mật khẩu qua email.</p>
    <p>Nếu nghi ngờ, hãy liên hệ trực tiếp qua số hotline chính thức của công ty.</p>',
    'thumbnail_5.jpg',
    'lua dao email, canh bao bao mat, laptop security, phishing',
    '2025-11-26 08:00:00'
);

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
INSERT INTO settings (`key`,`value`) VALUES
('home_banner','banner.jpg'),
('home_intro_title','Hiệu năng mạnh mẽ, thiết kế hiện đại'),
('home_intro_desc','Khám phá ngay bộ sưu tập laptop 2025'),
('company_name','Laptop Store Việt Nam'),
('company_address','123 Nguyễn Huệ, Quận 1, TP.HCM'),
('company_phone','0123456789'),
('company_email','contact@laptopstore.vn')