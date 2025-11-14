# Laravel Blade Components - Panduan Penggunaan

Dokumentasi lengkap untuk penggunaan komponen Blade yang telah disesuaikan dengan template **Metronic (Keen Theme)**.

## Daftar Isi

- [Buttons](#buttons)
- [Links (Button Style)](#links-button-style)
- [Alert](#alert)
- [Badge](#badge)
- [Card/Portlet](#cardportlet)
- [Breadcrumb](#breadcrumb)
- [Spinner/Loading](#spinnerloading)
- [Table](#table)
- [Form Input](#form-input)
- [Form Textarea](#form-textarea)
- [Form Select](#form-select)
- [Form Select2](#form-select2)
- [Form Checkbox](#form-checkbox)
- [Form Radiobox](#form-radiobox)
- [Headings](#headings)
- [Modal](#modal)

---

## Buttons

Komponen button dengan props untuk mengatur ukuran dan varian warna.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `type` | string | `button` | Tipe button (button, submit, reset) |
| `variant` | string | `primary` | Varian warna (primary, secondary, success, danger, warning, info, dark, default) |
| `size` | string | `md` | Ukuran button (lg, md, sm, xs) |
| `disabled` | boolean | `false` | Menonaktifkan button |
| `block` | boolean | `false` | Button full width |

### Varian Warna
- `primary` - Biru (utama)
- `secondary` - Abu-abu
- `success` - Hijau
- `danger` - Merah
- `warning` - Kuning
- `info` - Cyan
- `dark` - Hitam
- `default` - Default

### Ukuran
- `lg` - Large
- `md` - Medium (default)
- `sm` - Small
- `xs` - Extra Small

### Contoh Penggunaan

```blade
<!-- Button Basic (Primary Medium) -->
<x-button>
    Simpan
</x-button>

<!-- Button dengan Variant -->
<x-button variant="success">
    Submit
</x-button>

<x-button variant="danger">
    Hapus
</x-button>

<x-button variant="warning">
    Edit
</x-button>

<!-- Button dengan Size -->
<x-button size="lg" variant="primary">
    Large Button
</x-button>

<x-button size="sm" variant="info">
    Small Button
</x-button>

<x-button size="xs" variant="secondary">
    Extra Small
</x-button>

<!-- Button dengan Type Submit -->
<x-button type="submit" variant="success">
    Submit Form
</x-button>

<!-- Button Disabled -->
<x-button variant="danger" disabled>
    Disabled
</x-button>

<!-- Button Block (Full Width) -->
<x-button variant="primary" block>
    Full Width Button
</x-button>

<!-- Button dengan Icon -->
<x-button variant="primary">
    <i class="la la-plus"></i> Tambah Data
</x-button>

<!-- Button dengan Class Tambahan -->
<x-button variant="info" class="btn-wide">
    Custom Class
</x-button>

<!-- Kombinasi Props -->
<x-button type="submit" variant="success" size="lg" class="mt-3">
    <i class="la la-check"></i> Simpan Data
</x-button>
```

### Contoh Kombinasi dalam Form

```blade
<div class="kt-portlet__foot">
    <div class="kt-form__actions">
        <x-button type="submit" variant="primary">
            <i class="la la-check"></i> Simpan
        </x-button>
        
        <x-button type="reset" variant="secondary">
            Reset
        </x-button>
        
        <a href="{{ route('users.index') }}">
            <x-button variant="default">
                <i class="la la-arrow-left"></i> Kembali
            </x-button>
        </a>
    </div>
</div>
```

### Tips
- Gunakan `variant` untuk menentukan warna button sesuai dengan aksi (success untuk save, danger untuk delete, dll)
- Gunakan `size` untuk menyesuaikan ukuran button dengan konteks penggunaan
- Prop `block` berguna untuk button di mobile atau form login
- Kombinasikan dengan icon untuk tampilan lebih informatif

---

## Links (Button Style)

Komponen link (`<a href>`) dengan styling button. Sama seperti button namun menggunakan tag `<a>` untuk navigasi.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `href` | string | `#` | URL tujuan link |
| `target` | string | `_self` | Target link (_blank, _self, dll) |
| `variant` | string | `primary` | Varian warna (primary, secondary, success, danger, warning, info, dark, default) |
| `size` | string | `md` | Ukuran link (lg, md, sm, xs) |
| `disabled` | boolean | `false` | Menonaktifkan link (href jadi javascript:void(0)) |
| `block` | boolean | `false` | Link full width |

### Varian Warna
- `primary` - Biru (utama)
- `secondary` - Abu-abu
- `success` - Hijau
- `danger` - Merah
- `warning` - Kuning
- `info` - Cyan
- `dark` - Hitam
- `default` - Default

### Ukuran
- `lg` - Large
- `md` - Medium (default)
- `sm` - Small
- `xs` - Extra Small

### Contoh Penggunaan

```blade
<!-- Link Basic (Primary Medium) -->
<x-link href="{{ route('users.index') }}">
    Lihat Data
</x-link>

<!-- Link dengan Variant -->
<x-link href="{{ route('users.create') }}" variant="success">
    <i class="la la-plus"></i> Tambah User
</x-link>

<x-link href="{{ route('users.edit', $user) }}" variant="warning">
    <i class="la la-edit"></i> Edit
</x-link>

<x-link href="{{ route('users.destroy', $user) }}" variant="danger">
    <i class="la la-trash"></i> Hapus
</x-link>

<!-- Link dengan Size -->
<x-link href="{{ route('dashboard') }}" size="lg" variant="primary">
    Dashboard
</x-link>

<x-link href="{{ route('profile') }}" size="sm" variant="info">
    Profile
</x-link>

<x-link href="{{ route('settings') }}" size="xs" variant="secondary">
    <i class="la la-cog"></i>
</x-link>

<!-- Link dengan Target Blank -->
<x-link href="https://google.com" target="_blank" variant="info">
    Buka Google <i class="la la-external-link"></i>
</x-link>

<!-- Link Disabled -->
<x-link href="#" variant="danger" disabled>
    Tidak Aktif
</x-link>

<!-- Link dengan Class Tambahan -->
<x-link href="{{ route('help') }}" variant="info" class="btn-wide">
    Bantuan
</x-link>

<!-- Kombinasi Props -->
<x-link href="{{ route('users.create') }}" variant="success" size="lg" class="mt-3">
    <i class="la la-plus"></i> Tambah Data Baru
</x-link>
```

### Contoh Penggunaan dalam Table

```blade
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <x-link href="{{ route('users.show', $user) }}" variant="info" size="xs">
                    <i class="la la-eye"></i>
                </x-link>
                
                <x-link href="{{ route('users.edit', $user) }}" variant="warning" size="xs">
                    <i class="la la-edit"></i>
                </x-link>
                
                <x-link 
                    href="{{ route('users.destroy', $user) }}" 
                    variant="danger" 
                    size="xs"
                    onclick="return confirm('Yakin hapus?')"
                >
                    <i class="la la-trash"></i>
                </x-link>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
```

### Contoh Kombinasi Link & Button

```blade
<!-- Toolbar dengan kombinasi link dan button -->
<div class="kt-portlet__head-toolbar">
    <x-link href="{{ route('users.create') }}" variant="primary">
        <i class="la la-plus"></i> Tambah User
    </x-link>
    
    <x-link href="{{ route('users.export') }}" variant="success" target="_blank">
        <i class="la la-download"></i> Export Excel
    </x-link>
    
    <x-button variant="secondary" type="button" onclick="window.print()">
        <i class="la la-print"></i> Print
    </x-button>
</div>
```

### Perbedaan Link vs Button

| Aspek | Link | Button |
|-------|------|--------|
| Element | `<a>` | `<button>` |
| Props Utama | `href`, `target` | `type` |
| Fungsi | Navigasi/Redirect | Submit form, trigger action |
| Disabled | href jadi `javascript:void(0)` | attribute `disabled` |
| Best Use | Menu, navigasi, download, external link | Form submit, modal trigger, AJAX action |

### Tips Penggunaan

1. **Gunakan Link untuk navigasi:**
   ```blade
   <x-link href="{{ route('dashboard') }}" variant="primary">Dashboard</x-link>
   ```

2. **Gunakan Button untuk form:**
   ```blade
   <x-button type="submit" variant="primary">Simpan</x-button>
   ```

3. **Link dengan route helper:**
   ```blade
   <x-link href="{{ route('users.show', $user) }}" variant="success">Detail</x-link>
   ```

4. **Link untuk file download:**
   ```blade
   <x-link href="{{ asset('documents/manual.pdf') }}" variant="info" target="_blank">
       <i class="la la-download"></i> Download Manual
   </x-link>
   ```

5. **Link dengan JavaScript:**
   ```blade
   <x-link variant="danger" size="sm" 
       href="#" 
       onclick="event.preventDefault(); deleteItem({{ $id }})"
   >
       Delete
   </x-link>
   ```

---

## Alert

Komponen alert untuk menampilkan pesan notifikasi dengan berbagai tipe.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `type` | string | `info` | Tipe alert (success, danger, warning, info, primary, secondary) |
| `dismissible` | boolean | `false` | Alert bisa ditutup |
| `icon` | string | `''` | Custom icon class (false untuk disable icon) |
| `title` | string | `''` | Judul alert (bold) |

### Contoh Penggunaan

```blade
<!-- Alert Success -->
<x-alert type="success">
    Data berhasil disimpan!
</x-alert>

<!-- Alert Danger/Error -->
<x-alert type="danger">
    Terjadi kesalahan saat memproses data.
</x-alert>

<!-- Alert Warning -->
<x-alert type="warning">
    Perhatian! Data akan dihapus permanen.
</x-alert>

<!-- Alert Info -->
<x-alert type="info">
    Informasi: Sistem akan maintenance pada pukul 22:00.
</x-alert>

<!-- Alert dengan Title -->
<x-alert type="success" title="Berhasil!">
    Data pengguna telah berhasil ditambahkan.
</x-alert>

<!-- Alert Dismissible (bisa ditutup) -->
<x-alert type="warning" dismissible>
    Jangan lupa untuk backup data Anda secara berkala.
</x-alert>

<!-- Alert dengan Custom Icon -->
<x-alert type="primary" icon="la la-user">
    Profile Anda telah diupdate.
</x-alert>

<!-- Alert tanpa Icon -->
<x-alert type="info" :icon="false">
    Pesan tanpa icon.
</x-alert>

<!-- Alert dengan Class Tambahan -->
<x-alert type="success" class="mb-4">
    Operasi selesai dengan sukses!
</x-alert>
```

### Contoh dengan Session Flash Message

```php
// Controller
public function store(Request $request)
{
    // ... save data
    
    return redirect()->route('users.index')
        ->with('success', 'User berhasil ditambahkan!');
}
```

```blade
<!-- View -->
@if(session('success'))
    <x-alert type="success" dismissible>
        {{ session('success') }}
    </x-alert>
@endif

@if(session('error'))
    <x-alert type="danger" dismissible>
        {{ session('error') }}
    </x-alert>
@endif

@if(session('warning'))
    <x-alert type="warning" dismissible>
        {{ session('warning') }}
    </x-alert>
@endif

@if(session('info'))
    <x-alert type="info" dismissible>
        {{ session('info') }}
    </x-alert>
@endif
```

---

## Badge

Komponen badge untuk label atau status dengan berbagai warna.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `type` | string | `primary` | Tipe badge (primary, secondary, success, danger, warning, info, dark, light) |
| `pill` | boolean | `false` | Badge berbentuk pill (rounded) |

### Contoh Penggunaan

```blade
<!-- Badge Basic -->
<x-badge type="primary">New</x-badge>
<x-badge type="success">Active</x-badge>
<x-badge type="danger">Inactive</x-badge>
<x-badge type="warning">Pending</x-badge>
<x-badge type="info">Info</x-badge>
<x-badge type="dark">Admin</x-badge>

<!-- Badge Pill -->
<x-badge type="primary" pill>5</x-badge>
<x-badge type="success" pill>Online</x-badge>

<!-- Badge dalam Table -->
<table class="table">
    <tr>
        <td>John Doe</td>
        <td>
            @if($user->is_active)
                <x-badge type="success">Active</x-badge>
            @else
                <x-badge type="danger">Inactive</x-badge>
            @endif
        </td>
    </tr>
</table>

<!-- Badge dengan Custom Class -->
<x-badge type="warning" class="font-weight-bold">Hot!</x-badge>

<!-- Badge untuk Notifikasi -->
<a href="{{ route('notifications') }}">
    <i class="la la-bell"></i>
    <x-badge type="danger" pill>{{ $unreadCount }}</x-badge>
</a>

<!-- Badge untuk Status -->
@switch($order->status)
    @case('pending')
        <x-badge type="warning">Pending</x-badge>
        @break
    @case('processing')
        <x-badge type="info">Processing</x-badge>
        @break
    @case('completed')
        <x-badge type="success">Completed</x-badge>
        @break
    @case('cancelled')
        <x-badge type="danger">Cancelled</x-badge>
        @break
@endswitch
```

---

## Card/Portlet

Komponen card/portlet wrapper sesuai dengan Metronic theme untuk membungkus konten.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `title` | string | `''` | Judul card/portlet |
| `flush` | boolean | `false` | Card tanpa padding (height fluid) |

### Slots
- `actions` - Toolbar di header (optional)
- `footer` - Footer card (optional)
- Default slot - Body/konten card

### Contoh Penggunaan

```blade
<!-- Card Basic dengan Title -->
<x-card title="Data Pengguna">
    <p>Konten card disini...</p>
</x-card>

<!-- Card dengan Actions (Toolbar) -->
<x-card title="Daftar User">
    <x-slot name="actions">
        <x-link href="{{ route('users.create') }}" variant="primary">
            <i class="la la-plus"></i> Tambah
        </x-link>
    </x-slot>
    
    <!-- Konten card -->
    <x-table striped>
        <x-slot name="thead">
            <tr>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </x-slot>
        
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
        </tr>
        @endforeach
    </x-table>
</x-card>

<!-- Card dengan Footer -->
<x-card title="Form User">
    <!-- Form content -->
    <x-forms.input name="name" label="Nama" />
    <x-forms.input name="email" label="Email" type="email" />
    
    <x-slot name="footer">
        <x-button type="submit" variant="primary">Simpan</x-button>
        <x-button variant="secondary">Batal</x-button>
    </x-slot>
</x-card>

<!-- Card Tanpa Title -->
<x-card>
    <h4>Custom Header</h4>
    <p>Card tanpa title prop...</p>
</x-card>

<!-- Card dengan Class Custom -->
<x-card title="Statistics" class="kt-portlet--bordered">
    <div class="row">
        <div class="col-md-4">Total: 100</div>
        <div class="col-md-4">Active: 80</div>
        <div class="col-md-4">Inactive: 20</div>
    </div>
</x-card>

<!-- Nested Cards -->
<x-card title="Dashboard">
    <div class="row">
        <div class="col-md-6">
            <x-card title="Card 1">
                Content 1
            </x-card>
        </div>
        <div class="col-md-6">
            <x-card title="Card 2">
                Content 2
            </x-card>
        </div>
    </div>
</x-card>
```

---

## Breadcrumb

Komponen breadcrumb untuk navigasi halaman sesuai Metronic theme.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `items` | array | `[]` | Array item breadcrumb ['label' => '...', 'url' => '...'] |
| `separator` | string | `''` | Custom separator (default menggunakan Metronic) |

### Contoh Penggunaan

```blade
<!-- Breadcrumb dengan Array -->
<x-breadcrumb :items="[
    ['label' => 'Home', 'url' => route('dashboard')],
    ['label' => 'Users', 'url' => route('users.index')],
    ['label' => 'Detail']
]" />

<!-- Breadcrumb Manual (Slot) -->
<x-breadcrumb>
    <a href="{{ route('dashboard') }}" class="kt-subheader__breadcrumbs-link">
        Home
    </a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{ route('users.index') }}" class="kt-subheader__breadcrumbs-link">
        Users
    </a>
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <span class="kt-subheader__breadcrumbs-link">
        Detail
    </span>
</x-breadcrumb>

<!-- Penggunaan di Subheader -->
<div class="kt-subheader kt-grid__item">
    <div class="kt-container kt-container--fluid">
        <div class="kt-subheader__main">
            <x-headings.h1>User Management</x-headings.h1>
            
            <x-breadcrumb :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'Users']
            ]" />
        </div>
    </div>
</div>
```

### Contoh dengan Controller

```php
// Controller
public function show($id)
{
    $user = User::findOrFail($id);
    
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Users', 'url' => route('users.index')],
        ['label' => $user->name]
    ];
    
    return view('users.show', compact('user', 'breadcrumbs'));
}
```

```blade
<!-- View -->
<x-breadcrumb :items="$breadcrumbs" />
```

---

## Spinner/Loading

Komponen spinner/loading untuk menampilkan indikator loading.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `type` | string | `border` | Tipe spinner (border, grow) |
| `size` | string | `''` | Ukuran spinner (sm, lg, atau kosong) |
| `color` | string | `primary` | Warna spinner (primary, secondary, success, dll) |
| `centered` | boolean | `false` | Spinner di tengah (dengan min-height 200px) |

### Contoh Penggunaan

```blade
<!-- Spinner Basic -->
<x-spinner />

<!-- Spinner dengan Warna -->
<x-spinner color="primary" />
<x-spinner color="success" />
<x-spinner color="danger" />
<x-spinner color="warning" />
<x-spinner color="info" />

<!-- Spinner Ukuran Small -->
<x-spinner size="sm" />

<!-- Spinner Ukuran Large -->
<x-spinner size="lg" />

<!-- Spinner Type Grow -->
<x-spinner type="grow" />
<x-spinner type="grow" color="success" />

<!-- Spinner Centered (di tengah halaman) -->
<x-spinner centered color="primary" />

<!-- Spinner dalam Button -->
<button class="btn btn-primary" disabled>
    <x-spinner size="sm" color="light" class="mr-2" />
    Loading...
</button>

<!-- Spinner dengan Teks -->
<div class="text-center">
    <x-spinner color="primary" />
    <p class="mt-2">Memuat data...</p>
</div>

<!-- Spinner dalam Card -->
<x-card title="Data">
    @if($loading)
        <x-spinner centered />
    @else
        <!-- Data content -->
    @endif
</x-card>

<!-- Spinner Inline -->
<div>
    Processing <x-spinner size="sm" color="primary" />
</div>
```

### Contoh dengan JavaScript

```blade
<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
    <x-spinner centered color="light" size="lg" />
</div>

<script>
    // Tampilkan loading
    function showLoading() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    }
    
    // Sembunyikan loading
    function hideLoading() {
        document.getElementById('loadingOverlay').style.display = 'none';
    }
    
    // Contoh AJAX dengan loading
    function fetchData() {
        showLoading();
        
        fetch('/api/data')
            .then(response => response.json())
            .then(data => {
                // Process data
                hideLoading();
            })
            .catch(error => {
                console.error('Error:', error);
                hideLoading();
            });
    }
</script>
```

---

## Table

Komponen table dengan styling Bootstrap dan Metronic theme.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `striped` | boolean | `false` | Table dengan baris bergaris |
| `bordered` | boolean | `false` | Table dengan border |
| `hover` | boolean | `true` | Efek hover pada baris |
| `responsive` | boolean | `true` | Table responsive (scroll horizontal di mobile) |

### Slots
- `thead` - Table header (optional)
- `tfoot` - Table footer (optional)
- Default slot - Table body (tbody)

### Contoh Penggunaan

```blade
<!-- Table Basic -->
<x-table>
    <x-slot name="thead">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Aksi</th>
        </tr>
    </x-slot>
    
    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            <x-link href="{{ route('users.edit', $user) }}" variant="warning" size="xs">
                <i class="la la-edit"></i>
            </x-link>
        </td>
    </tr>
    @endforeach
</x-table>

<!-- Table Striped -->
<x-table striped>
    <x-slot name="thead">
        <tr>
            <th>No</th>
            <th>Product</th>
            <th>Price</th>
        </tr>
    </x-slot>
    
    @foreach($products as $index => $product)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $product->name }}</td>
        <td>Rp {{ number_format($product->price) }}</td>
    </tr>
    @endforeach
</x-table>

<!-- Table Bordered -->
<x-table bordered striped>
    <x-slot name="thead">
        <tr>
            <th>Column 1</th>
            <th>Column 2</th>
        </tr>
    </x-slot>
    
    <tr>
        <td>Data 1</td>
        <td>Data 2</td>
    </tr>
</x-table>

<!-- Table dengan Footer -->
<x-table striped>
    <x-slot name="thead">
        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </x-slot>
    
    @foreach($items as $item)
    <tr>
        <td>{{ $item->name }}</td>
        <td>{{ $item->qty }}</td>
        <td>Rp {{ number_format($item->price) }}</td>
        <td>Rp {{ number_format($item->qty * $item->price) }}</td>
    </tr>
    @endforeach
    
    <x-slot name="tfoot">
        <tr>
            <th colspan="3">Grand Total</th>
            <th>Rp {{ number_format($grandTotal) }}</th>
        </tr>
    </x-slot>
</x-table>

<!-- Table Non-Responsive -->
<x-table :responsive="false">
    <x-slot name="thead">
        <tr>
            <th>Data</th>
        </tr>
    </x-slot>
    
    <tr>
        <td>Content</td>
    </tr>
</x-table>

<!-- Table dengan Badge -->
<x-table striped hover>
    <x-slot name="thead">
        <tr>
            <th>Name</th>
            <th>Status</th>
            <th>Role</th>
        </tr>
    </x-slot>
    
    @foreach($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>
            @if($user->is_active)
                <x-badge type="success">Active</x-badge>
            @else
                <x-badge type="danger">Inactive</x-badge>
            @endif
        </td>
        <td>
            <x-badge type="primary">{{ $user->role }}</x-badge>
        </td>
    </tr>
    @endforeach
</x-table>

<!-- Table dalam Card -->
<x-card title="Data Pengguna">
    <x-slot name="actions">
        <x-link href="{{ route('users.create') }}" variant="primary">
            <i class="la la-plus"></i> Tambah
        </x-link>
    </x-slot>
    
    <x-table striped hover>
        <x-slot name="thead">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </x-slot>
        
        @forelse($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <x-link href="{{ route('users.show', $user) }}" variant="info" size="xs">
                    <i class="la la-eye"></i>
                </x-link>
                <x-link href="{{ route('users.edit', $user) }}" variant="warning" size="xs">
                    <i class="la la-edit"></i>
                </x-link>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">
                <x-alert type="info">Tidak ada data</x-alert>
            </td>
        </tr>
        @endforelse
    </x-table>
</x-card>
```

---

## Form Input

Komponen input field dengan support label, validasi error, dan help text.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `name` | string | `''` | Nama input (required) |
| `id` | string | `''` | ID input (default: sama dengan name) |
| `type` | string | `text` | Tipe input (text, email, password, number, dll) |
| `label` | string | `''` | Label untuk input |
| `value` | string | `''` | Nilai default |
| `placeholder` | string | `''` | Placeholder text |
| `required` | boolean | `false` | Input wajib diisi |
| `disabled` | boolean | `false` | Menonaktifkan input |
| `readonly` | boolean | `false` | Input hanya baca |
| `autofocus` | boolean | `false` | Auto focus pada input |
| `autocomplete` | string | `''` | Nilai autocomplete (on, off, email, dll) |
| `min` | string | `''` | Nilai minimum (untuk type number/date) |
| `max` | string | `''` | Nilai maksimum (untuk type number/date) |
| `step` | string | `''` | Step increment (untuk type number) |
| `minlength` | string | `''` | Panjang karakter minimum |
| `maxlength` | string | `''` | Panjang karakter maksimum |
| `pattern` | string | `''` | Pattern regex untuk validasi |
| `help` | string | `''` | Teks bantuan di bawah input |
| `addClass` | string | `''` | Class tambahan untuk input |
| `inputClass` | string | `''` | Class tambahan untuk input (alias addClass) |
| `labelClass` | string | `''` | Class tambahan untuk label |
| `wrapperClass` | string | `''` | Class tambahan untuk wrapper div |

### Contoh Penggunaan

```blade
<!-- Input dengan label -->
<x-forms.input 
    name="name" 
    label="Nama Lengkap"
    placeholder="Masukkan nama lengkap"
    required
/>

<!-- Input email -->
<x-forms.input 
    name="email" 
    label="Email"
    type="email"
    placeholder="example@email.com"
    required
/>

<!-- Input password -->
<x-forms.input 
    name="password" 
    label="Password"
    type="password"
    required
/>

<!-- Input dengan nilai default -->
<x-forms.input 
    name="phone" 
    label="Nomor Telepon"
    type="tel"
    value="{{ $user->phone }}"
/>

<!-- Input dengan help text -->
<x-forms.input 
    name="username" 
    label="Username"
    help="Username harus 5-20 karakter, hanya huruf dan angka"
    required
/>

<!-- Input number dengan min dan max -->
<x-forms.input 
    name="age" 
    label="Umur"
    type="number"
    min="17"
    max="100"
/>

<!-- Input readonly -->
<x-forms.input 
    name="code" 
    label="Kode"
    value="{{ $code }}"
    readonly
/>

<!-- Input disabled -->
<x-forms.input 
    name="status" 
    label="Status"
    value="Active"
    disabled
/>

<!-- Input tanpa label (inline) -->
<x-forms.input 
    name="search" 
    type="text"
    placeholder="Cari..."
    class="form-control-sm"
/>

<!-- Input dengan custom class -->
<x-forms.input 
    name="amount" 
    label="Jumlah"
    type="number"
    addClass="text-right font-weight-bold"
    labelClass="text-primary"
    wrapperClass="col-md-6"
/>

<!-- Input dengan autocomplete -->
<x-forms.input 
    name="email" 
    label="Email"
    type="email"
    autocomplete="email"
    autofocus
/>

<!-- Input dengan pattern dan maxlength -->
<x-forms.input 
    name="phone" 
    label="Nomor HP"
    type="tel"
    pattern="[0-9]{10,13}"
    maxlength="13"
    placeholder="08xxxxxxxxxx"
    help="Format: 08xxxxxxxxxx (10-13 digit)"
/>

<!-- Input date dengan min dan max -->
<x-forms.input 
    name="birth_date" 
    label="Tanggal Lahir"
    type="date"
    min="1950-01-01"
    max="2010-12-31"
/>

<!-- Input number dengan step -->
<x-forms.input 
    name="price" 
    label="Harga"
    type="number"
    step="0.01"
    min="0"
    placeholder="0.00"
/>
```

### Contoh Form Lengkap

```blade
<form action="{{ route('users.store') }}" method="POST">
    @csrf
    
    <div class="kt-portlet__body">
        <x-forms.input 
            name="name" 
            label="Nama Lengkap"
            placeholder="Masukkan nama lengkap"
            required
        />

        <x-forms.input 
            name="email" 
            label="Email"
            type="email"
            placeholder="example@email.com"
            required
        />

        <x-forms.input 
            name="phone" 
            label="Nomor Telepon"
            type="tel"
            placeholder="08xxxxxxxxxx"
        />
    </div>
    
    <div class="kt-portlet__foot">
        <x-button type="submit" variant="primary">
            Simpan
        </x-button>
    </div>
</form>
```

---

## Form Textarea

Komponen textarea dengan support label, validasi error, dan help text.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `name` | string | `''` | Nama textarea (required) |
| `id` | string | `''` | ID textarea (default: sama dengan name) |
| `label` | string | `''` | Label untuk textarea |
| `value` | string | `''` | Nilai default |
| `placeholder` | string | `''` | Placeholder text |
| `rows` | integer | `3` | Jumlah baris |
| `cols` | string | `''` | Jumlah kolom |
| `required` | boolean | `false` | Textarea wajib diisi |
| `disabled` | boolean | `false` | Menonaktifkan textarea |
| `readonly` | boolean | `false` | Textarea hanya baca |
| `autofocus` | boolean | `false` | Auto focus pada textarea |
| `minlength` | string | `''` | Panjang karakter minimum |
| `maxlength` | string | `''` | Panjang karakter maksimum |
| `help` | string | `''` | Teks bantuan |
| `addClass` | string | `''` | Class tambahan untuk textarea |
| `textareaClass` | string | `''` | Class tambahan untuk textarea (alias addClass) |
| `labelClass` | string | `''` | Class tambahan untuk label |
| `wrapperClass` | string | `''` | Class tambahan untuk wrapper div |

### Contoh Penggunaan

```blade
<!-- Textarea basic -->
<x-forms.textarea 
    name="description" 
    label="Deskripsi"
    placeholder="Masukkan deskripsi..."
/>

<!-- Textarea dengan rows custom -->
<x-forms.textarea 
    name="address" 
    label="Alamat Lengkap"
    rows="5"
    placeholder="Masukkan alamat lengkap..."
    required
/>

<!-- Textarea dengan nilai default -->
<x-forms.textarea 
    name="notes" 
    label="Catatan"
    value="{{ $data->notes }}"
    rows="4"
/>

<!-- Textarea dengan help text -->
<x-forms.textarea 
    name="bio" 
    label="Biografi"
    rows="6"
    help="Maksimal 500 karakter"
/>

<!-- Textarea readonly -->
<x-forms.textarea 
    name="system_notes" 
    label="Catatan Sistem"
    value="{{ $systemNotes }}"
    readonly
    rows="3"
/>

<!-- Textarea dengan custom class -->
<x-forms.textarea 
    name="description" 
    label="Deskripsi"
    addClass="font-monospace"
    labelClass="text-info"
    wrapperClass="col-md-8"
    rows="5"
/>

<!-- Textarea dengan maxlength dan minlength -->
<x-forms.textarea 
    name="message" 
    label="Pesan"
    minlength="10"
    maxlength="500"
    rows="5"
    help="Minimal 10 karakter, maksimal 500 karakter"
    required
/>

<!-- Textarea dengan cols dan autofocus -->
<x-forms.textarea 
    name="comment" 
    label="Komentar"
    rows="4"
    cols="50"
    autofocus
    placeholder="Tulis komentar Anda..."
/>
```

---

## Form Select

Komponen dropdown select standard.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `name` | string | `''` | Nama select (required) |
| `id` | string | `''` | ID select (default: sama dengan name) |
| `label` | string | `''` | Label untuk select |
| `options` | array | `[]` | Array options (key => value) |
| `selected` | string/array | `''` | Nilai yang dipilih |
| `placeholder` | string | `Pilih...` | Placeholder option |
| `required` | boolean | `false` | Select wajib dipilih |
| `disabled` | boolean | `false` | Menonaktifkan select |
| `readonly` | boolean | `false` | Select hanya baca |
| `autofocus` | boolean | `false` | Auto focus pada select |
| `multiple` | boolean | `false` | Multiple selection |
| `size` | string | `''` | Jumlah options yang terlihat |
| `help` | string | `''` | Teks bantuan |
| `addClass` | string | `''` | Class tambahan untuk select |
| `selectClass` | string | `''` | Class tambahan untuk select (alias addClass) |
| `labelClass` | string | `''` | Class tambahan untuk label |
| `wrapperClass` | string | `''` | Class tambahan untuk wrapper div |

### Contoh Penggunaan

```blade
<!-- Select basic -->
<x-forms.select 
    name="status" 
    label="Status"
    :options="[
        'active' => 'Aktif',
        'inactive' => 'Tidak Aktif'
    ]"
    required
/>

<!-- Select dengan nilai terpilih -->
<x-forms.select 
    name="role" 
    label="Role"
    :options="[
        'admin' => 'Administrator',
        'user' => 'User',
        'guest' => 'Guest'
    ]"
    selected="user"
/>

<!-- Select dari database -->
<x-forms.select 
    name="category_id" 
    label="Kategori"
    :options="$categories->pluck('name', 'id')"
    placeholder="-- Pilih Kategori --"
    required
/>

<!-- Select dengan help text -->
<x-forms.select 
    name="priority" 
    label="Prioritas"
    :options="[
        'high' => 'Tinggi',
        'medium' => 'Sedang',
        'low' => 'Rendah'
    ]"
    help="Pilih prioritas untuk task ini"
/>

<!-- Select disabled -->
<x-forms.select 
    name="type" 
    label="Tipe"
    :options="['type1' => 'Type 1']"
    selected="type1"
    disabled
/>

<!-- Select dengan custom class -->
<x-forms.select 
    name="status" 
    label="Status"
    :options="['active' => 'Active', 'inactive' => 'Inactive']"
    addClass="text-uppercase"
    labelClass="font-weight-bold"
    wrapperClass="col-md-4"
/>

<!-- Select multiple dengan size -->
<x-forms.select 
    name="permissions[]" 
    label="Pilih Permissions"
    :options="$permissions"
    multiple
    size="5"
    :selected="$selectedPermissions"
/>

<!-- Select dengan autofocus dan readonly -->
<x-forms.select 
    name="country" 
    label="Negara"
    :options="['id' => 'Indonesia', 'my' => 'Malaysia']"
    autofocus
    required
/>
```

### Contoh dengan Controller

```php
// Controller
public function create()
{
    $categories = Category::all();
    return view('products.create', compact('categories'));
}
```

```blade
<!-- View -->
<x-forms.select 
    name="category_id" 
    label="Kategori"
    :options="$categories->pluck('name', 'id')"
    required
/>
```

---

## Form Select2

Komponen select dengan fitur Select2 (search, multiple selection).

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `name` | string | `''` | Nama select (required) |
| `id` | string | `''` | ID select (default: sama dengan name) |
| `label` | string | `''` | Label untuk select |
| `options` | array | `[]` | Array options (key => value) |
| `selected` | string/array | `''` | Nilai yang dipilih |
| `placeholder` | string | `Pilih...` | Placeholder option |
| `multiple` | boolean | `false` | Multiple selection |
| `required` | boolean | `false` | Select wajib dipilih |
| `disabled` | boolean | `false` | Menonaktifkan select |
| `readonly` | boolean | `false` | Select hanya baca |
| `autofocus` | boolean | `false` | Auto focus pada select |
| `size` | string | `''` | Jumlah options yang terlihat |
| `help` | string | `''` | Teks bantuan |
| `addClass` | string | `''` | Class tambahan untuk select |
| `selectClass` | string | `''` | Class tambahan untuk select (alias addClass) |
| `labelClass` | string | `''` | Class tambahan untuk label |
| `wrapperClass` | string | `''` | Class tambahan untuk wrapper div |

### Contoh Penggunaan

```blade
<!-- Select2 basic -->
<x-forms.select2 
    name="user_id" 
    label="User"
    :options="$users->pluck('name', 'id')"
    placeholder="Cari user..."
/>

<!-- Select2 multiple -->
<x-forms.select2 
    name="tags[]" 
    label="Tags"
    :options="$tags->pluck('name', 'id')"
    multiple
    placeholder="Pilih tags..."
/>

<!-- Select2 dengan nilai terpilih (single) -->
<x-forms.select2 
    name="assigned_to" 
    label="Assign To"
    :options="$users->pluck('name', 'id')"
    :selected="$task->assigned_to"
/>

<!-- Select2 dengan nilai terpilih (multiple) -->
<x-forms.select2 
    name="permissions[]" 
    label="Permissions"
    :options="$permissions->pluck('name', 'id')"
    :selected="$role->permissions->pluck('id')->toArray()"
    multiple
/>

<!-- Select2 dengan custom class -->
<x-forms.select2 
    name="categories[]" 
    label="Kategori"
    :options="$categories"
    multiple
    addClass="select2-custom"
    labelClass="text-primary"
    wrapperClass="mb-4"
/>

<!-- Select2 dengan size dan autofocus -->
<x-forms.select2 
    name="team_id" 
    label="Tim"
    :options="$teams->pluck('name', 'id')"
    autofocus
    required
    placeholder="Pilih tim..."
/>
```

### Inisialisasi Select2 (JavaScript)

Tambahkan script ini di bagian bawah view atau di section script:

```blade
@section('script')
<script>
    $(document).ready(function() {
        // Inisialisasi semua select2
        $('.select2').select2({
            placeholder: "Pilih...",
            allowClear: true
        });
    });
</script>
@endsection
```

---

## Form Checkbox

Komponen checkbox dengan styling Metronic (kt-checkbox).

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `name` | string | `''` | Nama checkbox (required) |
| `id` | string | `''` | ID checkbox (default: sama dengan name) |
| `label` | string | `''` | Label untuk checkbox |
| `value` | string | `1` | Nilai checkbox |
| `checked` | boolean | `false` | Status checked |
| `disabled` | boolean | `false` | Menonaktifkan checkbox |
| `readonly` | boolean | `false` | Checkbox hanya baca |
| `required` | boolean | `false` | Checkbox wajib dicentang |
| `autofocus` | boolean | `false` | Auto focus pada checkbox |
| `help` | string | `''` | Teks bantuan |
| `addClass` | string | `''` | Class tambahan untuk checkbox |
| `checkboxClass` | string | `''` | Class tambahan untuk input checkbox |
| `labelClass` | string | `''` | Class tambahan untuk label kt-checkbox |
| `wrapperClass` | string | `''` | Class tambahan untuk wrapper div |

### Contoh Penggunaan

```blade
<!-- Checkbox basic -->
<x-forms.checkbox 
    name="agree" 
    label="Saya setuju dengan syarat dan ketentuan"
/>

<!-- Checkbox dengan checked -->
<x-forms.checkbox 
    name="is_active" 
    label="Aktif"
    checked
/>

<!-- Checkbox dengan nilai custom -->
<x-forms.checkbox 
    name="notification" 
    label="Terima notifikasi email"
    value="yes"
/>

<!-- Multiple checkbox -->
<div class="form-group">
    <label>Pilih Hobi:</label>
    <x-forms.checkbox 
        name="hobbies[]" 
        label="Membaca"
        value="reading"
    />
    <x-forms.checkbox 
        name="hobbies[]" 
        label="Olahraga"
        value="sports"
    />
    <x-forms.checkbox 
        name="hobbies[]" 
        label="Traveling"
        value="traveling"
    />
</div>

<!-- Checkbox dengan help text -->
<x-forms.checkbox 
    name="subscribe" 
    label="Subscribe newsletter"
    help="Anda akan menerima email setiap minggu"
/>

<!-- Checkbox disabled -->
<x-forms.checkbox 
    name="verified" 
    label="Email Verified"
    checked
    disabled
/>

<!-- Checkbox dengan custom class -->
<x-forms.checkbox 
    name="terms" 
    label="Saya setuju dengan syarat dan ketentuan"
    required
    wrapperClass="mb-3"
    labelClass="text-danger"
/>

<!-- Checkbox dengan autofocus dan readonly -->
<x-forms.checkbox 
    name="is_admin" 
    label="Administrator"
    :checked="$user->is_admin"
    readonly
/>
```

### Contoh dengan Edit Form

```blade
<!-- Controller -->
public function edit($id)
{
    $user = User::findOrFail($id);
    return view('users.edit', compact('user'));
}
```

```blade
<!-- View -->
<x-forms.checkbox 
    name="is_active" 
    label="Status Aktif"
    :checked="$user->is_active"
/>
```

---

## Form Radiobox

Komponen radio button dengan styling Metronic (kt-radio).

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `name` | string | `''` | Nama radio (required) |
| `id` | string | `''` | ID radio (default: name_value) |
| `label` | string | `''` | Label untuk radio |
| `value` | string | `''` | Nilai radio (required) |
| `checked` | boolean/string | `false` | Status checked |
| `disabled` | boolean | `false` | Menonaktifkan radio |
| `readonly` | boolean | `false` | Radio hanya baca |
| `required` | boolean | `false` | Radio wajib dipilih |
| `autofocus` | boolean | `false` | Auto focus pada radio |
| `help` | string | `''` | Teks bantuan |
| `addClass` | string | `''` | Class tambahan untuk radio |
| `radioClass` | string | `''` | Class tambahan untuk input radio |
| `labelClass` | string | `''` | Class tambahan untuk label kt-radio |
| `wrapperClass` | string | `''` | Class tambahan untuk wrapper div |

### Contoh Penggunaan

```blade
<!-- Radio basic -->
<div class="form-group">
    <label>Jenis Kelamin:</label>
    <x-forms.radiobox 
        name="gender" 
        value="male"
        label="Laki-laki"
    />
    <x-forms.radiobox 
        name="gender" 
        value="female"
        label="Perempuan"
    />
</div>

<!-- Radio dengan checked -->
<div class="form-group">
    <label>Status:</label>
    <x-forms.radiobox 
        name="status" 
        value="active"
        label="Aktif"
        checked
    />
    <x-forms.radiobox 
        name="status" 
        value="inactive"
        label="Tidak Aktif"
    />
</div>

<!-- Radio dengan nilai dari database -->
<div class="form-group">
    <label>Tipe Member:</label>
    <x-forms.radiobox 
        name="member_type" 
        value="regular"
        label="Regular"
        :checked="$user->member_type == 'regular'"
    />
    <x-forms.radiobox 
        name="member_type" 
        value="premium"
        label="Premium"
        :checked="$user->member_type == 'premium'"
    />
    <x-forms.radiobox 
        name="member_type" 
        value="vip"
        label="VIP"
        :checked="$user->member_type == 'vip'"
    />
</div>

<!-- Radio dengan help text -->
<div class="form-group">
    <label>Metode Pembayaran:</label>
    <x-forms.radiobox 
        name="payment_method" 
        value="cash"
        label="Cash"
        help="Bayar tunai saat delivery"
    />
    <x-forms.radiobox 
        name="payment_method" 
        value="transfer"
        label="Transfer Bank"
        help="Transfer ke rekening bank"
    />
</div>

<!-- Radio disabled -->
<x-forms.radiobox 
    name="plan" 
    value="free"
    label="Free Plan"
    checked
    disabled
/>

<!-- Radio dengan custom class -->
<div class="form-group">
    <label>Tingkat Pendidikan:</label>
    <x-forms.radiobox 
        name="education" 
        value="high_school"
        label="SMA"
        wrapperClass="d-inline-block mr-3"
    />
    <x-forms.radiobox 
        name="education" 
        value="bachelor"
        label="S1"
        wrapperClass="d-inline-block mr-3"
    />
    <x-forms.radiobox 
        name="education" 
        value="master"
        label="S2"
        wrapperClass="d-inline-block"
    />
</div>

<!-- Radio dengan required dan autofocus -->
<div class="form-group">
    <label>Pilih Paket <span class="text-danger">*</span></label>
    <x-forms.radiobox 
        name="package" 
        value="basic"
        label="Basic"
        required
        autofocus
    />
    <x-forms.radiobox 
        name="package" 
        value="premium"
        label="Premium"
        required
    />
</div>
```

---

## Headings

Komponen heading (H1 - H5) dengan styling Metronic.

### H1 - Subheader Title

Digunakan untuk judul halaman di subheader.

#### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `subtitle` | string | `''` | Subtitle/deskripsi |

#### Contoh

```blade
<!-- H1 basic -->
<x-headings.h1>
    Dashboard
</x-headings.h1>

<!-- H1 dengan subtitle -->
<x-headings.h1 subtitle="Halaman utama aplikasi">
    Dashboard
</x-headings.h1>

<!-- H1 dengan subtitle panjang -->
<x-headings.h1 subtitle="Kelola semua data pengguna sistem">
    User Management
</x-headings.h1>
```

### H2 - Portlet Title

Digunakan untuk judul portlet/card.

#### Contoh

```blade
<!-- H2 basic -->
<x-headings.h2>
    Data Pengguna
</x-headings.h2>

<!-- H2 dengan class tambahan -->
<x-headings.h2 class="text-primary">
    Form Tambah Data
</x-headings.h2>
```

### H3, H4, H5 - General Headings

Heading umum untuk konten.

#### Contoh

```blade
<!-- H3 -->
<x-headings.h3>
    Section Title
</x-headings.h3>

<x-headings.h3 class="text-danger">
    Important Section
</x-headings.h3>

<!-- H4 -->
<x-headings.h4>
    Subsection Title
</x-headings.h4>

<!-- H5 -->
<x-headings.h5>
    Small Title
</x-headings.h5>
```

### Contoh Implementasi dalam Layout

```blade
<!-- Subheader -->
<div class="kt-subheader kt-grid__item">
    <div class="kt-container kt-container--fluid">
        <x-headings.h1 subtitle="Kelola data pengguna sistem">
            User Management
        </x-headings.h1>
    </div>
</div>

<!-- Content -->
<div class="kt-container kt-container--fluid kt-grid__item kt-grid__item--fluid">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <x-headings.h2>
                    Daftar Pengguna
                </x-headings.h2>
            </div>
        </div>
        <div class="kt-portlet__body">
            <!-- Content here -->
        </div>
    </div>
</div>
```

---

## Modal

Komponen modal dengan berbagai ukuran dan konfigurasi.

### Props
| Prop | Type | Default | Deskripsi |
|------|------|---------|-----------|
| `id` | string | `modal` | ID modal (required) |
| `title` | string | `''` | Judul modal |
| `size` | string | `''` | Ukuran modal (sm, lg, xl) |
| `centered` | boolean | `false` | Modal di tengah vertikal |
| `scrollable` | boolean | `false` | Body modal scrollable |
| `static` | boolean | `false` | Static backdrop (tidak bisa close dengan klik luar) |

### Contoh Penggunaan

```blade
<!-- Modal basic -->
<x-modals.modal id="modalBasic" title="Judul Modal">
    <p>Konten modal disini...</p>
</x-modals.modal>

<!-- Modal dengan footer -->
<x-modals.modal id="modalWithFooter" title="Konfirmasi">
    <p>Apakah Anda yakin ingin menghapus data ini?</p>
    
    <x-slot name="footer">
        <x-button variant="secondary" data-dismiss="modal">
            Batal
        </x-button>
        <x-button variant="danger" id="btnDelete">
            Hapus
        </x-button>
    </x-slot>
</x-modals.modal>

<!-- Modal small -->
<x-modals.modal id="modalSmall" title="Modal Kecil" size="sm">
    <p>Ini modal kecil</p>
</x-modals.modal>

<!-- Modal large -->
<x-modals.modal id="modalLarge" title="Modal Besar" size="lg">
    <p>Ini modal besar dengan konten lebih luas</p>
</x-modals.modal>

<!-- Modal extra large -->
<x-modals.modal id="modalXL" title="Modal Extra Large" size="xl">
    <p>Ini modal extra large</p>
</x-modals.modal>

<!-- Modal centered -->
<x-modals.modal id="modalCentered" title="Modal Centered" centered>
    <p>Modal ini di tengah layar</p>
</x-modals.modal>

<!-- Modal scrollable -->
<x-modals.modal id="modalScrollable" title="Modal Scrollable" scrollable>
    <p>Konten panjang yang bisa di-scroll...</p>
    <!-- Konten panjang -->
</x-modals.modal>

<!-- Modal static (tidak bisa close dengan klik backdrop) -->
<x-modals.modal id="modalStatic" title="Modal Static" static>
    <p>Modal ini tidak bisa ditutup dengan klik di luar modal</p>
    
    <x-slot name="footer">
        <x-button variant="primary" data-dismiss="modal">
            Tutup
        </x-button>
    </x-slot>
</x-modals.modal>

<!-- Modal tanpa title (custom header) -->
<x-modals.modal id="modalNoTitle">
    <h4>Custom Header Content</h4>
    <p>Modal tanpa title prop, sehingga header tidak ada</p>
</x-modals.modal>
```

### Contoh Modal Form

```blade
<!-- Trigger button -->
<x-buttons.md.primary data-toggle="modal" data-target="#modalForm">
    Tambah Data
</x-buttons.md.primary>

<!-- Modal -->
<x-modals.modal id="modalForm" title="Tambah User" size="lg">
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        
        <x-forms.input 
            name="name" 
            label="Nama Lengkap"
            required
        />
        
        <x-forms.input 
            name="email" 
            label="Email"
            type="email"
            required
        />
        
        <x-forms.select 
            name="role" 
            label="Role"
            :options="['admin' => 'Admin', 'user' => 'User']"
            required
        />
        
    </form>
    
    <x-slot name="footer">
        <x-buttons.md.secondary data-dismiss="modal">
            Batal
        </x-buttons.md.secondary>
        <x-buttons.md.primary type="submit" form="userForm">
            Simpan
        </x-buttons.md.primary>
    </x-slot>
</x-modals.modal>
```

### Membuka Modal dengan JavaScript

```blade
<!-- Button trigger -->
<x-buttons.md.info id="btnOpenModal">
    Buka Modal
</x-buttons.md.info>

<!-- Modal -->
<x-modals.modal id="myModal" title="My Modal">
    Konten modal
</x-modals.modal>

@section('script')
<script>
    // Buka modal
    $('#btnOpenModal').click(function() {
        $('#myModal').modal('show');
    });
    
    // Tutup modal
    $('#myModal').modal('hide');
    
    // Event ketika modal dibuka
    $('#myModal').on('shown.bs.modal', function () {
        console.log('Modal dibuka');
    });
    
    // Event ketika modal ditutup
    $('#myModal').on('hidden.bs.modal', function () {
        console.log('Modal ditutup');
    });
</script>
@endsection
```

---

## Tips & Best Practices

### 1. Validasi Error

Semua komponen form sudah support validasi error Laravel secara otomatis:

```php
// Controller
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users',
    ]);
    
    // ...
}
```

Error akan otomatis ditampilkan di bawah komponen yang bersangkutan.

### 2. Old Input

Semua komponen form mendukung `old()` helper Laravel untuk mempertahankan input saat validasi gagal.

### 3. Custom Class

Semua komponen mendukung penambahan class custom dengan berbagai cara:

```blade
<!-- Menggunakan class attribute (ditambahkan ke elemen utama) -->
<x-forms.input 
    name="email" 
    label="Email"
    class="form-control-lg"
/>

<!-- Menggunakan addClass prop (khusus untuk form components) -->
<x-forms.input 
    name="amount" 
    label="Jumlah"
    addClass="text-right font-weight-bold"
/>

<!-- Menggunakan props spesifik untuk setiap bagian -->
<x-forms.input 
    name="username" 
    label="Username"
    inputClass="text-uppercase"           <!-- Class untuk input element -->
    labelClass="text-primary font-weight-bold"  <!-- Class untuk label -->
    wrapperClass="col-md-6"                <!-- Class untuk wrapper div -->
/>

<!-- Untuk textarea -->
<x-forms.textarea 
    name="notes" 
    label="Catatan"
    textareaClass="font-monospace"
    labelClass="text-info"
    wrapperClass="col-md-8"
/>

<!-- Untuk select -->
<x-forms.select 
    name="category" 
    label="Kategori"
    :options="$categories"
    selectClass="text-uppercase"
    labelClass="font-weight-bold"
    wrapperClass="mb-4"
/>

<!-- Untuk checkbox -->
<x-forms.checkbox 
    name="agree" 
    label="Setuju"
    checkboxClass="custom-checkbox"
    labelClass="text-danger"
    wrapperClass="mb-3"
/>

<!-- Untuk radiobox -->
<x-forms.radiobox 
    name="gender" 
    value="male"
    label="Laki-laki"
    radioClass="custom-radio"
    labelClass="font-weight-bold"
    wrapperClass="d-inline-block mr-3"
/>

<!-- Untuk button -->
<x-buttons.md.primary class="btn-wide btn-bold btn-upper">
    Submit
</x-buttons.md.primary>
```

**Perbedaan addClass vs xxxClass:**
- `addClass` atau `inputClass`/`textareaClass`/`selectClass`: Class tambahan untuk elemen form itu sendiri
- `labelClass`: Class tambahan untuk label
- `wrapperClass`: Class tambahan untuk div wrapper (form-group)
- `class`: Class yang ditambahkan melalui attribute merge (untuk backward compatibility)

### 4. Attributes Tambahan

Anda bisa menambahkan attribute HTML apa saja:

```blade
<x-forms.input 
    name="phone" 
    label="Phone"
    maxlength="15"
    pattern="[0-9]+"
    data-mask="phone"
/>

<x-buttons.md.danger 
    onclick="return confirm('Yakin?')"
    data-id="123"
>
    Delete
</x-buttons.md.danger>
```

### 5. Kombinasi dengan Alpine.js atau Livewire

Komponen ini kompatibel dengan Alpine.js dan Livewire:

```blade
<!-- Alpine.js -->
<x-forms.input 
    name="search" 
    x-model="search"
    @input="filterData()"
/>

<!-- Livewire -->
<x-forms.input 
    name="title" 
    wire:model.defer="title"
/>
```

---

## Troubleshooting

### Komponen tidak ditemukan

Pastikan komponen berada di folder `resources/views/components/` dengan struktur yang benar.

### Style tidak muncul

Pastikan template Metronic sudah di-load dengan benar di layout utama.

### Select2 tidak berfungsi

Pastikan jQuery dan Select2 sudah di-include:

```blade
<!-- Di layout head -->
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet">

<!-- Di layout footer -->
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
```

Dan inisialisasi Select2:

```blade
@section('script')
<script>
    $('.select2').select2();
</script>
@endsection
```

---

## Update Log

- **v1.1.0** (2025-11-14)
  - Added 32 link components with button styling (4 sizes × 8 variants)
  - Enhanced all form components with additional props
  - Added custom class support (addClass, labelClass, wrapperClass, etc.)
  - Added props: autofocus, autocomplete, min/max, minlength/maxlength, pattern, readonly, size, cols
  
- **v1.0.0** (2025-11-14)
  - Initial release
  - 32 button components (4 sizes × 8 variants)
  - 6 form components (input, textarea, select, select2, checkbox, radiobox)
  - 5 heading components (H1 - H5)
  - 1 modal component

---

## Kontak & Support

Untuk pertanyaan atau bug report, silakan hubungi tim development.

**Happy Coding! 🚀**
