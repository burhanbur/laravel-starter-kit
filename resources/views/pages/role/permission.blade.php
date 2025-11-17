@extends('layouts.main')

@section('title', config('app.alias') . ' | Konfigurasi Permission Role')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <i class="flaticon2-lock"></i> &nbsp; Konfigurasi Permission - {{ $role->name }}
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <a href="{{ route('role.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <form method="POST" action="{{ route('role.permission.update', ['id' => $id]) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="kt-portlet__body">
                    <h5>Daftar Permission <span class="text-danger">*</span></h5>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkAll"> 
                                <label class="custom-control-label" for="checkAll">Pilih Semua</label>
                            </div>
                        </div>
                    </div>
                    <hr>
        <div class="row">
            @foreach($groups as $key => $group)
                <div class="col-md-3" style="margin-bottom: 2%;">
                    <div class="mb-2">
                        <strong class="d-block">{{ $group->group }}</strong>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input check-group" id="checkGroup-{{ $key }}" data-group="{{ $key }}"> 
                            <label class="custom-control-label" for="checkGroup-{{ $key }}">
                                <small class="text-primary">Pilih Semua</small>
                            </label>
                        </div>
                    </div>

                    @php
                        $routesInGroup = \App\Models\Route::where('module', $group->group)
                            ->orderBy('name', 'asc')
                            ->get();
                    @endphp

                    @foreach($routesInGroup as $k => $route)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" 
                                   class="custom-control-input check check-group-{{ $key }}" 
                                   name="route_id[]" 
                                   id="check-{{ $k }}-{{ $key }}" 
                                   value="{{ $route->id }}" 
                                   data-group="{{ $key }}"
                                   @if (in_array($route->id, $myRoutes)) checked @endif> 
                            <label class="custom-control-label" for="check-{{ $k }}-{{ $key }}">
                                {{ $route->name }}
                                <small class="text-muted d-block">{{ $route->description }}</small>
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
                </div>
                
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>&nbsp; Simpan
                        </button>
                        <a href="{{ route('role.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        // Check/Uncheck All
        $('#checkAll').change(function(){
            if($(this).is(':checked')){
                $('.check').prop('checked',true);
                $('.check-group').prop('checked',true);
            }else{
                $('.check').prop('checked',false);
                $('.check-group').prop('checked',false);
            }
        });

        // Check/Uncheck All per Group
        $('.check-group').change(function(){
            var groupId = $(this).data('group');
            if($(this).is(':checked')){
                $('.check-group-' + groupId).prop('checked',true);
            }else{
                $('.check-group-' + groupId).prop('checked',false);
            }
            updateCheckAllStatus();
        });

        // Individual checkbox click
        $('.check').click(function(){
            var groupId = $(this).data('group');
            updateGroupCheckboxStatus(groupId);
            updateCheckAllStatus();
        });

        // Function to update group checkbox status
        function updateGroupCheckboxStatus(groupId) {
            var total_in_group = $('.check-group-' + groupId).length;
            var checked_in_group = $('.check-group-' + groupId + ':checked').length;

            if(checked_in_group == total_in_group){
                $('#checkGroup-' + groupId).prop('checked',true);
            }else{
                $('#checkGroup-' + groupId).prop('checked',false);
            }
        }

        // Function to update main check all status
        function updateCheckAllStatus() {
            var total_checkboxes = $('.check').length;
            var total_checkboxes_checked = $('.check:checked').length;

            if(total_checkboxes_checked == total_checkboxes){
                $('#checkAll').prop('checked',true);
            }else{
                $('#checkAll').prop('checked',false);
            }
        }

        // Initialize group checkbox status on page load
        $('.check-group').each(function(){
            var groupId = $(this).data('group');
            updateGroupCheckboxStatus(groupId);
        });

        // Initialize main check all status on page load
        updateCheckAllStatus();
    });
</script>
@endpush
