@props([
    'currentPrice',
])

<div class="w-fit bg-white border border-black rounded-xl m-4 p-4 flex flex-col gap-3">
    <div class="flex items-center gap-2">
        <h1 class="text-xl font-bold">Gas</h1>
        <span class="inline-block w-3 h-3 bg-green-500 rounded-full"
              style="animation: pulse-green 2s infinite;">
        </span>
    </div>


    @if(!$currentPrice)
        <div class="flex flex-col gap-1 pt-2 px-2">
            Er is nog geen informatie beschikbaar. Check later terug voor de huidige prijzen.
        </div>
    @else
        <div class="flex flex-col gap-1 pt-2 px-2">
            <div>Huidige prijs: €{{ $currentPrice->market_price }}</div>
            <div>Start: {{$currentPrice->start_date}}</div>
            <div>Eind: {{$currentPrice->end_date}}</div>
        </div>
    @endif
</div>
