@extends('layouts.layouts')
@section('title','Settings')
@push('css')
<style>
    .onoffswitch {
        position: relative;
        width: 90px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .onoffswitch-checkbox {
        display: none;
    }

    .onoffswitch-label {
        display: block;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid #999999;
        border-radius: 20px;
    }

    .onoffswitch-inner {
        display: block;
        width: 200%;
        margin-left: -100%;
        -moz-transition: margin 0.3s ease-in 0s;
        -webkit-transition: margin 0.3s ease-in 0s;
        -o-transition: margin 0.3s ease-in 0s;
        transition: margin 0.3s ease-in 0s;
    }

    .onoffswitch-inner:before,
    .onoffswitch-inner:after {
        display: block;
        float: left;
        width: 50%;
        height: 30px;
        padding: 0;
        line-height: 30px;
        font-size: 14px;
        color: white;
        font-family: Trebuchet, Arial, sans-serif;
        font-weight: bold;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    .onoffswitch-inner:before {
        content: "YES";
        padding-left: 10px;
        background-color: #2FCCFF;
        color: #FFFFFF;
    }

    .onoffswitch-inner:after {
        content: "NO";
        padding-right: 10px;
        background-color: #EEEEEE;
        color: #999999;
        text-align: right;
    }

    .onoffswitch-switch {
        display: block;
        width: 18px;
        margin: 6px;
        background: #FFFFFF;
        border: 2px solid #999999;
        border-radius: 20px;
        position: absolute;
        top: 0;
        bottom: 0;
        right: 56px;
        -moz-transition: all 0.3s ease-in 0s;
        -webkit-transition: all 0.3s ease-in 0s;
        -o-transition: all 0.3s ease-in 0s;
        transition: all 0.3s ease-in 0s;
    }

    .onoffswitch-checkbox:checked+.onoffswitch-label .onoffswitch-inner {
        margin-left: 0;
    }

    .onoffswitch-checkbox:checked+.onoffswitch-label .onoffswitch-switch {
        right: 0px;
    }
</style>
@endpush

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Setting</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Setting</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa fa-money-check me-1"></i>
                Module Setting
            </div>
            <form action="{{ route('setting.update') }}" method="post">
                @csrf
                <div class="card-body" id="showData">
                    <div class="row justify-content-center">
                        <div class="col-xl-4">
                            <h4>Utility Module</h4>

                            <div class="onoffswitch">
                                <input type="checkbox" name="utility" class="onoffswitch-checkbox" id="myonoffswitch"
                                    value="1" {{ ($setting->isUtility == 1) ? 'checked' : '' }}>
                                <label class="onoffswitch-label" for="myonoffswitch">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <h4>Cooker Module</h4>

                            <div class="onoffswitch">
                                <input type="checkbox" name="cook" class="onoffswitch-checkbox" id="myonoffswitch1"
                                    value="1" {{ ($setting->isCooker == 1) ? 'checked' : '' }}>
                                <label class="onoffswitch-label" for="myonoffswitch1">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success float-end">Save Changer</button>
                </div>
            </form>
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