@extends('layouts.auth')

@section('contents')
    <form action="{{ route('register') }}" autocomplete="off" method="POST">
        <x-ack />
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Name') }}</label>
            <x-text-input :value="old('name')" autocomplete="email" autofocus class="form-control" id="email" name="name" required type="text" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }}</label>
            <x-text-input :value="old('email')" autocomplete="email" autofocus class="form-control" id="email" name="email" required type="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="mb-2">
            <label class="form-label" for="password">
                {{ __('Mot de passe') }}
            </label>
            <div class="input-group input-group-flat">
                <x-text-input  class="form-control" id="password" name="password" required type="password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>
        <div class="form-footer">
            @csrf
            <button class="btn btn-primary w-100" type="submit">{{ __('Se connecter') }}</button>
        </div>
    </form>
@endsection
