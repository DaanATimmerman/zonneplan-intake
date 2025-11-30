<?php

namespace App\Livewire;

use App\Models\ElectricityPrice;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;

class ElectricityPriceHistory extends Component
{
    public string $selectedDate;

    public string $minSelectDate;

    public string $maxSelectDate;

    /** @var array<int, string> */
    public array $labels = [];

    /** @var array<int, float> */
    public array $data = [];

    public function mount(): void
    {
        $this->minSelectDate = Carbon::parse(ElectricityPrice::whereNotNull('market_price')->min('start_date'))->format('Y-m-d');
        $this->maxSelectDate = Carbon::parse(ElectricityPrice::whereNotNull('market_price')->max('end_date'))->format('Y-m-d');
        $this->selectedDate = $this->maxSelectDate;

        $this->loadData();
    }

    public function updatedSelectedDate(): void
    {
        $this->loadData();
    }

    protected function loadData(): void
    {
        $start = $this->selectedDate.' 00:00:00';
        $end = $this->selectedDate.' 23:59:59';

        $prices = ElectricityPrice::whereBetween('start_date', [$start, $end])
            ->whereNotNull('market_price')
            ->orderBy('start_date')
            ->get(['start_date', 'market_price']);

        $this->labels = $prices->map(fn ($p) => Carbon::parse($p->start_date)->format('H:i:s'))->toArray();
        $this->data = $prices->pluck('market_price')->toArray();

        $this->dispatch('updateChart',
            labels: array_values($this->labels),
            data: array_values($this->data)
        );
    }

    public function render(): View
    {
        return view('livewire.electricity-price-history');
    }
}
