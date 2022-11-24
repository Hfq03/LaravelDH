<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>
            </div>
        </div>
    </div>
    @section('content')
    <div class="flex-container">
        <div><a href="{{ url('/post') }}"><i class="fa-solid fa-house fa-3x"></a></i></div>
        <div><i class="fa-solid fa-heart fa-3x"></i></div>
        <div><i class="fa-solid fa-square-plus fa-3x"></i></div>
        <div><a href="{{ url('/places') }}"><i class="fa-solid fa-location-dot fa-3x"></i></a></div>
        <div><i class="fa-solid fa-circle-user fa-3x"></i></div>
        <div><a href="{{ url('/files') }}" class="btn btn-primary">Files</a></div>
    </div>
    @endsection

</x-app-layout>
