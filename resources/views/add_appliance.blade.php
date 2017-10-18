@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <h1>Add an appliance</h1>
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
            <form action="/add_appliance" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="client_code">Client Code</label>
                    <input type="text" class="form-control" id="client_code" name="client_code" style="text-transform:uppercase;" placeholder="Client Code" value="{{ old('client_code') }}">
                </div>
                <div class="form-group">
                    <label for="client_name">Client Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Client Name" value="{{ old('client_name') }}">
                </div>
                <div class="form-group">
                    <label for="tunnel">Tunnel IP</label>
                    <input type="text" class="form-control" id="tunnel" name="tunnel" placeholder="xxx.xxx.xxx.xxx" value="{{ old('tunnel') }}">
                </div>
                <div class="form-group">
                    <label for="external">External IP</label>
                    <input type="text" class="form-control" id="external" name="external" placeholder="xxx.xxx.xxx.xxx" value="{{ old('external') }}">
                </div>
                <button type="submit" class="btn btn-default">Add</button>
            </form>
        </div>
    </div>
@endsection