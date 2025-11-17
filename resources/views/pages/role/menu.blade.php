@extends('layouts.main')

@section('title', config('app.alias') . ' | Konfigurasi Menu Role')

@push('styles')
<style>
    .menu-item-card {
        background: #fff;
        border: 1px solid #e2e5ec;
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    .menu-item-card:hover {
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .menu-item-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    .menu-number {
        background: #5867dd;
        color: white;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 10px;
    }
    .preview-sidebar {
        background: #f7f8fa;
        border: 1px solid #e2e5ec;
        border-radius: 4px;
        padding: 20px;
        position: sticky;
        top: 20px;
    }
    .preview-menu-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin-bottom: 5px;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        border-left: 3px solid transparent;
    }
    .preview-menu-item:hover {
        background: #5867dd;
        color: white;
        border-left-color: #3b4ec5;
    }
    .preview-menu-item.inactive {
        opacity: 0.5;
        background: #f5f5f5;
    }
    .preview-menu-item i {
        margin-right: 10px;
        width: 20px;
    }
    .preview-menu-item.child {
        padding-left: 45px;
        font-size: 0.9em;
    }
    .preview-menu-item.child:before {
        content: "└─";
        position: absolute;
        left: 25px;
        color: #a1a8c3;
    }
    .preview-empty {
        text-align: center;
        padding: 40px 20px;
        color: #a1a8c3;
    }
    .drag-handle {
        cursor: move;
        color: #a1a8c3;
        margin-right: 10px;
    }
    .menu-type-badge {
        font-size: 0.75rem;
        padding: 2px 8px;
        border-radius: 3px;
        margin-left: 10px;
    }
    .badge-sidebar {
        background: #5867dd;
        color: white;
    }
    .badge-topbar {
        background: #fd397a;
        color: white;
    }
    .child-indicator {
        display: inline-block;
        padding: 2px 8px;
        background: #ffb822;
        color: white;
        border-radius: 3px;
        font-size: 0.75rem;
        margin-left: 10px;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <i class="flaticon2-list"></i> &nbsp; Konfigurasi Menu - {{ $role->name }}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <button type="button" class="btn btn-primary btn-sm" id="addrow">
                        <i class="fa fa-plus"></i> Tambah Menu
                    </button>
                </div>
            </div>
            
            <form method="POST" action="{{ route('role.menu.update', ['id' => $id]) }}" enctype="multipart/form-data" id="menuForm">
                @csrf
                
                <div class="kt-portlet__body">
                    <div id="menu">
                        @php $counter = 0 @endphp
                        @if($collection->count() == 0)
                            <div class="alert alert-info" id="emptyState">
                                <i class="fa fa-info-circle"></i> Belum ada menu yang dikonfigurasi. Klik tombol "Tambah Menu" untuk memulai.
                            </div>
                        @endif
                        
                        @foreach($collection as $key => $value)
                            <div class="menu-item-card" data-index="{{ $value->id }}">
                                <div class="menu-item-header">
                                    <i class="fa fa-grip-vertical drag-handle"></i>
                                    <div class="menu-number">{{ $key + 1 }}</div>
                                    <strong>Item Menu #{{ $key + 1 }}</strong>
                                    <button type="button" class="btn btn-sm btn-danger ml-auto ibtnDel">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Menu <span class="text-danger">*</span></label>
                                            <select class="form-control select2 menu-select" name="menu_id[{{ $value->id }}]" required data-menu-icon="">
                                                <option value="">Pilih Menu</option>
                                                @foreach($menus as $k => $v)
                                                    <option value="{{ $v->id }}" 
                                                            data-icon="{{ $v->icon }}" 
                                                            @if ($v->id == $value->menu_id) selected @endif>
                                                        {{ $v->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Route (URL)</label>
                                            <select class="form-control select2" name="route_id[{{ $value->id }}]">
                                                <option value="">Pilih Route</option>
                                                @foreach($routes as $k => $v)
                                                    <option value="{{ $v->id }}" @if ($v->id == $value->route_id) selected @endif>{{ $v->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Parent Menu</label>
                                            <select class="form-control select2 parent-select" name="parent_id[{{ $value->id }}]" data-current-id="{{ $value->id }}">
                                                <option value="">Tidak Ada (Root Menu)</option>
                                                @foreach($collection as $parent)
                                                    @if($parent->id != $value->id)
                                                        <option value="{{ $parent->id }}" @if ($parent->id == $value->parent_id) selected @endif>
                                                            {{ $parent->menu->name ?? 'Unknown' }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">Pilih parent jika menu ini adalah submenu</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tipe Menu <span class="text-danger">*</span></label>
                                            <select class="form-control select2 menu-type-select" name="menu_type_id[{{ $value->id }}]" required>
                                                @foreach($menuTypes as $type)
                                                    <option value="{{ $type->id }}" @if ($type->id == ($value->menu_type_id ?? 1)) selected @endif>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">Sidebar, Topbar, atau lainnya</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Urutan <span class="text-danger">*</span></label>
                                            <input type="number" 
                                                   class="form-control sequence-input" 
                                                   name="sequence[{{ $value->id }}]" 
                                                   value="{{ $value->sequence }}" 
                                                   min="1" 
                                                   step="1"
                                                   required
                                                   placeholder="Contoh: 1, 2, 3...">
                                            <small class="form-text text-muted">Urutan tampilan menu (angka terkecil di atas)</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <div class="kt-checkbox-inline">
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="is_active[{{ $value->id }}]" class="active-checkbox" @if ($value->is_active) checked @endif>
                                                    Menu Aktif
                                                    <span></span>
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">Centang jika menu ingin ditampilkan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $counter = $key + 1;
                            @endphp
                        @endforeach
                    </div>
                </div>
    
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>&nbsp; Simpan Konfigurasi
                        </button>
                        <a href="{{ route('role.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Preview Sidebar -->
    <div class="col-lg-4">
        <div class="preview-sidebar">
            <h5 class="mb-3">
                <i class="fa fa-eye"></i> Preview Menu Sidebar
            </h5>
            <p class="text-muted small mb-3">Tampilan menu yang akan terlihat oleh role <strong>{{ $role->name }}</strong></p>
            <hr>
            <div id="menuPreview">
                <div class="preview-empty">
                    <i class="fa fa-list-ul fa-3x mb-3"></i>
                    <p>Belum ada menu<br><small>Tambahkan menu untuk melihat preview</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    var counter = parseInt('<?= $counter ?>');
    var menuData = @json($menus);
    var routeData = @json($routes);
    var menuTypeData = @json($menuTypes);

    $(document).ready(function(){
        initializeComponents();
        updatePreview();
        updateMenuNumbers();
    });

    function initializeComponents() {
        $('.select2').select2({
            theme: 'bootstrap4',
        });

        // Listen to changes for preview update
        $(document).on('change', '.menu-select, .parent-select, .menu-type-select, .active-checkbox, .sequence-input', function() {
            updatePreview();
        });
        
        // Update parent options when menu selection changes
        $(document).on('change', '.menu-select', function() {
            updateParentOptions();
        });
    }

    function updatePreview() {
        var menuItems = [];
        var menuItemsMap = {};
        
        $('#menu .menu-item-card').each(function(index) {
            var $card = $(this);
            var cardIndex = $card.data('index');
            var currentId = $card.find('.parent-select').data('current-id');
            var menuId = $card.find('.menu-select').val();
            var parentId = $card.find('.parent-select').val();
            var menuTypeId = $card.find('.menu-type-select').val();
            var isActive = $card.find('.active-checkbox').is(':checked');
            var sequence = parseInt($card.find('.sequence-input').val()) || 999;
            
            if(menuId) {
                var menuOption = $card.find('.menu-select option:selected');
                var menuName = menuOption.text();
                var menuIcon = menuOption.data('icon') || 'fa fa-dot-circle';
                var menuTypeName = $card.find('.menu-type-select option:selected').text();
                
                var item = {
                    id: currentId || cardIndex,
                    cardIndex: cardIndex,
                    name: menuName,
                    icon: menuIcon,
                    active: isActive,
                    sequence: sequence,
                    parentId: parentId,
                    menuType: menuTypeName,
                    menuTypeId: menuTypeId
                };
                
                menuItems.push(item);
                menuItemsMap[item.id] = item;
            }
        });
        
        // Sort by sequence
        menuItems.sort(function(a, b) {
            return a.sequence - b.sequence;
        });
        
        // Generate preview grouped by menu type
        var previewHtml = '';
        if(menuItems.length === 0) {
            previewHtml = '<div class="preview-empty"><i class="fa fa-list-ul fa-3x mb-3"></i><p>Belum ada menu<br><small>Tambahkan menu untuk melihat preview</small></p></div>';
        } else {
            var menuTypes = {};
            
            // Group root menus by type
            menuItems.forEach(function(item) {
                // Only add root menus (no parent or empty parent)
                if(!item.parentId || item.parentId === '' || item.parentId === null) {
                    if(!menuTypes[item.menuType]) {
                        menuTypes[item.menuType] = [];
                    }
                    menuTypes[item.menuType].push(item);
                }
            });
            
            // Render each menu type group
            Object.keys(menuTypes).forEach(function(typeName) {
                var typeClass = typeName.toLowerCase().replace(/\s+/g, '-');
                previewHtml += '<div class="mb-3">';
                previewHtml += '<strong class="menu-type-badge badge-' + typeClass + '">' + typeName + '</strong>';
                
                // Render root menus
                menuTypes[typeName].forEach(function(item) {
                    var activeClass = item.active ? '' : ' inactive';
                    previewHtml += '<div class="preview-menu-item' + activeClass + '">';
                    previewHtml += '<i class="' + item.icon + '"></i>';
                    previewHtml += '<span>' + item.name + '</span>';
                    if(!item.active) {
                        previewHtml += '<small class="ml-auto">(Nonaktif)</small>';
                    }
                    previewHtml += '</div>';
                    
                    // Render children of this menu
                    menuItems.forEach(function(child) {
                        if(child.parentId && child.parentId == item.id) {
                            var childActiveClass = child.active ? '' : ' inactive';
                            previewHtml += '<div class="preview-menu-item child' + childActiveClass + '">';
                            previewHtml += '<i class="' + child.icon + '"></i>';
                            previewHtml += '<span>' + child.name + '</span>';
                            if(!child.active) {
                                previewHtml += '<small class="ml-auto">(Nonaktif)</small>';
                            }
                            previewHtml += '</div>';
                        }
                    });
                });
                
                previewHtml += '</div>';
            });
        }
        
        $('#menuPreview').html(previewHtml);
    }
    
    function updateParentOptions() {
        // Update parent dropdown options to exclude self and show current menus
        $('#menu .menu-item-card').each(function() {
            var $card = $(this);
            var currentId = $card.find('.parent-select').data('current-id');
            var $parentSelect = $card.find('.parent-select');
            var currentParent = $parentSelect.val();
            
            // Rebuild options
            var options = '<option value="">Tidak Ada (Root Menu)</option>';
            $('#menu .menu-item-card').each(function() {
                var $otherCard = $(this);
                var otherId = $otherCard.find('.parent-select').data('current-id');
                
                // Skip self
                if(otherId != currentId) {
                    var menuId = $otherCard.find('.menu-select').val();
                    var menuName = $otherCard.find('.menu-select option:selected').text();
                    
                    // Only add to options if menu is actually selected
                    if(menuId && menuName && menuName !== 'Pilih Menu') {
                        var selected = (currentParent && otherId == currentParent) ? 'selected' : '';
                        options += '<option value="' + otherId + '" ' + selected + '>' + menuName + '</option>';
                    }
                }
            });
            
            $parentSelect.html(options);
        });
    }

    function updateMenuNumbers() {
        $('#menu .menu-item-card').each(function(index) {
            $(this).find('.menu-number').text(index + 1);
            $(this).find('.menu-item-header strong').text('Item Menu #' + (index + 1));
        });
    }

    $("#addrow").on("click", function () {
        $('#emptyState').remove();
        
        var newCard = $('<div class="menu-item-card" data-index="' + counter + '">');
        var html = '';
        
        html += '<div class="menu-item-header">';
        html += '<i class="fa fa-grip-vertical drag-handle"></i>';
        html += '<div class="menu-number">' + (counter + 1) + '</div>';
        html += '<strong>Item Menu #' + (counter + 1) + '</strong>';
        html += '<button type="button" class="btn btn-sm btn-danger ml-auto ibtnDel"><i class="fa fa-trash"></i> Hapus</button>';
        html += '</div>';
        
        html += '<div class="row">';
        html += '<div class="col-md-6">';
        html += '<div class="form-group">';
        html += '<label>Menu <span class="text-danger">*</span></label>';
        html += '<select class="form-control select2-new menu-select" name="menu_id['+counter+']" required>';
        html += '<option value="">Pilih Menu</option>';
        menuData.forEach(function(menu) {
            html += '<option value="' + menu.id + '" data-icon="' + menu.icon + '">' + menu.name + '</option>';
        });
        html += '</select>';
        html += '</div></div>';
        
        html += '<div class="col-md-6">';
        html += '<div class="form-group">';
        html += '<label>Route (URL)</label>';
        html += '<select class="form-control select2-new" name="route_id['+counter+']">';
        html += '<option value="">Pilih Route</option>';
        routeData.forEach(function(route) {
            html += '<option value="' + route.id + '">' + route.name + '</option>';
        });
        html += '</select>';
        html += '</div></div></div>';
        
        html += '<div class="row">';
        html += '<div class="col-md-6">';
        html += '<div class="form-group">';
        html += '<label>Parent Menu</label>';
        html += '<select class="form-control select2-new parent-select" name="parent_id['+counter+']" data-current-id="'+counter+'">';
        html += '<option value="">Tidak Ada (Root Menu)</option>';
        html += '</select>';
        html += '<small class="form-text text-muted">Pilih parent jika menu ini adalah submenu</small>';
        html += '</div></div>';
        
        html += '<div class="col-md-6">';
        html += '<div class="form-group">';
        html += '<label>Tipe Menu <span class="text-danger">*</span></label>';
        html += '<select class="form-control select2-new menu-type-select" name="menu_type_id['+counter+']" required>';
        menuTypeData.forEach(function(type) {
            html += '<option value="' + type.id + '">' + type.name + '</option>';
        });
        html += '</select>';
        html += '<small class="form-text text-muted">Sidebar, Topbar, atau lainnya</small>';
        html += '</div></div></div>';
        
        html += '<div class="row">';
        html += '<div class="col-md-6">';
        html += '<div class="form-group">';
        html += '<label>Urutan <span class="text-danger">*</span></label>';
        html += '<input type="number" class="form-control sequence-input" name="sequence['+counter+']" min="1" step="1" required placeholder="Contoh: 1, 2, 3...">';
        html += '<small class="form-text text-muted">Urutan tampilan menu (angka terkecil di atas)</small>';
        html += '</div></div>';
        
        html += '<div class="col-md-6">';
        html += '<div class="form-group">';
        html += '<label>&nbsp;</label>';
        html += '<div class="kt-checkbox-inline">';
        html += '<label class="kt-checkbox">';
        html += '<input type="checkbox" name="is_active['+counter+']" class="active-checkbox" checked>';
        html += 'Menu Aktif<span></span>';
        html += '</label></div>';
        html += '<small class="form-text text-muted">Centang jika menu ingin ditampilkan</small>';
        html += '</div></div></div>';
        
        newCard.html(html);
        $("#menu").append(newCard);

        // Initialize select2 for new elements
        $('.select2-new').select2({
            theme: 'bootstrap4',
        });
        $('.select2-new').removeClass('select2-new');

        counter++;
        updateMenuNumbers();
        updateParentOptions();
        updatePreview();
    });

    $("#menu").on("click", ".ibtnDel", function (event) {
        event.preventDefault();
        
        if(confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
            $(this).closest(".menu-item-card").fadeOut(300, function() {
                $(this).remove();
                updateMenuNumbers();
                updateParentOptions();
                updatePreview();
                
                if($('#menu .menu-item-card').length === 0) {
                    $('#menu').prepend('<div class="alert alert-info" id="emptyState"><i class="fa fa-info-circle"></i> Belum ada menu yang dikonfigurasi. Klik tombol "Tambah Menu" untuk memulai.</div>');
                }
            });
        }
    });
</script>
@endpush
