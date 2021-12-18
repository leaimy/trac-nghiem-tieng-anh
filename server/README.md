# Dự án Website Trắc Nghiệm Tiếng Anh 🍍🍍🍍

## 1. Nhóm tác giả 🍎🍎🍎

- Nguyễn Thị Hà
- Nguyễn Trọng Hiếu
- Nguyễn Ngọc Quang

## 2. Cách cài đặt Server

- Tải dự án về
- Đổi tên tập tin `ninja-config-example.json` thành `ninja-config.json`
- Mở terminal, di chuyển vào thư mục `server` và chạy lệnh `php -S 127.0.0.1:5000 -t public_html`

## 3. Thống kê SQL

3.1. Quản lý lịch sử bài kiểm tra trắc nghiệm

3.1.1. Phân tích số lượng bài trắc nghiệm theo người tạo

- Bởi admin (từ trang quản lý)
- Bởi người dùng (tạo bài trắc nghiệm tự động)

```sql
DROP PROCEDURE IF EXISTS AnalyseQuizzesQuantityByAuthor;

DELIMITER //

CREATE PROCEDURE AnalyseQuizzesQuantityByAuthor()
BEGIN
	DECLARE total INT DEFAULT 0;
	DECLARE total_by_anonymous INT DEFAULT 0;
	DECLARE total_by_admin INT DEFAULT 0;
	
	SELECT COUNT(*) INTO total FROM quiz;
	SELECT COUNT(*) INTO total_by_anonymous FROM quiz WHERE quiz.random_at IS NULL;
	
	SET total_by_admin = total - total_by_anonymous;
	
	SELECT total AS 'total', total_by_anonymous AS 'by_anonymous', total_by_admin AS 'by_admin';
END //

DELIMITER ;

CALL AnalyseQuizzesQuantityByAuthor();
```
