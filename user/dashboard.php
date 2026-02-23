<?php
session_start();
include "../config/koneksi.php";

if(!isset($_SESSION['login']) || $_SESSION['role']!='user'){
    header("Location: ../auth/login.php");
    exit;
}

$id = $_SESSION['id'];

// Ambil data peserta magang
$query = mysqli_query($conn,"SELECT * FROM peserta_magang WHERE user_id='$id'");
$peserta = mysqli_fetch_assoc($query);

// Ambil semua laporan user
$data_laporan = mysqli_query($conn,"SELECT * FROM laporan WHERE user_id='$id'");
$events = [];
while($d = mysqli_fetch_assoc($data_laporan)){
    $color = "#28a745"; // hadir
    if($d['status'] == 'tidak_hadir_ket') $color="#ffc107";
    if($d['status'] == 'tidak_hadir_tanpa_ket') $color="#dc3545";

    $tanggal = date('Y-m-d', strtotime($d['tanggal']));

    $events[] = [
        'title' => $d['status'],
        'start' => $tanggal,
        'color' => $color,
        'extendedProps' => [
            'uraian' => $d['uraian'],
            'pembelajaran' => $d['pembelajaran'],
            'kendala' => $d['kendala'],
            'alasan' => $d['alasan']
        ]
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard User</title>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
</head>
<body>

<div class="card-modern">
    <h3>Data Magang</h3>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #eef2f7, #d9e2ec); min-height: 100vh; padding: 20px; }
.card-modern { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px); border-radius: 20px; padding: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); margin-bottom: 20px; transition: 0.3s ease; }
.card-modern:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.12); }
.calendar-wrapper { max-width: 750px; margin: auto; background: white; padding: 20px; border-radius: 25px; box-shadow: 0 20px 50px rgba(0,0,0,0.08); transition: 0.4s ease; opacity: 0; transform: translateY(20px); animation: fadeInUp 0.8s ease forwards; }
@keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
#calendar { font-size: 14px; }
.fc-toolbar-title { font-size: 18px !important; font-weight: 600; color: #2c3e50; }
.fc-button { background: #4e73df !important; border: none !important; border-radius: 12px !important; padding: 5px 12px !important; font-size: 13px !important; transition: 0.3s ease !important; }
.fc-button:hover { background: #2e59d9 !important; transform: scale(1.05); }
.fc-daygrid-day { transition: 0.3s ease; border-radius: 12px; }
.fc-daygrid-day:hover { background: #eef3ff; cursor: pointer; transform: scale(1.05); }
.fc-day-today { background: rgba(78,115,223,0.1) !important; border-radius: 12px; }
.fc-daygrid-event { border-radius: 10px !important; padding: 3px 6px !important; font-size: 11px !important; font-weight: 500; border: none !important; transition: 0.3s ease; }
.fc-daygrid-event:hover { transform: scale(1.05); opacity: 0.9; }
.fc-theme-standard td, .fc-theme-standard th { border: none !important; }
.fc-col-header-cell-cushion { font-weight: 500; color: #6c757d; font-size: 13px; }
.modal-content { border-radius: 20px; border: none; box-shadow: 0 15px 40px rgba(0,0,0,0.15); }
.modal-header, .modal-footer { border: none; }
.modal-title { font-weight: 600; }
.form-control { border-radius: 12px; padding: 10px 15px; border: 1px solid #e0e0e0; transition: 0.3s; }
.form-control:focus { border-color: #4e73df; box-shadow: 0 0 0 3px rgba(78,115,223,0.2); }
.btn-primary { background: #4e73df; border: none; border-radius: 12px; padding: 8px 20px; font-weight: 500; transition: 0.3s; }
.btn-primary:hover { background: #2e59d9; transform: translateY(-2px); }
.btn-secondary { border-radius: 12px; }
.alert-danger { border-radius: 15px; background: #ffe5e5; border: none; color: #b02a37; }
.info-label { font-weight: 500; color: #6c757d; }
.info-value { font-weight: 600; color: #2c3e50; }
</style>
    <p><span class="info-label">Nama:</span> <span class="info-value"><?= $_SESSION['nama']; ?></span></p>
    <?php if($peserta){ ?>
        <p><span class="info-label">Posisi:</span> <span class="info-value"><?= $peserta['posisi']; ?></span></p>
        <p><span class="info-label">Lokasi:</span> <span class="info-value"><?= $peserta['lokasi']; ?></span></p>
        <p><span class="info-label">Periode:</span> <span class="info-value"><?= $peserta['periode']; ?></span></p>
    <?php } else { ?>
        <div class="alert alert-danger mt-2">Data magang belum diinput oleh admin. Silakan hubungi admin.</div>
    <?php } ?>
</div>

<div class="card-modern">
    <h4>Absensi & Laporan Harian</h4>
    <div class="calendar-wrapper">
        <div id="calendar"></div>
    </div>
</div>

<!-- MODAL INPUT -->
<div class="modal fade" id="modalInput" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="simpan_laporan.php">
        <div class="modal-header">
          <h5 class="modal-title">Input Laporan Harian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" readonly required>
          </div>
          <div class="mb-2">
            <label>Keterangan</label>
            <select name="status" id="status" class="form-control" required>
              <option value="">-- Pilih --</option>
              <option value="hadir">Hadir</option>
              <option value="tidak_hadir_ket">Tidak Hadir dengan Keterangan</option>
              <option value="tidak_hadir_tanpa_ket">Tidak Hadir Tanpa Keterangan</option>
            </select>
          </div>
          <div id="formHadir" style="display:none;">
            <textarea name="uraian" class="form-control mb-2" placeholder="Uraian Aktifitas"></textarea>
            <textarea name="pembelajaran" class="form-control mb-2" placeholder="Pembelajaran yang diperoleh"></textarea>
            <textarea name="kendala" class="form-control mb-2" placeholder="Kendala yang dialami"></textarea>
          </div>
          <div id="formAlasan" style="display:none;">
            <textarea name="alasan" class="form-control mb-2" placeholder="Alasan tidak hadir"></textarea>
          </div>
          <div class="form-check">
              <input class="form-check-input" type="checkbox" name="konfirmasi" value="1">
              <label class="form-check-label">
                Saya telah meninjau laporan dan menyatakan isi laporan sudah benar
              </label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalDetail" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detailContent"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    var modalInput = new bootstrap.Modal(document.getElementById('modalInput'));
    var modalDetail = new bootstrap.Modal(document.getElementById('modalDetail'));

    var eventsData = <?= json_encode($events) ?>;

    // buat map cepat untuk lookup laporan per tanggal
    var laporanMap = {};
    eventsData.forEach(function(e){
        laporanMap[e.start] = e;
    });

    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        initialDate: '2025-12-01',
        validRange: { start: '2025-12-01', end: '2026-07-01' },
        events: eventsData,
        dateClick: function(info) {
    // cari semua laporan pada tanggal itu
    let laporanHariIni = eventsData.filter(e => e.start === info.dateStr);

    if(laporanHariIni.length > 0){
        let html = `<p><strong>Tanggal:</strong> ${info.dateStr}</p><hr>`;
        laporanHariIni.forEach((laporan, index)=>{
            let data = laporan.extendedProps;
            html += `<p><strong>Laporan ${index+1} - ${laporan.title}</strong></p>`;
            
            if(data.uraian) html += `<p><b>Uraian:</b> ${data.uraian}</p>`;
            if(data.pembelajaran) html += `<p><b>Pembelajaran:</b> ${data.pembelajaran}</p>`;
            if(data.kendala) html += `<p><b>Kendala:</b> ${data.kendala}</p>`;
            if(data.alasan) html += `<p><b>Alasan:</b> ${data.alasan}</p>`;
            html += `<hr>`;
        });

        document.getElementById('detailContent').innerHTML = html;
        modalDetail.show();
        return;
    }

    // jika belum ada laporan, tampilkan form input
    document.getElementById('tanggal').value = info.dateStr;
    modalInput.show();
}

    });

    calendar.render();

    document.getElementById('status').addEventListener('change', function(){
        let status = this.value;
        document.getElementById('formHadir').style.display = 'none';
        document.getElementById('formAlasan').style.display = 'none';
        document.getElementById('formKonfirmasi').style.display = 'none';
        if(status === 'hadir') document.getElementById('formHadir').style.display='block';
        if(status === 'tidak_hadir_ket') document.getElementById('formAlasan').style.display='block';
        if(status === 'tidak_hadir_tanpa_ket') document.getElementById('formKonfirmasi').style.display='block';
    });

});
</script>
<a href="../auth/logout.php">Logout</a>
</body>
</html>
