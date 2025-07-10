@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4">
    <h1 class="text-2xl font-bold mb-4">{{ __('projects.details') }}</h1>
    <div class="border rounded p-4 mb-4">
        <p><strong>{{ __('projects.project_name') }}:</strong> {{ $project->name }}</p>
        <p><strong>{{ __('projects.description') }}:</strong> {{ $project->description }}</p>
        <p><strong>{{ __('projects.price') }}:</strong> {{ $project->price }}</p>
        <p><strong>{{ __('projects.done_jobs') }}:</strong> {{ $project->done_jobs }}</p>
        <p><strong>{{ __('projects.start_date') }}:</strong> {{ $project->start_date }}</p>
        <p><strong>{{ __('projects.end_date') }}:</strong> {{ $project->end_date }}</p>
        <p><strong>{{ __('projects.manager') }}:</strong> {{ $project->manager->name }} ({{ $project->manager->email }})</p>
        <p><strong>{{ __('projects.members') }}:</strong>
            @if($project->members->count())
                <ul class="list-disc ml-6">
                    @foreach($project->members as $member)
                        <li>{{ $member->name }} ({{ $member->email }})</li>
                    @endforeach
                </ul>
            @else
                {{ __('projects.no_member_projects') }}
            @endif
        </p>
    </div>
    @php $user = auth()->user(); @endphp
    @if($user && ($user->id === $project->manager_id || $project->members->contains($user)))
        <a href="{{ route('projects.edit', $project) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded font-semibold shadow transition">{{ __('projects.edit') }}</a>
    @endif
    <a href="{{ route('projects.index') }}" class="ml-2 text-gray-600">{{ __('projects.cancel') }}</a>
</div>
@endsection 