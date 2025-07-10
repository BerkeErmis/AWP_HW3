@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">{{ __('projects.edit') }}</h1>
    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')
        @php $isManager = auth()->user()->id === $project->manager_id; @endphp
        <div class="mb-4">
            <label class="block font-semibold">{{ __('projects.project_name') }}</label>
            <input type="text" name="name" class="border rounded w-full p-2" value="{{ old('name', $project->name) }}" {{ $isManager ? '' : 'readonly' }}>
            @error('name') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block font-semibold">{{ __('projects.description') }}</label>
            <textarea name="description" class="border rounded w-full p-2" {{ $isManager ? '' : 'readonly' }}>{{ old('description', $project->description) }}</textarea>
            @error('description') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block font-semibold">{{ __('projects.price') }}</label>
            <input type="number" step="0.01" name="price" class="border rounded w-full p-2" value="{{ old('price', $project->price) }}" {{ $isManager ? '' : 'readonly' }}>
            @error('price') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block font-semibold">{{ __('projects.done_jobs') }}</label>
            <textarea name="done_jobs" class="border rounded w-full p-2">{{ old('done_jobs', $project->done_jobs) }}</textarea>
            @error('done_jobs') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block font-semibold">{{ __('projects.start_date') }}</label>
            <input type="date" name="start_date" class="border rounded w-full p-2" value="{{ old('start_date', $project->start_date) }}" {{ $isManager ? '' : 'readonly' }}>
            @error('start_date') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>
        <div class="mb-4">
            <label class="block font-semibold">{{ __('projects.end_date') }}</label>
            <input type="date" name="end_date" class="border rounded w-full p-2" value="{{ old('end_date', $project->end_date) }}" {{ $isManager ? '' : 'readonly' }}>
            @error('end_date') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>
        @if($isManager)
        <div class="mb-4">
            <label class="block font-semibold">{{ __('projects.members') }} ({{ __('projects.actions') }})</label>
            <select name="members[]" multiple class="border rounded w-full p-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $project->members->contains($user->id) ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
            @error('members') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>
        @endif
        <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white px-5 py-2 rounded font-semibold shadow transition">{{ __('projects.save') }}</button>
        <a href="{{ route('projects.index') }}" class="ml-2 text-gray-600">{{ __('projects.cancel') }}</a>
    </form>
</div>
@endsection 