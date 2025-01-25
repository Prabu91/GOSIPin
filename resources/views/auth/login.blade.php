@extends('layouts.guest')

@section('title', 'Login')

@section('content')
	<div class="login-background min-h-screen bg-white flex items-center justify-center">
		<div class="login-overlay absolute inset-0 bg-sidebar bg-opacity-20"></div>
		<div class="relative z-10 flex justify-center items-center w-full px-4">
			<div class="hero-static w-full max-w-md bg-white rounded-lg shadow-lg p-6 border-4 border-sidebar">
				<!-- Header -->
				<div class="text-center my-6">
					<a href="{{ route('login') }}">
						<img src="{{ asset('images/logo-dark.png') }}" alt="Logo" class="mx-auto mb-10 w-60">
					</a>
				</div>
				<!-- Form -->
				<form method="POST" action="{{ route('login.process') }}" class="space-y-4">
					@csrf
					<div>
						<label for="npp" class="block text-sm font-medium text-txtl">
							Username <span class="text-red-500">*</span>
						</label>
						<input type="text" id="npp" name="npp" placeholder="NPP"
							class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring-blue-500 {{ $errors->has('npp') ? 'border-red-500' : '' }}">
						<x-input-error :messages="$errors->get('npp')" class="mt-1 text-red-500 text-sm" />
					</div>
					<div>
						<label for="val-password" class="block text-sm font-medium text-txtl">
							Password <span class="text-red-500">*</span>
						</label>
						<input type="password" id="val-password" name="password" placeholder="Masukan password"
							class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 focus:border-blue-500 focus:ring-blue-500 {{ $errors->has('password') ? 'border-red-500' : '' }}">
						<x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500 text-sm" />
					</div>
					<div class="flex justify-center">
						<button type="submit"
							class="w-full text-white bg-btn hover:bg-btnh focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
							LOGIN
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
