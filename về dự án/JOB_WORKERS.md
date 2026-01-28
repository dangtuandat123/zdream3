# JOB_WORKERS.md

Mục tiêu: liệt kê các job và lịch chạy cho queue/scheduler.

## 1) Job chính
- **SubmitGenerationJob**: tạo task provider, lưu `polling_url`.
- **PollGenerationResultJob**: poll trạng thái → download ảnh → upload MinIO.
- **ReconcileCreditsJob**: cập nhật cost thực tế và log giao dịch.
- **SyncProviderModelsJob**: sync model registry định kỳ.
- **CleanupExpiredImagesJob**: dọn ảnh hết hạn và bản ghi liên quan.

## 2) Scheduler (đề xuất)
- Sync models: mỗi 6–12h hoặc theo config.
- Cleanup images: chạy nightly.

## 3) Retry policy (đề xuất)
- 429: exponential backoff.
- 5xx: retry giới hạn.
- Task not found: retry 1–2 lần rồi fail.

## 4) Mục cần xác nhận
- Tên job thực tế + queue name.
- Số lần retry và delay cụ thể.
