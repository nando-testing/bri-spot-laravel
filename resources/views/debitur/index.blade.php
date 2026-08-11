@extends('layouts.app')

@section('title', 'Master Data LW Debitur (48 Kolom Lengkap) - Digital Flow')

@section('styles')
<style>
    .table-card {
        margin-bottom: 2rem;
        border-left: 4px solid #00529C;
    }

    .table-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        padding-bottom: 0.85rem;
        border-bottom: 1px solid #E2E8F0;
        margin-bottom: 1rem;
    }

    .toolbar-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0F172A;
    }

    .page-subtitle {
        font-size: 0.8rem;
        color: #64748B;
        margin-top: 0.2rem;
    }

    .neat-filter-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
        background: #F8FAFC;
        padding: 0.65rem 0.85rem;
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        margin-bottom: 1rem;
    }

    .search-input {
        padding: 0.55rem 0.85rem;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 0.82rem;
        outline: none;
        font-family: inherit;
        transition: all 0.2s;
        width: 100%;
        max-width: 360px;
    }

    .search-input:focus {
        border-color: #00529C;
        box-shadow: 0 0 0 3px rgba(0, 82, 156, 0.12);
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.82rem;
    }

    .custom-table th {
        padding: 0.85rem 0.65rem;
        color: #64748B;
        font-weight: 700;
        border-bottom: 1px solid #E2E8F0;
        font-size: 0.73rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        vertical-align: middle;
        background: #FAFAFA;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 0.85rem 0.65rem;
        border-bottom: 1px solid #E2E8F0;
        color: #0F172A;
        vertical-align: middle;
    }

    .custom-table tr:hover {
        background-color: #F8FAFC;
    }

    .col-plafon {
        min-width: 165px;
        white-space: nowrap;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.88rem;
        font-weight: 800;
        color: #10B981;
    }

    .col-balance {
        min-width: 165px;
        white-space: nowrap;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.88rem;
        font-weight: 800;
        color: #00529C;
    }

    .kol-badge {
        padding: 0.2rem 0.55rem;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 800;
        display: inline-block;
    }
    .kol-1 { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
    .kol-2 { background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; }
    .kol-3 { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }

    .btn-detail-page {
        background: linear-gradient(135deg, #00529C 0%, #003B73 100%);
        color: white;
        border: none;
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
        font-size: 0.76rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s;
        box-shadow: 0 2px 6px rgba(0, 82, 156, 0.2);
        white-space: nowrap;
    }

    .btn-detail-page:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 82, 156, 0.3);
        color: white;
    }

    .readonly-badge {
        background: #F1F5F9;
        color: #64748B;
        border: 1px solid #CBD5E1;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    /* PAGINATION STYLING */
    .pagination-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1rem;
        margin-top: 1rem;
        border-top: 1px solid #E2E8F0;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .pagination-info {
        font-size: 0.78rem;
        color: #64748B;
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .btn-page {
        padding: 0.35rem 0.7rem;
        background: #FFFFFF;
        border: 1px solid #CBD5E1;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-page:hover:not(:disabled) {
        background: #00529C;
        color: white;
        border-color: #00529C;
    }

    .btn-page.active {
        background: #00529C;
        color: white;
        border-color: #00529C;
    }

    .btn-page:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@section('content')

<div class="glass-card table-card">
    <div class="table-toolbar">
        <div>
            <div class="toolbar-title">📊 Master Data LW Debitur (48 Kolom Lengkap)</div>
            <p class="page-subtitle">Seluruh 48 atribut kolom data ter-import lengkap dari file <code>lw_debitur.xlsx</code></p>
        </div>

        <div>
            <span class="readonly-badge">🔒 Read-Only Master Data</span>
        </div>
    </div>

    <!-- PENCARIAN LIVE DEBITUR -->
    <div class="neat-filter-bar">
        <input type="text" id="searchDebitur" class="search-input" placeholder="Cari nama debitur, no. rekening, uker..." onkeyup="filterDebiturTable()">
        <div style="font-size:0.75rem; color:#64748B; font-weight:600;">
            Total Master: <strong>{{ count($debiturList) }} Record (48 Kolom Tersimpan)</strong>
        </div>
    </div>

    <div class="table-responsive">
        <table class="custom-table" id="debiturTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No. Rekening</th>
                    <th>Nama Debitur</th>
                    <th>Kanca / Uker</th>
                    <th>Jenis Pinjaman</th>
                    <th class="col-plafon">Plafon Kredit (Rp)</th>
                    <th class="col-balance">Baki Debet (Rp)</th>
                    <th>Rate (%)</th>
                    <th>Tgl Realisasi</th>
                    <th>Tgl JTH Tempo</th>
                    <th>Jangka Waktu</th>
                    <th>Kol ADK</th>
                    <th>PN Pengelola</th>
                    <th style="text-align: right;">Aksi Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($debiturList as $idx => $d)
                <tr>
                    <td><strong>{{ $idx + 1 }}</strong></td>
                    <td><span style="font-family: monospace; font-weight: 700;">{{ $d->nomor_rekening }}</span></td>
                    <td><strong>{{ $d->nama_debitur }}</strong></td>
                    <td><span style="font-size:0.75rem; color:#475569;">{{ $d->kanca }} ({{ $d->kode_kanca }})</span></td>
                    <td><span style="font-size:0.72rem; color:#64748B;">{{ $d->description ?: $d->ln_type }}</span></td>
                    <td class="col-plafon">Rp {{ number_format($d->plafon, 0, ',', '.') }}</td>
                    <td class="col-balance">Rp {{ number_format($d->balance_dalam_idr, 0, ',', '.') }}</td>
                    <td><span style="font-family: monospace; font-weight: 700;">{{ number_format($d->rate, 2) }}%</span></td>
                    <td><span style="font-family: monospace;">{{ $d->tgl_realisasi ?: '-' }}</span></td>
                    <td><span style="font-family: monospace;">{{ $d->tgl_jatuh_tempo ?: '-' }}</span></td>
                    <td><span style="font-family: monospace; background:#F1F5F9; padding:0.15rem 0.4rem; border-radius:4px;">{{ $d->jangka_waktu }}</span></td>
                    <td>
                        <span class="kol-badge {{ $d->kol_adk == '1' ? 'kol-1' : ($d->kol_adk == '2' ? 'kol-2' : 'kol-3') }}">
                            Kol {{ $d->kol_adk }}
                        </span>
                    </td>
                    <td><span style="font-size:0.72rem; color:#334155;">{{ $d->pn_pengelola_singlepn ?: '-' }}</span></td>
                    <td style="text-align: right;">
                        <a href="{{ route('debitur.show', $d->id) }}" class="btn-detail-page">
                            🔍 Halaman Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colSpan="14" style="text-align:center; padding: 2rem; color: #64748B;">
                        Belum ada data master debitur terimport.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION BAR -->
    <div class="pagination-bar" id="debiturPaginationBar">
        <div class="pagination-info" id="debiturPaginationInfo">Menampilkan 0 - 0 dari 0 Record</div>
        <div class="pagination-controls" id="debiturPaginationControls"></div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const PAGE_SIZE = 10;
let currentPage = 1;

function filterDebiturTable() {
    currentPage = 1;
    renderDebiturPagination();
}

function renderDebiturPagination() {
    const table = document.getElementById('debiturTable');
    if (!table) return;

    const filter = (document.getElementById('searchDebitur')?.value || '').toLowerCase();
    const tbody = table.getElementsByTagName('tbody')[0];
    if (!tbody) return;

    const rows = Array.from(tbody.querySelectorAll('tr'));
    const matchingRows = rows.filter(tr => {
        if (tr.cells.length <= 1) return true;
        return tr.textContent.toLowerCase().indexOf(filter) > -1;
    });

    const total = matchingRows.length;
    const totalPages = Math.ceil(total / PAGE_SIZE) || 1;
    const startIdx = (currentPage - 1) * PAGE_SIZE;
    const endIdx = startIdx + PAGE_SIZE;

    rows.forEach(tr => tr.style.display = 'none');
    matchingRows.slice(startIdx, endIdx).forEach(tr => tr.style.display = '');

    const info = document.getElementById('debiturPaginationInfo');
    const controls = document.getElementById('debiturPaginationControls');

    if (info && controls) {
        const fromItem = total > 0 ? startIdx + 1 : 0;
        const toItem = Math.min(endIdx, total);
        info.textContent = `Menampilkan ${fromItem} - ${toItem} dari ${total} Record Debitur (48 Kolom Tersimpan)`;

        let ctrlHtml = '';
        ctrlHtml += `<button class="btn-page" ${currentPage === 1 ? 'disabled' : ''} onclick="changeDebiturPage(${currentPage - 1})">« Prev</button>`;

        for (let p = 1; p <= totalPages; p++) {
            ctrlHtml += `<button class="btn-page ${p === currentPage ? 'active' : ''}" onclick="changeDebiturPage(${p})">${p}</button>`;
        }

        ctrlHtml += `<button class="btn-page" ${currentPage === totalPages ? 'disabled' : ''} onclick="changeDebiturPage(${currentPage + 1})">Next »</button>`;
        controls.innerHTML = ctrlHtml;
    }
}

function changeDebiturPage(pageNum) {
    currentPage = pageNum;
    renderDebiturPagination();
}

document.addEventListener('DOMContentLoaded', () => {
    renderDebiturPagination();
});
</script>
@endsection
