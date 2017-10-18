@extends('layouts.app')
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 50%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
@section('content')
    <div class="container">
        <div class="row">
            <h1>{{$client_code}}</h1>
            <?php $appliance = \App\Appliance::where('client_code', $client_code)->first(); ?>
            <h3>Client name: {{$appliance->client_name}}</h3>
            <h3>Tunnel IP  : {{$appliance->tunnel}}</h3>
            <h3>External IP: {{$appliance->external}}</h3>
            <h3>Subnets:</h3>
            @if (Session::has('success'))
                <div class="alert alert-success">{!! Session::get('success') !!}</div>
            @endif
            @if (Session::has('failure'))
                <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
            @endif
            <h3></h3>
            <?php $allRoutes = \App\Route::where('gateway', $appliance->id)->get() ?>
            @if ($allRoutes->first() == NULL)
                There is not any subnet associated with this appliance.
            @else
                <table>
                    <tr>
                        <th>Network Address</th>
                        <th>Subnet Mask</th>
                    </tr>
                    @foreach($allRoutes as $route)
                        <tr>
                            <th>{{$route->subnet}}</th>
                            <th>{{$route->mask}}</th>
                        </tr>
                    @endforeach
                </table>
            @endif
            <h3></h3><h3></h3>
            <h4>Add a subnet</h4>
            @if(count($errors))
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <br/>
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="/view_appliance" method="post">
                {!! csrf_field() !!}
                <div class="body">    
                    <div class="wrapper">
                        <span class="inline">
                            <input class="inputbold" type="text" id="network_address" name="network_address" placeholder="xxx.xxx.xxx.xxx" style="width: 120px;" value="{{ old('network_address') }}"/>/
                            <input class="inputbold" type="text" id="subnet_mask"  name="subnet_mask" placeholder="xx" style="width: 35px;" value="{{ old('subnet_mask') }}"/>
                            <input class="inputbold" type="hidden" id="client_code"  name="client_code" value="{{$appliance->client_code}}"/>
                            <button type="submit" class="inputbold">Add</button>
                        </span>
                   </div>
                </div>
            </form>
        </div>
    </div>
@endsection