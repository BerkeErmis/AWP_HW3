@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="flex items-center justify-between mb-6 mt-4">
        <h1 class="text-3xl font-bold">{{ __('projects.my_projects') }}</h1>
        <a href="{{ route('projects.create') }}" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded shadow font-semibold transition">+ {{ __('projects.add_new') }}</a>
    </div>

    <div class="mb-10">
        <h2 class="text-xl font-semibold mb-3 border-b pb-1">{{ __('projects.manager_projects') }}</h2>
        @if($managedProjects->count())
            <div class="grid gap-4">
                @foreach($managedProjects as $project)
                    <div class="bg-white border rounded-lg shadow p-5 flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <div class="text-lg font-bold">{{ $project->name }}</div>
                            <div class="text-sm text-gray-500 mb-1">{{ __('projects.start') }}: {{ $project->start_date }} | {{ __('projects.end') }}: {{ $project->end_date }}</div>
                        </div>
                        <div class="flex gap-3 mt-3 md:mt-0">
                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">{{ __('projects.details') }}</a>
                            <a href="{{ route('projects.edit', $project) }}" class="text-yellow-600 hover:underline">{{ __('projects.edit') }}</a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Silmek istediğine emin misin?')">{{ __('projects.delete') }}</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">{{ __('projects.no_projects') }}</p>
        @endif
    </div>

    <div>
        <h2 class="text-xl font-semibold mb-3 border-b pb-1">{{ __('projects.member_projects') }}</h2>
        @if($memberProjects->count())
            <div class="grid gap-4">
                @foreach($memberProjects as $project)
                    <div class="bg-white border rounded-lg shadow p-5 flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <div class="text-lg font-bold">{{ $project->name }}</div>
                            <div class="text-sm text-gray-500 mb-1">{{ __('projects.start') }}: {{ $project->start_date }} | {{ __('projects.end') }}: {{ $project->end_date }}</div>
                        </div>
                        <div class="flex gap-3 mt-3 md:mt-0">
                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">{{ __('projects.details') }}</a>
                            @if(Auth::user()->id === $project->manager_id)
                                <a href="{{ route('projects.edit', $project) }}" class="text-yellow-600 hover:underline">{{ __('projects.edit') }}</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">{{ __('projects.no_member_projects') }}</p>
        @endif
    </div>
</div>
@endsection 