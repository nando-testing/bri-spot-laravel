<?php

namespace App\Http\Controllers;

use App\Models\KprRecord;
use App\Models\Developer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class KprController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk mengakses Portal BRI SPOT KPR.');
        }

        $user = Auth::user();
        $activeRole = $user->role ?? 'SO';
        $currentUserName = $user->name ?? '';

        $allKprList = KprRecord::orderBy('id', 'desc')->get();
        $developers = Developer::orderBy('nama_developer', 'asc')->pluck('nama_developer')->toArray();

        // 1. Filter Tabel 1 (Tugas Role Aktif Sesuai Alur Jabatan)
        $table1Raw = $allKprList->filter(function ($item) use ($activeRole, $user) {
            if ($activeRole === 'Developer Perumahan') return false; // Developer hanya mode monitoring di Tabel 2
            if ($activeRole === 'Super Admin') return true;

            if ($activeRole === 'SO') {
                // SO mengelola berkas tahap registrasi & persiapan pengiriman ke RM
                return in_array($item->status, ['Collect Data', 'Proses RM']);
            }

            if ($activeRole === 'RM') {
                // RM HANYA mengelola berkas yang EKSKLUSIF di bawah namanya
                return $item->isAssignedToRm($user);
            }

            if ($activeRole === 'CBM') {
                // CBM mengelola berkas yang disetujui RM untuk verifikasi
                return in_array($item->status, ['Proses RM Diterima', 'Verifikasi CBM']);
            }

            if ($activeRole === 'ADK') {
                // ADK mengelola berkas tahap verifikasi CBM, proses akad, & input nomor rekening
                return in_array($item->status, ['Verifikasi CBM', 'Proses Akad ADK', 'Input Nomor Rekening Pinjaman']);
            }

            return true;
        });

        // 2. Filter Tabel 2 (Real Master Data KPR - Filtering Khusus Developer)
        $table2Raw = $allKprList->filter(function ($item) use ($activeRole, $currentUserName) {
            if ($activeRole === 'Developer Perumahan') {
                $devUser = strtolower(trim($currentUserName));
                $itemDev = strtolower(trim($item->nama_developer ?? ''));

                $cleanUserDev = trim(preg_replace('/\(.*\)/', '', preg_replace('/^pt\.?\s*/i', '', $devUser)));
                $cleanItemDev = trim(preg_replace('/^pt\.?\s*/i', '', $itemDev));

                $matchesDev = $cleanUserDev && (
                    str_contains($cleanItemDev, $cleanUserDev) ||
                    str_contains($cleanUserDev, $cleanItemDev)
                );

                if (!$matchesDev) return false;
            }

            return true;
        });

        return view('kpr.index', compact(
            'user',
            'activeRole',
            'allKprList',
            'table1Raw',
            'table2Raw',
            'developers'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $activeRole = $user->role ?? 'SO';

        if ($activeRole === 'Developer Perumahan') {
            return back()->with('error', 'Role Developer Perumahan hanya memiliki akses monitoring (Read-Only).');
        }

        $request->validate([
            'nama_debitur' => 'required|string|max:100',
            'unit_block' => 'required|string|max:100',
            'nama_developer' => 'required|string|max:100',
            'plafon_kredit' => 'required|numeric|min:0',
            'jenis_kpr' => 'required|in:KPR,KPRS',
        ]);

        $tanggal = $request->tanggal ?: date('d/m/Y');
        $namaPetugas = $user->name;
        $jabatanPetugas = $user->role === 'Super Admin' ? 'SO' : $user->role;

        $namaRmPenanggungJawab = $request->nama_rm_penanggung_jawab;
        if ($user->role === 'RM') {
            $namaRmPenanggungJawab = $user->name;
        }

        if ($request->nama_developer === 'OTHER' && $request->custom_developer_name) {
            $customDev = trim($request->custom_developer_name);
            Developer::firstOrCreate(['nama_developer' => $customDev]);
            $finalDev = $customDev;
        } else {
            $finalDev = $request->nama_developer;
        }

        $initialStatus = ($user->role === 'RM') ? 'Proses RM' : 'Collect Data';

        KprRecord::create([
            'tanggal' => $tanggal,
            'jabatan_petugas' => $jabatanPetugas,
            'nama_petugas' => $namaPetugas,
            'nama_rm_penanggung_jawab' => $namaRmPenanggungJawab ?: $user->name,
            'nama_developer' => $finalDev,
            'nama_debitur' => trim($request->nama_debitur),
            'jenis_kpr' => $request->jenis_kpr,
            'plafon_kredit' => $request->plafon_kredit,
            'unit_block' => trim($request->unit_block),
            'status' => $initialStatus,
            'nomor_rekening' => $request->nomor_rekening ?: '',
        ]);

        return back()->with('success', "Berkas KPR baru a.n {$request->nama_debitur} berhasil diregister ke MariaDB!");
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $kpr = KprRecord::findOrFail($id);

        // Validasi Hak Akses Edit Berdasarkan Role
        if (!$kpr->canEdit($user)) {
            return back()->with('error', $kpr->getRestrictionReason($user));
        }

        $request->validate([
            'nama_debitur' => 'required|string|max:100',
            'unit_block' => 'required|string|max:100',
            'nama_developer' => 'required|string|max:100',
            'plafon_kredit' => 'required|numeric|min:0',
            'jenis_kpr' => 'required|in:KPR,KPRS',
        ]);

        if ($request->nama_developer === 'OTHER' && $request->custom_developer_name) {
            $customDev = trim($request->custom_developer_name);
            Developer::firstOrCreate(['nama_developer' => $customDev]);
            $finalDev = $customDev;
        } else {
            $finalDev = $request->nama_developer;
        }

        $kpr->update([
            'nama_debitur' => trim($request->nama_debitur),
            'nama_developer' => $finalDev,
            'jenis_kpr' => $request->jenis_kpr,
            'plafon_kredit' => $request->plafon_kredit,
            'unit_block' => trim($request->unit_block),
            'nama_rm_penanggung_jawab' => $request->nama_rm_penanggung_jawab ?: $kpr->nama_rm_penanggung_jawab,
            'status' => $request->status ?: $kpr->status,
            'nomor_rekening' => $request->nomor_rekening ?: $kpr->nomor_rekening,
        ]);

        return back()->with('success', "Data berkas KPR a.n {$kpr->nama_debitur} berhasil diperbarui!");
    }

    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        $kpr = KprRecord::findOrFail($id);

        // Validasi Hak Akses Edit Status Berdasarkan Role
        if (!$kpr->canEdit($user)) {
            return back()->with('error', $kpr->getRestrictionReason($user));
        }

        $request->validate([
            'status' => 'required|string',
        ]);

        $kpr->update([
            'status' => $request->status,
        ]);

        return back()->with('success', "Status berkas KPR a.n {$kpr->nama_debitur} berhasil diperbarui ke '{$request->status}'!");
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $kpr = KprRecord::findOrFail($id);

        // Validasi Hak Akses Hapus Berdasarkan Role
        if (!$kpr->canDelete($user)) {
            return back()->with('error', $kpr->getRestrictionReason($user));
        }

        $kpr->delete();

        return back()->with('info', "Berkas KPR a.n {$kpr->nama_debitur} telah dihapus dari Database.");
    }

    public function exportCsv()
    {
        $records = KprRecord::orderBy('id', 'desc')->get();
        $filename = "Master_Data_KPR_" . date('Y-m-d') . ".csv";

        $handle = fopen('php://output', 'w');
        fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM for Excel UTF-8

        fputcsv($handle, [
            'Tanggal Input', 'Petugas Input', 'RM Penanggung Jawab', 'Nama Developer',
            'Nama Debitur', 'Jenis KPR', 'Plafon Kredit (Rp)', 'Blok & Unit',
            'Status KPR', 'No Rekening'
        ]);

        foreach ($records as $r) {
            fputcsv($handle, [
                $r->tanggal,
                "{$r->nama_petugas} ({$r->jabatan_petugas})",
                $r->nama_rm_penanggung_jawab ?: '-',
                $r->nama_developer,
                $r->nama_debitur,
                $r->jenis_kpr,
                $r->plafon_kredit,
                $r->unit_block,
                $r->status,
                $r->nomor_rekening ?: '-'
            ]);
        }

        fclose($handle);

        return Response::make('', 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
