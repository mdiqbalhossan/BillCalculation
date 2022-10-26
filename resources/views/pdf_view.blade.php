<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $data['month'] }} - {{ $data['type'] }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" />
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;700&display=swap" rel="stylesheet"> -->
    <style>
        @page {
            margin: 0px;
        }

        * {
            padding: 0;
            margin: 0px;
        }

        body {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        @font-face {
            font-family: font-family: "Roboto Slab", serif;
            src: local("Roboto Slab"), url("https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;700&display=swap") format("truetype");
            font-weight: normal;
            font-style: normal;

        }

        body {
            font-family: "Roboto Slab", serif;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="text-success font-weight-bold text-center">Amanullah House</h2>
        </div>
        <div class="row justify-content-center">
            <p class="text-center">46/6, B, Jhigatola, Dhanmondi,</p>
            <p class="text-center">Dhaka-1209</p>
        </div>
        <hr />
        <div class="row justify-content-between px-5 text-danger">
            <span class="text-left">Type: {{ $data['type'] }} Bill</span>
            <span class="text-right float-right">Month: {{ $data['month'] }}</span>
        </div>
        <hr />
        {{-- Bill Summary --}}
        <table class="table table-primary table-bordered border-primary table-sm">
            <thead class="bg-danger text-white">
                <tr class="">
                    <th colspan="5" class="text-center">Bill Summary</th>
                </tr>
                <tr class="text-center">
                    <th scope="col">SI</th>
                    <th scope="col">Total Member</th>
                    <th scope="col">Total Collection</th>
                    <th scope="col">Collected Fund</th>
                    <th scope="col">Due Fund</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <th scope="row">1</th>
                    <td>{{ $data['member'] }}</td>
                    <td>{{ $data['total_collection'] }}</td>
                    <td>{{ $data['collected_fund'] }}</td>
                    <td>{{ $data['due_fund'] }}</td>
                </tr>
            </tbody>
        </table>
        {{-- Bill Summary --}}
        @if ($data['type'] == 'Cooker')
        <hr />
        {{-- Pay Cooker Bill List --}}
        <table class="table table-primary table-bordered border-primary table-sm">
            <thead class="bg-success text-white">
                <tr class="">
                    <th colspan="4" class="text-center">
                        Pay Cooker Bill List
                    </th>
                </tr>
                <tr class="text-center">
                    <th scope="col">SI</th>
                    <th scope="col">Name</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @if ($extra['givenCooker'] != null)
                @foreach($extra['givenCooker'] as $key => $value)
                <tr class="text-center">
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->amount }}</td>
                    <td>{{ $value->date }}</td>
                </tr>
                @endforeach
                @else
                <h4 class="text-danger">No Data Avaialable Here!!</h4>
                @endif
            </tbody>
        </table>
        {{-- Pay Cooker Bill List --}}
        @endif
        @if ($data['type'] =='Utility')
        {{-- Adjust Member --}}
        <table class="table table-primary table-bordered border-primary table-sm">
            <thead class="bg-success text-white">
                <tr class="">
                    <th colspan="4" class="text-center">Adjust Member</th>
                </tr>
                <tr class="text-center">
                    <th scope="col">SI</th>
                    <th scope="col">Room No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if ($extra['adjustMember'] != null)
                @foreach($extra['adjustMember'] as $key => $value)
                <tr class="text-center">
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $value->room_no }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ Helper::singleAmount('utility') }}</td>
                </tr>
                @endforeach
                @else
                <h4 class="text-danger">No Data Avaialable Here!!</h4>
                @endif
            </tbody>
        </table>
        {{-- Adjust Member --}}
        @endif

        {{-- Due Member List --}}
        <table class="table table-primary table-bordered border-primary table-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th colspan="4" class="text-center">Due Member List</th>
                </tr>
                <tr class="text-center">
                    <th scope="col">SI</th>
                    <th scope="col">Room No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($due_member as $key => $value)
                <tr class="text-center">
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $value->room_no }}</td>
                    <td>{{ $value->name }}</td>
                    <td>
                        {{ Helper::singleAmount(Str::lower($data['type'])) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Due Member List --}}
        {{-- Paid Member List --}}
        <table class="table table-primary table-bordered border-primary table-sm">
            <thead class="thead-dark">
                <tr class="table-danger">
                    <th colspan="5" class="text-center">Paid Member</th>
                </tr>
                <tr class="text-center">
                    <th scope="col">SI</th>
                    <th scope="col">Room No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($paid_member as $key => $value)
                <tr class="text-center">
                    <th scope="row">{{ $key+1 }}</th>
                    <td>{{ $value->member->room_no }}</td>
                    <td>{{ $value->member->name }}</td>
                    <td>{{ $value->amount }}</td>
                    <td>{{ $value->date }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Paid Member List --}}
        <hr>
        <div class="row justify-content-between mx-3 mb-3">
            <strong style="font-size: 15px;">PDF File Automatically Generated By
                Software.</strong>
            <strong class="float-right" style="font-size: 15px;">Software Made By
                <a href="https://facebook.com/iqbaljmrabbi">Md Iqbal Hossan.</a></strong>
        </div>
        <div class="mx-3" style="font-size: 15px;">Generated On : {{ date('Y-m-d H:i:s') }}</div>
    </div>
</body>

</html>