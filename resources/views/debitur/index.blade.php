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

    .btn-detail {
        background: #00529C;
        color: white;
        border: none;
        padding: 0.35rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }
    .btn-detail:hover {
        background: #003B73;
        transform: translateY(-1px);
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

    /* MODAL DETAIL 48 KOLOM */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 0.85rem;
        margin-bottom: 1.25rem;
    }

    .detail-item {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        padding: 0.65rem 0.85rem;
        border-radius: 8px;
    }

    .detail-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 0.2rem;
    }

    .detail-val {
        font-size: 0.84rem;
        font-weight: 700;
        color: #0F172A;
        word-break: break-word;
    }

    .section-header-modal {
        font-size: 0.8rem;
        font-weight: 800;
        color: #00529C;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding-bottom: 0.35rem;
        border-bottom: 1.5px solid #E2E8F0;
        margin-top: 1.25rem;
        margin-bottom: 0.85rem;
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
                    <th style="text-align: right;">Detail Lengkap</th>
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
                        <button class="btn-detail" onclick="openDetailModal({{ json_encode($d) }})">
                            🔍 Detail 48 Kolom
                        </button>
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

<!-- ===================================================
     MODAL DETAIL LENGKAP 48 KOLOM DEBITUR
     =================================================== -->
<div id="detailDebiturModal" class="modal-overlay">
    <div class="modal-card" style="max-width: 880px;">
        <div class="modal-header">
            <div class="modal-title-group">
                <h3>📋 Detail Lengkap 48 Kolom Debitur</h3>
                <p id="modalDebiturSubtitle">Informasi atribut lengkap ter-import dari lw_debitur.xlsx</p>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeDetailModal()">✕</button>
        </div>

        <div id="detailModalBody">
            <!-- DYNAMICALLY POPULATED VIA JS -->
        </div>

        <div class="modal-footer-actions">
            <button type="button" class="btn-modal-cancel" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
const PAGE_SIZE = 10;
let currentPage = 1;

function openDetailModal(item) {
    document.getElementById('modalDebiturSubtitle').textContent = `Debitur: ${item.nama_debitur} | No. Rekening: ${item.nomor_rekening}`;
    
    const body = document.getElementById('detailModalBody');
    body.innerHTML = `
        <div class="section-header-modal">🏢 1. Informasi Wilayah & Unit Kerja</div>
        <div class="detail-grid">
            <div class="detail-item"><div class="detail-label">PERIODE</div><div class="detail-val">${item.periode || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">KODE KANWIL & KANWIL</div><div class="detail-val">${item.kode_kanwil || ''} - ${item.kanwil || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">KODE KANCA & KANCA</div><div class="detail-val">${item.kode_kanca || ''} - ${item.kanca || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">KODE UKER & UKER</div><div class="detail-val">${item.kode_uker || ''} - ${item.uker || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">CURRENCY</div><div class="detail-val">${item.currency || 'IDR'}</div></div>
            <div class="detail-item"><div class="detail-label">CIFNO</div><div class="detail-val">${item.cifno || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">SEGMEN LV1 & DESC</div><div class="detail-val">${item.segmen_lv1 || ''} - ${item.desc_segmen_lv1 || '-'}</div></div>
        </div>

        <div class="section-header-modal">👤 2. Identitas Debitur & Rekening</div>
        <div class="detail-grid">
            <div class="detail-item"><div class="detail-label">NAMA DEBITUR</div><div class="detail-val">${item.nama_debitur || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">NOMOR REKENING</div><div class="detail-val" style="font-family:monospace; font-weight:800; color:#00529C;">${item.nomor_rekening || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">LN TYPE</div><div class="detail-val">${item.ln_type || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">CODE & DESCRIPTION</div><div class="detail-val">${item.code || ''} - ${item.description || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">FLAG RESTRUK</div><div class="detail-val">${item.flag_restruk || '-'}</div></div>
        </div>

        <div class="section-header-modal">💰 3. Plafon, Saldo Baki Debet & Keuangan</div>
        <div class="detail-grid">
            <div class="detail-item"><div class="detail-label">PLAFON (M)</div><div class="detail-val" style="color:#10B981;">Rp ${parseFloat(item.plafon || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">PLAFON DALAM IDR (AV)</div><div class="detail-val" style="color:#10B981;">Rp ${parseFloat(item.plafon_dalam_idr || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">BALANCE / BAKI DEBET (AW)</div><div class="detail-val" style="color:#00529C;">Rp ${parseFloat(item.balance_dalam_idr || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">RATE SUKU BUNGA (%)</div><div class="detail-val">${parseFloat(item.rate || 0).toFixed(2)}%</div></div>
            <div class="detail-item"><div class="detail-label">TGL REALISASI (R)</div><div class="detail-val">${item.tgl_realisasi || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">TGL JATUH TEMPO (S)</div><div class="detail-val">${item.tgl_jatuh_tempo || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">JANGKA WAKTU (T)</div><div class="detail-val">${item.jangka_waktu || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">NEXT PMT DATE (N)</div><div class="detail-val">${item.next_pmt_date || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">NEXT INT PMT DATE (O)</div><div class="detail-val">${item.next_int_pmt_date || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">FREQ PAYMENT (AE)</div><div class="detail-val">${item.freq_payment || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">FREQ INT PAYMENT (AF)</div><div class="detail-val">${item.freq_int_payment || '-'}</div></div>
        </div>

        <div class="section-header-modal">📊 4. Kolektabilitas & Tunggakan</div>
        <div class="detail-grid">
            <div class="detail-item"><div class="detail-label">KOL ADK (AK)</div><div class="detail-val">Kol ${item.kol_adk || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">KOLEKTABILITAS LANCAR (W)</div><div class="detail-val">Rp ${parseFloat(item.kolektabilitas_lancar || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">KOLEKTABILITAS DPK (X)</div><div class="detail-val">Rp ${parseFloat(item.kolektabilitas_dpk || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">KOLEKTABILITAS KURANG LANCAR (Y)</div><div class="detail-val">Rp ${parseFloat(item.kolektabilitas_kurang_lancar || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">KOLEKTABILITAS DIRAGUKAN (Z)</div><div class="detail-val">Rp ${parseFloat(item.kolektabilitas_diragukan || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">KOLEKTABILITAS MACET (AA)</div><div class="detail-val">Rp ${parseFloat(item.kolektabilitas_macet || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">TUNGGAKAN POKOK (AB)</div><div class="detail-val">Rp ${parseFloat(item.tunggakan_pokok || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">TUNGGAKAN BUNGA (AC)</div><div class="detail-val">Rp ${parseFloat(item.tunggakan_bunga || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">TUNGGAKAN PINALTI (AD)</div><div class="detail-val">Rp ${parseFloat(item.tunggakan_pinalti || 0).toLocaleString('id-ID')}</div></div>
            <div class="detail-item"><div class="detail-label">TGL MENUNGGAK (Q)</div><div class="detail-val">${item.tgl_menunggak || '-'}</div></div>
        </div>

        <div class="section-header-modal">👨‍💼 5. Pegawai & Officer Penanggung Jawab (PN)</div>
        <div class="detail-grid">
            <div class="detail-item"><div class="detail-label">PN PENGELOLA SINGLEPN (AL)</div><div class="detail-val">${item.pn_pengelola_singlepn || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">PN PENGELOLA 1 (AM)</div><div class="detail-val">${item.pn_pengelola_1 || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">PN PENGELOLA 2 (AQ)</div><div class="detail-val">${item.pn_pengelola_2 || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">PN PEMRAKARSA (AN)</div><div class="detail-val">${item.pn_pemrakarsa || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">PN PEMUTUS (AR)</div><div class="detail-val">${item.pn_pemutus || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">PN REFERRAL (AO)</div><div class="detail-val">${item.pn_referral || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">PN RESTRUK (AP)</div><div class="detail-val">${item.pn_restruk || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">PN CRM (AS)</div><div class="detail-val">${item.pn_crm || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">PN RM REFERRAL NAIK SEGMENTASI (AT)</div><div class="detail-val">${item.pn_rm_referral_naik_segmentasi || '-'}</div></div>
            <div class="detail-item"><div class="detail-label">PN RM CRR (AU)</div><div class="detail-val">${item.pn_rm_crr || '-'}</div></div>
        </div>
    `;

    document.getElementById('detailDebiturModal').style.display = 'flex';
}

function closeDetailModal() {
    document.getElementById('detailDebiturModal').style.display = 'none';
}

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
