@extends('layouts.main')

@section('title', config('app.alias') . ' | Manajemen Route')

@push('styles')
<link href="{{ asset('assets/plugins/datatables/datatables.bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/datatables/datatables.bundle.min.js') }}" type="text/javascript"></script>
<script>
    var TableDatatablesEditable = function () {
        var handleTable = function () {
            var table = $('#myDataTables');
            var oTable = table.DataTable({
                // Prevent cell-indexing errors when table contains grouping/header rows
                "autoWidth": false,
                "deferRender": true,
                // Disable Responsive extension here to avoid cloned rows when
                // tbody contains grouping rows with colspan which can break
                // DataTables internal cell indexing (_DT_CellIndex).
                "responsive": false,
                // define 6 columns to match the table header so DataTables can
                // correctly index cells even when rows use colspan (group rows)
                "columns": [
                    null,
                    null,
                    null,
                    null,
                    null,
                    null
                ],
                "pageLength": 10,
                "lengthMenu": [
                    [10, 15, 20, -1],
                    [10, 15, 20, "All"]
                ],
                "language": {
                    "search": "",
                    "searchPlaceholder": "Cari data...",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    "infoEmpty": "Tidak ada entri yang ditemukan",
                    "zeroRecords": "Tidak ada data yang cocok ditemukan",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "columnDefs": [
                    {
                        'orderable': false,
                        'targets': [0, -1]
                    }, 
                    {
                        "searchable": true,
                        "targets": [0]
                    }
                ],
                "order": [
                    [0, "asc"]
                ]
            });
        }

        return {
            init: function () {
                handleTable();
            }
        };
    }();

    jQuery(document).ready(function() {
        TableDatatablesEditable.init();
    });

    setInterval(function(){
        $('.modalInterval').off('click').on('click', function () {
          $('#modalInterval').modal({backdrop: 'static', keyboard: false}) 
          
            $('#modalIntervalContent').load($(this).attr('value'));
            $('#modalIntervalTitle').html($(this).attr('title'));
        });
    }, 500);

    // Filter functionality
    $('#applyFilter').click(function() {
        var module = $('#filterModule').val();
        var method = $('#filterMethod').val();
        var url = '{{ route("route.index") }}';
        var params = [];
        
        if(module) params.push('module=' + module);
        if(method) params.push('method=' + method);
        
        if(params.length > 0) {
            url += '?' + params.join('&');
        }
        
        window.location.href = url;
    });

    $('#resetFilter').click(function() {
        window.location.href = '{{ route("route.index") }}';
    });

    // Allow Enter key to trigger filter
    $('#filterModule, #filterMethod').keypress(function(e) {
        if(e.which == 13) {
            $('#applyFilter').click();
        }
    });

    // Search functionality
    $('#searchInput').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        var visibleCount = 0;
        
        $('#myDataTables tbody tr').each(function() {
            var $row = $(this);
            
            // Skip module header rows
            if($row.hasClass('table-info')) {
                return;
            }
            
            // Get text from all columns except action column
            var rowText = '';
            $row.find('td:not(:last-child)').each(function() {
                rowText += $(this).text().toLowerCase() + ' ';
            });
            
            // Show/hide row based on search
            if(rowText.indexOf(searchTerm) > -1) {
                $row.show();
                visibleCount++;
            } else {
                $row.hide();
            }
        });
        
        // Update total badge
        $('#totalBadge').text('Total: ' + visibleCount + ' routes');
        
        // Show/hide module headers based on visible rows
        $('#myDataTables tbody tr.table-info').each(function() {
            var $headerRow = $(this);
            var hasVisibleRows = false;
            
            // Check if any following rows (until next header) are visible
            $headerRow.nextUntil('tr.table-info').each(function() {
                if($(this).is(':visible')) {
                    hasVisibleRows = true;
                    return false; // break loop
                }
            });
            
            if(hasVisibleRows) {
                $headerRow.show();
            } else {
                $headerRow.hide();
            }
        });
        
        // Show message if no results
        if(visibleCount === 0 && searchTerm !== '') {
            if($('#noResultsRow').length === 0) {
                $('#myDataTables tbody').append(
                    '<tr id="noResultsRow"><td colspan="6" class="text-center text-muted"><i class="fa fa-search"></i> Tidak ada hasil yang ditemukan</td></tr>'
                );
            }
        } else {
            $('#noResultsRow').remove();
        }
    });

</script>
@endpush

@push('modal')
<div class="modal fade" id="modalInterval" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="modalIntervalTitle"></h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
              <div class="modalError"></div>
              <div id="modalIntervalContent"></div>
          </div>
      </div>
  </div>
</div>
@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            <i class="flaticon2-layers-1"></i> &nbsp; Manajemen Route
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="javascript:void(0)" value="{{ route('route.create') }}" class="btn btn-icon btn-success modalInterval" data-bs-toggle="modal" title="Tambah Data Route" data-bs-target="#modalInterval"><i class="la la-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <!-- Filter Section -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <label>Filter Modul</label>
                            <select class="form-control" id="filterModule">
                                <option value="">Semua Modul</option>
                                @foreach($modules as $mod)
                                    <option value="{{ $mod }}" @if(request('module') == $mod) selected @endif>{{ $mod }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Filter Method</label>
                            <select class="form-control" id="filterMethod">
                                <option value="">Semua Method</option>
                                @foreach($methods as $met)
                                    <option value="{{ $met }}" @if(request('method') == $met) selected @endif>{{ $met }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label>
                            <div>
                                <button type="button" class="btn btn-primary" id="applyFilter">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                                <button type="button" class="btn btn-secondary" id="resetFilter">
                                    <i class="fa fa-undo"></i> Reset
                                </button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp;</label>
                            <div class="text-right">
                                <span class="badge badge-info" id="totalBadge">Total: {{ $route->count() }} routes</span>
                            </div>
                        </div>
                    </div>

                    <!-- Search Section -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari route name, module, atau description...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="myDataTables" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center" width="50px">No</th>
                                    <th class="text-center">Nama Route</th>
                                    <th class="text-center" width="100px">Method</th>
                                    <th class="text-center" width="150px">Modul</th>
                                    <th class="text-center">Deskripsi</th>
                                    <th class="text-center" width="120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $currentModule = null; @endphp
                                @foreach($route as $i => $item)
                                    @if($currentModule !== $item->module)
                                        @php $currentModule = $item->module; @endphp
                                        <tr class="table-info">
                                            <td colspan="6" class="font-weight-bold">
                                                <i class="fa fa-folder"></i> {{ $item->module }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="text-center align-middle">{{ $i+1 }}</td>
                                        <td class="align-middle">
                                            <code class="text-dark">{{ $item->name }}</code>
                                        </td>
                                        <td class="text-center align-middle">
                                            <span class="badge badge-pill {{ \App\Models\Route::getMethodBadgeColor($item->method) }}">
                                                {{ $item->method }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-light">{{ $item->module }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <small>{{ $item->description ?: '-' }}</small>
                                        </td>
                                        <td class="text-center align-middle">
                                            <form action="{{ route('route.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:void(0)" 
                                                   value="{{ route('route.edit', ['id' => $item->id]) }}" 
                                                   class="btn btn-sm btn-icon btn-info modalInterval" 
                                                   data-bs-toggle="modal" 
                                                   title="Ubah Data Route" 
                                                   data-bs-target="#modalInterval">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="submit" 
                                                        class="btn btn-sm btn-icon btn-danger js-submit-confirm" 
                                                        title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection