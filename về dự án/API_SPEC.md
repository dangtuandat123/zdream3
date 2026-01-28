# API_SPEC.md

Mục tiêu: chuẩn hóa hợp đồng API nội bộ để frontend và backend thống nhất. Nếu chưa có chuẩn, dùng nội dung dưới như baseline.

## 1) Quy ước chung
- Base path: `/api`
- Auth: **Laravel Sanctum** (session cookie cho SPA)
- Request/Response: JSON
- Pagination (đề xuất): `?page=1&per_page=20`
- Error format (đề xuất):
```
{
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "...",
    "details": {}
  }
}
```

## 2) Auth (theo Laravel)
- `GET /sanctum/csrf-cookie`
- `POST /login`
- `POST /logout`
- `POST /register` (nếu bật đăng ký)
- `POST /forgot-password` / `POST /reset-password`

## 3) Public/Client
### 3.1. Styles & Tags
- `GET /api/styles`
- `GET /api/styles/{slug}`
- `GET /api/tags`

### 3.2. Model Registry
- `GET /api/models` (list + capabilities)
- `GET /api/models/{slug}` (detail)

### 3.3. Studio / Generations
- `POST /api/generations`
  - Body (tối thiểu):
    - `style_id`
    - `options[]` (ids)
    - `user_custom_input` (optional)
    - `params` (theo model schema)
    - `images[]` (urls/base64, theo image slots)
    - `mask` / `expand` (nếu cần)
- `GET /api/generations/{id}` (status + image_url khi ready)
- `GET /api/generations` (history list)
- `DELETE /api/generations/{id}` (xóa khỏi history)

### 3.4. Wallet
- `GET /api/wallet` (balance + recent transactions)
- `POST /api/wallet/topup` (tạo QR + nội dung chuyển khoản)
- `POST /api/wallet/callback` (internal, HMAC + idempotency)

## 4) Admin (đề xuất)
- `GET/POST/PUT/DELETE /api/admin/styles`
- `GET/POST/PUT/DELETE /api/admin/style-options`
- `GET/POST/PUT/DELETE /api/admin/tags`
- `GET/POST/PUT/DELETE /api/admin/users`
- `POST /api/admin/users/{id}/adjust-credits`
- `GET /api/admin/transactions`
- `GET/POST/PUT /api/admin/settings`
- `POST /api/admin/models/sync`

## 5) Response schema đề xuất (tóm tắt)
### 5.1. Generation
```
{
  "id": 123,
  "status": "processing|completed|failed",
  "estimated_cost": 0,
  "provider_cost": 0,
  "image_url": null,
  "error_message": null,
  "created_at": "..."
}
```

### 5.2. Model
```
{
  "model_slug": "flux-2-pro",
  "label": "FLUX.2 Pro",
  "capabilities": {...},
  "param_schema": {...},
  "limits": {...}
}
```

## 6) Mục cần xác nhận
- Tên endpoint thực tế và chuẩn response (đồng nhất frontend/backend).
- Cách map `options` vào prompt final.
- Có dùng idempotency key cho `POST /api/generations`?
