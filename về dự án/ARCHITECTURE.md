# ARCHITECTURE.md

Mục tiêu: mô tả kiến trúc ở mức đủ chi tiết để agent có thể bắt tay vào code ngay, **không suy đoán** phần nghiệp vụ chưa xác nhận.
Stack mục tiêu: **Laravel 12 (API)** + **ReactJS CSR (SPA)**.

## 1) Phạm vi & nguyên tắc
- API-first, mọi UI gọi qua JSON API.
- SPA CSR, không SSR.
- Không hardcode model AI; sync từ provider và render UI theo capability.
- Tất cả generation chạy **async** qua queue + polling.
- Ảnh kết quả luôn **download ngay** và **re-serve** qua storage nội bộ.

## 2) Sơ đồ tổng quát (text)
```
[React SPA]
    -> [Laravel API]
        -> [MySQL]
        -> [Queue/Workers]
            -> [BFL API: create task]
            -> [polling_url]
            -> [download result]
        -> [MinIO S3]
    <- [API JSON + Presigned URLs]

[VietQR/Bank] -> [Callback endpoint nội bộ] -> [Laravel API]
```

## 3) Thành phần & trách nhiệm
- **Frontend SPA**: render Style/Studio/Wallet/History; polling status; upload ảnh tham chiếu.
- **API Gateway/Controllers**: auth, validation, request orchestration.
- **Domain Services**:
  - `GenerationService`: build prompt, map params, tạo task provider.
  - `ModelRegistryService`: sync model schema & capabilities.
  - `WalletService`: trừ/hoàn credits, idempotency.
  - `StorageService`: upload MinIO, presigned URL.
- **Queue Workers**:
  - Submit generation.
  - Poll provider result.
  - Reconcile cost/credits.
- **Scheduler**: sync models; cleanup data; retry/reconcile.
- **Admin Module**: CRUD Style/Option/Tag/Settings/Users.

## 4) Luồng chính (tóm tắt)
### 4.1. Tạo ảnh
1) UI gửi yêu cầu tạo ảnh.
2) API validate credits + inputs theo model capability.
3) Lưu `generated_images` trạng thái `processing` + trừ credits tạm.
4) Dispatch job tạo task và lưu `provider_task_id` + `provider_polling_url`.
5) Polling job kiểm tra trạng thái; khi `ready` → download ảnh → upload MinIO → update record.

### 4.2. Nạp tiền (VietQR)
1) UI tạo yêu cầu nạp → nhận QR + thông tin chuyển khoản.
2) Bank/VietQR callback vào endpoint nội bộ.
3) Verify chữ ký/HMAC + idempotency + số tiền.
4) Cộng credits + log giao dịch.

### 4.3. Sync model registry
- Job định kỳ gọi provider OpenAPI/registry → cập nhật bảng `provider_models`.
- UI dùng `/api/models` để render controls.

## 5) Quyết định kiến trúc bắt buộc
- **Bắt buộc dùng `polling_url`** từ provider.
- **Không sử dụng trực tiếp URL kết quả** (hết hạn nhanh, không CORS).
- **Rate-limit theo model** ở tầng queue (vd: `flux-kontext-max` max 6 concurrent).

## 6) Ranh giới & out-of-scope
- Không huấn luyện model tại chỗ.
- Không xây server-side rendering.
- Không mở public API cho bên thứ ba (trừ khi bổ sung sau).

## 7) Điểm cần xác nhận
- Hợp đồng callback VietQR (payload + signature).
- Chính sách hoàn credits khi lỗi/moderated.
- SLA cho thời gian tạo ảnh và retry policy.
- Domain/port thực tế của SPA để cấu hình Sanctum.
