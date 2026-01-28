# USER_FLOWS.md

Mục tiêu: mô tả rõ luồng người dùng để agent dựng UI + API đúng hành vi.

## 1) Duyệt Style
**Tiền đề**: Guest hoặc user.
1) Mở trang danh mục.
2) Filter/sort/search.
3) Click một Style → trang Studio.

## 2) Tạo ảnh (Studio)
**Tiền đề**: User đã đăng nhập, đủ credits.
1) Chọn options theo nhóm.
2) (Tuỳ style) nhập mô tả bổ sung.
3) (Tuỳ model) chọn tỉ lệ/size.
4) Upload ảnh tham chiếu theo slot.
5) (Tuỳ model) upload mask / nhập expand.
6) Nhấn “Tạo ảnh”.
7) UI chuyển sang trạng thái processing + polling.
8) Thành công: hiển thị ảnh + nút tải về.
9) Thất bại: thông báo lỗi + hoàn credits theo policy.

## 3) Lịch sử ảnh
1) Mở trang History.
2) Lọc theo trạng thái/style.
3) Xem thumbnail, tải ảnh, xoá ảnh.

## 4) Ví & nạp tiền
1) Mở Wallet.
2) Tạo QR + hiển thị thông tin chuyển khoản.
3) Chuyển khoản theo hướng dẫn.
4) Khi callback xác nhận → cộng credits + thông báo.

## 5) Quản trị
1) Admin đăng nhập.
2) Quản lý Style/Option/Tag/Settings.
3) Xem giao dịch, chỉnh credits.

## 6) Edge cases cần xử lý
- Không đủ credits → chặn submit.
- Model không hỗ trợ param → ẩn/disable UI.
- Polling timeout → thông báo rõ ràng.
- Link kết quả hết hạn → luôn re-serve nội bộ.
