@extends('layouts.app')

@section('title', 'Login - BRI SPOT KPR Portal')

@section('styles')
<style>
    .login-wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 0;
    }

    .login-card {
        width: 100%;
        max-width: 440px;
        background: #FFFFFF;
        border-radius: 16px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 10px 30px rgba(0, 82, 156, 0.12);
        padding: 2.25rem;
    }

    .login-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .login-brand-badge {
        display: inline-block;
        background: #00529C;
        color: white;
        font-size: 1.5rem;
        font-weight: 900;
        padding: 0.4rem 1.25rem;
        border-radius: 8px;
        letter-spacing: 0.1em;
        margin-bottom: 0.75rem;
    }

    .login-header h2 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0F172A;
    }

    .login-header p {
        font-size: 0.8rem;
        color: #64748B;
        margin-top: 0.25rem;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.4rem;
    }

    .form-input {
        width: 100%;
        padding: 0.65rem 0.85rem;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 0.85rem;
        font-family: inherit;
        outline: none;
        transition: all 0.2s;
    }

    .form-input:focus {
        border-color: #00529C;
        box-shadow: 0 0 0 3px rgba(0, 82, 156, 0.12);
    }

    .btn-submit {
        width: 100%;
        padding: 0.75rem;
        background: linear-gradient(135deg, #00529C 0%, #003B73 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.88rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-submit:hover {
        opacity: 0.95;
        transform: translateY(-1px);
    }

    .demo-buttons-title {
        font-size: 0.72rem;
        font-weight: 800;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 1.75rem;
        margin-bottom: 0.75rem;
        text-align: center;
    }

    .demo-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
    }

    .btn-demo {
        padding: 0.45rem;
        background: #F1F5F9;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        font-size: 0.73rem;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
        text-align: left;
        transition: all 0.2s;
    }

    .btn-demo:hover {
        background: #E0F2FE;
        border-color: #BAE6FD;
        color: #00529C;
    }

    .demo-role {
        display: block;
        font-size: 0.65rem;
        color: #64748B;
        font-weight: 600;
    }
</style>
@section('content')
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-header">
            <div class="login-brand-badge">BRI</div>
            <h2>BRI SPOT KPR Portal</h2>
            <p>Sistem Manajemen & Monitoring Alur Berkas KPR (MariaDB)</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Username / NIP Pegawai</label>
                <input type="text" id="username_input" name="username" class="form-input" placeholder="Masukkan username (cth: rina_rm)" required autofocus>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" id="password_input" name="password" class="form-input" placeholder="Masukkan password" value="123456" required>
            </div>

            <button type="submit" class="btn-submit">Masuk Ke Portal</button>
        </form>

        <div class="demo-buttons-title">— Pilihan Akun Demo (Klik Langsung) —</div>

        <div class="demo-grid">
            <button class="btn-demo" onclick="fillLogin('budi_so')">
                <strong>budi_so</strong>
                <span class="demo-role">Sales Officer (SO)</span>
            </button>
            <button class="btn-demo" onclick="fillLogin('rina_rm')">
                <strong>rina_rm</strong>
                <span class="demo-role">RM Penanggung Jawab</span>
            </button>
            <button class="btn-demo" onclick="fillLogin('ciputra_dev')">
                <strong>ciputra_dev</strong>
                <span class="demo-role">Developer Perumahan</span>
            </button>
            <button class="btn-demo" onclick="fillLogin('admin')">
                <strong>admin</strong>
                <span class="demo-role">Super Admin BRI</span>
            </button>
        </div>
    </div>
</div>

<script>
function fillLogin(username) {
    document.getElementById('username_input').value = username;
    document.getElementById('password_input').value = '123456';
}
</script>
@endsection
