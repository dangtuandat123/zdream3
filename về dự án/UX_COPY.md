# UX_COPY.md

Mục tiêu: chuẩn hóa microcopy/labels/error để UI nhất quán. Có thể chỉnh tone sau.

## 1) Tone & nguyên tắc
- Ngắn gọn, dễ hiểu, tránh thuật ngữ kỹ thuật.
- Ưu tiên hành động rõ ràng (CTA cụ thể).
- Không đổ lỗi người dùng.

## 2) Trạng thái chung
| Key | Text | Khi nào |
|---|---|---|
| LOADING_GENERIC | Đang xử lý… | Loading chung |
| EMPTY_GENERIC | Chưa có dữ liệu | Empty state |
| ERROR_GENERIC | Đã có lỗi xảy ra. Vui lòng thử lại. | Lỗi không xác định |
| SESSION_EXPIRED | Phiên đăng nhập hết hạn. Vui lòng đăng nhập lại. | 401/419 |

## 3) Studio
| Key | Text | Khi nào |
|---|---|---|
| STUDIO_REQUIRE_IMAGE | Vui lòng tải ảnh tham chiếu. | Model i2i yêu cầu ảnh |
| STUDIO_REQUIRE_MASK | Vui lòng tải mask đúng kích thước ảnh. | Inpainting |
| STUDIO_INVALID_SIZE | Kích thước ảnh chưa hợp lệ. | Size vượt giới hạn |
| STUDIO_INSUFFICIENT_CREDITS | Bạn không đủ credits để tạo ảnh. | Credits thiếu |
| STUDIO_PROCESSING | Đang tạo ảnh… | Sau submit |
| STUDIO_READY | Ảnh đã sẵn sàng! | Ready |
| STUDIO_FAILED | Không thể tạo ảnh. Vui lòng thử lại. | Failed |
| STUDIO_MODERATED | Ảnh bị từ chối do chính sách nội dung. | Moderated |

## 4) Wallet
| Key | Text | Khi nào |
|---|---|---|
| WALLET_TOPUP_TITLE | Nạp tiền qua chuyển khoản | Section title |
| WALLET_TOPUP_PENDING | Đang chờ xác nhận giao dịch… | Sau khi tạo QR |
| WALLET_TOPUP_SUCCESS | Nạp tiền thành công! | Callback OK |
| WALLET_TOPUP_FAILED | Không thể xác nhận giao dịch. | Callback failed |

## 5) History
| Key | Text | Khi nào |
|---|---|---|
| HISTORY_EMPTY | Bạn chưa có ảnh nào. | Empty history |
| HISTORY_DELETE_CONFIRM | Xóa ảnh này khỏi lịch sử? | Confirm delete |

## 6) Admin
| Key | Text | Khi nào |
|---|---|---|
| ADMIN_SAVE_SUCCESS | Lưu thay đổi thành công. | Save OK |
| ADMIN_SAVE_FAILED | Lưu thất bại. Vui lòng thử lại. | Save error |
