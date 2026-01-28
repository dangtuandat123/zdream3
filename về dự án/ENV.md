# ENV.md

Mục tiêu: liệt kê các biến môi trường cần thiết. **Không commit secret thật**.

## 1) Core
- `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_DEBUG`, `APP_URL`

## 2) Database
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

## 3) Cache/Queue/Session
- `CACHE_DRIVER`, `QUEUE_CONNECTION`, `SESSION_DRIVER`, `SESSION_LIFETIME`, `FILESYSTEM_DISK`

## 4) Storage (MinIO)
- `MINIO_ENDPOINT`
- `MINIO_ACCESS_KEY`
- `MINIO_SECRET_KEY`
- `MINIO_BUCKET`
- `MINIO_REGION`
- `MINIO_USE_PATH_STYLE_ENDPOINT`

## 5) BFL Provider
- `BFL_BASE_URL`
- `BFL_API_KEY`
- `BFL_SYNC_CRON` (chu kỳ sync model, nếu dùng scheduler)

## 6) VietQR
- `VIETQR_BANK_ID`
- `VIETQR_ACCOUNT_NUMBER`
- `VIETQR_ACCOUNT_NAME`
- `VIETQR_TEMPLATE`

## 7) Internal security
- `INTERNAL_API_SECRET` (HMAC hoặc secret cho callback)

## 8) Ghi chú
- Các giá trị trong `config.txt` chỉ là **mẫu**; cần chuyển sang `.env` thật và rotate secrets.
