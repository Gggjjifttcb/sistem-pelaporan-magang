<?php
session_start();
include "config/koneksi.php";

$user_id = isset($_GET['user']) ? $_GET['user'] : '';

$users = mysqli_query($conn,"SELECT * FROM users WHERE role='user'");

$query = "
SELECT laporan.*, users.nama 
FROM laporan
JOIN users ON laporan.user_id = users.id
";

if($user_id != ''){
    $query .= " WHERE users.id = '$user_id'";
}

$data = mysqli_query($conn,$query);

$events = [];

while($d = mysqli_fetch_assoc($data)){

    $color = "#28a745"; // hadir

    if($d['status'] == 'tidak_hadir_ket'){
        $color = "#ffc107";
    }

    if($d['status'] == 'tidak_hadir_tanpa_ket'){
        $color = "#dc3545";
    }

    $events[] = [
        'title' => $d['nama'],
        'start' => $d['tanggal'],
        'color' => $color,
        'extendedProps' => [
            'status' => $d['status'],
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
<title>Monitoring Laporan Magang</title>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

</head>
<body class="container mt-4">

<h3>Monitoring Laporan Magang</h3>

<form method="GET" class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <select name="user" class="form-control" onchange="this.form.submit()">
                <option value="">Semua User</option>
                <?php while($u=mysqli_fetch_assoc($users)){ ?>
                    <option value="<?= $u['id'] ?>" <?= ($user_id==$u['id'])?'selected':'' ?>>
                        <?= $u['nama'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
</form>

<div class="calendar-wrapper">
    <div id="calendar"></div>
</div>
>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalDetail" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detail Laporan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="detailContent"></div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    var modal = new bootstrap.Modal(document.getElementById('modalDetail'));

    var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        initialDate: '2025-11-01',
        validRange: {
            start: '2025-11-01',
            end: '2026-07-01'
        },
        events: <?= json_encode($events) ?>,

        eventClick: function(info){

            let data = info.event.extendedProps;

            let html = `
                <b>Nama:</b> ${info.event.title}<br>
                <b>Tanggal:</b> ${info.event.startStr}<br>
                <b>Status:</b> ${data.status}<hr>
            `;

            if(data.status === 'hadir'){
                html += `
                    <b>Uraian:</b><br>${data.uraian ?? '-'}<br><br>
                    <b>Pembelajaran:</b><br>${data.pembelajaran ?? '-'}<br><br>
                    <b>Kendala:</b><br>${data.kendala ?? '-'}
                `;
            }

            if(data.status === 'tidak_hadir_ket'){
                html += `<b>Alasan:</b><br>${data.alasan ?? '-'}`;
            }

            if(data.status === 'tidak_hadir_tanpa_ket'){
                html += `<b>Keterangan:</b><br>Tidak hadir tanpa keterangan`;
            }

            document.getElementById('detailContent').innerHTML = html;
            modal.show();
        }
    });

    calendar.render();

});
</script>

</body>
</html>
