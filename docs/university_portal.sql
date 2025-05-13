-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 13, 2025 lúc 05:25 PM
-- Phiên bản máy phục vụ: 8.0.37
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `university_portal`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `documents`
--

CREATE TABLE `documents` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `order_number` int NOT NULL,
  `university_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `documents`
--

INSERT INTO `documents` (`id`, `name`, `link`, `order_number`, `university_id`) VALUES
(1, 'Giáo trình Lập trình Python Cơ bản', 'https://xyz.edu.vn/documents/python_basic.pdf', 1, 1),
(2, 'Tài liệu Trí tuệ Nhân tạo và Học máy', 'https938://xyz.edu.vn/documents/ai_ml_intro.pdf', 2, 1),
(3, 'Hướng dẫn Xây dựng API với Node.js', 'https://xyz.edu.vn/documents/nodejs_api.pdf', 3, 1),
(4, 'Cơ sở dữ liệu NoSQL: MongoDB', 'https://xyz.edu.vn/documents/nosql_mongodb.pdf', 1, 2),
(5, 'An ninh mạng: Các mối đe dọa và phòng chống', 'https://xyz.edu.vn/documents/cybersecurity.pdf', 2, 2),
(6, 'Tài liệu Xử lý Ngôn ngữ Tự nhiên (NLP)', 'https://xyz.edu.vn/documents/nlp_intro.pdf', 1, 3),
(7, 'Lập trình Web với ReactJS', 'https://xyz.edu.vn/documents/reactjs_web.pdf', 3, 3),
(8, 'Hệ thống thông tin thông minh', 'https://xyz.edu.vn/documents/smart_systems.pdf', 1, 4),
(9, 'Dữ liệu lớn (Big Data) và Hadoop', 'https://xyz.edu.vn/documents/bigdata_hadoop.pdf', 1, 5),
(10, 'Tài liệu DevOps và CI/CD', 'https://xyz.edu.vn/documents/devops_cicd.pdf', 1, 6),
(11, 'Lập trình di động với Flutter', 'https://xyz.edu.vn/documents/flutter_mobile.pdf', 4, 1),
(12, 'Blockchain và Ứng dụng trong CNTT', 'https://xyz.edu.vn/documents/blockchain_intro.pdf', 3, 2),
(13, 'Học sâu (Deep Learning) Cơ bản', 'https://xyz.edu.vn/documents/deep_learning.pdf', 4, 3),
(14, 'Giáo trình Cơ sở dữ liệu SQL', 'https://xyz.edu.vn/documents/sql_database.pdf', 2, 4),
(15, 'Tài liệu Mạng máy tính CCNA', 'https://xyz.edu.vn/documents/ccna_networking.pdf', 3, 5),
(16, 'Phát triển ứng dụng với Django', 'https://xyz.edu.vn/documents/django_web.pdf', 2, 6),
(21, 'Tài liệu Kubernetes Cơ bản', 'https://xyz.edu.vn/documents/kubernetes_intro.pdf', 5, 1),
(22, 'Lập trình C++ Nâng cao', 'https://xyz.edu.vn/documents/cpp_advanced.pdf', 4, 2),
(23, 'Tài liệu Phân tích Hệ thống CNTT', 'https://xyz.edu.vn/documents/system_analysis.pdf', 2, 3),
(24, 'Ứng dụng AI trong Tài chính', 'https://xyz.edu.vn/documents/ai_finance.pdf', 3, 4),
(25, 'Hướng dẫn Sử dụng Git và GitHub', 'https://xyz.edu.vn/documents/git_github.pdf', 2, 5),
(26, 'Tài liệu Phát triển Game với Unity', 'https://xyz.edu.vn/documents/unity_gamedev.pdf', 3, 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `create_at` datetime NOT NULL,
  `university_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `content`, `create_at`, `university_id`) VALUES
(1, 'Thông báo nghỉ lớp Lập trình Python abc', '<p>Lớp Lập trình Python (CN01) nghỉ ngày 15/05/2025 do giảng viên tham gia hội thảo. Lịch học bù sẽ thông báo sau. abc</p>', '2025-05-12 08:00:00', 3),
(2, 'Lịch học bù môn Trí tuệ Nhân tạo', 'Lớp Trí tuệ Nhân tạo (CN02) học bù vào 18/05/2025, 14:00 tại phòng A204. Vui lòng chuẩn bị bài tập nhóm.', '2025-05-11 10:30:00', 1),
(3, 'Seminar: Ứng dụng AI trong Y tế', 'Khoa CNTT tổ chức seminar về ứng dụng AI trong y tế. Thời gian: 20/05/2025, 9:00 AM tại hội trường A1.', '2025-05-10 09:00:00', 1),
(4, 'Lịch báo cáo cuối kỳ môn Node.js', 'Lịch báo cáo cuối kỳ môn Xây dựng API với Node.js diễn ra ngày 25/05/2025, 8:00 tại phòng B103. Nộp slide trước 22/05/2025.', '2025-05-12 07:30:00', 2),
(5, 'Thông báo nghỉ lớp Cơ sở dữ liệu', 'Lớp Cơ sở dữ liệu NoSQL (CN03) nghỉ ngày 16/05/2025 do sự cố kỹ thuật. Lịch học bù sẽ được cập nhật.', '2025-05-11 11:00:00', 2),
(6, 'Workshop: Xây dựng API với Node.js', 'Workshop thực hành xây dựng API sử dụng Node.js diễn ra vào 22/05/2025, 13:00 tại phòng C305. Đăng ký trước 20/05/2025.', '2025-05-10 10:00:00', 2),
(7, 'Thông báo nộp bài tập môn An ninh mạng', 'Bài tập lớn môn An ninh mạng cần nộp trước 27/05/2025 qua hệ thống LMS. Không nhận bài muộn.', '2025-05-12 08:30:00', 3),
(8, 'Lịch học bù môn ReactJS', 'Lớp Lập trình Web với ReactJS (CN04) học bù vào 19/05/2025, 10:00 tại phòng D102. Chuẩn bị project demo.', '2025-05-11 09:00:00', 3),
(9, 'Cuộc thi lập trình Hackathon 2025', 'Khoa CNTT tổ chức Hackathon 2025. Thời gian: 28/05/2025. Đăng ký nhóm trước 25/05/2025.', '2025-05-10 08:00:00', 3),
(10, 'Thông báo nghỉ lớp Hệ thống thông minh', 'Lớp Hệ thống thông tin thông minh (CN05) nghỉ ngày 17/05/2025 do giảng viên có việc đột xuất. Lịch học bù sẽ thông báo sau.', '2025-05-12 07:00:00', 4),
(11, 'Lịch báo cáo cuối kỳ môn Big Data', 'Lịch báo cáo cuối kỳ môn Dữ liệu lớn diễn ra ngày 26/05/2025, 13:00 tại phòng E203. Nộp báo cáo trước 23/05/2025.', '2025-05-11 12:00:00', 4),
(12, 'Hội thảo: Hệ thống thông tin thông minh', 'Hội thảo về hệ thống thông tin thông minh diễn ra vào 21/05/2025, 10:00 AM tại hội trường C. Đăng ký tham gia trước 19/05/2025.', '2025-05-10 09:30:00', 4),
(13, 'Lịch học bù môn DevOps', 'Lớp DevOps (CN06) học bù vào 20/05/2025, 15:00 tại phòng F104. Vui lòng mang theo tài liệu CI/CD.', '2025-05-12 08:00:00', 5),
(14, 'Thông báo nộp đề cương môn Flutter', 'Đề cương bài tập lớn môn Lập trình di động với Flutter cần nộp trước 24/05/2025 qua email giảng viên.', '2025-05-11 10:00:00', 5),
(15, 'Seminar: IoT và Thành phố thông minh', 'Seminar về IoT và ứng dụng trong thành phố thông minh diễn ra vào 23/05/2025, 9:00 AM tại hội trường D.', '2025-05-10 11:00:00', 5),
(16, 'Thông báo nghỉ lớp Blockchain', 'Lớp Blockchain (CN07) nghỉ ngày 18/05/2025 do trùng lịch hội thảo. Lịch học bù sẽ được cập nhật.', '2025-05-12 09:00:00', 6),
(17, 'Lịch báo cáo cuối kỳ môn NLP', 'Lịch báo cáo cuối kỳ môn Xử lý Ngôn ngữ Tự nhiên diễn ra ngày 27/05/2025, 14:00 tại phòng G205. Nộp slide trước 24/05/2025.', '2025-05-11 08:30:00', 6),
(31, 'Thông báo abc', '<p>Thông báo abcThông báo abc</p><p>Thông báo abc</p><p>v</p><p><strong>Thông báo abc</strong></p><p>v</p><p>Thông báo <strong>abc</strong></p>', '2025-05-12 17:18:25', 1),
(32, 'Thông báo abc', '<p>Thông báo abcThông báo abcThông báo abc</p>', '2025-05-12 17:19:02', 1),
(33, 'Thông báo abc', '<p>Thông báo abcThông báo abcThông báo abc</p>', '2025-05-12 17:19:14', 1),
(34, 'Thông báo abc', '<p>Thông báo abcThông báo abcThông báo abc</p>', '2025-05-12 17:20:31', 1),
(35, 'fadsfads', '<p>fasdfasdf</p>', '2025-05-12 17:20:52', 1),
(36, '123123', '<p>31231231</p>', '2025-05-12 17:22:18', 1),
(37, '123123', '<p>31231231</p>', '2025-05-12 17:24:13', 1),
(39, 'àdf', '<p>ấdfasdfas</p>', '2025-05-12 17:26:32', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `profile`
--

CREATE TABLE `profile` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `workplace` text NOT NULL,
  `short_intro` text NOT NULL,
  `detailed_intro` text NOT NULL,
  `research_fields` text NOT NULL,
  `contact_info` text NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `profile`
--

INSERT INTO `profile` (`id`, `name`, `workplace`, `short_intro`, `detailed_intro`, `research_fields`, `contact_info`, `avatar`) VALUES
(1, 'TS. Nguyễn Văn A', 'Giảng viên Khoa Công nghệ Thông tin', '<p>Với hơn 20 năm kinh nghiệm giảng dạy và nghiên cứu, tôi luôn nỗ lực đóng góp vào sự phát triển của ngành Công nghệ Thông tin tại Việt Nam.</p>', '<p>Xin chào! Tôi là Nguyễn Văn A, Tiến sĩ tại Trường Đại học XYZ. Với hơn 20 năm giảng dạy và nghiên cứu, tôi cố gắng đóng góp cho ngành Công nghệ Thông tin ở Việt Nam. Tôi yêu thích công nghệ, thích chia sẻ kiến thức với sinh viên và tham gia nghiên cứu về trí tuệ nhân tạo, dữ liệu lớn, an ninh mạng. Mục tiêu của tôi là giúp sinh viên học tốt và hỗ trợ phát triển các giải pháp công nghệ hữu ích.</p>', '<p>1. Trí tuệ nhân tạo (AI) và Học máy (Machine Learning): <a href=\"https://scholar.google.com/\">nghiên cứu của tôi</a>.</p><p>2. Xử lý ngôn ngữ tự nhiên (NLP): <a href=\"https://scholar.google.com/\">nghiên cứu của tôi</a>.</p><p>3. Hệ thống thông tin thông minh: <a href=\"https://scholar.google.com/\">nghiên cứu của tôi</a>.</p>', '<p>Email: nguyenvana@xyz.edu.vn&nbsp;</p><p>Điện thoại: &nbsp;0123 456 789</p><p><a href=\"https://www.facebook.com/\">Facebook</a></p><p><a href=\"https://github.com/\">Github</a></p>', '682180b853c7a-1824-quan-3112.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `universities`
--

CREATE TABLE `universities` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `universities`
--

INSERT INTO `universities` (`id`, `name`) VALUES
(1, 'Trường Đại học Tôn Đức Thắng'),
(2, 'Đại học Quốc gia TP.HCM'),
(3, 'Đại học Bách Khoa TP.HCM'),
(4, 'Đại học Kinh tế TP.HCM'),
(5, 'Đại học Sư phạm Kỹ thuật TP.HCM'),
(6, 'Đại học Văn Lang');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `university_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `role`, `university_id`) VALUES
(2, 'tdtu1@gmail.com', '123456', 'TDTU1', 'USER', 1),
(3, 'tdtu2@gmail.com', '123456', 'TDTU2', 'USER', 1),
(4, 'vnuhcm1@gmail.com', '123456', 'VNU-HCM-1', 'USER', 2),
(5, 'vnuhcm2@gmail.com', '123456', 'VNU-HCM-1', 'USER', 2),
(6, 'vnuhcm3@gmail.com', '123456', 'VNU-HCM-3', 'USER', 2),
(7, 'hcmut1@gmail.com', '123456', 'HCMUT-1', 'USER', 3),
(8, 'hcmut2@gmail.com', '123456', 'HCMUT-2', 'USER', 3),
(9, 'ueh1@gmail.com', '123456', 'UEH-1', 'USER', 4),
(10, 'ueh2@gmail.com', '123456', 'UEH-2', 'USER', 4),
(11, 'ute1@gmail.com', '123456', 'UTE-1', 'USER', 5),
(12, 'ute2@gmail.com', '123456', 'UTE-2', 'USER', 5),
(13, 'vlu1@gmail.com', '123456', 'VLU-2', 'USER', 6),
(14, 'admin2@gmail.com', '123456', 'Quản Trị Viên 2', 'ADMIN', 1),
(15, 'admin@gmail.com', '123456', 'Quản Trị Viên', 'ADMIN', 1);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
