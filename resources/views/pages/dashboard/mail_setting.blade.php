@extends('layouts.sideNav')

@section('content')
<!-- resources/views/pages/dashboard/mail_setting.blade.php -->
<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Mail Env Settings</h6>
            <form class="forms-sample" action="{{ url('mail-settings') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Mail Host</label>
                    <input type="text" name="MAIL_HOST" class="form-control" autocomplete="off" value="{{ env('MAIL_HOST') }}">
                </div>
                <div class="form-group">
                    <label>Mail Port</label>
                    <input type="number" name="MAIL_PORT" class="form-control" value="{{ env('MAIL_PORT') }}">
                </div>
                <div class="form-group">
                    <label>Mail Username</label>
                    <input type="text" name="MAIL_USERNAME" class="form-control" value="{{ env('MAIL_USERNAME') }}">
                </div>
                <div class="form-group">
                    <label>Mail Password</label>
                    <input type="password" name="MAIL_PASSWORD" class="form-control" value="{{ env('MAIL_PASSWORD') }}">
                </div>
                <div class="form-group">
                    <label>Mail Encryption</label>
                    <input type="text" name="MAIL_ENCRYPTION" class="form-control" value="{{ env('MAIL_ENCRYPTION') }}">
                </div>
                <div class="form-group">
                    <label>Mail From Address</label>
                    <input type="text" name="MAIL_FROM_ADDRESS" class="form-control" value="{{ env('MAIL_FROM_ADDRESS') }}">
                </div>

                <div class="form-check form-check-flat form-check-primary">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input">
                        Remember me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="reset" class="btn btn-light">Cancel</button>
            </form>
        </div>
    </div>
</div>

@endsection 
@section('footer_script') 
@endsection
