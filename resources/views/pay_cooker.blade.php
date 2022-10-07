@extends('layouts.layouts')
@section('title','Pay Cooker Bill')
@push('css')

@endpush

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Pay Cooker Bill</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Pay Cooker Bill</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa fa-money-check me-1"></i>
                Pay Cooker Bill
                <span class="p-2 mt-3 ms-3 bg-success bg-gradient text-white rounded-3">Total Paid:- {{ $total
                    }}</span>
                <a href="#" class="btn btn-success btn-sm" id="add_btn" style="float: right;"><i
                        class="fa fa-plus-circle" aria-hidden="true"></i></a>
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
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
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
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    url: '{{ route('cooker.pay.fetch') }}',
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
                $('#submit_btn').text("Add Pay Cooker Bill");
                $('#id').val('');
                $('#data_form').trigger("reset");
                $('.modal-title').html("Add Pay Cooker Bill");
                $("#form_modal").modal('show');
            })
    
            // Reset Form
            function reset(){
                $('#submit_btn').text("Add Pay Cooker Bill");
                $('#id').val('');
                $('#data_form').trigger("reset");
                $('.modal-title').html("Add Pay Cooker Bill");
            }
    
            // Edit Button Click
            $('body').on('click', '.edit', function () {
                var id = $(this).attr('id');
                $.get("{{ route('bill.index') }}" +'/' + id +'/edit', function (data) {
                $('.modal-title').html("Edit Pay Cooker Bill");
                $('#submit_btn').val("Update Pay Cooker Bill");
                $('#id').val(data.id);
                $('#amount').val(data.amount);
                $('#date').val(data.date);
                $('#name').val(data.name);
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
                    url: "{{ route('bill.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (response) {            
                        if (response.status == 200) {
                            $.toast({
                            type: 'success',
                            title: 'Success',
                            subtitle: 'Cooker',
                            content: 'Cooker Bill Paid Succesfully',
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
                        subtitle: 'Cooker Bill',
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
                let url = '/pay/cooker/bill/' + id;
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
</script>
@endpush