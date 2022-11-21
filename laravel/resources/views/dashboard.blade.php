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
    <ul>
        <li><a href="{{ url('/post') }}"><i class="fa-solid fa-house fa-3x"></a></i></li>
        <li><i class="fa-solid fa-heart fa-3x"></i></li>
        <li><i class="fa-solid fa-square-plus fa-3x"></i></li>
        <li><a href="{{ url('/places') }}"><i class="fa-solid fa-location-dot fa-3x"></i></a></li>
        <li><i class="fa-solid fa-circle-user fa-3x"></i></li>
    </ul>
    @endsection

</x-app-layout>
