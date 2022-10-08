@extends('layouts.layouts')
@section('title','Utility')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Utility Bill</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Utility Bill</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa fa-money-check me-1"></i>
                Electricity and Water Bill
                <span class="p-2 mt-3 ms-3 bg-success bg-gradient text-white rounded-3">Total Collect:- {{ $total
                    }}</span>
                <a href="#" class="btn btn-success btn-sm" id="add_btn" style="float: right;"><i
                        class="fa fa-plus-circle" aria-hidden="true"></i></a>
                <a href="#" class="btn btn-primary btn-sm" id="add_member_btn" title="Add Member For Utility"
                    style="float: right;"><i class="fa fa-user-plus" aria-hidden="true"></i></a>
            </div>
            <div class="card-body" id="showData">
                <h4 class="text-success text-center">Loading...</h4>
            </div>
        </div>
    </div>
</main>

{{-- Add or update modal --}}
<div class="modal fade" id="form_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="data_form">
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <label for="member_id" class="form-label">Members</label>
                    <select class="form-control js-example-basic-single" name="member_id[]" id="member_id"
                        multiple="multiple">
                        @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->room_no }} - {{ $member->name }}</option>
                        @endforeach
                    </select>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount" id="amount">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" id="date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit_btn">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Add or update modal --}}
{{-- Add Member Modal --}}
<div class="modal fade" id="add_member_form_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="u_data_form">
                <input type="hidden" name="id" id="u_id">
                <div class="modal-body">
                    <label for="member_id" class="form-label">Members</label>
                    <select class="form-control js-example-basic-single" name="member_id[]" id="u_member_id"
                        multiple="multiple">
                        @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->room_no }} - {{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="u_submit_btn">Save changes</button>
                </div>
            </form>
            <hr>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h3>Member For Only Utility</h3>
                        </div>
                        <div class="card-body" id="show_member">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Add Member Modal --}}
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            placeholder: 'Select an option',
            theme: 'bootstrap-5',
        });
        $('.js-example-basic-single').select2({
        placeholder: 'Select an option',
        theme: 'bootstrap-5',
        });
            // Csrf Token
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });           
    
            // Fetch Data
            fetchData();
            function fetchData(){
                $.ajax({
                    url: '{{ route('utility.fetch') }}',
                    method: 'get',
                    success: function(response) {
                        $("#showData").html(response);
                        let dataTable = new DataTable("#datatablesSimple");
                        $('#example').DataTable();
                        dataTable.init();
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            }

            $("#add_btn").click(function(e){
                e.preventDefault();
                $('#submit_btn').text("Add Utility");
                $('#id').val('');
                $('#data_form').trigger("reset");
                $('.modal-title').html("Add Utility");
                $('#member_id').val('').trigger('change');
                $("#form_modal").modal('show');
            })
            
    
            // Reset Form
            function reset(){
                $('#submit_btn').text("Add Utility");
                $('#id').val('');
                $('#data_form').trigger("reset");
                $('.modal-title').html("Add Utility");
                $('#member_id').val('').trigger('change');
            }
    
            // Edit Button Click
            $('body').on('click', '.edit', function () {
                var id = $(this).attr('id');
                $.get("{{ route('utility.index') }}" +'/' + id +'/edit', function (data) {
                $('.modal-title').html("Edit Utility");
                $('#submit_btn').val("Update Utility");
                $('#id').val(data.id);
                $('#amount').val(data.amount);
                $('#date').val(data.date);
                $('#member_id').val(data.member_id).trigger('change');
                $("#form_modal").modal('show');
                console.log(data)
                })
            });
            
            // Data Save and update
            $('#submit_btn').click(function (e) {
                e.preventDefault();
                $(this).html('Sending..');
            
                $.ajax({
                    data: $('#data_form').serialize(),
                    url: "{{ route('utility.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (response) {            
                        if (response.status == 200) {
                            $.toast({
                            type: 'success',
                            title: 'Success',
                            subtitle: 'Utility',
                            content: 'Utility Saved Succesfully',
                            delay: 5000,                            
                            });
                            fetchData();
                            reset();
                            $("#form_modal").modal('hide');
                        }           
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $.toast({
                        type: 'error',
                        title: 'Error',
                        subtitle: 'Utility',
                        content: 'Something Went Wrong. Please try again',
                        delay: 5000,
                        });
                    }
                });
            });
    
            // Delete
            $(document).on('click', '.dlt', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                let url = '/utility/' + id;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'delete',
                            data: {
                                id: id,
                            },
                            success: function(response) {
                                console.log(response);
                                Swal.fire(
                                    'Deleted!',
                                    'Your Data has been deleted.',
                                    'success'
                                )
                                fetchData();
                            },
                            error: function(response){
                                console.log(response);
                            }
                        });
                    }
                })
            });
        });


        /***Add Member Ajax Request***/

        fetchUData();
        function fetchUData(){
        $.ajax({
        url: '{{ route('utility.fetch.member') }}',
        method: 'get',
        success: function(response) {
        $("#show_member").html(response);
        $('#example1').DataTable();
        },
        error: function(response){
        console.log(response);
        }
        });
        }

        // Reset Function
        function ureset(){
        $('#u_submit_btn').text("Add Member");
        $('#u_data_form').trigger("reset");
        $('.modal-title').html("Add Utility");
        $('#u_member_id').val('').trigger('change');
        }
        // Add Member Button
        $("#add_member_btn").click(function(e){
        e.preventDefault();
        $('#u_submit_btn').text("Add Member");
        $('#u_id').val('');
        $('#u_data_form').trigger("reset");
        $('.modal-title').html("Add Member");
        $('#u_member_id').val('').trigger('change');
        $("#add_member_form_modal").modal('show');
        })

        // Save Data
        $('#u_submit_btn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
        
        $.ajax({
        data: $('#u_data_form').serialize(),
        url: "{{ route('utility.update.member') }}",
        type: "POST",
        dataType: 'json',
        success: function (response) {
        if (response.status == 200) {
        $.toast({
        type: 'success',
        title: 'Success',
        subtitle: 'Utility Member',
        content: 'Member Added For Utility Succesfully',
        delay: 5000,
        });
        fetchUData();
        ureset();
        }
        },
        error: function (data) {
        console.log('Error:', data);
        $.toast({
        type: 'error',
        title: 'Error',
        subtitle: 'Utility',
        content: 'Something Went Wrong. Please try again',
        delay: 5000,
        });
        }
        });
        });
</script>
@endpush