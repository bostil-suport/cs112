@extends('layouts.app')

@section('content')
    <h2>Please, add your password. Later you can login another way, uses email and password.</h2>

    @if (Session::has('confirm_pass'))

        <div class="alert alert-danger">
            <strong>Warning!</strong>
            {{ Session::get('confirm_pass') }}
        </div>

    @endif


    <form method="POST" action="{{ url('addpass') }}">
    @csrf

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    Add pass
                </button>
            </div>
        </div>
    </form>


    @endsection