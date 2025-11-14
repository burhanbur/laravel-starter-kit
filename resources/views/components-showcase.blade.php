@extends('layouts.main')

@section('title', 'Komponen UI')

@section('content')
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
    
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                                <i class="fa fa-layer-group"></i> Komponen UI
                        </h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <p class="lead">
                        Koleksi lengkap komponen UI yang telah disesuaikan dengan Metronic Theme. 
                        Setiap komponen dapat langsung digunakan dengan copy-paste kode yang tersedia.
                    </p>
                    <div class="alert alert-light alert-elevate" role="alert">
                        <div class="alert-icon"><i class="fa fa-info-circle kt-font-brand"></i></div>
                        <div class="alert-text">
                            <strong>Dokumentasi Lengkap:</strong> Lihat 
                            <a href="{{ asset('components/README.md') }}" target="_blank" class="kt-link">README.md</a> 
                            untuk dokumentasi detail semua props dan contoh penggunaan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="row">
        <div class="col-12">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-brand" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="tab" href="#tab_buttons" role="tab" aria-selected="true">
                                <i class="fa fa-hand-pointer"></i> Buttons
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab_alerts" role="tab" aria-selected="false">
                                <i class="fa fa-bell"></i> Alerts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab_badges" role="tab" aria-selected="false">
                                <i class="fa fa-tag"></i> Badges
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab_forms" role="tab" aria-selected="false">
                                <i class="fa fa-edit"></i> Forms
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab_tables" role="tab" aria-selected="false">
                                <i class="fa fa-table"></i> Tables
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab_cards" role="tab" aria-selected="false">
                                <i class="fa fa-window-maximize"></i> Cards
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab_others" role="tab" aria-selected="false">
                                <i class="fa fa-cube"></i> Others
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        
        <!-- BUTTONS TAB -->
        <div class="tab-pane active show" id="tab_buttons" role="tabpanel">
            <x-card title="Buttons & Links" class="mb-0">
                
                <!-- Button Variants -->
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Button Variants</h4>
                    <div class="kt-section__content">
                        <x-button variant="primary">Primary</x-button>
                        <x-button variant="secondary">Secondary</x-button>
                        <x-button variant="success">Success</x-button>
                        <x-button variant="danger">Danger</x-button>
                        <x-button variant="warning">Warning</x-button>
                        <x-button variant="info">Info</x-button>
                        <x-button variant="dark">Dark</x-button>
                        <x-button variant="default">Default</x-button>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-button variant="primary"&gt;Primary&lt;/x-button&gt;
&lt;x-button variant="success"&gt;Success&lt;/x-button&gt;
&lt;x-button variant="danger"&gt;Danger&lt;/x-button&gt;</code></pre>
                    </div>
                </div>

                <!-- Button Sizes -->
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Button Sizes</h4>
                    <div class="kt-section__content">
                        <x-button variant="primary" size="lg">Large Button</x-button>
                        <x-button variant="primary">Default Button</x-button>
                        <x-button variant="primary" size="sm">Small Button</x-button>
                        <x-button variant="primary" size="xs">Extra Small</x-button>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-button variant="primary" size="lg"&gt;Large Button&lt;/x-button&gt;
&lt;x-button variant="primary"&gt;Default Button&lt;/x-button&gt;
&lt;x-button variant="primary" size="sm"&gt;Small Button&lt;/x-button&gt;
&lt;x-button variant="primary" size="xs"&gt;Extra Small&lt;/x-button&gt;</code></pre>
                    </div>
                </div>

                <!-- Button with Icons -->
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Buttons with Icons</h4>
                    <div class="kt-section__content">
                        <x-button variant="primary"><i class="fa fa-plus"></i> Create New</x-button>
                        <x-button variant="success"><i class="fa fa-check"></i> Save</x-button>
                        <x-button variant="danger"><i class="fa fa-trash"></i> Delete</x-button>
                        <x-button variant="info"><i class="fa fa-download"></i> Download</x-button>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-button variant="primary"&gt;&lt;i class="fa fa-plus"&gt;&lt;/i&gt; Create New&lt;/x-button&gt;</code></pre>
                    </div>
                </div>

                <!-- Links as Buttons -->
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Links (Button Style)</h4>
                    <div class="kt-section__content">
                        <x-link href="#" variant="primary">Link Primary</x-link>
                        <x-link href="#" variant="success">Link Success</x-link>
                        <x-link href="#" variant="warning" size="sm"><i class="fa fa-edit"></i> Edit</x-link>
                        <x-link href="#" variant="danger" size="xs"><i class="fa fa-trash"></i></x-link>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-link href="#" variant="primary"&gt;Link Primary&lt;/x-link&gt;
&lt;x-link href="#" variant="warning" size="sm"&gt;&lt;i class="fa fa-edit"&gt;&lt;/i&gt; Edit&lt;/x-link&gt;</code></pre>
                    </div>
                </div>

                <!-- Disabled State -->
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Disabled State</h4>
                    <div class="kt-section__content">
                        <x-button variant="primary" disabled>Disabled Button</x-button>
                        <x-link href="#" variant="success" disabled>Disabled Link</x-link>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-button variant="primary" disabled&gt;Disabled Button&lt;/x-button&gt;
&lt;x-link href="#" variant="success" disabled&gt;Disabled Link&lt;/x-link&gt;</code></pre>
                    </div>
                </div>

                <!-- Block Button -->
                <div class="kt-section">
                    <h4 class="kt-section__title">Block Button (Full Width)</h4>
                    <div class="kt-section__content">
                        <x-button variant="primary" block>Block Level Button</x-button>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-button variant="primary" block&gt;Block Level Button&lt;/x-button&gt;</code></pre>
                    </div>
                </div>

            </x-card>
        </div>

        <!-- ALERTS TAB -->
        <div class="tab-pane" id="tab_alerts" role="tabpanel">
            <x-card title="Alert Messages" class="mb-0">
                
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Alert Variants</h4>
                    <div class="kt-section__content">
                        <x-alert type="success">
                            <strong>Success!</strong> Data berhasil disimpan.
                        </x-alert>
                        <x-alert type="danger">
                            <strong>Error!</strong> Terjadi kesalahan saat memproses data.
                        </x-alert>
                        <x-alert type="warning">
                            <strong>Warning!</strong> Perhatian! Data akan dihapus permanen.
                        </x-alert>
                        <x-alert type="info">
                            <strong>Info:</strong> Sistem akan maintenance pada pukul 22:00.
                        </x-alert>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-alert type="success"&gt;
    &lt;strong&gt;Success!&lt;/strong&gt; Data berhasil disimpan.
&lt;/x-alert&gt;</code></pre>
                    </div>
                </div>

                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Alert with Title</h4>
                    <div class="kt-section__content">
                        <x-alert type="success" title="Berhasil!">
                            Data pengguna telah berhasil ditambahkan ke database.
                        </x-alert>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-alert type="success" title="Berhasil!"&gt;
    Data pengguna telah berhasil ditambahkan.
&lt;/x-alert&gt;</code></pre>
                    </div>
                </div>

                <div class="kt-section">
                    <h4 class="kt-section__title">Dismissible Alert</h4>
                    <div class="kt-section__content">
                        <x-alert type="warning" dismissible>
                            <strong>Reminder:</strong> Jangan lupa untuk backup data Anda secara berkala.
                        </x-alert>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-alert type="warning" dismissible&gt;
    &lt;strong&gt;Reminder:&lt;/strong&gt; Jangan lupa backup data.
&lt;/x-alert&gt;</code></pre>
                    </div>
                </div>

            </x-card>
        </div>

        <!-- BADGES TAB -->
        <div class="tab-pane" id="tab_badges" role="tabpanel">
            <x-card title="Badges" class="mb-0">
                
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Badge Variants</h4>
                    <div class="kt-section__content">
                        <x-badge type="primary">Primary</x-badge>
                        <x-badge type="secondary">Secondary</x-badge>
                        <x-badge type="success">Success</x-badge>
                        <x-badge type="danger">Danger</x-badge>
                        <x-badge type="warning">Warning</x-badge>
                        <x-badge type="info">Info</x-badge>
                        <x-badge type="dark">Dark</x-badge>
                        <x-badge type="light">Light</x-badge>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-badge type="primary"&gt;Primary&lt;/x-badge&gt;
&lt;x-badge type="success"&gt;Success&lt;/x-badge&gt;</code></pre>
                    </div>
                </div>

                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Pill Badges</h4>
                    <div class="kt-section__content">
                        <x-badge type="primary" pill>1</x-badge>
                        <x-badge type="success" pill>Active</x-badge>
                        <x-badge type="danger" pill>99+</x-badge>
                        <x-badge type="warning" pill>Pending</x-badge>
                        <x-badge type="info" pill>New</x-badge>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-badge type="primary" pill&gt;1&lt;/x-badge&gt;
&lt;x-badge type="success" pill&gt;Active&lt;/x-badge&gt;</code></pre>
                    </div>
                </div>

                <div class="kt-section">
                    <h4 class="kt-section__title">Badge in Context</h4>
                    <div class="kt-section__content">
                        <h5>User Status: <x-badge type="success">Active</x-badge></h5>
                        <h5>Notifications <x-badge type="danger" pill>5</x-badge></h5>
                        <h5>Role: <x-badge type="primary">Administrator</x-badge></h5>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;h5&gt;User Status: &lt;x-badge type="success"&gt;Active&lt;/x-badge&gt;&lt;/h5&gt;
&lt;h5&gt;Notifications &lt;x-badge type="danger" pill&gt;5&lt;/x-badge&gt;&lt;/h5&gt;</code></pre>
                    </div>
                </div>

            </x-card>
        </div>

        <!-- FORMS TAB -->
        <div class="tab-pane" id="tab_forms" role="tabpanel">
            <x-card title="Form Components" class="mb-0">
                
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Text Input</h4>
                    <div class="kt-section__content">
                        <x-forms.input 
                            name="username" 
                            label="Username" 
                            placeholder="Enter username"
                            help="Username harus minimal 5 karakter"
                        />
                        <x-forms.input 
                            name="email" 
                            label="Email Address" 
                            type="email"
                            placeholder="user@example.com"
                            required
                        />
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-forms.input 
    name="username" 
    label="Username" 
    placeholder="Enter username"
    help="Username harus minimal 5 karakter"
/&gt;</code></pre>
                    </div>
                </div>

                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Textarea</h4>
                    <div class="kt-section__content">
                        <x-forms.textarea 
                            name="description" 
                            label="Description"
                            rows="4"
                            placeholder="Enter description here..."
                        />
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-forms.textarea 
    name="description" 
    label="Description"
    rows="4"
/&gt;</code></pre>
                    </div>
                </div>

                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Select Dropdown</h4>
                    <div class="kt-section__content">
                        <x-forms.select 
                            name="country" 
                            label="Country"
                            :options="['id' => 'Indonesia', 'sg' => 'Singapore', 'my' => 'Malaysia']"
                            placeholder="Select country..."
                        />
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-forms.select 
    name="country" 
    label="Country"
    :options="['id' => 'Indonesia', 'sg' => 'Singapore']"
    placeholder="Select country..."
/&gt;</code></pre>
                    </div>
                </div>

                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Checkbox</h4>
                    <div class="kt-section__content">
                        <x-forms.checkbox 
                            name="agree" 
                            label="I agree to the terms and conditions"
                        />
                        <x-forms.checkbox 
                            name="newsletter" 
                            label="Subscribe to newsletter"
                            checked
                        />
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-forms.checkbox 
    name="agree" 
    label="I agree to the terms"
/&gt;</code></pre>
                    </div>
                </div>

                <div class="kt-section">
                    <h4 class="kt-section__title">Radio Button</h4>
                    <div class="kt-section__content">
                        <x-forms.radiobox 
                            name="gender" 
                            value="male"
                            label="Male"
                        />
                        <x-forms.radiobox 
                            name="gender" 
                            value="female"
                            label="Female"
                        />
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-forms.radiobox 
    name="gender" 
    value="male"
    label="Male"
/&gt;</code></pre>
                    </div>
                </div>

            </x-card>
        </div>

        <!-- TABLES TAB -->
        <div class="tab-pane" id="tab_tables" role="tabpanel">
            <x-card title="Tables" class="mb-0">
                
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Basic Table</h4>
                    <div class="kt-section__content">
                        <x-table>
                            <x-slot name="thead">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </x-slot>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td><x-badge type="success">Active</x-badge></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td><x-badge type="warning">Pending</x-badge></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Bob Wilson</td>
                                <td>bob@example.com</td>
                                <td><x-badge type="danger">Inactive</x-badge></td>
                            </tr>
                        </x-table>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-table&gt;
    &lt;x-slot name="thead"&gt;
        &lt;tr&gt;&lt;th&gt;ID&lt;/th&gt;&lt;th&gt;Name&lt;/th&gt;&lt;/tr&gt;
    &lt;/x-slot&gt;
    &lt;tr&gt;&lt;td&gt;1&lt;/td&gt;&lt;td&gt;John&lt;/td&gt;&lt;/tr&gt;
&lt;/x-table&gt;</code></pre>
                    </div>
                </div>

                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Striped & Hover Table</h4>
                    <div class="kt-section__content">
                        <x-table striped hover>
                            <x-slot name="thead">
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                </tr>
                            </x-slot>
                            <tr>
                                <td>1</td>
                                <td>Laptop</td>
                                <td>Rp 10,000,000</td>
                                <td>15</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Mouse</td>
                                <td>Rp 150,000</td>
                                <td>50</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Keyboard</td>
                                <td>Rp 500,000</td>
                                <td>30</td>
                            </tr>
                        </x-table>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-table striped hover&gt;
    ...
&lt;/x-table&gt;</code></pre>
                    </div>
                </div>

                <div class="kt-section">
                    <h4 class="kt-section__title">Table with Actions</h4>
                    <div class="kt-section__content">
                        <x-table striped>
                            <x-slot name="thead">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </x-slot>
                            <tr>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td>
                                    <x-link href="#" variant="info" size="xs"><i class="fa fa-eye"></i></x-link>
                                    <x-link href="#" variant="warning" size="xs"><i class="fa fa-edit"></i></x-link>
                                    <x-link href="#" variant="danger" size="xs"><i class="fa fa-trash"></i></x-link>
                                </td>
                            </tr>
                            <tr>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td>
                                    <x-link href="#" variant="info" size="xs"><i class="fa fa-eye"></i></x-link>
                                    <x-link href="#" variant="warning" size="xs"><i class="fa fa-edit"></i></x-link>
                                    <x-link href="#" variant="danger" size="xs"><i class="fa fa-trash"></i></x-link>
                                </td>
                            </tr>
                        </x-table>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;td&gt;
    &lt;x-link href="#" variant="info" size="xs"&gt;&lt;i class="fa fa-eye"&gt;&lt;/i&gt;&lt;/x-link&gt;
    &lt;x-link href="#" variant="warning" size="xs"&gt;&lt;i class="fa fa-edit"&gt;&lt;/i&gt;&lt;/x-link&gt;
&lt;/td&gt;</code></pre>
                    </div>
                </div>

            </x-card>
        </div>

        <!-- CARDS TAB -->
        <div class="tab-pane" id="tab_cards" role="tabpanel">
            <x-card title="Card Examples" class="mb-0">
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Basic Card & Card with Actions</h4>
                    <div class="kt-section__content">
                        <div class="row">
                            <div class="col-md-6">
                                <x-card title="Basic Card">
                                    <p>This is a basic card component with title.</p>
                                    <p>Cards are used to group related content.</p>
                                </x-card>
                            </div>
                            <div class="col-md-6">
                                <x-card title="Card with Actions">
                                    <x-slot name="actions">
                                        <x-button variant="primary" size="sm">
                                            <i class="fa fa-plus"></i> Add
                                        </x-button>
                                    </x-slot>
                                    <p>This card has action buttons in the header.</p>
                                </x-card>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Card with Footer</h4>
                    <div class="kt-section__content">
                        <div class="row">
                            <div class="col-md-12">
                                <x-card title="Card with Footer">
                                    <p>This card has a footer section with action buttons.</p>
                                    <x-forms.input name="sample" label="Sample Field" placeholder="Enter something..." />
                                    
                                    <x-slot name="footer">
                                        <x-button type="submit" variant="primary">Save</x-button>
                                        <x-button variant="secondary">Cancel</x-button>
                                    </x-slot>
                                </x-card>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-section">
                    <h4 class="kt-section__title">Code Example</h4>
                    <div class="kt-section__content">
                        <pre class="language-markup"><code>&lt;x-card title="Card Title"&gt;
    &lt;x-slot name="actions"&gt;
        &lt;x-button variant="primary"&gt;Add&lt;/x-button&gt;
    &lt;/x-slot&gt;
    
    &lt;!-- Card content --&gt;
    
    &lt;x-slot name="footer"&gt;
        &lt;x-button variant="primary"&gt;Save&lt;/x-button&gt;
    &lt;/x-slot&gt;
&lt;/x-card&gt;</code></pre>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- OTHERS TAB -->
        <div class="tab-pane" id="tab_others" role="tabpanel">
            <x-card title="Other Components" class="mb-0">
                
                <!-- Breadcrumb -->
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Breadcrumb</h4>
                    <div class="kt-section__content">
                        <x-breadcrumb :items="[
                            ['label' => 'Home', 'url' => '#'],
                            ['label' => 'Library', 'url' => '#'],
                            ['label' => 'Components']
                        ]" />
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-breadcrumb :items="[
    ['label' => 'Home', 'url' => '#'],
    ['label' => 'Library', 'url' => '#'],
    ['label' => 'Components']
]" /&gt;</code></pre>
                    </div>
                </div>

                <!-- Spinner -->
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Spinner / Loading</h4>
                    <div class="kt-section__content">
                        <x-spinner color="primary" />
                        <x-spinner color="success" />
                        <x-spinner color="danger" />
                        <x-spinner type="grow" color="warning" />
                        <x-spinner type="grow" color="info" />
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-spinner color="primary" /&gt;
&lt;x-spinner type="grow" color="warning" /&gt;</code></pre>
                    </div>
                </div>

                <!-- Headings -->
                <div class="kt-section mb-5">
                    <h4 class="kt-section__title">Headings</h4>
                    <div class="kt-section__content">
                        <x-headings.h1>Heading 1</x-headings.h1>
                        <x-headings.h2>Heading 2</x-headings.h2>
                        <x-headings.h3>Heading 3</x-headings.h3>
                        <x-headings.h4>Heading 4</x-headings.h4>
                        <x-headings.h5>Heading 5</x-headings.h5>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-headings.h1&gt;Heading 1&lt;/x-headings.h1&gt;
&lt;x-headings.h2&gt;Heading 2&lt;/x-headings.h2&gt;</code></pre>
                    </div>
                </div>

                <!-- Modal -->
                <div class="kt-section">
                    <h4 class="kt-section__title">Modal</h4>
                    <div class="kt-section__content">
                        <x-button variant="primary" data-toggle="modal" data-target="#demoModal">
                            Open Modal
                        </x-button>
                    </div>
                    <div class="kt-section__content mt-3">
                        <pre class="language-markup"><code>&lt;x-button variant="primary" data-toggle="modal" data-target="#myModal"&gt;
    Open Modal
&lt;/x-button&gt;

&lt;x-modal id="myModal" title="Modal Title"&gt;
    &lt;p&gt;Modal content here...&lt;/p&gt;
    
    &lt;x-slot name="footer"&gt;
        &lt;x-button variant="primary"&gt;Save&lt;/x-button&gt;
        &lt;x-button variant="secondary" data-dismiss="modal"&gt;Close&lt;/x-button&gt;
    &lt;/x-slot&gt;
&lt;/x-modal&gt;</code></pre>
                    </div>
                </div>

            </x-card>
        </div>

    </div>

</div>

<!-- Demo Modal -->
<x-modal id="demoModal" title="Demo Modal">
    <p>This is a demo modal to show how modals work.</p>
    <p>You can add any content here including forms, tables, or other components.</p>
    
    <x-slot name="footer">
        <x-button variant="secondary" data-dismiss="modal">Close</x-button>
        <x-button variant="primary">Save changes</x-button>
    </x-slot>
</x-modal>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Simple tab switcher
    $('.nav-tabs a[data-toggle="tab"]').on('click', function (e) {
        e.preventDefault();
        
        // Remove active from all tabs and panes
        $('.nav-tabs .nav-link').removeClass('active show');
        $('.tab-pane').removeClass('active show');
        
        // Add active to clicked tab
        $(this).addClass('active show');
        
        // Show corresponding pane
        var target = $(this).attr('href');
        $(target).addClass('active show');
    });
});
</script>
@endpush
