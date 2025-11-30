@props([
    'currentPrice',
    'cheapestPrice',
    'mostExpensivePrice',
    'mostSustainable'
])

<div class="w-fit bg-white border border-black rounded-xl m-4 p-4 flex flex-col gap-3">
    <div class="flex items-center gap-2">
        <h1 class="text-xl font-bold">Stroom</h1>
        <span class="inline-block w-3 h-3 bg-green-500 rounded-full"
              style="animation: pulse-green 2s infinite;">
        </span>

        <a href="{{ route('history') }}" class="ml-auto">
            <button class="cursor-pointer hover:bg-green-700 bg-[#00AA66] text-white px-2 py-1 rounded-xl">
                Historie inzien
            </button>
        </a>
    </div>

    @if(!$currentPrice || !$cheapestPrice || !$mostExpensivePrice || !$mostSustainable)
        <div class="flex flex-col gap-1 pt-2 px-2">
            Er is nog geen informatie beschikbaar. Check later terug voor de huidige prijzen.
        </div>
    @else
        <div class="flex flex-col gap-1 pt-2 px-2">
            <div>Huidige prijs: €{{ $currentPrice->market_price }}</div>
            <div>Duurzaamheidscore: {{$currentPrice->sustainability_score}}</div>
            <div>Start: {{$currentPrice->start_date}}</div>
            <div>Eind: {{$currentPrice->end_date}}</div>
        </div>

        <div class="flex flex-col gap-1 border-t border-gray-400 pt-2 px-2">
            <div>Goedkoopste opkomende prijs: €{{$cheapestPrice->market_price}}</div>
            <div>Duurzaamheidscore: {{$cheapestPrice->sustainability_score}}</div>
            <div>Start: {{$cheapestPrice->start_date}}</div>
            <div>Eind: {{$cheapestPrice->end_date}}</div>
        </div>

        <div class="flex flex-col gap-1 border-t border-gray-400 pt-2 px-2">
            <div>Duurste opkomende prijs: €{{$mostExpensivePrice->market_price}}</div>
            <div>Duurzaamheidscore: {{$mostExpensivePrice->sustainability_score}}</div>
            <div>Start: {{$mostExpensivePrice->start_date}}</div>
            <div>Eind: {{$mostExpensivePrice->end_date}}</div>
        </div>

        <div class="flex flex-col gap-1 border-t border-gray-400 pt-2 px-2">
            <div>Meest duurzame opkomende prijs: €{{$mostSustainable->market_price}}</div>
            <div>Duurzaamheidscore: {{$mostSustainable->sustainability_score}}</div>
            <div>Start: {{$mostSustainable->start_date}}</div>
            <div>Eind: {{$mostSustainable->end_date}}</div>
        </div>
    @endif
</div>
