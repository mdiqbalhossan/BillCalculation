@extends('layouts.layouts')
@section('title','Download')
@push('css')

@endpush

@section('content')
<main>
    <div class="container-fluid px-4">
        <form method="POST" action="{{ route('post.download') }}" class="row g-3 justify-content-center my-5">
            @csrf
            <div class="col-auto">
                <select class="form-select" aria-label="Default select example" name="month">
                    <option selected>Select Month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">Jun</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            <div class="col-auto">
                <select class="form-select" aria-label="Default select example" name="type">
                    <option selected>Select Type</option>
                    <option value="utility">Utility</option>
                    <option value="cooker">Cooker</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Download</button>
            </div>
        </form>
        <div class="row justify-content-center">
            <div class="col-6">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
            </div>
        </div>


    </div>
</main>

@endsection

@push('js')
<script>
    @if(Session::has('message'))
        $(document).ready(function () {
            $.toast({
            type: 'success',
            title: 'Success',
            subtitle: 'Utility',
            content: "{{ Session::get('message') }}",
            delay: 5000,
            });
        });
    @endif
</script>
@endpush