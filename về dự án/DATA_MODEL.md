# DATA_MODEL.md

Mục tiêu: liệt kê mô hình dữ liệu đủ rõ để tạo migration + seed. Dữ liệu chi tiết có thể điều chỉnh sau khi xác nhận.

## 1) Quan hệ chính (tóm tắt)
- `users` 1‑N `generated_images`
- `users` 1‑N `wallet_transactions`
- `styles` 1‑N `style_options`
- `tags` 1‑N `styles`
- `provider_models` dùng để render UI + validate params

## 2) Bảng & cột chính
### 2.1. `users`
- `id`, `name`, `email`, `password`
- `credits`, `is_admin`, `is_active`
- timestamps

### 2.2. `styles`
- `id`, `name`, `slug`, `description`, `thumbnail_url`
- `price`, `is_active`, `sort_order`
- `provider_model_id` (hiện tại là `bfl_model_id`), `legacy_provider_model_id` (hiện tại là `openrouter_model_id`)
- `base_prompt`, `config_payload` (JSON)
- `allow_user_custom_prompt`
- `capabilities` (JSON)
- `image_slots` (JSON), `system_images` (JSON)
- `tag_id`

### 2.3. `style_options`
- `id`, `style_id`, `label`, `group_name`, `prompt_fragment`
- `icon`, `thumbnail`
- `sort_order`, `is_default`

### 2.4. `tags`
- `id`, `name`, `color_from`, `color_to`, `icon`, `sort_order`, `is_active`

### 2.5. `generated_images`
- `id`, `user_id`, `style_id`
- `final_prompt`, `selected_options` (JSON), `user_custom_input`
- `generation_params` (JSON)
- `estimated_cost`, `provider_cost`
- `provider_task_id` (hiện tại `bfl_task_id`), `provider_polling_url`
- `legacy_provider_task_id` (hiện tại `openrouter_id`)
- `storage_path`
- `status` (`pending|processing|completed|failed`)
- `error_message`, `credits_used`
- timestamps, soft deletes

### 2.6. `wallet_transactions`
- `id`, `user_id`
- `type` (`credit|debit`), `amount`
- `balance_before`, `balance_after`
- `reason`, `source`, `reference_id`
- timestamps

### 2.7. `settings`
- `key`, `value`, `type`, `group`, `label`, `description`, `is_encrypted`

### 2.8. `provider_models`
- `id`, `provider`, `model_slug`, `label`, `version`
- `endpoint`, `category` (t2i/i2i/inpaint/outpaint/finetune)
- `capabilities` (JSON), `param_schema` (JSON), `limits` (JSON)
- `is_active`, `synced_at`

## 3) Constraints & index đề xuất
- Unique: `styles.slug`, `tags.name`, `provider_models.model_slug`.
- `wallet_transactions.reference_id` unique để đảm bảo idempotency.
- Index: `generated_images.user_id`, `generated_images.status`, `styles.tag_id`.

## 4) Dữ liệu JSON
- `styles.capabilities` và `provider_models.capabilities` phải đồng bộ schema.
- `generated_images.generation_params` lưu đúng payload gửi provider.

## 5) Dữ liệu seed tối thiểu (đề xuất)
- Admin user mặc định.
- Tag/Style mẫu.
- Settings: tỷ lệ VND ↔ credits, provider base URL, timeout, rate limit.

## 6) Mục cần xác nhận
- Kiểu dữ liệu cho `credits` (int/decimal).
- Có cần bảng `credit_holds` nếu giữ tạm?
- Chuẩn hóa `provider_model_id` (đổi tên cột?).
