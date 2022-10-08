@extends('layouts.layouts')
@section('title','Member')
@push('css')
<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        float: right;
    }

    /* Hide default HTML checkbox */
    .switch input {
        display: none;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }


    input.danger:checked+.slider {
        background-color: #f44336;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
@endpush
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Members</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Members</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-users me-1"></i>
                All Member
                <a href="#" class="btn btn-success btn-sm" id="add_btn" style="float: right;"><i
                        class="fa fa-plus-circle" aria-hidden="true"></i></a>
            </div>
            <div class="card-body" id="showData">
                <h4 class="text-success text-center">Loading...</h4>
            </div>
        </div>
    </div>
</main>
{{-- Add Modal --}}
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
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone">
                    </div>
                    <div class="mb-3">
                        <label for="room_no" class="form-label">Room No</label>
                        <input type="number" class="form-control" name="room_no" id="room_no">
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
{{-- Add Modal --}}
@endsection

@push('js')
<script>
    $(document).ready(function() {
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
                    url: '{{ route('member.fetch') }}',
                    method: 'get',
                    success: function(response) {
                        $("#showData").html(response);
                        $('#example').DataTable();
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            }

            $("#add_btn").click(function(e){
                e.preventDefault();
                $('#submit_btn').text("Add Member");
                $('#id').val('');
                $('#data_form').trigger("reset");
                $('.modal-title').html("Add Member");
                $("#form_modal").modal('show');
            })
    
            // Reset Form
            function reset(){
                $('#submit_btn').text("Add Member");
                $('#id').val('');
                $('#data_form').trigger("reset");
                $('.modal-title').html("Add Member");
            }
    
            // Edit Button Click
            $('body').on('click', '.edit', function () {
                var id = $(this).attr('id');
                $.get("{{ route('member.index') }}" +'/' + id +'/edit', function (data) {
                $('.modal-title').html("Edit Member");
                $('#submit_btn').val("Update Member");
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#phone').val(data.phone);
                $('#room_no').val(data.room_no);
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
                    url: "{{ route('member.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (response) {            
                        if (response.status == 200) {
                            $.toast({
                            type: 'success',
                            title: 'Success',
                            subtitle: 'Member Saved',
                            content: 'Member Data Saved Succesfully!',
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
                        subtitle: 'Member Save',
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
                let url = '/member/' + id;
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

            // Stay
            $("body").on("click", ".activeStatus", function(e) {
            e.preventDefault();
            id = $(this).attr("id");
            $.ajax({
            type: "GET",
            url: 'member/activate/'+id,
            success: function (response) {
            if(response.status == 200){
            $.toast({
            type: 'success',
            title: 'Success',
            subtitle: 'Member Status',
            content: 'Member Status Activate Succesfully',
            delay: 5000,
            });
            fetchData();
            }
            }
            });
            });

            // Leave
            $("body").on("click", ".deactivateStatus", function(e) {
            e.preventDefault();
            id = $(this).attr("id");
            $.ajax({
            type: "GET",
            url: 'member/deactivate/'+id,
            success: function (response) {
            if(response.status == 200){
                $.toast({
                type: 'success',
                title: 'Success',
                subtitle: 'Member Status',
                content: 'Member Status Deactivate Succesfully',
                delay: 5000,
                });
            fetchData();
            }
            }
            });
            });
        });
</script>
@endpush