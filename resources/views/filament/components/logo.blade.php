@props(['logo' => null])

@if($logo)
    {{ $logo }}
@else
    <x-filament::icon-button icon="heroicon-o-shopping-cart" class="h-10" />
@endif
