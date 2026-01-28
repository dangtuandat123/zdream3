# NON_FUNCTIONAL.md

Mục tiêu: yêu cầu phi chức năng để agent triển khai đúng chuẩn vận hành.

## 1) Hiệu năng & giới hạn
- Queue xử lý generation; request API không bị block.
- Polling interval 5–10s, có backoff khi 429.
- Throttle theo model (24 concurrent, `flux-kontext-max` 6).

## 2) SLA & timeout (đề xuất)
- Timeout tạo ảnh: cấu hình theo model.
- Max retry: giới hạn để tránh treo job vô hạn.
- Watchdog: job timeout → fail + refund theo policy.

## 3) Cache
- Cache model registry + settings.
- Cache presigned URL trong thời hạn ngắn.

## 4) Logging & observability
- Log đầy đủ: request id, provider task id, user id, cost.
- Alert khi tỷ lệ fail/timeout tăng.

## 5) Data retention
- Ảnh có thể hết hạn sau N ngày (config).
- Log giao dịch giữ lâu hơn ảnh.

## 6) Mục cần xác nhận
- KPI thời gian tạo ảnh mục tiêu.
- Chính sách giữ ảnh và chi phí storage.
