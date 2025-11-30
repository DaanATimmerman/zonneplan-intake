<div>
    <div class="w-2/3 m-auto mt-16 rounded-xl border border-black p-4 ">
        <div class="flex">
            <div class="mb-4">
                <label for="selectedDate" class="block mb-2 font-semibold">Selecteer een datum:</label>
                <input
                    type="date"
                    id="selectedDate"
                    wire:model.live="selectedDate"
                    min="{{ $minSelectDate }}"
                    max="{{ $maxSelectDate }}"
                    class="border rounded px-3 py-2"
                >
            </div>

            <a href="{{ route('main') }}" class="ml-auto">
                <button class="cursor-pointer hover:bg-green-700 bg-[#00AA66] text-white px-3 py-2 rounded-xl">
                    Terug naar het overzicht
                </button>
            </a>
        </div>

        <div wire:ignore>
            <canvas height="400" id="priceChart"></canvas>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let ctx = document.getElementById('priceChart').getContext('2d');

            let priceChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Stroomprijs (€/kWh)',
                        data: @json($data),
                        backgroundColor: 'rgb(0, 170, 101, 0.2)',
                        borderColor: 'rgb(0, 170, 101)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let v = context.raw;
                                    return v.toFixed(6) + ' €/kWh'; // 6 decimals
                                }
                            }
                        }
                    }
                }
            });

            // update chart with new labels/data
            Livewire.on('updateChart', payload => {
                console.log(payload)
                priceChart.data.labels = payload.labels;
                priceChart.data.datasets[0].data = payload.data;
                priceChart.update();
            });
        </script>
    @endpush
</div>
