<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (
    !isset($_SESSION['user']) ||
    !is_array($_SESSION['user']) ||
    !isset($_SESSION['user']['id']) ||
    !isset($_SESSION['user']['vai_tro']) ||
    $_SESSION['user']['vai_tro'] !== 'admin'
) {
    header('Location: /petshop/petshop/admin/dang_nhap.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tồn kho</title>
    <style>
        :root{
            --bg:#f3f6fb;
            --card:#ffffff;
            --text:#0f172a;
            --muted:#64748b;
            --line:#e2e8f0;
            --primary:#2563eb;
            --primary-hover:#1d4ed8;
            --shadow:0 10px 30px rgba(15,23,42,.08);
            --radius:18px;
        }

        *{ box-sizing:border-box; }

        body{
            margin:0;
            font-family:Arial, Helvetica, sans-serif;
            background:var(--bg);
            color:var(--text);
        }

        .wrap{
            padding:24px;
        }

        .header{
            margin-bottom:20px;
        }

        .header h1{
            margin:0;
            font-size:36px;
            font-weight:800;
        }

        .header p{
            margin:8px 0 0;
            color:var(--muted);
            font-size:16px;
        }

        .alert{
            display:none;
            margin-bottom:16px;
            padding:14px 16px;
            border-radius:14px;
            font-weight:700;
        }

        .alert.success{
            display:block;
            background:#dcfce7;
            color:#166534;
            border:1px solid #bbf7d0;
        }

        .alert.error{
            display:block;
            background:#fee2e2;
            color:#991b1b;
            border:1px solid #fecaca;
        }

        .stats-grid{
            display:grid;
            grid-template-columns:repeat(4, minmax(0, 1fr));
            gap:16px;
            margin-bottom:20px;
        }

        .stat-card{
            background:var(--card);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            padding:20px;
            border:1px solid rgba(226,232,240,.8);
        }

        .stat-label{
            color:var(--muted);
            font-size:14px;
            margin-bottom:8px;
        }

        .stat-value{
            font-size:30px;
            font-weight:800;
        }

        .card{
            background:var(--card);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            overflow:hidden;
            border:1px solid rgba(226,232,240,.8);
            margin-bottom:18px;
        }

        .card-head{
            padding:18px 20px;
            border-bottom:1px solid var(--line);
            font-size:22px;
            font-weight:800;
        }

        .card-body{
            padding:20px;
        }

        .toolbar{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
            align-items:center;
        }

        .toolbar input,
        .toolbar select{
            border:1px solid #dbe2ea;
            border-radius:14px;
            padding:12px 14px;
            font-size:15px;
            outline:none;
            background:#fff;
        }

        .toolbar input{
            min-width:320px;
            flex:1;
        }

        .toolbar input:focus,
        .toolbar select:focus{
            border-color:var(--primary);
            box-shadow:0 0 0 4px rgba(37,99,235,.12);
        }

        .btn{
            border:none;
            border-radius:12px;
            padding:12px 16px;
            font-weight:700;
            font-size:14px;
            cursor:pointer;
            transition:.2s ease;
            white-space:nowrap;
        }

        .btn-primary{
            background:var(--primary);
            color:#fff;
        }

        .btn-primary:hover{
            background:var(--primary-hover);
        }

        .btn-secondary{
            background:#64748b;
            color:#fff;
        }

        .btn-secondary:hover{
            background:#475569;
        }

        .table-wrap{
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
            min-width:1050px;
        }

        th, td{
            padding:14px;
            border-bottom:1px solid #e5e7eb;
            text-align:left;
            vertical-align:middle;
        }

        th{
            background:#f8fafc;
            font-size:15px;
            font-weight:800;
            color:#334155;
        }

        .product-cell{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .product-thumb{
            width:56px;
            height:56px;
            border-radius:12px;
            object-fit:cover;
            border:1px solid #e5e7eb;
            background:#f8fafc;
        }

        .product-name{
            font-weight:700;
            margin-bottom:4px;
        }

        .product-meta{
            font-size:13px;
            color:var(--muted);
        }

        .badge{
            display:inline-block;
            padding:7px 12px;
            border-radius:999px;
            font-size:13px;
            font-weight:800;
            white-space:nowrap;
        }

        .badge-ok{
            background:#dcfce7;
            color:#166534;
        }

        .badge-low{
            background:#fef3c7;
            color:#92400e;
        }

        .badge-out{
            background:#fee2e2;
            color:#991b1b;
        }

        .empty-text{
            padding:16px;
            color:var(--muted);
        }

        @media (max-width: 1100px){
            .stats-grid{
                grid-template-columns:repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px){
            .wrap{
                padding:16px;
            }

            .header h1{
                font-size:30px;
            }

            .stats-grid{
                grid-template-columns:1fr;
            }

            .toolbar input{
                min-width:100%;
            }

            .btn{
                width:100%;
            }
        }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <h1>Tồn kho</h1>
        <p>Theo dõi số lượng sản phẩm hiện có trong kho và cảnh báo hàng sắp hết.</p>
    </div>

    <div id="alertBox" class="alert"></div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Tổng sản phẩm</div>
            <div class="stat-value" id="statTongSanPham">0</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Tổng tồn kho</div>
            <div class="stat-value" id="statTongTonKho">0</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Sắp hết hàng</div>
            <div class="stat-value" id="statSapHet">0</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Hết hàng</div>
            <div class="stat-value" id="statHetHang">0</div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">Bộ lọc tồn kho</div>
        <div class="card-body">
            <div class="toolbar">
                <input type="text" id="searchKeyword" placeholder="Tìm theo tên sản phẩm hoặc mã SKU...">
                <select id="filterType">
                    <option value="">Tất cả trạng thái</option>
                    <option value="con_hang">Còn hàng</option>
                    <option value="sap_het">Sắp hết</option>
                    <option value="het_hang">Hết hàng</option>
                </select>
                <button class="btn btn-primary" onclick="loadInventory()">Tìm kiếm</button>
                <button class="btn btn-secondary" onclick="resetFilter()">Làm mới</button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-head">Danh sách tồn kho</div>
        <div class="card-body">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Mã SKU</th>
                            <th>Giá bán</th>
                            <th>Số lượng tồn</th>
                            <th>Trạng thái kho</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
                        <tr>
                            <td colspan="6" class="empty-text">Đang tải dữ liệu...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    const apiUrl = '../api/api_ton_kho.php';
    const noImage = '../assets/img/no-image.jpg';

    function showAlert(message, type = 'success') {
        const box = document.getElementById('alertBox');
        box.className = 'alert ' + type;
        box.innerText = message;

        setTimeout(() => {
            box.className = 'alert';
            box.innerText = '';
        }, 3000);
    }

    function formatMoney(value) {
        return new Intl.NumberFormat('vi-VN').format(Number(value || 0));
    }

    function escapeHtml(str) {
        return String(str ?? '').replace(/[&<>"']/g, function(m) {
            return ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[m];
        });
    }

    function imagePath(path) {
        if (!path) return noImage;
        return '../' + path;
    }

    function resetFilter() {
        document.getElementById('searchKeyword').value = '';
        document.getElementById('filterType').value = '';
        loadInventory();
    }

    async function loadStats() {
        try {
            const res = await fetch(apiUrl + '?action=stats');
            const data = await res.json();

            if (!data.success) {
                showAlert(data.message || 'Không tải được thống kê tồn kho.', 'error');
                return;
            }

            document.getElementById('statTongSanPham').innerText = formatMoney(data.data.tong_san_pham);
            document.getElementById('statTongTonKho').innerText = formatMoney(data.data.tong_ton_kho);
            document.getElementById('statSapHet').innerText = formatMoney(data.data.sap_het);
            document.getElementById('statHetHang').innerText = formatMoney(data.data.het_hang);
        } catch (e) {
            showAlert('Lỗi tải thống kê tồn kho.', 'error');
            console.error(e);
        }
    }

    async function loadInventory() {
        const keyword = document.getElementById('searchKeyword').value.trim();
        const filter = document.getElementById('filterType').value;
        const tbody = document.getElementById('inventoryTableBody');

        tbody.innerHTML = `<tr><td colspan="6" class="empty-text">Đang tải dữ liệu...</td></tr>`;

        try {
            const res = await fetch(apiUrl + '?action=list&keyword=' + encodeURIComponent(keyword) + '&filter=' + encodeURIComponent(filter));
            const data = await res.json();

            if (!data.success) {
                tbody.innerHTML = `<tr><td colspan="6" class="empty-text">${escapeHtml(data.message || 'Không tải được tồn kho.')}</td></tr>`;
                return;
            }

            if (!data.data || data.data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="empty-text">Không có dữ liệu phù hợp.</td></tr>`;
                return;
            }

            tbody.innerHTML = data.data.map(item => {
                let badgeClass = 'badge-ok';
                let badgeText = 'Còn hàng';

                if (Number(item.so_luong_ton) <= 0) {
                    badgeClass = 'badge-out';
                    badgeText = 'Hết hàng';
                } else if (Number(item.so_luong_ton) <= 5) {
                    badgeClass = 'badge-low';
                    badgeText = 'Sắp hết';
                }

                return `
                    <tr>
                        <td>
                            <div class="product-cell">
                                <img class="product-thumb" src="${imagePath(item.hinh_anh)}" alt="Ảnh sản phẩm" onerror="this.src='${noImage}'">
                                <div>
                                    <div class="product-name">${escapeHtml(item.ten_san_pham)}</div>
                                    <div class="product-meta">ID: ${item.id}</div>
                                </div>
                            </div>
                        </td>
                        <td>${escapeHtml(item.ma_sku || '—')}</td>
                        <td>${formatMoney(item.gia_ban)} đ</td>
                        <td><strong>${item.so_luong_ton}</strong></td>
                        <td><span class="badge ${badgeClass}">${badgeText}</span></td>
                        <td>${escapeHtml(item.ngay_tao || '—')}</td>
                    </tr>
                `;
            }).join('');
        } catch (e) {
            tbody.innerHTML = `<tr><td colspan="6" class="empty-text">Lỗi tải tồn kho. Kiểm tra API.</td></tr>`;
            console.error(e);
        }
    }

    document.getElementById('searchKeyword').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            loadInventory();
        }
    });

    loadStats();
    loadInventory();
</script>
</body>
</html>