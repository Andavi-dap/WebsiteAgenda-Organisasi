import os
from reportlab.lib.pagesizes import A4
from reportlab.lib import colors
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, HRFlowable
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle

pdf_path = "C:/laragon/www/kabinet-haruna-main/rangkuman_kabinet_haruna.pdf"
doc = SimpleDocTemplate(pdf_path, pagesize=A4,
                        rightMargin=36, leftMargin=36,
                        topMargin=36, bottomMargin=36)

styles = getSampleStyleSheet()

# Custom Styles
title_style = ParagraphStyle(
    'DocTitle',
    parent=styles['Heading1'],
    fontName='Helvetica-Bold',
    fontSize=18,
    leading=22,
    textColor=colors.HexColor('#1E3A8A'),
    spaceAfter=6
)

subtitle_style = ParagraphStyle(
    'DocSubTitle',
    parent=styles['Normal'],
    fontName='Helvetica',
    fontSize=10,
    leading=14,
    textColor=colors.HexColor('#4B5563'),
    spaceAfter=12
)

h2_style = ParagraphStyle(
    'SectionHeading',
    parent=styles['Heading2'],
    fontName='Helvetica-Bold',
    fontSize=13,
    leading=16,
    textColor=colors.HexColor('#1E3A8A'),
    spaceBefore=12,
    spaceAfter=6
)

body_style = ParagraphStyle(
    'BodyTextCustom',
    parent=styles['Normal'],
    fontName='Helvetica',
    fontSize=9.5,
    leading=13.5,
    textColor=colors.HexColor('#1F2937'),
    spaceAfter=6
)

bullet_style = ParagraphStyle(
    'BulletCustom',
    parent=body_style,
    leftIndent=12,
    spaceAfter=4
)

table_header_style = ParagraphStyle(
    'TableHeader',
    parent=styles['Normal'],
    fontName='Helvetica-Bold',
    fontSize=9,
    leading=11,
    textColor=colors.white
)

table_cell_style = ParagraphStyle(
    'TableCell',
    parent=styles['Normal'],
    fontName='Helvetica',
    fontSize=8.5,
    leading=11,
    textColor=colors.HexColor('#1F2937')
)

story = []

# Title & Header
story.append(Paragraph("RANGKUMAN PROJECT: WEBSITE AGENDA ORGANISASI HARUNA", title_style))
story.append(Paragraph("HIMEDIAJKT Kabinet Haruna (Polimedia Jakarta) — Panduan Belajar & Presentasi", subtitle_style))
story.append(HRFlowable(width="100%", thickness=1.5, color=colors.HexColor('#1E3A8A'), spaceBefore=2, spaceAfter=10))

# 1. Identitas Project
story.append(Paragraph("1. Identitas Project", h2_style))
story.append(Paragraph("<b>Nama Project:</b> Website Agenda Organisasi HARUNA", bullet_style))
story.append(Paragraph("<b>Organisasi:</b> HIMEDIAJKT Kabinet Haruna, Polimedia Jakarta", bullet_style))
story.append(Paragraph("<b>Repository:</b> <code>https://github.com/Andavi-dap/Website-Agenda-Organisasi.git</code>", bullet_style))
story.append(Paragraph("<b>Tech Stack:</b> Laravel 12 (PHP 8.2), Tailwind CSS v4, Vite, SQLite / MySQL, Blade Templates.", bullet_style))

# 2. Struktur Folder & Arsitektur
story.append(Paragraph("2. Struktur Folder & Arsitektur MVC", h2_style))
story.append(Paragraph("Project menggunakan arsitektur <b>MVC (Model-View-Controller)</b> standar Laravel:", body_style))

arch_data = [
    [Paragraph("<b>Path / Folder</b>", table_header_style), Paragraph("<b>Keterangan / Fungsi Utama</b>", table_header_style)],
    [Paragraph("<code>app/Http/Controllers/</code>", table_cell_style), Paragraph("Berisi <code>AuthController.php</code> (login/logout hardcoded user pengurus) & <code>KegiatanController.php</code> (CRUD agenda, filter, kalender).", table_cell_style)],
    [Paragraph("<code>app/Models/</code>", table_cell_style), Paragraph("Berisi <code>Kegiatan.php</code> (Eloquent Model + scope waktu otomatis) & <code>User.php</code>.", table_cell_style)],
    [Paragraph("<code>app/Support/Role.php</code>", table_cell_style), Paragraph("Logika penentuan hak akses (Admin vs Pengguna Umum berdasarkan jabatan).", table_cell_style)],
    [Paragraph("<code>config/haruna.php</code>", table_cell_style), Paragraph("Konfigurasi daftar divisi himpunan dan role jabatan admin.", table_cell_style)],
    [Paragraph("<code>routes/web.php</code>", table_cell_style), Paragraph("Daftar routing web aplikasi dan proteksi middleware autentikasi.", table_cell_style)],
    [Paragraph("<code>resources/views/</code>", table_cell_style), Paragraph("Template Blade (dashboard index, kalender, list kegiatan, login).", table_cell_style)]
]

t1 = Table(arch_data, colWidths=[150, 390])
t1.setStyle(TableStyle([
    ('BACKGROUND', (0,0), (-1,0), colors.HexColor('#1E3A8A')),
    ('ALIGN', (0,0), (-1,-1), 'LEFT'),
    ('VALIGN', (0,0), (-1,-1), 'TOP'),
    ('TEXTCOLOR', (0,0), (-1,0), colors.white),
    ('BOTTOMPADDING', (0,0), (-1,-1), 5),
    ('TOPPADDING', (0,0), (-1,-1), 5),
    ('LEFTPADDING', (0,0), (-1,-1), 6),
    ('RIGHTPADDING', (0,0), (-1,-1), 6),
    ('GRID', (0,0), (-1,-1), 0.5, colors.HexColor('#D1D5DB')),
    ('ROWBACKGROUNDS', (0,1), (-1,-1), [colors.white, colors.HexColor('#F9FAFB')])
]))
story.append(t1)
story.append(Spacer(1, 8))

# 3. Logika Utama (Core Logic)
story.append(Paragraph("3. Logika Utama (Core Logic)", h2_style))

story.append(Paragraph("<b>A. Sistem Autentikasi & Role (<code>AuthController.php</code> & <code>Role.php</code>)</b>", body_style))
story.append(Paragraph("• Data pengurus dihimpun langsung dalam array <code>$users</code> di <code>AuthController</code> (Nama, Jabatan, Password, Foto).", bullet_style))
story.append(Paragraph("• Pengecekan Admin menggunakan <code>Role::isAdmin(\$jabatan)</code>: Ketua Himpunan, Wakil Ketua Himpunan, dan semua jabatan dengan prefix <code>Ketua Divisi </code>.", bullet_style))
story.append(Paragraph("• Data user disimpan ke session <code>session(['user' => \$user])</code> setelah login sukses.", bullet_style))

story.append(Paragraph("<b>B. Manajemen Agenda & Status Otomatis (<code>KegiatanController.php</code> & <code>Kegiatan.php</code>)</b>", body_style))
story.append(Paragraph("• <b>Status Otomatis:</b> Method <code>hitungStatus(\$tanggal, \$waktu)</code> membandingkan waktu sekarang via <code>Carbon</code>. Menghasilkan status <code>akan datang</code> atau <code>selesai</code>.", bullet_style))
story.append(Paragraph("• <b>Fitur Controller:</b><br/>"
                       "- <code>index()</code>: Dashboard utama & list kegiatan terdekat.<br/>"
                       "- <code>semua()</code>, <code>akanDatang()</code>, <code>selesai()</code>: Pengelompokan kegiatan berdasar bulan/tahun.<br/>"
                       "- <code>kalender()</code>: Render kalender bulanan dengan grid hari & event berdasar tanggal.<br/>"
                       "- CRUD lengkap (<code>create</code>, <code>store</code>, <code>edit</code>, <code>update</code>, <code>destroy</code>) dengan validasi <code>KegiatanRequest</code>.", bullet_style))

story.append(Spacer(1, 4))

# 4. Cheat Sheet Presentasi
story.append(Paragraph("4. Cheat Sheet untuk Presentasi", h2_style))
story.append(Paragraph("1. <b>Latar Belakang:</b> Digitalisasi jadwal dan agenda kegiatan HIMEDIAJKT Kabinet Haruna untuk transparansi dan koordinasi organisasi.", bullet_style))
story.append(Paragraph("2. <b>Keunggulan Teknis:</b> Dibangun di atas Laravel 12 terbaru, kalkulasi status event real-time, serta role-based UI yang mencerminkan struktur organisasi riil.", bullet_style))
story.append(Paragraph("3. <b>Demo Alur:</b> Login dengan akun pengurus → Lihat Dashboard & Statistik Kegiatan → Tambah/Edit Kegiatan & saksikan status otomatis berubah → Buka View Kalender Bulanan.", bullet_style))

doc.build(story)
print("PDF generated successfully at:", pdf_path)
