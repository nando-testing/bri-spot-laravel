<?php

namespace App\Http\Controllers;

use App\Models\LwDebitur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LwDebiturController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk mengakses Master Debitur.');
        }

        $user = Auth::user();
        $activeRole = $user->role ?? 'SO';

        // Query master debitur dari Excel
        $debiturList = LwDebitur::orderBy('id', 'asc')->get();

        return view('debitur.index', compact('user', 'activeRole', 'debiturList'));
    }

    public function show($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $activeRole = $user->role ?? 'SO';
        $debitur = LwDebitur::findOrFail($id);

        return view('debitur.show', compact('user', 'activeRole', 'debitur'));
    }
}
