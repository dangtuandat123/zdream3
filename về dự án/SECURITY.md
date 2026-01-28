# SECURITY.md

Mục tiêu: chuẩn bảo mật tối thiểu cho hệ thống.

## 1) Auth & Session
- Dùng Sanctum cho SPA.
- Bắt buộc `/sanctum/csrf-cookie` trước login.
- CORS `supports_credentials=true` và `stateful` đúng domain.

## 2) Quyền truy cập
- Chỉ owner có thể xem/xóa ảnh.
- Admin endpoint bắt buộc role admin.

## 3) Secrets & Config
- Không commit secret vào repo.
- Rotate MINIO/VietQR/API key khi deploy thật.

## 4) Input validation
- Chặn SSRF khi nhận URL ảnh.
- Validate kích thước, định dạng, mask.

## 5) Idempotency
- Topup và refund phải có idempotency key.
- Không cộng credits trùng.

## 6) Rate limiting
- API public rate-limit theo IP/user.
- Internal callback cần secret + rate-limit.
