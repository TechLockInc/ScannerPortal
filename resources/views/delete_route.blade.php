@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <h1>Delete an appliance</h1>
            This action will also delete all routes associated with this appliance!
            <h1></h1>
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
            <form action="/delete_appliance" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <label for="client_code">Client Code</label>
                    <input type="text" class="form-control" id="client_code" name="client_code" style="text-transform:uppercase;" placeholder="Client Code" value="{{ old('client_code') }}">
                </div>
                <button type="submit" class="btn btn-default">Delete</button>
            </form>
        </div>
    </div>
@endsection