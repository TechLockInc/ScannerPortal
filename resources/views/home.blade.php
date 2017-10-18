@extends('layouts.app')
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
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
<div class="container" style="width: 100%">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>All Appliances</h2></div>
                @if (Session::has('success'))
                    <div class="alert alert-success">{!! Session::get('success') !!}</div>
                @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{!! Session::get('failure') !!}</div>
                @endif
                <div class="panel-body">
                    <?php $allAppliances = \App\Appliance::all(); ?>
                    @if ($allAppliances->first() == NULL)
                        There is not any appliance stored in the database!
                    @else
                        <table>
                            <tr>
                                <th>Client Code</th>
                                <th>Client Name</th>
                                <th>Tunel IP</th>
                                <th>External IP</th>
                            </tr>
                            @foreach($allAppliances as $appliance)
                                <tr>
                                    <th><a href="{{ url('/view_appliance/'.$appliance->client_code) }}">{{$appliance->client_code}}</th>
                                    <th>{{$appliance->client_name}}</th>
                                    <th>{{$appliance->tunnel}}</th>
                                    <th>{{$appliance->external}}</th>
                                </tr>
                            @endforeach
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
