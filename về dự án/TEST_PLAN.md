# TEST_PLAN.md

Mục tiêu: danh sách test cases cốt lõi.

## 1) Unit tests
- Build prompt từ Style + Options + user input.
- Validate params theo model schema.
- Wallet: trừ/hoàn credits + idempotency.

## 2) Integration tests
- Tạo generation → poll ready → upload MinIO.
- VietQR callback hợp lệ/không hợp lệ.
- Sync model registry từ provider.

## 3) E2E tests (SPA)
- Duyệt style → tạo ảnh → xem history.
- Nạp tiền → credits tăng.
- Admin CRUD Style/Option/Tag.

## 4) Error/edge cases
- Ảnh input > 4MP (auto resize).
- Ảnh không bội số 16 (crop).
- Moderated → refund.
- Provider 429 → backoff.
