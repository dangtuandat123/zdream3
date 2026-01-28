# MIGRATIONS_NOTES.md

Mục tiêu: ghi chú seed data và cấu hình mặc định khi migrate.

## 1) Seed tối thiểu
- Admin user mặc định (email + password cấu hình ngoài).
- Tag mẫu (vd: Portrait, Product, Cartoon).
- Style mẫu (để test flow end-to-end).

## 2) Settings mặc định (đề xuất)
- `credits_per_vnd` / `vnd_per_credit`.
- `provider_base_url`, `provider_api_key`.
- `generation_timeout`, `poll_interval`, `max_retry`.
- `image_retention_days`.

## 3) Mục cần xác nhận
- Giá trị mặc định cho credits.
- Có cần seed model registry hay chỉ sync online?
