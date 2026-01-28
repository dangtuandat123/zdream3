# PERMISSIONS.md

Mục tiêu: ma trận quyền để backend + frontend thống nhất.

| Quyền / Vai trò | Guest | User | Admin |
|---|---|---|---|
| Xem Style | ✅ | ✅ | ✅ |
| Tạo ảnh | ❌ | ✅ | ✅ |
| Xem lịch sử cá nhân | ❌ | ✅ | ✅ |
| Xóa ảnh cá nhân | ❌ | ✅ | ✅ |
| Nạp tiền | ❌ | ✅ | ✅ |
| Quản lý Style/Option/Tag | ❌ | ❌ | ✅ |
| Quản lý Users/Transactions | ❌ | ❌ | ✅ |
| Cấu hình Settings | ❌ | ❌ | ✅ |

Ghi chú: có thể bổ sung role `editor` nếu cần phân quyền tinh hơn.
