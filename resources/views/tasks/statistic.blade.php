<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistic') }}
        </h2>
    </x-slot>

    <div class="flex-1 flex flex-col" id="statistic">
        <statistic></statistic>
    </div>
</x-app-layout>
