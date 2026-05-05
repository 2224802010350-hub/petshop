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
    <title>Quản lý nhà cung cấp</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
    <style>
        :root{
            --bg: #f3f6fb;
            --card: #ffffff;
            --text: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --success-bg: #dcfce7;
            --success-text: #166534;
            --danger-bg: #fee2e2;
            --danger-text: #991b1b;
            --warning-bg: #fef3c7;
            --warning-text: #92400e;
            --secondary: #64748b;
            --secondary-hover: #475569;
            --shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            --radius: 18px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
        }

        .page-wrap {
            padding: 28px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
            flex-wrap: wrap;
        }

        .page-title {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .page-title h1 {
            margin: 0;
            font-size: 34px;
            line-height: 1.2;
            font-weight: 800;
            color: #0f172a;
        }

        .page-title p {
            margin: 0;
            color: var(--muted);
            font-size: 15px;
        }

        .toolbar-card,
        .table-card,
        .stats-card {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .toolbar-card {
            padding: 18px;
            margin-bottom: 20px;
        }

        .toolbar {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .search-box {
            flex: 1;
            min-width: 280px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            height: 48px;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 0 16px;
            font-size: 15px;
            outline: none;
            transition: 0.2s ease;
            background: #fff;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .stats-card {
            padding: 18px;
        }

        .stats-label {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 10px;
        }

        .stats-value {
            font-size: 28px;
            font-weight: 800;
            color: #0f172a;
        }

        .table-card {
            overflow: hidden;
        }

        .table-card-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .table-card-header h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
        }

        .table-card-header span {
            color: var(--muted);
            font-size: 14px;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        thead th {
            background: #f8fafc;
            color: #475569;
            text-align: left;
            font-size: 14px;
            font-weight: 700;
            padding: 16px 16px;
            border-bottom: 1px solid var(--line);
            white-space: nowrap;
        }

        tbody td {
            padding: 18px 16px;
            border-bottom: 1px solid #eef2f7;
            vertical-align: middle;
            font-size: 15px;
        }

        tbody tr {
            transition: background 0.2s ease;
        }

        tbody tr:hover {
            background: #f8fbff;
        }

        .supplier-name {
            font-weight: 700;
            color: #0f172a;
        }

        .sub-text {
            color: var(--muted);
            font-size: 13px;
            margin-top: 4px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            padding: 0 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-success {
            background: var(--success-bg);
            color: var(--success-text);
        }

        .badge-danger {
            background: var(--danger-bg);
            color: var(--danger-text);
        }

        .btn {
            border: none;
            border-radius: 12px;
            height: 44px;padding: 0 18px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
        }

        .btn-secondary {
            background: var(--secondary);
            color: #fff;
        }

        .btn-secondary:hover {
            background: var(--secondary-hover);
        }

        .btn-warning {
            background: #f59e0b;
            color: #fff;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-danger {
            background: #ef4444;
            color: #fff;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-ghost {
            background: #eef2ff;
            color: #3730a3;
        }

        .btn-ghost:hover {
            background: #e0e7ff;
        }

        .action-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-group .btn {
            height: 38px;
            padding: 0 14px;
            border-radius: 10px;
            font-size: 13px;
        }

        .alert {
            display: none;
            margin-bottom: 18px;
            padding: 14px 16px;
            border-radius: 14px;
            font-weight: 600;
        }

        .alert.success {
            display: block;
            background: #ecfdf3;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert.error {
            display: block;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .empty-state {
            text-align: center;
            padding: 42px 20px;
            color: var(--muted);
        }

        .modal {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 9999;
            backdrop-filter: blur(3px);
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            width: 100%;
            max-width: 820px;
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.2);
            animation: popup 0.22s ease;
        }

        @keyframes popup {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {padding: 20px 24px;
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
        }

        .modal-body {
            padding: 24px;
            background: #fff;
        }

        .modal-footer {
            padding: 18px 24px;
            border-top: 1px solid var(--line);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            background: #fcfdff;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 700;
            color: #334155;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 12px 14px;
            font-size: 15px;
            outline: none;
            transition: 0.2s ease;
            background: #fff;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 110px;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .page-wrap {
                padding: 16px;
            }

            .page-title h1 {
                font-size: 28px;
            }

            .form-grid,
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .search-box {
                min-width: 100%;
            }

            .modal-body,
            .modal-header,
            .modal-footer {
                padding-left: 16px;
                padding-right: 16px;
            }

            .btn {
                width: 100%;
            }

            .top-actions {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="page-wrap">
    <div class="page-header">
        <div class="page-title">
            <h1>Quản lý nhà cung cấp</h1><p>Theo dõi thông tin đối tác cung ứng cho hệ thống petshop.</p>
        </div>

        <div class="top-actions">
            <button class="btn btn-primary" onclick="openCreateModal()">+ Thêm nhà cung cấp</button>
        </div>
    </div>

    <div id="alertBox" class="alert"></div>

    <div class="stats-grid" id="statsGrid">
        <div class="stats-card">
            <div class="stats-label">Tổng nhà cung cấp</div>
            <div class="stats-value" id="statTotal">0</div>
        </div>
        <div class="stats-card">
            <div class="stats-label">Đang hoạt động</div>
            <div class="stats-value" id="statActive">0</div>
        </div>
        <div class="stats-card">
            <div class="stats-label">Ngưng hợp tác</div>
            <div class="stats-value" id="statInactive">0</div>
        </div>
        <div class="stats-card">
            <div class="stats-label">Có email liên hệ</div>
            <div class="stats-value" id="statHasEmail">0</div>
        </div>
    </div>

    <div class="toolbar-card">
        <div class="toolbar">
            <div class="search-box">
                <input type="text" id="searchKeyword" placeholder="Tìm theo tên, người liên hệ, số điện thoại, email...">
            </div>
            <button class="btn btn-secondary" onclick="loadSuppliers()">Tìm kiếm</button>
            <button class="btn btn-ghost" onclick="resetSearch()">Làm mới</button>
        </div>
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <div>
                <h2>Danh sách nhà cung cấp</h2>
                <span>Hiển thị toàn bộ dữ liệu trong hệ thống.</span>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên nhà cung cấp</th>
                        <th>Người liên hệ</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th style="min-width: 210px;">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="supplierTableBody">
                    <tr>
                        <td colspan="9" class="empty-state">Đang tải dữ liệu...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal" id="supplierModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Thêm nhà cung cấp</h3>
        </div>

        <div class="modal-body">
            <form id="supplierForm">
                <input type="hidden" name="id" id="id">

                <div class="form-grid">
                    <div class="form-group"><label for="ten_nha_cung_cap">Tên nhà cung cấp</label>
                        <input type="text" name="ten_nha_cung_cap" id="ten_nha_cung_cap" placeholder="Ví dụ: Royal Canin" required>
                    </div>

                    <div class="form-group">
                        <label for="nguoi_lien_he">Người liên hệ</label>
                        <input type="text" name="nguoi_lien_he" id="nguoi_lien_he" placeholder="Tên người phụ trách">
                    </div>

                    <div class="form-group">
                        <label for="so_dien_thoai">Số điện thoại</label>
                        <input type="text" name="so_dien_thoai" id="so_dien_thoai" placeholder="Nhập số điện thoại">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="example@email.com">
                    </div>

                    <div class="form-group full">
                        <label for="dia_chi">Địa chỉ</label>
                        <input type="text" name="dia_chi" id="dia_chi" placeholder="Nhập địa chỉ nhà cung cấp">
                    </div>

                    <div class="form-group full">
                        <label for="ghi_chu">Ghi chú</label>
                        <textarea name="ghi_chu" id="ghi_chu" placeholder="Thông tin thêm về nhà cung cấp..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="trang_thai">Trạng thái</label>
                        <select name="trang_thai" id="trang_thai">
                            <option value="1">Đang hoạt động</option>
                            <option value="0">Ngưng hợp tác</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal()">Đóng</button>
            <button class="btn btn-primary" onclick="saveSupplier()">Lưu thông tin</button>
        </div>
    </div>
</div>

<script>
    const apiUrl = '../api/api_nha_cung_cap.php';
    let currentMode = 'create';
    let latestSuppliers = [];

    function showAlert(message, type = 'success') {
        const box = document.getElementById('alertBox');
        box.className = 'alert ' + type;
        box.innerText = message;

        setTimeout(() => {
            box.className = 'alert';
            box.innerText = '';
        }, 3000);
    }

    function openCreateModal() {
        currentMode = 'create';
        document.getElementById('modalTitle').innerText = 'Thêm nhà cung cấp';
        document.getElementById('supplierForm').reset();
        document.getElementById('id').value = '';
        document.getElementById('trang_thai').value = '1';document.getElementById('supplierModal').classList.add('show');
    }

    function closeModal() {
        document.getElementById('supplierModal').classList.remove('show');
    }

    function resetSearch() {
        document.getElementById('searchKeyword').value = '';
        loadSuppliers();
    }

    function updateStats(data) {
        const total = data.length;
        const active = data.filter(item => Number(item.trang_thai) === 1).length;
        const inactive = total - active;
        const hasEmail = data.filter(item => (item.email || '').trim() !== '').length;

        document.getElementById('statTotal').innerText = total;
        document.getElementById('statActive').innerText = active;
        document.getElementById('statInactive').innerText = inactive;
        document.getElementById('statHasEmail').innerText = hasEmail;
    }

    async function loadSuppliers() {
        const keyword = document.getElementById('searchKeyword').value.trim();
        const url = apiUrl + '?action=list&keyword=' + encodeURIComponent(keyword);

        const res = await fetch(url);
        const data = await res.json();

        const tbody = document.getElementById('supplierTableBody');
        tbody.innerHTML = '';

        if (!data.success) {
            tbody.innerHTML = `<tr><td colspan="9" class="empty-state">${escapeHtml(data.message)}</td></tr>`;
            updateStats([]);
            return;
        }

        latestSuppliers = data.data || [];
        updateStats(latestSuppliers);

        if (latestSuppliers.length === 0) {
            tbody.innerHTML = `<tr><td colspan="9" class="empty-state">Chưa có nhà cung cấp nào.</td></tr>`;
            return;
        }

        latestSuppliers.forEach(item => {
            const isActive = Number(item.trang_thai) === 1;
            const statusClass = isActive ? 'badge-success' : 'badge-danger';
            const statusText = isActive ? 'Đang hoạt động' : 'Ngưng hợp tác';

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>#${item.id}</td>
                <td>
                    <div class="supplier-name">${escapeHtml(item.ten_nha_cung_cap || '')}</div>
                    <div class="sub-text">${escapeHtml(item.ghi_chu || 'Không có ghi chú')}</div>
                </td>
                <td>${escapeHtml(item.nguoi_lien_he || '—')}</td>
                <td>${escapeHtml(item.so_dien_thoai || '—')}</td>
                <td>${escapeHtml(item.email || '—')}</td>
                <td>${escapeHtml(item.dia_chi || '—')}</td>
                <td><span class="badge ${statusClass}">${statusText}</span></td>
                <td>${formatDateTime(item.ngay_tao)}</td>
                <td>
                    <div class="action-group">
                        <button class="btn btn-warning" onclick="editSupplier(${item.id})">Sửa</button><button class="btn btn-secondary" onclick="toggleStatus(${item.id})">Ẩn/Hiện</button>
                        <button class="btn btn-danger" onclick="deleteSupplier(${item.id})">Xóa</button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    }

    async function editSupplier(id) {
        const res = await fetch(apiUrl + '?action=detail&id=' + id);
        const data = await res.json();

        if (!data.success) {
            showAlert(data.message, 'error');
            return;
        }

        currentMode = 'update';
        document.getElementById('modalTitle').innerText = 'Cập nhật nhà cung cấp';

        const item = data.data;
        document.getElementById('id').value = item.id || '';
        document.getElementById('ten_nha_cung_cap').value = item.ten_nha_cung_cap || '';
        document.getElementById('nguoi_lien_he').value = item.nguoi_lien_he || '';
        document.getElementById('so_dien_thoai').value = item.so_dien_thoai || '';
        document.getElementById('email').value = item.email || '';
        document.getElementById('dia_chi').value = item.dia_chi || '';
        document.getElementById('ghi_chu').value = item.ghi_chu || '';
        document.getElementById('trang_thai').value = item.trang_thai || 0;

        document.getElementById('supplierModal').classList.add('show');
    }

    async function saveSupplier() {
        const form = document.getElementById('supplierForm');
        const formData = new FormData(form);
        formData.append('action', currentMode === 'create' ? 'create' : 'update');

        const res = await fetch(apiUrl, {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        if (data.success) {
            closeModal();
            showAlert(data.message, 'success');
            loadSuppliers();
        } else {
            showAlert(data.message, 'error');
        }
    }

    async function deleteSupplier(id) {
        if (!confirm('Bạn có chắc muốn xóa nhà cung cấp này?')) return;

        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        const res = await fetch(apiUrl, {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        if (data.success) {
            showAlert(data.message, 'success');
            loadSuppliers();
        } else {
            showAlert(data.message, 'error');
        }
    }

    async function toggleStatus(id) {
        const formData = new FormData();
        formData.append('action', 'toggle_status');
        formData.append('id', id);

        const res = await fetch(apiUrl, {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        if (data.success) {
            showAlert(data.message, 'success');
            loadSuppliers();} else {
            showAlert(data.message, 'error');
        }
    }

    function formatDateTime(value) {
        if (!value) return '—';
        const d = new Date(value.replace(' ', 'T'));
        if (isNaN(d.getTime())) return value;
        return d.toLocaleString('vi-VN');
    }

    function escapeHtml(str) {
        return String(str).replace(/[&<>"']/g, function(m) {
            return ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[m];
        });
    }

    document.getElementById('searchKeyword').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            loadSuppliers();
        }
    });

    document.getElementById('supplierModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    loadSuppliers();
</script>
</body>
</html>