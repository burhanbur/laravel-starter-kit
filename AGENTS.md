# AI Agent Guidelines - Laravel Starter Kit

You are an expert full-stack Laravel AI assistant working on this repository. Follow these architectural standards, conventions, and workflows strictly.

---

## 1. Core Architecture & Stack
- **Framework:** Laravel (PHP 8.2+).
- **Design Pattern:** Standard MVC (Model-View-Controller).
- **Query Strategy:** Direct Eloquent integration in Controllers. Do NOT use the Repository Pattern for standard CRUD. Use Eloquent directly (`Model::create()`, `Model::findOrFail()`, `Model::with()`, query builder).
- **UI Framework:** Metronic UI (`kt-` prefixed classes in views).
- **Language Policy:**
  - Code, variables, functions, and database columns are written in **English**.
  - User-facing text (Flash messages, validation errors, labels, table headers) MUST be in **Indonesian (Bahasa Indonesia)**.

---

## 2. Database & Schema Standards
- **Primary Keys:**
  - All standalone tables use **UUID** as primary keys.
  - Generate UUIDs using the global helper `(string) uuidv7()` (RFC 9562 UUIDv7 compliant, defined in `app/Helpers/Utilities.php`). NEVER use `Str::uuid()`.
- **Composite Primary Keys:**
  - Pivot / mapping tables with composite primary keys (e.g. `user_roles`, `role_permissions`) MUST extend `App\Models\MultiplePrimaryKey`.
  - Set `protected $primaryKey = ['col_a', 'col_b'];` and `public $incrementing = false;`.
  - Migration must define `$table->primary(['col_a', 'col_b']);`. Do NOT add a surrogate `id` column to these tables.
- **Audit Columns:**
  - Transactional and entity tables must implement:
    - `created_by` (UUID/char(36), nullable)
    - `updated_by` (UUID/char(36), nullable)
    - `deleted_by` (UUID/char(36), nullable)
    - `created_at`, `updated_at`, `deleted_at` (`SoftDeletes`)
- **Foreign Keys:**
  - Reference the target table UUID `id`. Always establish appropriate indexes and cascade rules.
- **Database Safety (CRITICAL):**
  - **NEVER** run destructive database commands (`migrate:fresh`, `migrate:refresh`, `db:wipe`, `DROP`, `TRUNCATE`) without the user's explicit prior approval.
  - Treat local databases as real, persistent data.

---

## 3. Controller Conventions
- **Naming:** PascalCase extending `App\Http\Controllers\Controller` (e.g., `UserController`).
- **Database Transactions:**
  - **EVERY** mutating operation (Create, Update, Delete) **MUST** be wrapped in a database transaction:
    ```php
    DB::beginTransaction();
    try {
        // Eloquent operations...
        DB::commit();
        Session::flash('notification', ['level' => 'success', 'message' => 'Data berhasil disimpan.']);
        return redirect()->route('module.index');
    } catch (Exception $ex) {
        DB::rollBack();
        Log::error($ex->getMessage());
        Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memproses data.']);
        return redirect()->back()->withInput();
    }
    ```
- **Audit Field Assignment:**
  - Assign tracking fields manually in the controller:
    ```php
    $data['created_by'] = auth()->user()->id;
    $data['updated_by'] = auth()->user()->id;
    ```
- **Passing Data to Views:**
  - Use `get_defined_vars()`:
    ```php
    $roles = Role::all();
    $data = User::findOrFail($id);
    return view('pages.user.edit', get_defined_vars());
    ```
- **AJAX / Modal Rendering:**
  - When returning `create` or `edit` views inside Bootstrap modals:
    ```php
    return view('pages.user.create', get_defined_vars())->renderSections()['content'];
    ```

---

## 4. Model Conventions
- **Traits:** Always include `HasFactory`. Use `SoftDeletes` if the table has `deleted_at`.
- **Explicit Properties:** Always declare `$table`, `$primaryKey`, and `$fillable`.
- **UUID Boot Hook:**
  - For models with UUID primary keys:
    ```php
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) uuidv7();
            }
        });
    }
    ```
- **Constants:** Define category IDs or status codes as model constants (e.g., `public const SIDEBAR = 1;`).

---

## 5. Form Requests (Validation)
- **Location:** `app/Http/Requests/{Module}/{Action}Request.php` (e.g., `StoreUserRequest`).
- **Authorization:** Return `true` in `authorize()` unless custom policy is applied.
- **Localization:** Always implement the `messages()` method with localized Indonesian messages:
  ```php
  public function messages(): array
  {
      return [
          'name.required' => 'Nama wajib diisi',
          'email.unique'  => 'Email sudah terdaftar',
      ];
  }
  ```

---

## 6. Routes & RBAC
- **Files:** `routes/web.php` for web routes, `routes/api.php` for REST API endpoints.
- **Grouping:** Group routes by prefix and middleware (`auth`, `permission`):
  ```php
  Route::group(['prefix' => 'role'], function () {
      Route::get('/', [RoleController::class, 'index'])->name('role.index');
      Route::post('/', [RoleController::class, 'store'])->name('role.store');
  });
  ```
- **RBAC & Menus:**
  - Roles, permissions (`role_permissions`), and user-roles (`user_roles`) govern authorization.
  - `menus`: Catalog of menu names and icons (`id`, `name`, `icon`).
  - `role_menus`: Dynamic per-role hierarchical menu tree (`id`, `parent_id`, `role_id`, `menu_id`, `route_id`, `menu_type_id`, `sequence`, `is_active`).
  - `menu_types`: 1 = Sidebar, 2 = Topbar.

---

## 7. Views (Blade & Metronic UI)
- **Location:** `resources/views/pages/{module-name}/` (e.g., `pages/user/index.blade.php`).
- **Base Layout:** `@extends('layouts.main')`.
- **Theme Components:** Use Metronic UI classes:
  - Portlet: `kt-portlet`, `kt-portlet__head`, `kt-portlet__body`
  - Badges: `kt-badge`, `badge-primary`, `badge-success`, etc.
  - Forms: `form-group`, `form-control`

---

## 8. API & Swagger Documentation
- Use `zircote/swagger-php` annotations.
- Distinguish API scopes:
  - **Internal API:** Configured in `app/Docs/Internal/ApiInfo.php`.
  - **External API:** Configured in `app/Docs/External/ApiInfo.php`.
- Add proper `@OA\Tag`, `@OA\Get`, `@OA\Post`, `@OA\Schema`, and response annotations.

---

## 9. AI Development Workflow & Quality Checklist
Before marking any task as complete:
1. **Explore First:** Read existing files in the domain before modifying or creating new ones.
2. **Follow Conventions:** Respect direct Eloquent, `uuidv7()`, `DB::beginTransaction()`, and `get_defined_vars()`.
3. **Validate Syntax:** Always run `php -l <file>` on modified or newly created PHP files.
4. **Preserve User Conventions:** Do NOT alter architectural decisions (such as `MultiplePrimaryKey` or dynamic `role_menus` tree) without explicit user instructions.
