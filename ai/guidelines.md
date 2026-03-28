# Laravel Starter Kit AI Agent Guidelines

This document outlines the coding standards, architectural patterns, and development workflow for the generic AI agent to follow when contributing to this codebase. By strictly adhering to these guidelines, the AI agent ensures consistency, predictability, and maintainability.

## 1. Architectural Patterns
- **Framework:** Laravel.
- **Design Pattern:** Standard MVC (Model-View-Controller).
- **Query Strategy:** Direct Eloquent integration in Controllers. We do not enforce the Repository Pattern for standard CRUD. Use Eloquent directly (`Model::create()`, `Model::findOrFail()`, `Model::with()`).
- **UI Framework/Theme:** Metronic UI (evident by `$kt-` prefixed classes in views).
- **Language:** Code is primarily written in English, but user-facing messages (Flash messages, validation errors, labels) are in Indonesian (Bahasa Indonesia).

## 2. Database & Schema Design
- **Primary Keys:** The system heavily utilizes **UUID** as primary keys instead of auto-incrementing integers.
- **Audit Columns:** Every primary transaction table must implement audit tracking columns:
    - `created_by` (UUID)
    - `updated_by` (UUID)
    - `deleted_by` (UUID)
    - `created_at`
    - `updated_at`
    - `deleted_at` (Using SoftDeletes)
- **Foreign Keys:** Must reference the `id` of related tables (also UUIDs). Establish indexes for foreign keys or heavily queried columns.

## 3. Controllers Rules
When writing or modifying Controllers, strictly observe the following:

- **Naming Convention:** PascalCase extending the base Controller (e.g., `UserController extends Controller`).
- **Transactions:** Any modifying operation (Create/Update/Delete) **MUST** be wrapped in a database transaction:
    ```php
    DB::beginTransaction();
    try {
        // DB Operations...
        DB::commit();
    } catch (Exception $ex) {
        DB::rollBack();
        // Error handling
    }
    ```
- **Tracking Fields Assignment:** Always assign tracking fields manually inside the controller rather than model events (unless specified otherwise):
    ```php
    $data['created_by'] = auth()->user()->id;
    $data['updated_by'] = auth()->user()->id;
    ```
- **Error Handling & Logging:** Always catch `Exception`, log it, set an error flash message, and redirect back with input:
    ```php
    Log::error($ex->getMessage());
    Session::flash('notification', ['level' => 'error', 'message' => 'Gagal memproses data.']);
    return redirect()->back()->withInput();
    ```
- **Success Handling:** Set a success flash message and redirect to the index route:
    ```php
    Session::flash('notification', ['level' => 'success', 'message' => 'Data berhasil dibuat.']);
    return redirect()->route('module.index');
    ```
- **Variable Passing to Views:** Use `get_defined_vars()` to pass all variables defined in the controller method to the view:
    ```php
    $roles = Role::all();
    $data = User::findOrFail($id);
    return view('pages.user.edit', get_defined_vars());
    ```
- **Ajax / Modal Rendering:** For `create()` and `edit()` functions that render inside modals via AJAX, return only the specific section:
    ```php
    return view('pages.user.create', get_defined_vars())->renderSections()['content'];
    ```

## 4. Models
- **Traits:** Always include `HasFactory`. If the table uses `deleted_at`, include `SoftDeletes`.
- **Properties Definition:** Explicitly define the `$table`, `$primaryKey`, and `$fillable` array.
    ```php
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'created_by', 'updated_by'];
    ```
- Constants: Define status numbers or categories as Model constants (e.g., `public const SIDEBAR = 1;`).

## 5. Form Requests (Validation)
- **Location:** `app/Http/Requests/{Module}/{Action}Request.php` (e.g., `StoreUserRequest`).
- **Base Class:** FormRequests must extend `App\Http\Requests\BaseFormRequest` (if available) or the standard Laravel `FormRequest`.
- **Custom Messages:** Always implement the `messages()` method returning localized string responses (Indonesian).
    ```php
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'email.unique' => 'Email sudah digunakan',
        ];
    }
    ```

## 6. Routes
- **File:** `routes/web.php` for web endpoints, `routes/api.php` for APIs.
- **Grouping:** Organize routes by middleware groups (`auth`, `permission`) and prefix (`group(['prefix' => 'user'])`).
- **Naming:** Follow standard dot-notation naming (e.g., `module.index`, `module.store`). Let route variables match the module scope.

## 7. Views (Blade)
- **Directory Structure:** Views reside in `resources/views/pages/{module-name}/`. (e.g., `pages/user/index.blade.php`).
- **Directives:** Use standard blade directives (`@if`, `@foreach`, `@extends`, `@section`).
- **Theme Constraints:** Respect the Metronic UI structure using the necessary `kt-` classes for layout, forms, and cards.

## 8. Swagger / API Documentation
- Use `zircote/swagger-php` annotations.
- The Swagger documentation is divided into two distinct scopes:
  - **Internal API**: Configured in `app/Docs/Internal/ApiInfo.php`. Intended for endpoints consumed by internal applications.
  - **External API**: Configured in `app/Docs/External/ApiInfo.php`. Intended for public-facing or partner API integrations.
- Ensure any new API endpoint includes the respective `@OA` annotations properly, keeping the boundaries of Internal vs External APIs in mind.

## 9. Permissions and Menus
- The application uses custom role-permission and dynamic sidebars configured via DB (`role_menus`, `role_permissions`, `user_roles`). Make sure to check if new menus/routes must be inserted into seeders to be visible.

---
**Summary for AI Execution Step:**
*Read Context > Write tests/requests > Validate FormRequests > Write Controller Methods + DB Transactions + Flash Messages > Create Blade Views with Metronic.*
