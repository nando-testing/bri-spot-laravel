@extends('layouts.app')

@section('title', 'Digital Flow - Monitoring Alur berkas KPR')

@section('styles')
<style>
    /* PAGE & TOOLBAR */
    .page-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #00529C;
    }

    .page-subtitle {
        font-size: 0.8rem;
        color: #64748B;
    }

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
        font-size: 1.05rem;
        font-weight: 800;
        color: #0F172A;
    }

    .toolbar-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .search-input, .select-input {
        padding: 0.55rem 0.85rem;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 0.82rem;
        outline: none;
        font-family: inherit;
        transition: all 0.2s;
    }

    .search-input:focus, .select-input:focus {
        border-color: #00529C;
        box-shadow: 0 0 0 3px rgba(0, 82, 156, 0.12);
    }

    .btn-action-primary {
        background: linear-gradient(135deg, #00529C 0%, #003B73 100%);
        color: white;
        border: none;
        padding: 0.55rem 1.1rem;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        box-shadow: 0 2px 6px rgba(0, 82, 156, 0.2);
    }

    .btn-action-primary:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 82, 156, 0.3);
    }

    .btn-action-secondary {
        background: #F1F5F9;
        color: #334155;
        border: 1px solid #CBD5E1;
        padding: 0.55rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
    }

    .btn-action-secondary:hover {
        background: #E2E8F0;
        color: #0F172A;
    }

    /* NEAT FILTER & SEARCH BAR */
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

    /* CUSTOM TABLE */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.84rem;
    }

    .custom-table th {
        padding: 0.9rem 0.75rem;
        color: #64748B;
        font-weight: 700;
        border-bottom: 1px solid #E2E8F0;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        vertical-align: middle;
        background: #FAFAFA;
    }

    .custom-table td {
        padding: 0.85rem 0.75rem;
        border-bottom: 1px solid #E2E8F0;
        color: #0F172A;
        vertical-align: middle;
    }

    .custom-table tr:hover {
        background-color: #F8FAFC;
    }

    .badge-jabatan {
        padding: 0.15rem 0.45rem;
        background: #F1F5F9;
        border: 1px solid #E2E8F0;
        border-radius: 4px;
        font-weight: 800;
        font-size: 0.7rem;
    }

    .jenis-tag {
        font-size: 0.75rem;
        font-weight: 700;
        color: #475569;
    }

    /* KOLOM PLAFON KREDIT BESAR & JELAS */
    .col-plafon {
        min-width: 175px;
        white-space: nowrap;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.88rem;
        font-weight: 800;
        color: #10B981;
    }

    .unit-badge {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.75rem;
        font-weight: 600;
        background: #F1F5F9;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        white-space: nowrap;
    }

    .status-badge {
        padding: 0.3rem 0.65rem;
        font-size: 0.73rem;
        font-weight: 700;
        border-radius: 20px;
        display: inline-block;
        white-space: nowrap;
    }

    .status-collect { background: rgba(59, 130, 246, 0.15); color: #3B82F6; }
    .status-rm { background: rgba(245, 158, 11, 0.15); color: #F59E0B; }
    .status-selesai { background: rgba(16, 185, 129, 0.15); color: #10B981; }

    /* ACTION BUTTON STYLES */
    .btn-edit {
        background: #E0F2FE;
        color: #00529C;
        border: 1px solid #BAE6FD;
        padding: 0.35rem 0.7rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-edit:hover { background: #BAE6FD; }

    .btn-delete {
        background: #FEF2F2;
        color: #EF4444;
        border: 1px solid #FCA5A5;
        padding: 0.35rem 0.7rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-delete:hover { background: #FCA5A5; }

    /* BUTTON DISABLED / TANPA WEWENANG */
    .btn-disabled {
        background: #F1F5F9 !important;
        color: #94A3B8 !important;
        border: 1px solid #E2E8F0 !important;
        padding: 0.35rem 0.65rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: not-allowed !important;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        opacity: 0.65;
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

    /* MODAL STYLING TANPA LOGO BERLEBIHAN */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(6px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 1rem;
        animation: fadeIn 0.25s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-card {
        background: #FFFFFF;
        width: 100%;
        max-width: 640px;
        max-height: 90vh;
        overflow-y: auto;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 25px 50px -12px rgba(0, 59, 115, 0.25);
        border: 1px solid #E2E8F0;
        position: relative;
    }

    .modal-card::-webkit-scrollbar {
        width: 6px;
    }
    .modal-card::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 10px;
    }

    .modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding-bottom: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 2px solid #F1F5F9;
    }

    .modal-title-group h3 {
        font-size: 1.2rem;
        font-weight: 800;
        color: #00529C;
    }

    .modal-title-group p {
        font-size: 0.78rem;
        color: #64748B;
        margin-top: 0.25rem;
    }

    .modal-close-btn {
        background: #F1F5F9;
        color: #64748B;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .modal-close-btn:hover {
        background: #FEF2F2;
        color: #EF4444;
    }

    .form-section-title {
        font-size: 0.75rem;
        font-weight: 800;
        color: #00529C;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-top: 1rem;
        margin-bottom: 0.85rem;
        padding-bottom: 0.35rem;
        border-bottom: 1px dashed #E2E8F0;
    }

    .form-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group-neat {
        margin-bottom: 1rem;
    }

    .form-label-neat {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.45rem;
    }

    .form-label-neat .req {
        color: #EF4444;
        margin-left: 0.15rem;
    }

    /* FORM INPUT CLEAN TANPA IKON BANJIR */
    .form-control-neat {
        width: 100%;
        padding: 0.65rem 0.85rem;
        border: 1.5px solid #CBD5E1;
        border-radius: 10px;
        font-size: 0.85rem;
        font-family: inherit;
        color: #0F172A;
        background-color: #FFFFFF;
        outline: none;
        transition: all 0.2s ease-in-out;
    }

    .form-control-neat:focus {
        border-color: #00529C;
        box-shadow: 0 0 0 4px rgba(0, 82, 156, 0.12);
    }

    .plafon-live-preview {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.78rem;
        font-weight: 700;
        color: #10B981;
        margin-top: 0.35rem;
        background: #ECFDF5;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        display: inline-block;
    }

    .modal-footer-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
        margin-top: 1.75rem;
        padding-top: 1.25rem;
        border-top: 2px solid #F1F5F9;
    }

    .btn-modal-cancel {
        padding: 0.65rem 1.25rem;
        background: #F1F5F9;
        color: #475569;
        border: 1px solid #CBD5E1;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-modal-cancel:hover {
        background: #E2E8F0;
        color: #0F172A;
    }

    .btn-modal-save {
        padding: 0.65rem 1.5rem;
        background: linear-gradient(135deg, #00529C 0%, #003B73 100%);
        color: #FFFFFF;
        border: none;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(0, 82, 156, 0.25);
    }
    .btn-modal-save:hover {
        opacity: 0.95;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 82, 156, 0.35);
    }

    @media (max-width: 640px) {
        .form-grid-2 {
            grid-template-columns: 1fr;
        }
        .modal-card {
            padding: 1.25rem;
        }
    }
</style>
@section('content')

<!-- DEVELOPER MONITORING BANNER -->
@if($activeRole === 'Developer Perumahan')
<div class="glass-card" style="border-left: 4px solid #00529C; background: #F0F9FF; margin-bottom: 1.5rem;">
    <h4 style="font-weight: 800; color: #00529C; font-size: 0.95rem;">
        Mode Monitoring Khusus Developer: {{ $user->name }}
    </h4>
    <p style="font-size: 0.78rem; color: #475569; margin-top: 0.2rem;">
        Menampilkan <strong>{{ count($table2Raw) }} berkas KPR</strong> khusus proyek perumahan milik <strong>{{ $user->name }}</strong>.
    </p>
</div>
@endif

<!-- TABEL 1: BERKAS TUGAS ROLE AKTIF (HANYA UNTUK SO/RM/CBM/ADK/SUPER ADMIN) -->
@if($activeRole !== 'Developer Perumahan')
<div class="glass-card table-card">
    <div class="table-toolbar">
        <div>
            <div class="toolbar-title">Tabel 1: Berkas Tugas Role Aktif ({{ $user->name }} - {{ $activeRole }})</div>
            <p class="page-subtitle">Daftar berkas KPR sesuai alur tugas wewenang</p>
        </div>

        <div class="toolbar-controls">
            @if(in_array($activeRole, ['SO', 'RM', 'Super Admin']))
                <button type="button" class="btn-action-primary" onclick="openAddModal()">
                    + Register KPR Baru
                </button>
            @endif
        </div>
    </div>

    <!-- PENCARIAN RAPI TABLE 1 -->
    <div class="neat-filter-bar">
        <div style="display:flex; align-items:center; gap:0.5rem; width: 100%; max-width: 360px;">
            <input type="text" id="searchTable1" class="search-input" style="width:100%;" placeholder="Cari debitur, developer, unit..." onkeyup="filterTable('table1', 'searchTable1')">
        </div>
        <div style="font-size:0.75rem; color:#64748B; font-weight:600;">
            Total Berkas Berjalan: <strong>{{ count($table1Raw) }} Berkas</strong>
        </div>
    </div>

    <div class="table-responsive">
        <table class="custom-table" id="table1">
            <thead>
                <tr>
                    <th>Tgl Input</th>
                    <th>User Input</th>
                    <th>Debitur & Developer</th>
                    <th>RM Penanggung Jawab</th>
                    <th>Jenis KPR</th>
                    <th class="col-plafon">Plafon Kredit (Rp)</th>
                    <th>Blok / Unit</th>
                    <th>No. Rekening</th>
                    <th>Status Alur Tugas</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($table1Raw as $item)
                @php
                    $canEdit = $item->canEdit($user);
                    $reason = $item->getRestrictionReason($user);

                    $roleStatuses = [
                        'SO' => ['Collect Data', 'Proses RM'],
                        'RM' => ['Collect Data', 'Proses RM', 'Proses RM Diterima', 'Proses RM Ditolak', 'Verifikasi CBM', 'Proses Akad ADK', 'Selesai'],
                        'CBM' => ['Proses RM Diterima', 'Verifikasi CBM', 'Proses Akad ADK'],
                        'ADK' => ['Verifikasi CBM', 'Proses Akad ADK', 'Selesai'],
                        'Super Admin' => ['Collect Data', 'Proses RM', 'Proses RM Diterima', 'Proses RM Ditolak', 'Verifikasi CBM', 'Proses Akad ADK', 'Selesai']
                    ];

                    $allowedStatuses = $roleStatuses[$activeRole] ?? ['Collect Data', 'Proses RM', 'Proses RM Diterima', 'Proses RM Ditolak', 'Verifikasi CBM', 'Proses Akad ADK', 'Selesai'];
                    if (!in_array($item->status, $allowedStatuses)) {
                        $allowedStatuses[] = $item->status;
                    }
                @endphp
                <tr>
                    <td><span style="font-family: monospace;">{{ $item->tanggal }}</span></td>
                    <td>
                        <span class="badge-jabatan">{{ $item->jabatan_petugas }}</span>
                        <strong>{{ $item->nama_petugas }}</strong>
                    </td>
                    <td>
                        <div><strong>{{ $item->nama_debitur }}</strong></div>
                        <div style="font-size: 0.72rem; color: #64748B;">{{ $item->nama_developer }}</div>
                    </td>
                    <td><strong>{{ $item->nama_rm_penanggung_jawab ?: '-' }}</strong></td>
                    <td><span class="jenis-tag">{{ $item->jenis_kpr }}</span></td>
                    <td class="col-plafon">Rp {{ number_format($item->plafon_kredit, 0, ',', '.') }}</td>
                    <td><span class="unit-badge">{{ $item->unit_block }}</span></td>
                    <td><span style="font-family: monospace;">{{ $item->nomor_rekening ?: '-' }}</span></td>
                    <td>
                        <form action="{{ route('kpr.status', $item->id) }}" method="POST" style="display:flex; gap:0.3rem;">
                            @csrf
                            <select name="status" class="select-input" {{ !$canEdit ? 'disabled style=opacity:0.6;cursor:not-allowed;' : '' }}>
                                @foreach($allowedStatuses as $st)
                                    <option value="{{ $st }}" {{ $item->status === $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                            @if($canEdit)
                                <button type="submit" class="btn-action-primary" style="padding: 0.35rem 0.6rem;" title="Simpan Status">Simpan</button>
                            @else
                                <button type="button" class="btn-disabled" title="{{ $reason }}">🔒</button>
                            @endif
                        </form>
                    </td>
                    <td style="text-align: right;">
                        <div style="display:inline-flex; gap:0.3rem; justify-content:flex-end;">
                            @if($canEdit)
                                <button class="btn-edit" onclick="openEditModal({{ json_encode($item) }})">Edit</button>
                            @else
                                <button type="button" class="btn-disabled" disabled title="{{ $reason }}">Edit</button>
                            @endif

                            @if($activeRole === 'Super Admin')
                                <form action="{{ route('kpr.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus berkas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colSpan="10" style="text-align:center; padding: 2rem; color: #64748B;">
                        Tidak ada berkas tugas untuk role {{ $activeRole }} saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION BAR TABLE 1 -->
    <div class="pagination-bar" id="table1PaginationBar">
        <div class="pagination-info" id="table1PaginationInfo">Menampilkan 0 - 0 dari 0 Berkas</div>
        <div class="pagination-controls" id="table1PaginationControls"></div>
    </div>
</div>
@endif

<!-- TABEL 2: REAL MASTER DATA KPR (TIDAK TAMPIL UNTUK ROLE SO) -->
@if($activeRole !== 'SO')
<div class="glass-card table-card" style="border-left: 4px solid #64748B;">
    <div class="table-toolbar">
        <div>
            <div class="toolbar-title">
                {{ $activeRole === 'Developer Perumahan' ? "Monitoring Berkas Perumahan ({$user->name})" : "Tabel 2: Real Master Data KPR (" . count($table2Raw) . " Berkas)" }}
            </div>
            <p class="page-subtitle">Arsip Seluruh Berkas KPR Terdaftar</p>
        </div>

        <div class="toolbar-controls">
            <a href="{{ route('kpr.export') }}" class="btn-action-secondary">
                Export CSV
            </a>
        </div>
    </div>

    <!-- PENCARIAN RAPI TABLE 2 -->
    <div class="neat-filter-bar">
        <div style="display:flex; align-items:center; gap:0.5rem; width: 100%; max-width: 360px;">
            <input type="text" id="searchTable2" class="search-input" style="width:100%;" placeholder="Cari master debitur, developer, unit..." onkeyup="filterTable('table2', 'searchTable2')">
        </div>
        <div style="font-size:0.75rem; color:#64748B; font-weight:600;">
            Total Master: <strong>{{ count($table2Raw) }} Berkas</strong>
        </div>
    </div>

    <div class="table-responsive">
        <table class="custom-table" id="table2">
            <thead>
                <tr>
                    <th>Tgl Input</th>
                    <th>User Input</th>
                    <th>Debitur & Developer</th>
                    <th>RM Penanggung Jawab</th>
                    <th>Jenis KPR</th>
                    <th class="col-plafon">Plafon Kredit (Rp)</th>
                    <th>Blok / Unit</th>
                    <th>No. Rekening</th>
                    <th>Status Alur KPR</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($table2Raw as $item)
                @php
                    $canEditMaster = $item->canEdit($user);
                    $reasonMaster = $item->getRestrictionReason($user);
                @endphp
                <tr>
                    <td><span style="font-family: monospace;">{{ $item->tanggal }}</span></td>
                    <td>
                        <span class="badge-jabatan">{{ $item->jabatan_petugas }}</span>
                        <strong>{{ $item->nama_petugas }}</strong>
                    </td>
                    <td>
                        <div><strong>{{ $item->nama_debitur }}</strong></div>
                        <div style="font-size: 0.72rem; color: #64748B;">{{ $item->nama_developer }}</div>
                    </td>
                    <td><strong>{{ $item->nama_rm_penanggung_jawab ?: '-' }}</strong></td>
                    <td><span class="jenis-tag">{{ $item->jenis_kpr }}</span></td>
                    <td class="col-plafon">Rp {{ number_format($item->plafon_kredit, 0, ',', '.') }}</td>
                    <td><span class="unit-badge">{{ $item->unit_block }}</span></td>
                    <td><span style="font-family: monospace;">{{ $item->nomor_rekening ?: '-' }}</span></td>
                    <td>
                        <span class="status-badge {{ $item->status === 'Selesai' ? 'status-selesai' : 'status-collect' }}">{{ $item->status }}</span>
                    </td>
                    <td style="text-align: right;">
                        <div style="display:inline-flex; gap:0.3rem; justify-content:flex-end;">
                            @if($canEditMaster)
                                <button class="btn-edit" onclick="openEditModal({{ json_encode($item) }})">Edit</button>
                            @else
                                <button type="button" class="btn-disabled" disabled title="{{ $reasonMaster }}">Edit</button>
                            @endif

                            @if($activeRole === 'Super Admin')
                                <form action="{{ route('kpr.destroy', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus berkas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colSpan="10" style="text-align:center; padding: 2rem; color: #64748B;">
                        Data KPR tidak ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION BAR TABLE 2 -->
    <div class="pagination-bar" id="table2PaginationBar">
        <div class="pagination-info" id="table2PaginationInfo">Menampilkan 0 - 0 dari 0 Berkas</div>
        <div class="pagination-controls" id="table2PaginationControls"></div>
    </div>
</div>
@endif

<!-- ===================================================
     MODAL INPUT KPR BARU (BERSIH TANPA LOGO BANJIR)
     =================================================== -->
<div id="addKprModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <div class="modal-title-group">
                <h3>Register Berkas KPR Baru</h3>
                <p>Isi formulir pendaftaran berkas KPR baru di bawah ini.</p>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeAddModal()">✕</button>
        </div>

        <form action="{{ route('kpr.store') }}" method="POST">
            @csrf

            <!-- SEKSI 1: INFORMASI DEBITUR & PERUMAHAN -->
            <div class="form-section-title">
                1. Informasi Debitur & Developer Perumahan
            </div>

            <div class="form-group-neat">
                <label class="form-label-neat">Nama Lengkap Debitur <span class="req">*</span></label>
                <input type="text" name="nama_debitur" class="form-control-neat" required placeholder="cth: Budi Kurniawan">
            </div>

            <div class="form-group-neat">
                <label class="form-label-neat">Developer / PT Perumahan <span class="req">*</span></label>
                <select name="nama_developer" id="add_nama_developer" class="form-control-neat" required onchange="toggleCustomDeveloper('add')">
                    @foreach($developers as $dev)
                        <option value="{{ $dev }}">{{ $dev }}</option>
                    @endforeach
                    <option value="OTHER">+ Tambah Developer Baru...</option>
                </select>
            </div>

            <div class="form-group-neat" id="add_custom_dev_wrapper" style="display: none;">
                <label class="form-label-neat">Nama Developer Baru <span class="req">*</span></label>
                <input type="text" name="custom_developer_name" id="add_custom_dev_input" class="form-control-neat" placeholder="Ketik nama PT Developer baru">
            </div>

            <div class="form-group-neat">
                <label class="form-label-neat">Blok / Nomor Unit <span class="req">*</span></label>
                <input type="text" name="unit_block" class="form-control-neat" required placeholder="cth: Blok A1 No. 5">
            </div>

            <!-- SEKSI 2: KREDIT & KEUANGAN -->
            <div class="form-section-title">
                2. Ketentuan Jenis KPR & Plafon Kredit
            </div>

            <div class="form-grid-2">
                <div class="form-group-neat">
                    <label class="form-label-neat">Jenis KPR <span class="req">*</span></label>
                    <select name="jenis_kpr" class="form-control-neat" required>
                        <option value="KPR">KPR (Komersial)</option>
                        <option value="KPRS">KPRS (Subsidi / Syariah)</option>
                    </select>
                </div>

                <div class="form-group-neat">
                    <label class="form-label-neat">Plafon Kredit (Rp) <span class="req">*</span></label>
                    <input type="number" name="plafon_kredit" id="add_plafon_kredit" class="form-control-neat" required placeholder="500000000" oninput="updatePlafonPreview('add')">
                    <div id="add_plafon_preview" class="plafon-live-preview" style="display:none;">Rp 0</div>
                </div>
            </div>

            <!-- SEKSI 3: TANGGUNG JAWAB & RM -->
            <div class="form-section-title">
                3. Penanggung Jawab Berkas
            </div>

            <div class="form-grid-2">
                <div class="form-group-neat">
                    <label class="form-label-neat">Tanggal Register</label>
                    <input type="text" name="tanggal" class="form-control-neat" value="{{ date('d/m/Y') }}" readonly style="background:#F8FAFC;">
                </div>

                <div class="form-group-neat">
                    <label class="form-label-neat">RM Penanggung Jawab <span class="req">*</span></label>
                    <select name="nama_rm_penanggung_jawab" class="form-control-neat" required>
                        <option value="Rina Wijaya, S.E.">Rina Wijaya, S.E.</option>
                        <option value="Doni Pratama, S.H.">Doni Pratama, S.H.</option>
                        <option value="Ahmad Subagja, S.T.">Ahmad Subagja, S.T.</option>
                    </select>
                </div>
            </div>

            <!-- FOOTER ACTIONS (TANPA KATA MARIADB) -->
            <div class="modal-footer-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn-modal-save">
                    Simpan Berkas KPR
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================================================
     MODAL EDIT KPR (BERSIH TANPA LOGO BANJIR)
     =================================================== -->
<div id="editKprModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <div class="modal-title-group">
                <h3>Edit Data Berkas KPR</h3>
                <p>Perbarui informasi berkas KPR terdaftar di bawah ini.</p>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeEditModal()">✕</button>
        </div>

        <form id="editKprForm" action="" method="POST">
            @csrf

            <!-- SEKSI 1: INFORMASI DEBITUR & PERUMAHAN -->
            <div class="form-section-title">
                1. Informasi Debitur & Developer Perumahan
            </div>

            <div class="form-group-neat">
                <label class="form-label-neat">Nama Lengkap Debitur <span class="req">*</span></label>
                <input type="text" id="edit_nama_debitur" name="nama_debitur" class="form-control-neat" required>
            </div>

            <div class="form-group-neat">
                <label class="form-label-neat">Developer / PT Perumahan <span class="req">*</span></label>
                <select id="edit_nama_developer" name="nama_developer" class="form-control-neat" required onchange="toggleCustomDeveloper('edit')">
                    @foreach($developers as $dev)
                        <option value="{{ $dev }}">{{ $dev }}</option>
                    @endforeach
                    <option value="OTHER">+ Tambah Developer Baru...</option>
                </select>
            </div>

            <div class="form-group-neat" id="edit_custom_dev_wrapper" style="display: none;">
                <label class="form-label-neat">Nama Developer Baru <span class="req">*</span></label>
                <input type="text" name="custom_developer_name" id="edit_custom_dev_input" class="form-control-neat" placeholder="Ketik nama PT Developer baru">
            </div>

            <div class="form-group-neat">
                <label class="form-label-neat">Blok / Nomor Unit <span class="req">*</span></label>
                <input type="text" id="edit_unit_block" name="unit_block" class="form-control-neat" required>
            </div>

            <!-- SEKSI 2: KREDIT & KEUANGAN -->
            <div class="form-section-title">
                2. Ketentuan Jenis KPR & Plafon Kredit
            </div>

            <div class="form-grid-2">
                <div class="form-group-neat">
                    <label class="form-label-neat">Jenis KPR <span class="req">*</span></label>
                    <select id="edit_jenis_kpr" name="jenis_kpr" class="form-control-neat" required>
                        <option value="KPR">KPR (Komersial)</option>
                        <option value="KPRS">KPRS (Subsidi / Syariah)</option>
                    </select>
                </div>

                <div class="form-group-neat">
                    <label class="form-label-neat">Plafon Kredit (Rp) <span class="req">*</span></label>
                    <input type="number" id="edit_plafon_kredit" name="plafon_kredit" class="form-control-neat" required oninput="updatePlafonPreview('edit')">
                    <div id="edit_plafon_preview" class="plafon-live-preview" style="display:none;">Rp 0</div>
                </div>
            </div>

            <!-- SEKSI 3: TANGGUNG JAWAB & REKENING -->
            <div class="form-section-title">
                3. Penanggung Jawab & Status Berkas
            </div>

            <div class="form-grid-2">
                <div class="form-group-neat">
                    <label class="form-label-neat">RM Penanggung Jawab <span class="req">*</span></label>
                    <select id="edit_nama_rm_penanggung_jawab" name="nama_rm_penanggung_jawab" class="form-control-neat" required>
                        <option value="Rina Wijaya, S.E.">Rina Wijaya, S.E.</option>
                        <option value="Doni Pratama, S.H.">Doni Pratama, S.H.</option>
                        <option value="Ahmad Subagja, S.T.">Ahmad Subagja, S.T.</option>
                    </select>
                </div>

                <div class="form-group-neat">
                    <label class="form-label-neat">Status Alur Berkas <span class="req">*</span></label>
                    <select id="edit_status" name="status" class="form-control-neat" required>
                        <option value="Collect Data">Collect Data</option>
                        <option value="Proses RM">Proses RM</option>
                        <option value="Proses RM Diterima">Proses RM Diterima</option>
                        <option value="Proses RM Ditolak">Proses RM Ditolak</option>
                        <option value="Verifikasi CBM">Verifikasi CBM</option>
                        <option value="Proses Akad ADK">Proses Akad ADK</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>
            </div>

            <div class="form-group-neat">
                <label class="form-label-neat">Nomor Rekening Pinjaman <span style="font-weight:400; color:#64748B;">(Opsional)</span></label>
                <input type="text" id="edit_nomor_rekening" name="nomor_rekening" class="form-control-neat" placeholder="cth: 882-9401-2291">
            </div>

            <!-- FOOTER ACTIONS (TANPA KATA MARIADB) -->
            <div class="modal-footer-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-modal-save">
                    Update Data KPR
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ===================================================
     MODAL REGISTRASI AKUN PEGAWAI / DEVELOPER BARU
     =================================================== -->
<div id="registerUserModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <div class="modal-title-group">
                <h3>Registrasi Akun Pegawai / Developer</h3>
                <p>Buat kredensial login baru untuk staf atau pengembang perumahan.</p>
            </div>
            <button type="button" class="modal-close-btn" onclick="document.getElementById('registerUserModal').style.display='none'">✕</button>
        </div>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="form-group-neat">
                <label class="form-label-neat">Username / NIP Pegawai <span class="req">*</span></label>
                <input type="text" name="username" class="form-control-neat" required placeholder="cth: hendra_rm">
            </div>

            <div class="form-group-neat">
                <label class="form-label-neat">Nama Lengkap / PT Developer <span class="req">*</span></label>
                <input type="text" name="name" class="form-control-neat" required placeholder="cth: Hendra Gunawan, S.E. / PT. Ciputra">
            </div>

            <div class="form-group-neat">
                <label class="form-label-neat">Password <span class="req">*</span></label>
                <input type="password" name="password" class="form-control-neat" required placeholder="Masukkan password akun">
            </div>

            <div class="form-group-neat">
                <label class="form-label-neat">Role / Jabatan Pegawai <span class="req">*</span></label>
                <select name="role" class="form-control-neat" required>
                    <option value="SO">SO (Sales Officer)</option>
                    <option value="RM">RM (Relationship Manager)</option>
                    <option value="CBM">CBM (Consumer Business Manager)</option>
                    <option value="ADK">ADK (Administrasi Kredit)</option>
                    <option value="Developer Perumahan">Developer Perumahan (Monitoring)</option>
                    <option value="Super Admin">Super Admin</option>
                </select>
            </div>

            <!-- FOOTER ACTIONS (TANPA KATA MARIADB) -->
            <div class="modal-footer-actions">
                <button type="button" class="btn-modal-cancel" onclick="document.getElementById('registerUserModal').style.display='none'">Batal</button>
                <button type="submit" class="btn-modal-save">
                    Daftarkan Akun Baru
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
const PAGE_SIZE = 10;
let tablePages = {
    table1: 1,
    table2: 1
};

function openAddModal() {
    document.getElementById('addKprModal').style.display = 'flex';
}

function closeAddModal() {
    document.getElementById('addKprModal').style.display = 'none';
}

function openEditModal(item) {
    document.getElementById('editKprForm').action = '/kpr/' + item.id + '/update';
    document.getElementById('edit_nama_debitur').value = item.nama_debitur;
    document.getElementById('edit_nama_developer').value = item.nama_developer;
    document.getElementById('edit_jenis_kpr').value = item.jenis_kpr;
    document.getElementById('edit_plafon_kredit').value = item.plafon_kredit;
    document.getElementById('edit_unit_block').value = item.unit_block;
    document.getElementById('edit_nomor_rekening').value = item.nomor_rekening || '';
    if (document.getElementById('edit_nama_rm_penanggung_jawab')) {
        document.getElementById('edit_nama_rm_penanggung_jawab').value = item.nama_rm_penanggung_jawab || 'Rina Wijaya, S.E.';
    }
    if (document.getElementById('edit_status')) {
        let statusVal = item.status;
        if (statusVal === 'Input Nomor Rekening Pinjaman') statusVal = 'Selesai';
        document.getElementById('edit_status').value = statusVal;
    }

    updatePlafonPreview('edit');
    document.getElementById('editKprModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editKprModal').style.display = 'none';
}

function toggleCustomDeveloper(type) {
    const select = document.getElementById(type + '_nama_developer');
    const wrapper = document.getElementById(type + '_custom_dev_wrapper');
    const input = document.getElementById(type + '_custom_dev_input');

    if (select.value === 'OTHER') {
        wrapper.style.display = 'block';
        input.required = true;
        input.focus();
    } else {
        wrapper.style.display = 'none';
        input.required = false;
    }
}

function updatePlafonPreview(type) {
    const input = document.getElementById(type + '_plafon_kredit');
    const preview = document.getElementById(type + '_plafon_preview');
    const val = parseFloat(input.value);

    if (!isNaN(val) && val > 0) {
        preview.style.display = 'inline-block';
        preview.textContent = 'Preview: Rp ' + val.toLocaleString('id-ID');
    } else {
        preview.style.display = 'none';
    }
}

function filterTable(tableId, inputId) {
    tablePages[tableId] = 1;
    renderPaginatedTable(tableId, inputId);
}

function renderPaginatedTable(tableId, inputId) {
    const table = document.getElementById(tableId);
    if (!table) return;

    const filter = (document.getElementById(inputId)?.value || '').toLowerCase();
    const tbody = table.getElementsByTagName('tbody')[0];
    if (!tbody) return;

    const rows = Array.from(tbody.querySelectorAll('tr'));
    const matchingRows = rows.filter(tr => {
        if (tr.cells.length <= 1) return true; // empty message row
        return tr.textContent.toLowerCase().indexOf(filter) > -1;
    });

    const total = matchingRows.length;
    const page = tablePages[tableId] || 1;
    const totalPages = Math.ceil(total / PAGE_SIZE) || 1;
    const startIdx = (page - 1) * PAGE_SIZE;
    const endIdx = startIdx + PAGE_SIZE;

    rows.forEach(tr => tr.style.display = 'none');

    matchingRows.slice(startIdx, endIdx).forEach(tr => tr.style.display = '');

    // Update Pagination UI
    const bar = document.getElementById(tableId + 'PaginationBar');
    const info = document.getElementById(tableId + 'PaginationInfo');
    const controls = document.getElementById(tableId + 'PaginationControls');

    if (bar && info && controls) {
        const fromItem = total > 0 ? startIdx + 1 : 0;
        const toItem = Math.min(endIdx, total);
        info.textContent = `Menampilkan ${fromItem} - ${toItem} dari ${total} Berkas`;

        let ctrlHtml = '';
        ctrlHtml += `<button class="btn-page" ${page === 1 ? 'disabled' : ''} onclick="changePage('${tableId}', '${inputId}', ${page - 1})">« Prev</button>`;

        for (let p = 1; p <= totalPages; p++) {
            ctrlHtml += `<button class="btn-page ${p === page ? 'active' : ''}" onclick="changePage('${tableId}', '${inputId}', ${p})">${p}</button>`;
        }

        ctrlHtml += `<button class="btn-page" ${page === totalPages ? 'disabled' : ''} onclick="changePage('${tableId}', '${inputId}', ${page + 1})">Next »</button>`;
        controls.innerHTML = ctrlHtml;
    }
}

function changePage(tableId, inputId, pageNum) {
    tablePages[tableId] = pageNum;
    renderPaginatedTable(tableId, inputId);
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('table1')) {
        renderPaginatedTable('table1', 'searchTable1');
    }
    if (document.getElementById('table2')) {
        renderPaginatedTable('table2', 'searchTable2');
    }
});
</script>
@endsection
