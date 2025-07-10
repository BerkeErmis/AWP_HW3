@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Profil Bilgileri</h2>
    <div class="mb-8 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        @include('profile.partials.update-profile-information-form')
    </div>
    <div class="mb-8 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        @include('profile.partials.update-password-form')
    </div>
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
