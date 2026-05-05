<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (
    !isset($_SESSION['user']) ||
    !is_array($_SESSION['user']) ||
    ($_SESSION['user']['vai_tro'] ?? '') !== 'admin'
) {
    header('Location: /petshop/petshop/admin/dang_nhap.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khách hàng thân thiết</title>
    <style>
        :root{
            --bg:#f3f6fb;
            --card:#fff;
            --text:#0f172a;
            --muted:#64748b;
            --line:#e2e8f0;
            --primary:#2563eb;
            --shadow:0 10px 30px rgba(15,23,42,.08);
            --radius:18px;
            }

            body{
            margin:0;
            font-family:Arial, sans-serif;
            background:var(--bg);
            color:var(--text);
            }

            .wrap{padding:28px;}

            .page-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:16px;
            margin-bottom:22px;
            }

            .page-header h1{
            margin:0;
            font-size:36px;
            font-weight:800;
            }

            .desc{
            color:var(--muted);
            margin-top:8px;
            }

            .stats-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:16px;
            margin-bottom:20px;
            }

            .stat-card{
            background:var(--card);
            padding:20px;
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            }

            .stat-label{
            color:var(--muted);
            font-size:14px;
            }

            .stat-value{
            font-size:30px;
            font-weight:800;
            margin-top:8px;
            }

            .card{
            background:var(--card);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            overflow:hidden;
            margin-bottom:18px;
            }

            .card-body{padding:20px;}

            .toolbar{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
            }

            .search{
            flex:1;
            min-width:320px;
            padding:13px 15px;
            border:1px solid var(--line);
            border-radius:14px;
            font-size:15px;
            }

            .search:focus{
            outline:none;
            border-color:var(--primary);
            box-shadow:0 0 0 4px rgba(37,99,235,.12);
            }

            .btn{
            border:none;
            border-radius:12px;
            padding:12px 18px;
            font-weight:700;
            cursor:pointer;
            }

            .btn-primary{background:var(--primary);color:#fff;}
            .btn-warning{background:#f59e0b;color:#fff;}

            .table-wrap{overflow-x:auto;}

            table{
            width:100%;
            border-collapse:collapse;
            min-width:1000px;
            }

            th,td{
            padding:16px;
            border-bottom:1px solid #e5e7eb;
            text-align:left;
            }

            th{
            background:#f8fafc;
            color:#334155;
            }

            tr:hover{background:#f8fbff;}

            .customer-name{
            font-weight:800;
            }

            .customer-id{
            color:var(--muted);
            font-size:13px;
            margin-top:4px;
            }

            .point-input,
            .note-input{
            padding:10px 12px;
            border:1px solid var(--line);
            border-radius:10px;
            }

            .point-input{width:100px;}
            .note-input{min-width:220px;}

            .badge{
            padding:8px 14px;
            border-radius:999px;
            font-weight:800;
            font-size:13px;
            }

            .dong{background:#e2e8f0;color:#334155;}
            .bac{background:#e0f2fe;color:#0369a1;}
            .vang{background:#fef3c7;color:#92400e;}
            .kimcuong{background:#ede9fe;color:#5b21b6;}

            .alert{
            display:none;
            padding:14px 16px;
            border-radius:14px;
            margin-bottom:16px;
            font-weight:700;
            }

            .alert.success{display:block;background:#dcfce7;color:#166534;}
            .alert.error{display:block;background:#fee2e2;color:#991b1b;}

            @media(max-width:900px){
            .stats-grid{grid-template-columns:repeat(2,1fr);}
            }

            @media(max-width:600px){
            .stats-grid{grid-template-columns:1fr;}
            .page-header{align-items:flex-start;flex-direction:column;}
            }
    </style>
</head>
<body>
<div class="wrap">

    <a class="btn btn-back" href="dashboard.php">← Quay về menu</a>

    <h1>Khách hàng thân thiết</h1>
    <div class="desc">Quản lý điểm tích lũy và hạng thành viên của khách hàng.</div>

    <div id="alertBox" class="alert"></div>
    <div class="stats-grid">
  <div class="stat-card">
    <div class="stat-label">Tổng khách hàng</div>
    <div class="stat-value" id="statTotal">0</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Hạng Bạc trở lên</div>
    <div class="stat-value" id="statVip">0</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Tổng điểm</div>
    <div class="stat-value" id="statPoint">0</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Kim cương</div>
    <div class="stat-value" id="statDiamond">0</div>
  </div>
</div>
    <div class="card">
        <div class="card-body">
            <div class="toolbar">
                <input class="search" type="text" id="keyword" placeholder="Tìm theo tên, số điện thoại, email...">
                <button class="btn btn-primary" onclick="loadCustomers()">Tìm kiếm</button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Điểm</th>
                        <th>Hạng</th>
                        <th>Ghi chú</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="customerBody">
                    <tr>
                        <td colspan="7">Đang tải...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const apiUrl = '../api/api_khach_hang_than_thiet.php';

function escapeHtml(str) {
    return String(str ?? '').replace(/[&<>"']/g, m => ({
        '&':'&amp;',
        '<':'&lt;',
        '>':'&gt;',
        '"':'&quot;',
        "'":'&#039;'
    })[m]);
}

function showAlert(message, type = 'success') {
    const box = document.getElementById('alertBox');
    box.className = 'alert ' + type;
    box.innerText = message;

    setTimeout(() => {
        box.className = 'alert';
        box.innerText = '';
    }, 3000);
}

function badgeClass(hang) {
    if (hang === 'Kim cương') return 'kimcuong';
    if (hang === 'Vàng') return 'vang';
    if (hang === 'Bạc') return 'bac';
    return 'dong';
}

async function loadCustomers() {
    const keyword = document.getElementById('keyword').value.trim();
    const tbody = document.getElementById('customerBody');

    tbody.innerHTML = `<tr><td colspan="7">Đang tải...</td></tr>`;

    const res = await fetch(apiUrl + '?action=list&keyword=' + encodeURIComponent(keyword));
    const data = await res.json();

    if (!data.success) {
        tbody.innerHTML = `<tr><td colspan="7">${escapeHtml(data.message)}</td></tr>`;
        return;
    }

    if (!data.data || data.data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="7">Không có dữ liệu.</td></tr>`;
        return;
    }
    const total = data.data.length;
    const vip = data.data.filter(x => ['Bạc','Vàng','Kim cương'].includes(x.hang_thanh_vien)).length;
    const point = data.data.reduce((sum, x) => sum + Number(x.diem || 0), 0);
    const diamond = data.data.filter(x => x.hang_thanh_vien === 'Kim cương').length;

    document.getElementById('statTotal').innerText = total;
    document.getElementById('statVip').innerText = vip;
    document.getElementById('statPoint').innerText = point;
    document.getElementById('statDiamond').innerText = diamond;
    tbody.innerHTML = data.data.map(item => `
        <tr>
            <td>
            <div class="customer-name">${escapeHtml(item.ho_ten)}</div>
            <div class="customer-id">ID: ${item.khach_hang_id}</div>
            </td>            <td>${escapeHtml(item.so_dien_thoai || '—')}</td>
            <td>${escapeHtml(item.email || '—')}</td>
            <td>
            <input class="point-input" type="number" min="0" value="${item.diem}" id="diem_${item.khach_hang_id}">            </td>
            <td>
                <span class="badge ${badgeClass(item.hang_thanh_vien)}">${escapeHtml(item.hang_thanh_vien)}</span>
            </td>
            <td>
<input class="note-input" type="text" value="${escapeHtml(item.ghi_chu || '')}" id="ghichu_${item.khach_hang_id}" placeholder="Ghi chú...">            </td>
            <td>
                <button class="btn btn-warning" onclick="savePoint(${item.khach_hang_id})">Lưu điểm</button>
            </td>
        </tr>
    `).join('');
}

async function savePoint(id) {
    const diem = document.getElementById('diem_' + id).value;
    const ghiChu = document.getElementById('ghichu_' + id).value;

    const formData = new FormData();
    formData.append('action', 'update_point');
    formData.append('khach_hang_id', id);
    formData.append('diem', diem);
    formData.append('ghi_chu', ghiChu);

    const res = await fetch(apiUrl, {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    if (data.success) {
        showAlert(data.message, 'success');
        loadCustomers();
    } else {
        showAlert(data.message, 'error');
    }
}

document.getElementById('keyword').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        loadCustomers();
    }
});

loadCustomers();
</script>
</body>
</html>