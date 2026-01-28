# Model Capabilities (BFL/FLUX)

> Mục tiêu: mô tả capability matrix chi tiết theo tài liệu BFL local.  
> Thực tế **không hardcode**: runtime phải sync schema từ provider OpenAPI.

---

## Nguyên tắc bắt buộc
- **Danh sách model + schema tham số lấy từ provider** (`openapi.json` + endpoints liên quan).
- File này là **baseline** để thiết kế UI/logic; dữ liệu thực tế do **Model Registry** sync.
- UI luôn render theo `capabilities`/`param_schema` do backend trả về.

## Legend (cột dùng trong bảng)
- **Category**: `t2i` (text‑to‑image), `i2i` (image‑to‑image), `inpaint`, `outpaint`, `finetune`, `utility`.
- **Refs**: số ảnh tham chiếu tối đa (input_image_1..n).
- **Req**: trường bắt buộc (prompt/image/mask/expand/finetune_id).
- **Params**: tham số chính (seed, steps, guidance, safety_tolerance, output_format, raw, prompt_upsampling…).
- **Size**: ràng buộc kích thước (min/max/multiple, aspect_ratio).
- **Notes**: lưu ý quan trọng từ guides (TTL, CORS, prompt rules, rate limit…).

---

## FLUX.2 (t2i + i2i)
> Prompt có thể rất dài (tới ~32K tokens cho i2i). Output tối đa ~4MP; kích thước là bội số của 16.  
> I2I hỗ trợ multi‑reference theo model.

| Model | Endpoint | Category | Refs | Req | Params | Size | Notes |
|---|---|---|---|---|---|---|---|
| FLUX.2 [max] | `/v1/flux-2-max` | t2i + i2i | 8 | `prompt` | `seed`, `width`, `height`, `safety_tolerance`, `output_format`, `webhook_*` | min 64x64, max 4MP, bội 16 | Grounding search (model hỗ trợ) |
| FLUX.2 [pro] | `/v1/flux-2-pro` | t2i + i2i | 8 | `prompt` | `seed`, `width`, `height`, `safety_tolerance`, `output_format`, `webhook_*` | min 64x64, max 4MP, bội 16 | Production‑grade |
| FLUX.2 [flex] | `/v1/flux-2-flex` | t2i + i2i | 8 | `prompt` | `steps`, `guidance`, `prompt_upsampling`, `seed`, `width`, `height`, `safety_tolerance`, `output_format`, `webhook_*` | min 64x64, max 4MP, bội 16 | Hỗ trợ điều khiển chi tiết |
| FLUX.2 [klein‑4b] | `/v1/flux-2-klein-4b` | t2i + i2i | 4 | `prompt` | `seed`, `width`, `height`, `safety_tolerance`, `output_format`, `webhook_*` | min 64x64, max 4MP, bội 16 | **Không** prompt upsampling |
| FLUX.2 [klein‑9b] | `/v1/flux-2-klein-9b` | t2i + i2i | 4 | `prompt` | `seed`, `width`, `height`, `safety_tolerance`, `output_format`, `webhook_*` | min 64x64, max 4MP, bội 16 | **Không** prompt upsampling |

---

## FLUX.1 Kontext (t2i + i2i)
> Một endpoint xử lý cả t2i và i2i.  
> Output ~1MP, aspect_ratio 3:7 → 7:3, kích thước làm tròn bội số 32 (editing).

| Model | Endpoint | Category | Refs | Req | Params | Size | Notes |
|---|---|---|---|---|---|---|---|
| Kontext [pro] | `/v1/flux-kontext-pro` | t2i + i2i | 4 | `prompt` (i2i: `input_image`) | `aspect_ratio`, `seed`, `prompt_upsampling`, `safety_tolerance`, `output_format`, `webhook_*` | ~1MP, aspect_ratio 3:7→7:3 | Text editing (Replace 'old' with 'new'), annotation boxes |
| Kontext [max] | `/v1/flux-kontext-max` | t2i + i2i | 4 | `prompt` (i2i: `input_image`) | `aspect_ratio`, `seed`, `prompt_upsampling`, `safety_tolerance`, `output_format`, `webhook_*` | ~1MP, aspect_ratio 3:7→7:3 | Rate limit 6 concurrent |

---

## FLUX1.1 (t2i)

| Model | Endpoint | Category | Refs | Req | Params | Size | Notes |
|---|---|---|---|---|---|---|---|
| FLUX1.1 [pro] | `/v1/flux-pro-1.1` | t2i | 0 (image_prompt optional) | `prompt` | `width`, `height`, `prompt_upsampling`, `seed`, `safety_tolerance`, `output_format`, `webhook_*` | min 256, max 1440, bội 32 | image_prompt (base64) optional |
| FLUX1.1 [pro] Ultra | `/v1/flux-pro-1.1-ultra` | t2i | 0 (image_prompt optional) | `prompt` | `aspect_ratio`, `raw`, `prompt_upsampling`, `seed`, `safety_tolerance`, `output_format`, `image_prompt_strength`, `webhook_*` | up to 4MP | Raw mode |

---

## FLUX Tools (inpaint / outpaint)

| Model | Endpoint | Category | Refs | Req | Params | Size | Notes |
|---|---|---|---|---|---|---|---|
| FLUX.1 Fill [pro] | `/v1/flux-pro-1.0-fill` | inpaint | 1 | `image` | `mask`, `steps`, `guidance`, `prompt_upsampling`, `seed`, `safety_tolerance`, `output_format`, `webhook_*` | phụ thuộc ảnh | mask optional nếu dùng alpha |
| FLUX.1 Expand [pro] | `/v1/flux-pro-1.0-expand` | outpaint | 1 | `image` | `top`, `bottom`, `left`, `right`, `steps`, `guidance`, `prompt_upsampling`, `seed`, `safety_tolerance`, `output_format`, `webhook_*` | phụ thuộc ảnh | expand 0–2048 px mỗi cạnh |

---

## Finetune endpoints (base URL riêng)
> Một số endpoint dùng `https://api.us1.bfl.ai`.

| Model | Endpoint | Category | Refs | Req | Params | Notes |
|---|---|---|---|---|---|---|
| FLUX1.1 Ultra Finetuned | `/v1/flux-pro-1.1-ultra-finetuned` | finetune | 0 (image_prompt optional) | `finetune_id` | `finetune_strength`, `aspect_ratio`, `prompt_upsampling`, `seed`, `safety_tolerance`, `output_format`, `image_prompt_strength` | base_url `api.us1.bfl.ai` |
| FLUX.1 Fill Finetuned | `/v1/flux-pro-1.0-fill-finetuned` | finetune + inpaint | 1 | `finetune_id`, `image` | `mask`, `steps`, `guidance`, `prompt_upsampling`, `seed`, `safety_tolerance`, `output_format` | base_url `api.us1.bfl.ai` |

---

## Utility / Account

| Endpoint | Method | Category | Mục đích | Notes |
|---|---|---|---|---|
| `/v1/get_result` | GET | utility | Lấy kết quả theo `id` | **Phải** dùng `polling_url` trả về |
| `/v1/credits` | GET | utility | Số credits hiện tại | Auth header `x-key` |
| `/v1/my_finetunes` | GET | utility | Danh sách finetune | base_url `api.us1.bfl.ai` |
| `/v1/finetune_details` | GET | utility | Chi tiết finetune | base_url `api.us1.bfl.ai` |
| `/v1/delete_finetune` | POST | utility | Xóa finetune | base_url `api.us1.bfl.ai` |
| `/v1/licenses/models/{model_slug}/usage` | POST | utility | Report usage | base_url từ license API |

---

## Notes quan trọng (từ guides)
- `result.sample` **hết hạn ~10 phút**, **không CORS** ⇒ download ngay và re‑serve nội bộ.
- Rate limit chung **24 task**, riêng Kontext Max **6 task**.
- Trạng thái đặc biệt: `Request Moderated`, `Content Moderated`, `Task not found`, `Error`.
- Grounding search chỉ có ở model hỗ trợ (vd: FLUX.2 [max]).
- Prompt không dùng negative; ưu tiên word order; hỗ trợ hex colors & typography.
