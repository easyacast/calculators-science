{{-- Google AdSense Ad Unit - Only renders when configured --}}
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
@endif
