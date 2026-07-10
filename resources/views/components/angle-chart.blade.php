@php
    $chartId = $id ?? 'angle-chart-' . uniqid();
@endphp

<div class="bg-white rounded-xl shadow-lg p-8">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Grafik Sudut Lutut</h2>
    @if(!empty($angles))
        <canvas id="{{ $chartId }}" style="width: 100%; height: 220px;"></canvas>
        <script>
            (function () {
                const angles = @json($angles);
                const canvas = document.getElementById('{{ $chartId }}');
                const ctx = canvas.getContext('2d');

                function draw() {
                    const dpr = window.devicePixelRatio || 1;
                    const width = canvas.clientWidth;
                    const height = canvas.clientHeight || 220;
                    canvas.width = width * dpr;
                    canvas.height = height * dpr;
                    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
                    ctx.clearRect(0, 0, width, height);

                    if (!angles.length) {
                        return;
                    }

                    const padding = 32;
                    const min = Math.min(...angles);
                    const max = Math.max(...angles);
                    const range = (max - min) || 1;

                    const toX = (i) => padding + (i / (angles.length - 1 || 1)) * (width - padding * 2);
                    const toY = (v) => height - padding - ((v - min) / range) * (height - padding * 2);

                    ctx.strokeStyle = '#e5e7eb';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(padding, padding * 0.5);
                    ctx.lineTo(padding, height - padding);
                    ctx.lineTo(width - padding * 0.5, height - padding);
                    ctx.stroke();

                    ctx.strokeStyle = '#2563eb';
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    angles.forEach((angle, i) => {
                        const x = toX(i);
                        const y = toY(angle);
                        i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
                    });
                    ctx.stroke();

                    ctx.fillStyle = '#6b7280';
                    ctx.font = '12px sans-serif';
                    ctx.fillText(Math.round(max) + '°', 4, padding * 0.5 + 4);
                    ctx.fillText(Math.round(min) + '°', 4, height - padding + 4);
                }

                draw();
                window.addEventListener('resize', draw);
            })();
        </script>
    @else
        <p class="text-gray-500 text-center py-6">Belum ada data grafik untuk sesi ini.</p>
    @endif
</div>
