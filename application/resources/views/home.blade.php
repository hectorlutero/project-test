<x-guest-layout>

    @push('styles')
        <style>
            body {
                background-color: #f0f0f0;
            }
        </style>
    @endpush
    <x-home.hero />
    <x-home.highlights />
    <x-home.banner />
    <x-home.categories />
    <x-product-grid />

    <x-footer />
    {{-- <x-sidebar :teste="1"></x-sidebar> --}}

</x-guest-layout>
