# Ludens Admin 專案開發指南

本文件旨在為 Ludens Admin 專案提供一套開發標準與規範，以確保程式碼品質、一致性與可維護性。

## 1. 技術棧

-   **後端:** Laravel
-   **後台管理:** Backpack for Laravel
-   **前端:** Vite, JavaScript, Blade
-   **資料庫:** (請根據專案指定，例如 MySQL, PostgreSQL)
-   **測試:** PHPUnit

## 2. 命名慣例

-   **Models:** `SingularPascalCase` (例如：`ProperNoun.php`)
-   **Controllers (Backpack):** `SingularPascalCaseCrudController` (例如：`ProperNounCrudController.php`)
-   **Requests:** `SingularPascalCaseRequest` (例如：`ProperNounRequest.php`)
-   **Migrations:** `YYYY_MM_DD_HHMMSS_create_plural_snake_case_table` (例如：`2014_10_12_000000_create_users_table.php`)
-   **資料表:** `plural_snake_case` (例如：`proper_nouns`)
-   **路由:** `kebab-case` (例如：`/admin/proper-noun`)
-   **Blade 視圖:** `snake_case.blade.php`

## 3. Laravel & Backpack 最佳實踐

-   **路由:**
    -   後台相關的路由應定義在 `routes/backpack/custom.php` 中。
    -   API 路由應定義在 `routes/api.php`。
    -   網頁路由應定義在 `routes/web.php`。
-   **控制器 (Controller):**
    -   遵循 Backpack 的 CRUD 結構。`setupCreateOperation`, `setupListOperation`, `setupUpdateOperation` 等方法應用於定義欄位和操作。
    -   複雜的業務邏輯應從控制器中抽離至服務類別 (Service Class) 或模型 (Model) 中。
-   **模型 (Model):**
    -   定義好 `$fillable` 屬性以防止大量賦值漏洞。
    -   模型之間的關聯（如 `hasMany`, `belongsTo`）應明確定義。
-   **請求 (Request):**
    -   所有來自表單的驗證都應使用 Form Request 類別（例如 `ProperNounRequest.php`）。不要在控制器中直接寫驗證邏輯。
-   **資料庫:**
    -   所有資料庫結構的變更都必須透過 Migrations 進行。
    -   Migrations 應包含 `up()` 和 `down()` 方法，確保可回滾。
    -   使用 Seeders 填充初始資料或測試資料。

## 4. 程式碼風格

-   **PHP:** 遵循 [PSR-12](https://www.php-fig.org/psr/psr-12/) 程式碼風格規範。
-   **註解:** 對於複雜的查詢、演算法或業務邏輯，應添加清晰的註解。
-   **設定檔:** 敏感資訊（如 API 金鑰、資料庫密碼）應儲存在 `.env` 檔案中，並使用 `env()` 輔助函式在 `config/` 目錄下的設定檔中讀取。禁止將敏感資訊直接寫入程式碼或設定檔。

## 5. 前端開發

-   使用 Vite 進行前端資源的編譯與打包。
-   Backpack 的視圖客製化應在 `resources/views/vendor/backpack/` 目錄下進行。

## 6. Git 工作流程

-   遵循 Feature Branch Workflow。從 `main` 或 `develop` 分支建立新分支進行開發。
-   Commit 訊息應清晰明瞭，並**使用繁體中文**描述該次提交的目的。
    -   **Commit 執行方式：** 由於 `git commit -m "訊息"` 在特定終端機環境下可能因引號解析問題而失敗，建議採用以下更穩健的流程：
        1.  將 commit 訊息寫入一個暫存檔案（例如 `commit_message.txt`）。
        2.  執行 `git commit -F commit_message.txt`。
        3.  執行 `del commit_message.txt` (Windows) 或 `rm commit_message.txt` (Linux/macOS) 刪除暫存檔案。
-   提交程式碼前，確保所有測試都已通過。
