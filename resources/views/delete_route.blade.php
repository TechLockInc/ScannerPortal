@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <h1>Delete a subnet</h1>
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
            <form action="/delete_route" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="client_code">Client Code</label>
                    <input type="text" class="form-control" id="client_code" name="client_code" style="text-transform:uppercase;" placeholder="Client Code" value="{{ old('client_code') }}">
                </div>
                <div class="form-group">
                    <label for="client_name">Network Address/Mask</label>
                </div><div>
                    <input class="inputbold" type="text" id="network_address" name="network_address" placeholder="xxx.xxx.xxx.xxx" style="width: 120px;" value="{{ old('network_address') }}"/>/
                            <input class="inputbold" type="text" id="subnet_mask"  name="subnet_mask" placeholder="xx" style="width: 35px;" value="{{ old('subnet_mask') }}"/>
                </div>
                <h3></h3>
                <button type="submit" class="btn btn-default">Delete</button>
            </form>
        </div>
    </div>
@endsection