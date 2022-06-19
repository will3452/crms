@extends('nova::auth.layout')

@section('content')

{{-- @include('nova::auth.partials.header') --}}

<form
    class="bg-white shadow p-8 max-w-login mx-auto"
    method="POST"
    action="{{ route('nova.login') }}"
>
    {{ csrf_field() }}

    @if ($errors->any())
    <p class="text-center font-semibold text-danger my-3">
        @if ($errors->has('email'))
            {{ $errors->first('email') }}
        @else
            {{ $errors->first('password') }}
        @endif
        </p>
    @endif
    <div class="text-center font-bold text-2xl">
        Login as Doctor
    </div>
    <img src="/login.svg" alt="" class="img-fluid mt-4">
    <div class="mb-6 {{ $errors->has('email') ? ' has-error' : '' }}">
        <label class="block font-bold mb-2" for="email">{{ __('Email Address') }}</label>
        <input class="form-control form-input form-input-bordered w-full" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    </div>

    <div class="mb-6 {{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="block font-bold mb-2" for="password">{{ __('Password') }}</label>
        <input class="form-control form-input form-input-bordered w-full" id="password" type="password" name="password" required>
    </div>

    <button class="w-full p-2 btn-primary hover:bg-primary-dark" type="submit">
        {{ __('Login') }}
    </button>
</form>
@endsection
