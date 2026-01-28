# INTEGRATIONS.md

Mục tiêu: mô tả chi tiết tích hợp bên ngoài để agent code đúng quy tắc.

## 1) BFL (bfl.ai / FLUX)
### 1.1. Luồng tích hợp
1) Gửi request tạo task.
2) Nhận `task_id` + **`polling_url`**.
3) Polling theo `polling_url` đến khi `ready`.
4) Download ảnh ngay (URL kết quả hết hạn nhanh) → upload MinIO.

### 1.2. Quy tắc bắt buộc
- **Luôn dùng `polling_url`** do provider trả về.
- URL kết quả có **thời hạn ngắn** và **không CORS** ⇒ phải download server-side.
- **Rate limit concurrent**: tối đa 24 task, riêng `flux-kontext-max` tối đa 6.
- Xử lý lỗi: 402 (hết credits), 429 (rate limit), 5xx (retry có giới hạn).

### 1.3. Giới hạn & lưu ý từ docs
- Ảnh input > 4MP sẽ bị resize tự động.
- Ảnh không bội số 16 sẽ bị crop.
- **FLUX.2 Pro** có giới hạn **tổng input+output 9MP**.
- `safety_tolerance` có range khác nhau theo model (ví dụ 0–5 hoặc 0–6).
- Kontext có giới hạn prompt ngắn hơn (≈512 tokens).
- Inpainting yêu cầu mask khớp kích thước ảnh.

### 1.4. Capability-driven UI
- Lấy schema từ provider, render controls theo `capabilities/param_schema`.
- Không hardcode model/param.

## 2) MinIO (S3-compatible)
- Upload ảnh kết quả vào bucket nội bộ.
- Trả ảnh qua presigned URL hoặc proxy API.
- Không expose URL provider ra client.

## 3) VietQR / chuyển khoản
- UI hiển thị QR + thông tin chuyển khoản.
- Callback nội bộ cần HMAC + idempotency.
- Xác minh amount + nội dung chuyển khoản trước khi cộng credits.

## 4) Mục cần xác nhận
- Payload callback VietQR (field name + signature algorithm).
- Thời hạn presigned URL nội bộ.
