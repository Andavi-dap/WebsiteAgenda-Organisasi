<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin Agenda</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:
radial-gradient(circle at 20% 20%,rgba(96,165,250,.40),transparent 40%),
radial-gradient(circle at 80% 10%,rgba(59,130,246,.28),transparent 40%),
linear-gradient(135deg,#e0f2fe,#f8fafc);
display:flex;
min-height:100vh;
color:#1e293b;
overflow-x:hidden;
}

.sidebar{
width:250px;
padding:25px;
background:rgba(255,255,255,.55);
backdrop-filter:blur(24px);
flex-shrink:0;
}

.logo{
display:flex;
justify-content:center;
margin-bottom:35px;
}

.logo img{
width:190px;
max-width:100%;
filter:drop-shadow(0 8px 18px rgba(59,130,246,.25));
transition:.3s;
}

.logo img:hover{transform:scale(1.04);}

.menu a{
display:flex;
align-items:center;
gap:12px;
padding:13px 14px;
margin:8px 0;
border-radius:14px;
text-decoration:none;
color:#1e3a8a;
background:rgba(255,255,255,.45);
font-weight:600;
transition:.3s;
position:relative;
overflow:hidden;
}

.menu a:hover{
background:linear-gradient(135deg,#3b82f6,#60a5fa);
color:#fff;
transform:translateX(6px);
box-shadow:0 10px 20px rgba(59,130,246,.18);
}

.menu a.active{
background:linear-gradient(135deg,#2563eb,#3b82f6);
color:#fff;
box-shadow:0 14px 28px rgba(37,99,235,.22);
}

.side-icon{
width:18px;
height:18px;
stroke:#1e3a8a;
stroke-width:2.2;
flex-shrink:0;
}

.menu a:hover .side-icon,
.menu a.active .side-icon{stroke:#fff;}

.main{
flex:1;
padding:28px;
min-width:0;
}

.header-wrap{
display:grid;
grid-template-columns:1fr auto;
align-items:center;
gap:24px;
margin-bottom:28px;
}

.header-left{min-width:0;}

.header-left h1{
font-size:24px;
font-weight:800;
color:#0f172a;
margin:0 0 6px;
line-height:1.2;
}

.desc{
color:#64748b;
font-size:14px;
line-height:1.5;
}

.header-right{
display:flex;
align-items:center;
justify-content:flex-end;
gap:14px;
}

.add-btn,
.secondary-btn{
position:relative;
overflow:hidden;
text-decoration:none;
display:inline-flex;
align-items:center;
justify-content:center;
gap:8px;
padding:12px 18px;
border-radius:999px;
font-size:14px;
font-weight:700;
transition:.25s ease;
}

.add-btn{
color:#fff;
background:linear-gradient(135deg,#2563eb,#3b82f6);
box-shadow:0 12px 24px rgba(37,99,235,.24);
}

.add-btn:hover{
transform:translateY(-2px);
box-shadow:0 18px 30px rgba(37,99,235,.28);
}

.secondary-btn{
color:#1e3a8a;
background:rgba(255,255,255,.72);
box-shadow:0 10px 22px rgba(59,130,246,.10),inset 0 1px 0 rgba(255,255,255,.9);
}

.secondary-btn:hover{
transform:translateY(-2px);
box-shadow:0 14px 28px rgba(59,130,246,.18);
}

.profile{position:relative;}

.profile-box{
display:flex;
align-items:center;
gap:10px;
padding:8px 14px;
border-radius:18px;
background:rgba(255,255,255,.75);
cursor:pointer;
transition:.3s;
position:relative;
}

.profile-box:hover{
transform:translateY(-2px);
box-shadow:0 8px 18px rgba(59,130,246,.16);
}

.profile-box img{
width:42px;
height:42px;
border-radius:50%;
object-fit:cover;
border:2px solid #60a5fa;
}

.profile-box small{color:#64748b;}

.role-badge{
display:inline-block;
margin-top:2px;
padding:2px 8px;
border-radius:999px;
background:linear-gradient(135deg,#7c3aed,#6366f1);
color:#fff;
font-size:10px;
font-weight:700;
}

.dropdown{
display:none;
position:absolute;
right:0;
top:62px;
min-width:180px;
background:#fff;
border-radius:14px;
overflow:hidden;
box-shadow:0 18px 35px rgba(0,0,0,.12);
z-index:999;
animation:fadeDown .25s ease;
}

.dropdown a{
display:block;
padding:12px 15px;
text-decoration:none;
color:#1e293b;
font-size:14px;
}

.dropdown a:hover{background:#3b82f6;color:#fff;}

@keyframes fadeDown{
from{opacity:0;transform:translateY(-8px);}
to{opacity:1;transform:translateY(0);}
}

.flash{
padding:14px 18px;
border-radius:16px;
margin-bottom:20px;
font-weight:600;
}

.flash.success{
background:rgba(34,197,94,.12);
border:1px solid #22c55e;
color:#166534;
}

.flash.error{
background:rgba(239,68,68,.12);
border:1px solid #ef4444;
color:#991b1b;
}

.stats{
display:grid;
grid-template-columns:repeat(3,minmax(0,1fr));
gap:18px;
margin-bottom:25px;
}

.stat-card{
background:rgba(255,255,255,.35);
backdrop-filter:blur(12px);
border:1px solid rgba(255,255,255,.35);
border-radius:22px;
padding:20px 22px;
display:flex;
align-items:center;
gap:18px;
min-height:145px;
transition:.3s ease;
box-shadow:0 10px 20px rgba(0,0,0,.04);
}

.stat-card:hover{
transform:translateY(-6px);
box-shadow:0 18px 25px rgba(59,130,246,.12);
}

.icon-circle{
width:58px;
height:58px;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
color:#fff;
flex-shrink:0;
box-shadow:0 10px 18px rgba(0,0,0,.08);
}

.icon-circle svg{
width:28px;
height:28px;
stroke:#fff;
}

.blue{background:linear-gradient(135deg,#3b82f6,#60a5fa);}
.yellow{background:linear-gradient(135deg,#f59e0b,#fbbf24);}
.green{background:linear-gradient(135deg,#22c55e,#34d399);}

.stat-text h4{
font-size:14px;
font-weight:700;
color:#1e3a8a;
margin:0 0 10px;
}

.stat-text h2{
font-size:48px;
font-weight:800;
color:#0f172a;
margin:0 0 8px;
line-height:1;
}

.stat-text p{
font-size:13px;
color:#64748b;
font-weight:500;
}

.glass{
background:rgba(255,255,255,.68);
padding:20px;
border-radius:22px;
box-shadow:0 10px 20px rgba(0,0,0,.04);
}

.section-heading{
display:flex;
justify-content:space-between;
align-items:center;
gap:12px;
margin-bottom:15px;
}

.section-heading h2{
font-size:18px;
font-weight:700;
color:#0f172a;
}

.section-heading a{
color:#2563eb;
font-size:13px;
font-weight:700;
text-decoration:none;
}

.section-heading a:hover{text-decoration:underline;}

.row{
display:flex;
justify-content:space-between;
align-items:center;
gap:16px;
padding:14px;
margin-bottom:12px;
border-radius:14px;
background:rgba(255,255,255,.85);
transition:.3s;
position:relative;
overflow:hidden;
}

.row:last-child{margin-bottom:0;}

.row:hover{
transform:translateY(-3px);
box-shadow:0 10px 18px rgba(0,0,0,.05);
}

.row.akan{border-left:4px solid #f59e0b;}
.row.selesai{border-left:4px solid #22c55e;}

.activity-info{min-width:0;}
.activity-info strong{font-size:14px;color:#0f172a;}
.activity-info small{color:#64748b;font-size:12px;}
.divisi{margin-top:7px;}

.activity-actions{
display:flex;
align-items:center;
justify-content:flex-end;
gap:10px;
flex-shrink:0;
}

.status-badge{
display:inline-flex;
align-items:center;
padding:8px 14px;
border-radius:999px;
font-size:12px;
font-weight:700;
color:#fff;
transition:.3s;
}

.status-badge:hover{transform:translateY(-2px) scale(1.05);}
.status-akan{background:linear-gradient(135deg,#f59e0b,#fbbf24);box-shadow:0 8px 18px rgba(245,158,11,.35);}
.status-selesai{background:linear-gradient(135deg,#22c55e,#4ade80);box-shadow:0 8px 18px rgba(34,197,94,.35);}

.row-actions{
display:flex;
align-items:center;
gap:8px;
}

.action-btn{
display:inline-flex;
align-items:center;
justify-content:center;
min-height:36px;
padding:8px 13px;
border:0;
border-radius:999px;
color:#fff;
font-family:'Poppins',sans-serif;
font-size:12px;
font-weight:700;
text-decoration:none;
cursor:pointer;
transition:.25s ease;
}

.action-btn:hover{
transform:translateY(-2px);
box-shadow:0 8px 16px rgba(0,0,0,.16);
}

.action-edit{background:linear-gradient(135deg,#2563eb,#60a5fa);}
.action-delete{background:linear-gradient(135deg,#ef4444,#f87171);}
.empty{padding:18px 0;color:#64748b;font-size:14px;}

.ripple{
position:absolute;
border-radius:50%;
background:rgba(59,130,246,.35);
transform:scale(0);
animation:ripple .6s linear;
pointer-events:none;
}

@keyframes ripple{
to{transform:scale(4);opacity:0;}
}

@media(max-width:1200px){
.stats{grid-template-columns:repeat(2,minmax(0,1fr));}
}

@media(max-width:1050px){
.header-wrap{grid-template-columns:1fr;}
.header-right{justify-content:flex-start;flex-wrap:wrap;}
}

@media(max-width:900px){
.activity-actions{align-items:flex-end;flex-direction:column;}
}

@media(max-width:768px){
body{flex-direction:column;}
.sidebar{width:100%;}
.main{padding:22px;}
.stats{grid-template-columns:1fr;}
}

@media(max-width:560px){
.row{align-items:flex-start;flex-direction:column;}
.activity-actions{width:100%;align-items:flex-start;flex-direction:row;flex-wrap:wrap;}
.profile-box{padding:7px 10px;}
.profile-box img{width:36px;height:36px;}
}
</style>
</head>

<body>
<aside class="sidebar">
    <div class="logo">
        <img src="{{ asset('logo/logo.png') }}" alt="Logo HIMEDIAJKT">
    </div>

    <nav class="menu" aria-label="Navigasi utama">
        <a href="{{ route('kegiatan.index') }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none">
                <path d="M3 10.5L12 3l9 7.5"/>
                <path d="M5 9.5V20h14V9.5"/>
            </svg>
            Dashboard Kegiatan
        </a>
        <a href="{{ route('admin.dashboard') }}" class="active" aria-current="page">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="3" width="8" height="8" rx="1"/>
                <rect x="13" y="3" width="8" height="5" rx="1"/>
                <rect x="13" y="10" width="8" height="11" rx="1"/>
                <rect x="3" y="13" width="8" height="8" rx="1"/>
            </svg>
            Dashboard Admin
        </a>
        <a href="{{ route('kegiatan.kalender') }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none">
                <rect x="3" y="5" width="18" height="16" rx="2"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Kalender
        </a>
        <a href="{{ route('kegiatan.akan') }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 7v5l3 2"/>
            </svg>
            Akan Datang
        </a>
        <a href="{{ route('kegiatan.selesai') }}">
            <svg class="side-icon" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="9"/>
                <path d="M8.5 12.5l2.2 2.2L16 9"/>
            </svg>
            Selesai
        </a>
    </nav>
</aside>

<main class="main">
    @if(session('success'))
        <div class="flash success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash error">{{ session('error') }}</div>
    @endif

    <header class="header-wrap">
        <div class="header-left">
            <h1>Halo, {{ session('user.nama') }} 👋</h1>
            <p class="desc">Kelola dan pantau seluruh agenda kegiatan himpunan.</p>
        </div>
        <div class="header-right">
            <a href="{{ route('kegiatan.create') }}" class="add-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                    <path d="M12 5v14M5 12h14" stroke-linecap="round"/>
                </svg>
                Tambah Agenda
            </a>
            <a href="{{ route('kegiatan.index') }}" class="secondary-btn">Lihat Dashboard</a>
            <div class="profile">
                <div class="profile-box" onclick="toggleProfile()">
                    <img src="{{ asset('foto/'.session('user.foto')) }}" alt="Foto {{ session('user.nama') }}">
                    <div>
                        <b>{{ session('user.nama') }}</b><br>
                        <small>{{ session('user.jabatan') }}</small><br>
                        <span class="role-badge">Admin</span>
                    </div>
                </div>
                <div id="dropdown" class="dropdown">
                    <a href="{{ route('profile.view') }}">Lihat Profil</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:inherit; cursor:pointer; font:inherit; padding:0;">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <section class="stats" aria-label="Ringkasan agenda">
        <article class="stat-card">
            <div class="icon-circle blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="8" y1="3" x2="8" y2="7"/>
                    <line x1="16" y1="3" x2="16" y2="7"/>
                </svg>
            </div>
            <div class="stat-text">
                <h4>Total Kegiatan</h4>
                <h2>{{ $total }}</h2>
                <p>Semua waktu</p>
            </div>
        </article>
        <article class="stat-card">
            <div class="icon-circle yellow">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 7v5l3 2"/>
                </svg>
            </div>
            <div class="stat-text">
                <h4>Akan Datang</h4>
                <h2>{{ $akanDatang }}</h2>
                <p>Belum dilaksanakan</p>
            </div>
        </article>
        <article class="stat-card">
            <div class="icon-circle green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M8.5 12.5l2.2 2.2L16 9"/>
                </svg>
            </div>
            <div class="stat-text">
                <h4>Selesai</h4>
                <h2>{{ $selesai }}</h2>
                <p>Telah dilaksanakan</p>
            </div>
        </article>
    </section>

    <section class="glass">
        <div class="section-heading">
            <h2>Kelola Agenda</h2>
            <a href="{{ route('kegiatan.semua') }}">Lihat Semua Agenda</a>
        </div>

        @forelse($data as $item)
            <article class="row {{ $item->status === 'selesai' ? 'selesai' : 'akan' }}">
                <div class="activity-info">
                    <strong>{{ $item->nama_kegiatan }}</strong><br>
                    <small>{{ $item->tanggal }} | {{ $item->waktu }} | {{ $item->lokasi }}</small>
                    <div class="divisi"><x-divisi-chip :divisi="$item->divisi" /></div>
                </div>
                <div class="activity-actions">
                    <span class="status-badge {{ $item->status === 'selesai' ? 'status-selesai' : 'status-akan' }}">
                        {{ $item->status === 'selesai' ? 'Selesai' : 'Akan Datang' }}
                    </span>
                    <div class="row-actions">
                        <a href="{{ route('kegiatan.edit', $item->id) }}" class="action-btn action-edit">Edit</a>
                        <form action="{{ route('kegiatan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn action-delete">Hapus</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <p class="empty">Belum ada agenda. Tambahkan kegiatan pertama melalui tombol Tambah Agenda.</p>
        @endforelse
    </section>
</main>

<script>
function toggleProfile(){
    const dropdown=document.getElementById('dropdown');
    dropdown.style.display=dropdown.style.display==='block'?'none':'block';
}

window.addEventListener('click',function(event){
    if(!event.target.closest('.profile')){
        document.getElementById('dropdown').style.display='none';
    }
});

document.querySelectorAll('.menu a,.add-btn,.secondary-btn,.profile-box,.stat-card,.row,.action-btn').forEach(element=>{
    element.addEventListener('click',function(event){
        const ripple=document.createElement('span');
        ripple.classList.add('ripple');
        const rect=this.getBoundingClientRect();
        const size=Math.max(rect.width,rect.height);
        ripple.style.width=size+'px';
        ripple.style.height=size+'px';
        ripple.style.left=(event.clientX-rect.left-size/2)+'px';
        ripple.style.top=(event.clientY-rect.top-size/2)+'px';
        this.appendChild(ripple);
        setTimeout(()=>ripple.remove(),600);
    });
});
</script>
</body>
</html>
