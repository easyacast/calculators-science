{{-- Google AdSense Ad Unit Placeholder --}}
@php
$slot = $slot ?? '';
$format = $format ?? 'auto';
$responsive = $responsive ?? true;
$adClass = $adClass ?? '';
@endphp

@if(config('site.ads.show_ads') && config('site.ads.adsense_client_id'))
<div class="ad-container my-6 {{ $adClass }}">
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="{{ config('site.ads.adsense_client_id') }}"
         @if($slot) data-ad-slot="{{ $slot }}" @endif
         data-ad-format="{{ $format }}"
         @if($responsive) data-full-width-responsive="true" @endif
    ></ins>
    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
</div>
@else
{{-- Placeholder shown during development --}}
<div class="ad-container my-6 bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center text-gray-400 text-xs {{ $adClass }}">
    Ad Space (configure ADSENSE_CLIENT_ID in .env)
</div>
@endif
