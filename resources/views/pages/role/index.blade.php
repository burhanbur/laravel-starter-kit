@extends('layouts.main')

@section('title', config('app.alias') . ' | Manajemen Role')

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
                            <i class="flaticon2-shield"></i> &nbsp; Manajemen Peran (Role)
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="javascript:void(0)" value="{{ route('role.create') }}" class="btn btn-icon btn-success modalInterval" data-bs-toggle="modal" title="Tambah Data Role" data-bs-target="#modalInterval"><i class="la la-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="myDataTables" style="width: 100%;">
                            <thead>
                                <tr>
                                    <td class="text-center" width="50px">No</td>
                                    <td class="text-center">Kode</td>
                                    <td class="text-center">Nama</td>
                                    <td class="text-center">Jumlah Pengguna</td>
                                    <td class="text-center" width="150px">#</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($role as $i => $item)
                                <tr>
                                    <td class="text-center align-middle">{{ $i+1 }}</td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold">{{ $item->code }}</div>
                                    </td>
                                    <td class="align-middle">
                                        {{ $item->name }}
                                    </td>
                                    <td class="align-middle">
                                        {{ count($item->users) }}
                                    </td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('role.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="btn-group-vertical btn-group-sm d-md-none" role="group">
                                                <a href="{{ route('role.menu.show', ['id' => $item->id]) }}" class="btn btn-sm btn-icon btn-primary" title="Konfigurasi Menu - {{ $item->name }}"><i class="fa fa-sitemap"></i></a>
                                                <a href="{{ route('role.permission.show', ['id' => $item->id]) }}" class="btn btn-sm btn-icon btn-warning" title="Konfigurasi Permission - {{ $item->name }}"><i class="fa fa-user-shield"></i></a>
                                                <a href="javascript:void(0)" value="{{ route('role.edit', ['id' => $item->id]) }}" class="btn btn-sm btn-icon btn-info modalInterval" data-bs-toggle="modal" title="Ubah Data Role - {{ $item->name }}" data-bs-target="#modalInterval"><i class="fa fa-edit"></i></a>
                                                <button type="submit" class="btn btn-sm btn-danger js-submit-confirm" title="Delete"><i class="fa fa-times"></i></button>
                                            </div>
                                            <div class="d-none d-md-inline-block">
                                                <span class="tooltips" data-original-title="Konfigurasi Menu - {{ $item->name }}">
                                                    <a href="{{ route('role.menu.show', ['id' => $item->id]) }}" class="btn btn-sm btn-icon btn-primary"><i class="fa fa-sitemap"></i></a>
                                                </span>
                                                <span class="tooltips" data-original-title="Konfigurasi Permission - {{ $item->name }}">
                                                    <a href="{{ route('role.permission.show', ['id' => $item->id]) }}" class="btn btn-sm btn-icon btn-warning"><i class="fa fa-user-shield"></i></a>
                                                </span>
                                                <span class="tooltips" data-original-title="Ubah - {{ $item->name }}">
                                                    <a href="javascript:void(0)" value="{{ route('role.edit', ['id' => $item->id]) }}" class="btn btn-sm btn-icon btn-info modalInterval" data-bs-toggle="modal" title="Ubah Data Role - {{ $item->name }}" data-bs-target="#modalInterval"><i class="fa fa-edit"></i></a>
                                                </span>
                                                <span class="tooltips" data-original-title="Hapus">
                                                    <button type="submit" class="btn btn-sm btn-icon btn-danger js-submit-confirm"><i class="fa fa-times"></i></button>
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