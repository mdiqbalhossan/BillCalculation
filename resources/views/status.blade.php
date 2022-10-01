@extends('layouts.layouts')
@section('title','Status')
@push('css')
<style>
    .card {
        margin-bottom: 16px;
        background-color: #fff;
        border: 1px solid #eceff5;
        -webkit-box-shadow: 0 2px 6px 0 rgba(173, 175, 182, .3);
        box-shadow: 0 2px 6px 0 rgba(173, 175, 182, .3);
    }

    .btn-de-primary {
        background-color: transparent !important;
        color: #07baef !important;
        border: 1px solid #e8ebf3;
    }

    .shadow-1,
    .popover,
    .card {
        box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2), 0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0,
                0.12);
    }

    .border-start {
        border-right: 1px solid #e0e0e0 !important;
        border-top: 1px solid #e0e0e0 !important;
        border-bottom: 1px solid #e0e0e0 !important;
    }

    /* Title */
    .heading-1 {
        font-family: 'Roboto Slab', serif;
        font-size: 1.5em;
        letter-spacing: 0.08em;
        font-weight: bold;
        color: #F60;
        text-shadow: 0 1px 1px #FFFFFF;
        text-transform: uppercase;
    }

    .divider-1 {
        border-bottom: 1px solid #FFF;
        background-color: #DADADA;
        height: 2px;
        margin: 0.5em 0px 1.5em;
    }

    .divider-1 span {
        display: block;
        width: 150px;
        height: 1px;
        background-color: #F60;
    }

    .heading-2 {
        font-family: 'Roboto Slab', serif;
        font-size: 1.5em;
        letter-spacing: 0.08em;
        font-weight: bold;
        color: #1589FF;
        text-shadow: 0 1px 1px #FFFFFF;
        text-transform: uppercase;
    }

    .divider-2 {
        border-bottom: 1px solid #FFF;
        background-color: #DADADA;
        height: 2px;
        margin: 0.5em 0px 1.5em;
    }

    .divider-2 span {
        display: block;
        width: 150px;
        height: 1px;
        background-color: #1589FF;
    }

    .font-20 {
        font-size: 23px !important;
    }

    .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
        padding-left: 0px !important;
        top: 0px !important;
        padding: 10px;
    }

    @media only screen and (max-width: 600px) {
        .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
            padding: 0px !important;
            padding-left: 225px !important;
        }
    }
</style>
@endpush

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Status</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Status</li>
        </ol>
        @if ($setting->isCooker == 1)
        <h1 class="heading-2">Cooker Bill</h1>
        <div class="divider-2"> <span></span></div>
        <div class="row">
            <div class="col-xl-3">
                <div class="card border-start border-primary border-4">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center mb-2">
                            <div class="col">
                                <p class="text-primary mb-0 fw-bold">Fund Collected</p>
                                <h3 class="my-1 font-20 fw-bold">৳ {{ $total['cooker']['collected'] }}</h3>
                            </div>
                            <!--end col-->
                            <div class="col-auto align-self-center">
                                <img src="{{ asset('assets/icon/1.png') }}" class="thumb-lg" width="50px">
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <div class="col-xl-3">
                <div class="card border-start border-info border-4">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center mb-2">
                            <div class="col">
                                <p class="text-info mb-0 fw-bold">Given Cooker</p>
                                <h3 class="my-1 font-20 fw-bold">৳ {{ $total['cooker']['given'] }}</h3>
                            </div>
                            <!--end col-->
                            <div class="col-auto align-self-center">
                                <img src="{{ asset('assets/icon/2.png') }}" class="thumb-lg" width="50px">
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <div class="col-xl-3">
                <div class="card border-start border-success border-4">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center mb-2">
                            <div class="col">
                                <p class="text-success mb-0 fw-bold">Available Fund</p>
                                <h3 class="my-1 font-20 fw-bold">৳ {{ $total['cooker']['available'] }}</h3>
                            </div>
                            <!--end col-->
                            <div class="col-auto align-self-center">
                                <img src="{{ asset('assets/icon/3.png') }}" class="thumb-lg" width="50px">
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <div class="col-xl-3">
                <div class="card border-start border-danger border-4">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center mb-2">
                            <div class="col">
                                <p class="text-danger mb-0 fw-bold">Due Fund</p>
                                <h3 class="my-1 font-20 fw-bold">৳ {{ $total['cooker']['due'] }}</h3>
                            </div>
                            <!--end col-->
                            <div class="col-auto align-self-center">
                                <img src="{{ asset('assets/icon/4.png') }}" class="thumb-lg" width="50px">
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>

        </div>
        @endif
        @if ($setting->isUtility == 1)
        <h1 class="heading-1">Utility Bill</h1>
        <div class="divider-1"> <span></span></div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card border-start border-info border-4">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center mb-2">
                            <div class="col">
                                <p class="text-info mb-0 fw-bold">Fund Collected</p>
                                <h3 class="my-1 font-20 fw-bold">৳ {{ $total['utility']['collected'] }}</h3>
                            </div>
                            <!--end col-->
                            <div class="col-auto align-self-center">
                                <img src="{{ asset('assets/icon/1.png') }}" class="thumb-lg" width="50px">
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <div class="col-xl-4">
                <div class="card border-start border-warning border-4">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center mb-2">
                            <div class="col">
                                <p class="text-warning mb-0 fw-bold">Total Collections</p>
                                <h3 class="my-1 font-20 fw-bold">৳ {{ $total['utility']['total'] }}</h3>
                            </div>
                            <!--end col-->
                            <div class="col-auto align-self-center">
                                <img src="{{ asset('assets/icon/3.png') }}" class="thumb-lg" width="50px">
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <div class="col-xl-4">
                <div class="card border-start border-danger border-4">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center mb-2">
                            <div class="col">
                                <p class="text-danger mb-0 fw-bold">Due Fund</p>
                                <h3 class="my-1 font-20 fw-bold">৳ {{ $total['utility']['due'] }}</h3>
                            </div>
                            <!--end col-->
                            <div class="col-auto align-self-center">
                                <img src="{{ asset('assets/icon/4.png') }}" class="thumb-lg" width="50px">
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>

        </div>
        @endif
        <div class="row">
            @if ($setting->isCooker == 1)
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Due List For Cooker Bill
                    </div>
                    <div class="card-body">
                        <table id="example" class="table table-sm table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Room No</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Room No</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($cookerDue as $value)
                                <tr>
                                    <td>{{ $value->room_no }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $singleBill['cook'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Pay Cooker Bill List
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-sm table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($payBills as $value)
                                <tr>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->amount }}</td>
                                    <td>{{ $value->date }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            @if ($setting->isUtility == 1)
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Due List For Utility Bill
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-sm table-striped table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th>Room No</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Room No</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($utilityDue as $value)
                                <tr>
                                    <td>{{ $value->room_no }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $singleBill['utility'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('js')
<script>
    $(document).ready(function () {
            $('#example').DataTable();
            $('#example1').DataTable();
            $('#example2').DataTable();
        });
</script>
@endpush