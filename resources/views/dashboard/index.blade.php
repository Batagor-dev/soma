@php
    $sub_title = 'Dashboard';
@endphp

@extends('layout.backend.main', [
    'title' => 'Dashboard | ' . config('app.name'),
    'sub_title' => $sub_title
])

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Statistik --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="ri-user-3-line ri-2x text-primary"></i>
                    <h4 class="mt-2">{{ $totalUser }}</h4>
                    <p class="mb-0">Total Anggota</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="ri-calendar-event-line ri-2x text-success"></i>
                    <h4 class="mt-2">{{ $totalKegiatan }}</h4>
                    <p class="mb-0">Total Kegiatan</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <i class="ri-image-line ri-2x text-warning"></i>
                    <h4 class="mt-2">{{ $totalGalery }}</h4>
                    <p class="mb-0">Galeri Foto</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Statistik Kegiatan Tahun {{ now()->year }}</h5>
        </div>
        <div class="card-body">
            <canvas id="kegiatanChart" height="120"></canvas>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('kegiatanChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_values($kegiatanPerBulan->keys()->map(fn($b) => date('F', mktime(0,0,0,$b,1)))->toArray())) !!},
            datasets: [{
                label: 'Jumlah Kegiatan',
                data: {!! json_encode(array_values($kegiatanPerBulan->values()->toArray())) !!},
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });
</script>
@endpush
