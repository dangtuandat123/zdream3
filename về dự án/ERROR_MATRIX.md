# ERROR_MATRIX.md

Mục tiêu: chuẩn hóa lỗi để UI hiển thị nhất quán.

| Nguồn | Code | UX message | Hành động hệ thống | Mức độ |
|---|---|---|---|---|
| API | 401 | Phiên đăng nhập hết hạn. | Logout + redirect login | High |
| API | 403 | Bạn không có quyền. | Block action | High |
| API | 404 | Không tìm thấy dữ liệu. | Show empty | Low |
| API | 422 | Dữ liệu không hợp lệ. | Highlight field | Medium |
| BFL | 402 | Hết credits nhà cung cấp. | Fail + alert admin | High |
| BFL | 429 | Tạm quá tải. | Backoff + retry | Medium |
| BFL | Moderated | Nội dung không phù hợp. | Fail + refund | Medium |
| System | Timeout | Quá thời gian xử lý. | Fail + refund | High |
| System | Unknown | Đã có lỗi xảy ra. | Log + retry hạn chế | High |
