
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
INSERT INTO faqs (type, question, answer) VALUES
('Câu hỏi chung','Laptop có được bảo hành chính hãng không?', 'Tất cả laptop đều được bảo hành chính hãng 12 tháng.'),
('Câu hỏi chung','Chính sách đổi trả như thế nào?', 'Bạn có thể đổi trả trong vòng 7 ngày nếu sản phẩm lỗi do nhà sản xuất.'),
('Câu hỏi chung','Phương thức thanh toán nào được chấp nhận?', 'Chúng tôi chấp nhận thanh toán qua thẻ tín dụng, chuyển khoản và COD.'),
('Câu hỏi chung','Có chương trình khuyến mãi nào hiện có không?', 'Vui lòng kiểm tra trang khuyến mãi của chúng tôi để biết thông tin mới nhất.'),
('Shipping','Có hỗ trợ giao hàng toàn quốc không?', 'Chúng tôi giao hàng toàn quốc qua các đối tác uy tín.'),
('Shipping','Thời gian giao hàng mất bao lâu?', 'Thời gian giao hàng thường từ 2-5 ngày tùy khu vực.'),
('Shipping','Phí vận chuyển được tính như thế nào?', 'Phí vận chuyển sẽ được tính dựa trên địa chỉ giao hàng và tổng giá trị đơn hàng.'),
('Đặt hàng','Làm thế nào để đặt hàng trực tuyến?', 'Bạn có thể chọn sản phẩm và thêm vào giỏ hàng, sau đó tiến hành thanh toán.'),
('Đặt hàng','Tôi có thể hủy đơn hàng không?', 'Bạn có thể hủy đơn hàng trước khi nó được xử lý và giao đi.'),
('Đặt hàng','Làm sao để theo dõi đơn hàng?', 'Bạn có thể theo dõi đơn hàng qua tài khoản trên website.'),
('Hỗ trợ kỹ thuật','Laptop có hỗ trợ nâng cấp RAM và ổ cứng không?', 'Nhiều mẫu laptop cho phép nâng cấp, vui lòng kiểm tra thông số kỹ thuật.'),
('Hỗ trợ kỹ thuật','Làm thế nào để cài đặt phần mềm trên laptop mới?', 'Chúng tôi cung cấp hướng dẫn cài đặt phần mềm cơ bản khi bạn mua laptop.');


-- Dữ liệu bảng settings
INSERT INTO settings (`key`, `value`) VALUES
('company_name', 'Laptop Store Việt Nam'),
('company_address', '123 Nguyễn Văn Linh, Đà Nẵng'),
('company_phone', '0123 456 789'),
('company_email', 'contact@laptopstore.vn'),
('company_logo', 'logo.png'),
('home_banner', 'banner.jpg'),
('home_intro_title', 'Chào mừng đến với Laptop Store'),
('home_intro_desc', 'Cung cấp laptop chất lượng cao với giá tốt nhất.');
('about_title', 'Về Chúng Tôi'),
('about_subtitle', 'Khám phá câu chuyện và giá trị cốt lõi của Laptop Store Việt Nam'),
('about_mission', 'Tại Laptop Store Việt Nam, sứ mệnh của chúng tôi là cung cấp những sản phẩm laptop chất lượng cao với giá cả hợp lý, đồng thời mang đến dịch vụ khách hàng xuất sắc. Chúng tôi cam kết không ngừng cải tiến và đổi mới để đáp ứng nhu cầu ngày càng cao của khách hàng.<br><br>Chúng tôi tin rằng công nghệ có thể thay đổi cuộc sống và chúng tôi muốn là cầu nối giúp khách hàng tiếp cận với những sản phẩm tốt nhất trên thị trường. Sự hài lòng của khách hàng luôn là ưu tiên hàng đầu của chúng tôi.'),
('about_values', '<ul class="list-group list-group-flush"><li class="list-group-item"><strong>Chất Lượng:</strong> Chỉ cung cấp sản phẩm đạt tiêu chuẩn cao nhất.</li><li class="list-group-item"><strong>Đổi Mới:</strong> Luôn cập nhật công nghệ mới nhất.</li><li class="list-group-item"><strong>Dịch Vụ:</strong> Hỗ trợ và phục vụ khách hàng tận tâm.</li><li class="list-group-item"><strong>Trách Nhiệm:</strong> Đóng góp tích cực cho cộng đồng.</li></ul>');

-- Dữ liệu bảng creators
INSERT INTO creators (name, bio, role, profile_image) VALUES
('Nguyễn Văn A', 'Là sinh viên CNTT đam mê công nghệ và lập trình web.', 'Frontend Developer', 'nguyenvana.jpg'),
('Lê Thị B', 'Chuyên gia thiết kế đồ họa với hơn 5 năm kinh nghiệm.', 'UI/UX Designer', 'lethib.jpg'),
('Trần Minh C', 'Backend Developer với kỹ năng quản lý cơ sở dữ liệu.', 'Backend Developer', 'tranminhc.jpg'),
('Phạm Lan D', 'Chuyên viên marketing kỹ thuật số và quản lý dự án.', 'Digital Marketer', 'phamland.jpg');
