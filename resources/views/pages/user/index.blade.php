@extends('layouts.main')

@section('title', config('app.alias') . ' | Manajemen Pengguna')

@push('styles')
<link href="{{ asset('assets/plugins/datatables/datatables.bundle.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/datatables/datatables.bundle.min.js') }}" type="text/javascript"></script>
<script>
    var TableDatatablesEditable = function () {
        var handleTable = function () {
            var table = $('#myDataTables');
            var oTable = table.dataTable({
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
                            <i class="flaticon2-avatar"></i> &nbsp; Manajemen Pengguna
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="javascript:void(0)" value="{{ route('user.create') }}" class="btn btn-icon btn-success modalInterval" data-bs-toggle="modal" title="Tambah Data Pengguna" data-bs-target="#modalInterval"><i class="la la-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <form method="GET">
                        <div class="row">
                            <div class="col-md-10 col-12">
                                <div class="form-group">
                                    <label><strong>Peran</strong></label>
                                    <select name="role" class="form-control select2-format">
                                        <option value="">Semua</option>
                                        @foreach($roles as $key => $row)
                                            <option @if ($row->id == $role) selected @endif value="{{ $row->id }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 col-12">
                                <div class="form-group">
                                    <label class="d-none d-md-block" style="visibility: hidden;">js</label>
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="myDataTables" style="width: 100%;">
                            <thead>
                                <tr>
                                    <td class="text-center" width="50px">No</td>
                                    <td class="text-center">Nama</td>
                                    <td class="text-center d-none d-md-table-cell">Email</td>
                                    <td class="text-center d-none d-lg-table-cell">No. Telepon</td>
                                    <td class="text-center d-none d-md-table-cell">Peran</td>
                                    <td class="text-center" width="150px">#</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user as $i => $item)
                                <tr>
                                    <td class="text-center align-middle">{{ $i+1 }}</td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold">{{ $item->name }}</div>
                                        <small class="d-md-none text-muted">
                                            {{ $item->email }}<br>
                                            {{ $item->phone }}<br>
                                            <span class="badge badge-info">{{ $item->roles->pluck('name')->join(', ') }}</span>
                                        </small>
                                    </td>
                                    <td class="align-middle d-none d-md-table-cell">
                                        {{ $item->email }}
                                    </td>
                                    <td class="align-middle d-none d-lg-table-cell">
                                        {{ $item->phone }}
                                    </td>
                                    <td class="align-middle d-none d-md-table-cell">
                                        {{ $item->roles->pluck('name')->join(', ') }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('user.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="btn-group-vertical btn-group-sm d-md-none" role="group">
                                                <a href="{{ route('impersonate', $item->id)}}" class="btn btn-sm btn-dark" title="Impersonate"><i class="fa fa-user-secret"></i></a>
                                                <a href="javascript:void(0)" value="{{ route('user.edit', ['id' => $item->id]) }}" class="btn btn-sm btn-icon btn-info modalInterval" data-bs-toggle="modal" title="Ubah Data Pengguna" data-bs-target="#modalInterval"><i class="fa fa-edit"></i></a>
                                                <a href="javascript:void(0)" value="{{ route('user.change-password', ['id' => $item->id]) }}" class="btn btn-sm btn-icon btn-warning modalInterval" data-bs-toggle="modal" title="Ubah Password Data Pengguna" data-bs-target="#modalInterval"><i class="fa fa-unlock-alt"></i></a>
                                                <button type="submit" class="btn btn-sm btn-danger js-submit-confirm" {{ $item->hasChild() ? 'disabled' : '' }} title="Delete"><i class="fa fa-times"></i></button>
                                            </div>
                                            <div class="d-none d-md-inline-block">
                                                <span class="tooltips" data-original-title="Impersonate">
                                                    <a href="{{ route('impersonate', $item->id)}}" class="btn btn-sm btn-icon btn-dark"><i class="fa fa-user-secret"></i></a>
                                                </span>
                                                <span class="tooltips" data-original-title="Ubah">
                                                    <a href="javascript:void(0)" value="{{ route('user.edit', ['id' => $item->id]) }}" class="btn btn-sm btn-icon btn-info modalInterval" data-bs-toggle="modal" title="Ubah Data Pengguna" data-bs-target="#modalInterval"><i class="fa fa-edit"></i></a>
                                                </span>
                                                <span class="tooltips" data-original-title="Ubah Password">
                                                    <a href="javascript:void(0)" value="{{ route('user.change-password', ['id' => $item->id]) }}" class="btn btn-sm btn-icon btn-warning modalInterval" data-bs-toggle="modal" title="Ubah Password Data Pengguna" data-bs-target="#modalInterval"><i class="fa fa-unlock-alt"></i></a>
                                                </span>
                                                <span class="tooltips" data-original-title="Hapus">
                                                    <button type="submit" class="btn btn-sm btn-icon btn-danger js-submit-confirm" {{ $item->hasChild() ? 'disabled' : '' }}><i class="fa fa-times"></i></button>
                                                </span>
                                            </div>
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