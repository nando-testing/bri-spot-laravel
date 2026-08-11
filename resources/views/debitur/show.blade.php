@extends('layouts.app')

@section('title', 'Detail Debitur - ' . $debitur->nama_debitur . ' - Digital Flow')

@section('styles')
<style>
    .page-nav-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .btn-back {
        background: #FFFFFF;
        color: #00529C;
        border: 1px solid #CBD5E1;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .btn-back:hover {
        background: #F1F5F9;
        color: #003B73;
        border-color: #00529C;
    }

    .debitur-header-card {
        background: linear-gradient(135deg, #00529C 0%, #003B73 100%);
        color: white;
        border-radius: 16px;
        padding: 1.5rem 1.75rem;
        margin-bottom: 1.75rem;
        box-shadow: 0 6px 20px rgba(0, 82, 156, 0.25);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .debitur-title h2 {
        font-size: 1.4rem;
        font-weight: 800;
    }

    .debitur-title p {
        font-size: 0.82rem;
        opacity: 0.9;
        margin-top: 0.25rem;
    }

    .badge-rekening {
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
        padding: 0.45rem 0.9rem;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.25);
        font-family: 'JetBrains Mono', monospace;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .section-card {
        background: #FFFFFF;
        border-radius: 14px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .section-title-bar {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.95rem;
        font-weight: 800;
        color: #00529C;
        padding-bottom: 0.65rem;
        border-bottom: 2px solid #F1F5F9;
        margin-bottom: 1.15rem;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1rem;
    }

    .detail-item {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        padding: 0.75rem 0.9rem;
        border-radius: 10px;
    }

    .detail-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .detail-val {
        font-size: 0.88rem;
        font-weight: 800;
        color: #0F172A;
        word-break: break-word;
    }

    .kol-badge-large {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 800;
        display: inline-block;
    }
    .kol-1 { background: #ECFDF5; color: #065F46; border: 1px solid #A7F3D0; }
    .kol-2 { background: #FEF3C7; color: #92400E; border: 1px solid #FDE68A; }
    .kol-3 { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }
</style>
@section('content')

<!-- BAR NAVIGASI KEMBALI -->
<div class="page-nav-bar">
    <a href="{{ route('debitur.index') }}" class="btn-back">
        ← Kembali ke Master Data LW Debitur
    </a>
    <div style="font-size: 0.78rem; color: #64748B; font-weight: 600;">
        Tampilan Detail Halaman Terpisah (Read-Only)
    </div>
</div>

<!-- HEADER CARD DEBITUR -->
<div class="debitur-header-card">
    <div class="debitur-title">
        <h2>{{ $debitur->nama_debitur }}</h2>
        <p>Unit Kerja: {{ $debitur->kanca }} ({{ $debitur->kode_kanca }}) — {{ $debitur->description ?: 'Kredit Konsumtif KPR' }}</p>
    </div>
    <div>
        <div class="badge-rekening">
            No. Rek: {{ $debitur->nomor_rekening }}
        </div>
    </div>
</div>

<!-- SEKSI 1: INFORMASI WILAYAH & UNIT KERJA -->
<div class="section-card">
    <div class="section-title-bar">
        🏢 1. Informasi Wilayah & Unit Kerja (Kanwil / Kanca / Uker)
    </div>
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">PERIODE</div>
            <div class="detail-val">{{ $debitur->periode ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">KANWIL & KODE</div>
            <div class="detail-val">{{ $debitur->kode_kanwil }} - {{ $debitur->kanwil ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">KANCA & KODE</div>
            <div class="detail-val">{{ $debitur->kode_kanca }} - {{ $debitur->kanca ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">UKER & KODE</div>
            <div class="detail-val">{{ $debitur->kode_uker }} - {{ $debitur->uker ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">CURRENCY</div>
            <div class="detail-val">{{ $debitur->currency ?: 'IDR' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">CIFNO</div>
            <div class="detail-val" style="font-family: monospace;">{{ $debitur->cifno ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">SEGMEN LV1 & DESC</div>
            <div class="detail-val">{{ $debitur->segmen_lv1 }} - {{ $debitur->desc_segmen_lv1 ?: '-' }}</div>
        </div>
    </div>
</div>

<!-- SEKSI 2: IDENTITAS DEBITUR & REKENING -->
<div class="section-card">
    <div class="section-title-bar">
        👤 2. Identitas Debitur & Jenis Pinjaman
    </div>
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">NAMA DEBITUR</div>
            <div class="detail-val">{{ $debitur->nama_debitur }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">NOMOR REKENING</div>
            <div class="detail-val" style="font-family: monospace; color:#00529C;">{{ $debitur->nomor_rekening }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">LN TYPE</div>
            <div class="detail-val">{{ $debitur->ln_type ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">KODE & DESKRIPSI KREDIT</div>
            <div class="detail-val">{{ $debitur->code }} - {{ $debitur->description ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">FLAG RESTRUK</div>
            <div class="detail-val">{{ $debitur->flag_restruk ?: '-' }}</div>
        </div>
    </div>
</div>

<!-- SEKSI 3: PLAFON, SALDO BAKI DEBET & KEUANGAN -->
<div class="section-card">
    <div class="section-title-bar">
        💰 3. Ketentuan Plafon Kredit, Saldo Baki Debet & Suku Bunga
    </div>
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">PLAFON KREDIT (M)</div>
            <div class="detail-val" style="color: #10B981; font-family: monospace;">
                Rp {{ number_format($debitur->plafon, 0, ',', '.') }}
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">PLAFON DALAM IDR (AV)</div>
            <div class="detail-val" style="color: #10B981; font-family: monospace;">
                Rp {{ number_format($debitur->plafon_dalam_idr, 0, ',', '.') }}
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">BALANCE / BAKI DEBET (AW)</div>
            <div class="detail-val" style="color: #00529C; font-family: monospace;">
                Rp {{ number_format($debitur->balance_dalam_idr, 0, ',', '.') }}
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">RATE SUKU BUNGA (%)</div>
            <div class="detail-val" style="font-family: monospace;">
                {{ number_format($debitur->rate, 2) }}%
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">TANGGAL REALISASI (R)</div>
            <div class="detail-val" style="font-family: monospace;">{{ $debitur->tgl_realisasi ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">TANGGAL JATUH TEMPO (S)</div>
            <div class="detail-val" style="font-family: monospace;">{{ $debitur->tgl_jatuh_tempo ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">JANGKA WAKTU (T)</div>
            <div class="detail-val" style="font-family: monospace;">{{ $debitur->jangka_waktu ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">NEXT PAYMENT DATE (N)</div>
            <div class="detail-val" style="font-family: monospace;">{{ $debitur->next_pmt_date ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">NEXT INT PAYMENT DATE (O)</div>
            <div class="detail-val" style="font-family: monospace;">{{ $debitur->next_int_pmt_date ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">FREQ PAYMENT (AE)</div>
            <div class="detail-val">{{ $debitur->freq_payment ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">FREQ INT PAYMENT (AF)</div>
            <div class="detail-val">{{ $debitur->freq_int_payment ?: '-' }}</div>
        </div>
    </div>
</div>

<!-- SEKSI 4: KOLEKTABILITAS & TUNGGAKAN -->
<div class="section-card">
    <div class="section-title-bar">
        📊 4. Status Kolektabilitas ADK & Rincian Tunggakan
    </div>
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">KOL ADK (AK)</div>
            <div class="detail-val">
                <span class="kol-badge-large {{ $debitur->kol_adk == '1' ? 'kol-1' : ($debitur->kol_adk == '2' ? 'kol-2' : 'kol-3') }}">
                    Kolektabilitas {{ $debitur->kol_adk }}
                </span>
            </div>
        </div>
        <div class="detail-item">
            <div class="detail-label">KOLEKTABILITAS LANCAR (W)</div>
            <div class="detail-val" style="font-family: monospace;">Rp {{ number_format($debitur->kolektabilitas_lancar, 0, ',', '.') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">KOLEKTABILITAS DPK (X)</div>
            <div class="detail-val" style="font-family: monospace;">Rp {{ number_format($debitur->kolektabilitas_dpk, 0, ',', '.') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">KOLEKTABILITAS KURANG LANCAR (Y)</div>
            <div class="detail-val" style="font-family: monospace;">Rp {{ number_format($debitur->kolektabilitas_kurang_lancar, 0, ',', '.') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">KOLEKTABILITAS DIRAGUKAN (Z)</div>
            <div class="detail-val" style="font-family: monospace;">Rp {{ number_format($debitur->kolektabilitas_diragukan, 0, ',', '.') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">KOLEKTABILITAS MACET (AA)</div>
            <div class="detail-val" style="font-family: monospace;">Rp {{ number_format($debitur->kolektabilitas_macet, 0, ',', '.') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">TUNGGAKAN POKOK (AB)</div>
            <div class="detail-val" style="font-family: monospace; color:#EF4444;">Rp {{ number_format($debitur->tunggakan_pokok, 0, ',', '.') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">TUNGGAKAN BUNGA (AC)</div>
            <div class="detail-val" style="font-family: monospace; color:#EF4444;">Rp {{ number_format($debitur->tunggakan_bunga, 0, ',', '.') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">TUNGGAKAN PINALTI (AD)</div>
            <div class="detail-val" style="font-family: monospace; color:#EF4444;">Rp {{ number_format($debitur->tunggakan_pinalti, 0, ',', '.') }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">TGL MENUNGGAK (Q)</div>
            <div class="detail-val" style="font-family: monospace;">{{ $debitur->tgl_menunggak ?: '-' }}</div>
        </div>
    </div>
</div>

<!-- SEKSI 5: PEGAWAI & OFFICER PENANGGUNG JAWAB (PN) -->
<div class="section-card">
    <div class="section-title-bar">
        👨‍💼 5. Pegawai & Officer Penanggung Jawab (PN List)
    </div>
    <div class="detail-grid">
        <div class="detail-item">
            <div class="detail-label">PN PENGELOLA SINGLEPN (AL)</div>
            <div class="detail-val">{{ $debitur->pn_pengelola_singlepn ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">PN PENGELOLA 1 (AM)</div>
            <div class="detail-val">{{ $debitur->pn_pengelola_1 ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">PN PENGELOLA 2 (AQ)</div>
            <div class="detail-val">{{ $debitur->pn_pengelola_2 ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">PN PEMRAKARSA (AN)</div>
            <div class="detail-val">{{ $debitur->pn_pemrakarsa ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">PN PEMUTUS (AR)</div>
            <div class="detail-val">{{ $debitur->pn_pemutus ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">PN REFERRAL (AO)</div>
            <div class="detail-val">{{ $debitur->pn_referral ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">PN RESTRUK (AP)</div>
            <div class="detail-val">{{ $debitur->pn_restruk ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">PN CRM (AS)</div>
            <div class="detail-val">{{ $debitur->pn_crm ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">PN RM REFERRAL NAIK SEGMENTASI (AT)</div>
            <div class="detail-val">{{ $debitur->pn_rm_referral_naik_segmentasi ?: '-' }}</div>
        </div>
        <div class="detail-item">
            <div class="detail-label">PN RM CRR (AU)</div>
            <div class="detail-val">{{ $debitur->pn_rm_crr ?: '-' }}</div>
        </div>
    </div>
</div>

@endsection
