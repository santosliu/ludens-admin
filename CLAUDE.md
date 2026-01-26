# CLAUDE.md

本文件為 Claude Code (claude.ai/code) 在此專案中工作時提供指引。

**請使用繁體中文回覆。**

## 專案概述

Ludens Admin 是一個基於 Laravel 10 的遊戲相關資料管理後台系統，使用 **Backpack for Laravel v6** 作為後台框架。系統管理專有名詞（遊戲術語翻譯）、未上架遊戲及新聞請求。

## 指令

### 開發
```bash
npm run dev              # 啟動 Vite 開發伺服器
npm run build            # 建置正式環境資源
php artisan serve        # 啟動 Laravel 開發伺服器
```

### 測試
```bash
php artisan test                        # 執行所有測試
./vendor/bin/phpunit tests/Unit         # 僅執行單元測試
./vendor/bin/phpunit tests/Feature      # 僅執行功能測試
./vendor/bin/phpunit --filter=TestName  # 執行單一測試
```

### 資料庫
```bash
php artisan migrate           # 執行遷移
php artisan migrate:rollback  # 回滾上次遷移
php artisan db:seed           # 執行資料填充
```

### 程式碼風格
```bash
./vendor/bin/pint            # 執行 Laravel Pint (PSR-12)
```

## 架構

### 後台 CRUD 模式

所有後台功能遵循 Backpack 的 CRUD 模式：
- **路由**：定義於 `routes/backpack/custom.php`（如 `/admin/proper-noun`）
- **控制器**：`app/Http/Controllers/Admin/{Entity}CrudController.php`
- **請求驗證**：`app/Http/Requests/{Entity}Request.php`
- **模型**：`app/Models/{Entity}.php`

控制器實作設定方法：`setup()`、`setupListOperation()`、`setupCreateOperation()`、`setupUpdateOperation()`

### 主要模型

| 模型 | 資料表 | 用途 |
|------|--------|------|
| ProperNoun | proper_nouns | 遊戲術語翻譯 |
| NewsRequest | news_request | 新聞提交（含檔案上傳） |
| UnpublishGame | unpublish_games | 遊戲下架請求 |

### 檔案儲存

自訂磁碟 `external_scripts` 設定於 `config/filesystems.php`，用於 NewsRequest 的檔案上傳。請使用 Laravel 的 Storage facade 進行檔案操作。

## 慣例

- **命名**：Model 使用 PascalCase，資料表使用 plural_snake_case，路由使用 kebab-case
- **驗證**：一律使用 Form Request 類別，禁止在控制器中直接撰寫驗證邏輯
- **Git 提交訊息**：使用**繁體中文**撰寫
- **Git 提交方式**：因終端機編碼問題，請使用檔案方式提交：
  1. 將訊息寫入 `commit_message.txt`
  2. 執行 `git commit -F commit_message.txt`
  3. 刪除暫存檔案

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to enhance the user's satisfaction building Laravel applications.

## Foundational Context
This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.2.5
- laravel/framework (LARAVEL) - v10
- laravel/prompts (PROMPTS) - v0
- laravel/sanctum (SANCTUM) - v3
- laravel/mcp (MCP) - v0
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- phpunit/phpunit (PHPUNIT) - v10


## Conventions
- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts
- Do not create verification scripts or tinker when tests cover that functionality and prove it works. Unit and feature tests are more important.

## Application Structure & Architecture
- Stick to existing directory structure - don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling
- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Replies
- Be concise in your explanations - focus on what's important rather than explaining obvious details.

## Documentation Files
- You must only create documentation files if explicitly requested by the user.


=== boost rules ===

## Laravel Boost
- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan
- Use the `list-artisan-commands` tool when you need to call an Artisan command to double check the available parameters.

## URLs
- Whenever you share a project URL with the user you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain / IP, and port.

## Tinker / Debugging
- You should use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.

## Reading Browser Logs With the `browser-logs` Tool
- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)
- Boost comes with a powerful `search-docs` tool you should use before any other approaches. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation specific for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- The 'search-docs' tool is perfect for all Laravel related packages, including Laravel, Inertia, Livewire, Filament, Tailwind, Pest, Nova, Nightwatch, etc.
- You must use this tool to search for Laravel-ecosystem documentation before falling back to other approaches.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic based queries to start. For example: `['rate limiting', 'routing rate limiting', 'routing']`.
- Do not add package names to queries - package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax
- You can and should pass multiple queries at once. The most relevant results will be returned first.

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit"
3. Quoted Phrases (Exact Position) - query="infinite scroll" - Words must be adjacent and in that order
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit"
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms


=== php rules ===

## PHP

- Always use curly braces for control structures, even if it has one line.

### Constructors
- Use PHP 8 constructor property promotion in `__construct()`.
    - <code-snippet>public function __construct(public GitHub $github) { }</code-snippet>
- Do not allow empty `__construct()` methods with zero parameters.

### Type Declarations
- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<code-snippet name="Explicit Return Types and Method Params" lang="php">
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
</code-snippet>

## Comments
- Prefer PHPDoc blocks over comments. Never use comments within the code itself unless there is something _very_ complex going on.

## PHPDoc Blocks
- Add useful array shape type definitions for arrays when appropriate.

## Enums
- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.


=== laravel/core rules ===

## Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Database
- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation
- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `list-artisan-commands` to check the available options to `php artisan make:model`.

### APIs & Eloquent Resources
- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

### Controllers & Validation
- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

### Queues
- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

### Authentication & Authorization
- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

### URL Generation
- When generating links to other pages, prefer named routes and the `route()` function.

### Configuration
- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

### Testing
- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] <name>` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

### Vite Error
- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.


=== laravel/v10 rules ===

## Laravel 10

- Use the `search-docs` tool to get version specific documentation.
- Middleware typically live in `app/Http/Middleware/` and service providers in `app/Providers/`.
- There is no `bootstrap/app.php` application configuration in Laravel 10:
    - Middleware registration is in `app/Http/Kernel.php`
    - Exception handling is in `app/Exceptions/Handler.php`
    - Console commands and schedule registration is in `app/Console/Kernel.php`
    - Rate limits likely exist in `RouteServiceProvider` or `app/Http/Kernel.php`
- When using Eloquent model casts, you must use `protected $casts = [];` and not the `casts()` method. The `casts()` method isn't available on models in Laravel 10.


=== pint/core rules ===

## Laravel Pint Code Formatter

- You must run `vendor/bin/pint --dirty` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test`, simply run `vendor/bin/pint` to fix any formatting issues.


=== phpunit/core rules ===

## PHPUnit Core

- This application uses PHPUnit for testing. All tests must be written as PHPUnit classes. Use `php artisan make:test --phpunit <name>` to create a new test.
- If you see a test using "Pest", convert it to PHPUnit.
- Every time a test has been updated, run that singular test.
- When the tests relating to your feature are passing, ask the user if they would like to also run the entire test suite to make sure everything is still passing.
- Tests should test all of the happy paths, failure paths, and weird paths.
- You must not remove any tests or test files from the tests directory without approval. These are not temporary or helper files, these are core to the application.

### Running Tests
- Run the minimal number of tests, using an appropriate filter, before finalizing.
- To run all tests: `php artisan test`.
- To run all tests in a file: `php artisan test tests/Feature/ExampleTest.php`.
- To filter on a particular test name: `php artisan test --filter=testName` (recommended after making a change to a related file).
</laravel-boost-guidelines>