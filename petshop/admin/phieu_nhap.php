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

include __DIR__ . "/_header.php";
?>

<style>
:root{
    --bg:#f3f6fb;
    --card:#ffffff;
    --text:#0f172a;
    --muted:#64748b;
    --line:#e2e8f0;
    --primary:#2563eb;
    --primary-hover:#1d4ed8;
    --success:#16a34a;
    --success-hover:#15803d;
    --danger:#ef4444;
    --danger-hover:#dc2626;
    --secondary:#64748b;
    --secondary-hover:#475569;
    --shadow:0 10px 30px rgba(15,23,42,.08);
    --radius:18px;
}

.phieuNhapPage *{
    box-sizing:border-box;
}

.phieuNhapPage{
    width:100%;
    color:var(--text);
}

.phieuNhapPage .wrap{
    padding:0;
    width:100%;
}

.phieuNhapPage .header{
    margin-bottom:20px;
}

.phieuNhapPage .header h1{
    margin:0;
    font-size:36px;
    font-weight:800;
}

.phieuNhapPage .header p{
    margin:8px 0 0;
    color:var(--muted);
    font-size:16px;
}

.phieuNhapPage .alert{
    display:none;
    margin-bottom:16px;
    padding:14px 16px;
    border-radius:14px;
    font-weight:700;
}

.phieuNhapPage .alert.success{
    display:block;
    background:#dcfce7;
    color:#166534;
    border:1px solid #bbf7d0;
}

.phieuNhapPage .alert.error{
    display:block;
    background:#fee2e2;
    color:#991b1b;
    border:1px solid #fecaca;
}

.phieuNhapPage .card{
    background:var(--card);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
    overflow:hidden;
    margin-bottom:18px;
    border:1px solid rgba(226,232,240,.8);
    width:100%;
    max-width:none;
}

.phieuNhapPage .card-head{
    padding:18px 20px;
    border-bottom:1px solid var(--line);
    font-size:22px;
    font-weight:800;
}

.phieuNhapPage .card-body{
    padding:20px;
}

.phieuNhapPage .grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px;
}

.phieuNhapPage .form-group{
    display:flex;
    flex-direction:column;
    gap:8px;
}

.phieuNhapPage .form-group.full{
    grid-column:1 / -1;
}

.phieuNhapPage .form-group label{
    font-weight:700;
    font-size:15px;
    color:#334155;
}

.phieuNhapPage input,
.phieuNhapPage select,
.phieuNhapPage textarea{
    width:100%;
    border:1px solid #dbe2ea;
    border-radius:14px;
    padding:13px 14px;
    font-size:15px;
    outline:none;
    background:#fff;
}

.phieuNhapPage input:focus,
.phieuNhapPage select:focus,
.phieuNhapPage textarea:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 4px rgba(37,99,235,.12);
}

.phieuNhapPage textarea{
    min-height:100px;
    resize:vertical;
}

.phieuNhapPage .inline{
    display:flex;
    gap:10px;
    align-items:center;
}

.phieuNhapPage .btn{
    border:none;
    border-radius:12px;
    padding:12px 16px;
    font-weight:700;
    font-size:14px;
    cursor:pointer;
    transition:.2s ease;
    white-space:nowrap;
}

.phieuNhapPage .btn:active{
    transform:scale(.98);
}

.phieuNhapPage .btn-primary{
    background:var(--primary);
    color:#fff;
}

.phieuNhapPage .btn-primary:hover{
    background:var(--primary-hover);
}

.phieuNhapPage .btn-secondary{
    background:var(--secondary);
    color:#fff;
}

.phieuNhapPage .btn-secondary:hover{
    background:var(--secondary-hover);
}

.phieuNhapPage .btn-success{
    background:var(--success);
    color:#fff;
}

.phieuNhapPage .btn-success:hover{
    background:var(--success-hover);
}

.phieuNhapPage .btn-danger{
    background:var(--danger);
    color:#fff;
}

.phieuNhapPage .btn-danger:hover{
    background:var(--danger-hover);
}

.phieuNhapPage .product-suggest-box{
    margin-top:10px;
    border:1px solid #dbe2ea;
    border-radius:14px;
    background:#fff;
    overflow:hidden;
    box-shadow:0 8px 20px rgba(15,23,42,.06);
}

.phieuNhapPage .product-suggest-title{
    padding:12px 14px;
    font-weight:700;
    border-bottom:1px solid #e5e7eb;
    background:#f8fafc;
}

.phieuNhapPage .product-suggest-list{
    max-height:300px;
    overflow-y:auto;
}

.phieuNhapPage .product-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding:12px 14px;
    border-bottom:1px solid #eef2f7;
}

.phieuNhapPage .product-item:last-child{
    border-bottom:none;
}

.phieuNhapPage .product-left{
    display:flex;
    gap:12px;
    align-items:center;
    min-width:0;
    flex:1;
}

.phieuNhapPage .product-thumb{
    width:54px;
    height:54px;
    border-radius:10px;
    object-fit:cover;
    background:#f8fafc;
    border:1px solid #e5e7eb;
}

.phieuNhapPage .product-info{
    min-width:0;
    flex:1;
}

.phieuNhapPage .product-name{
    font-weight:700;
    margin-bottom:4px;
}

.phieuNhapPage .product-meta{
    font-size:13px;
    color:var(--muted);
}

.phieuNhapPage .empty-text{
    padding:14px;
    color:var(--muted);
}

.phieuNhapPage .table-wrap{
    overflow-x:auto;
    margin-top:18px;
}

.phieuNhapPage table{
    width:100%;
    border-collapse:collapse;
    min-width:980px;
}

.phieuNhapPage th,
.phieuNhapPage td{
    padding:14px;
    border-bottom:1px solid #e5e7eb;
    text-align:left;
    vertical-align:middle;
}

.phieuNhapPage th{
    background:#f8fafc;
    font-size:15px;
    font-weight:800;
    color:#334155;
}

.phieuNhapPage .summary{
    margin-top:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    flex-wrap:wrap;
}

.phieuNhapPage .summary-total{
    font-size:28px;
    font-weight:800;
}

.phieuNhapPage .action-row{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.phieuNhapPage .status{
    display:inline-block;
    padding:7px 12px;
    border-radius:999px;
    font-size:13px;
    font-weight:800;
    white-space:nowrap;
}

.phieuNhapPage .draft,
.phieuNhapPage .badge-low{
    background:#e2e8f0;
    color:#334155;
}

.phieuNhapPage .confirmed,
.phieuNhapPage .badge-ok{
    background:#dcfce7;
    color:#166534;
}

.phieuNhapPage .cancelled,
.phieuNhapPage .badge-out{
    background:#fee2e2;
    color:#991b1b;
}

.phieuNhapPage .qty-input,
.phieuNhapPage .price-input{
    max-width:150px;
}

@media (max-width:900px){
    .phieuNhapPage .grid{
        grid-template-columns:1fr;
    }
}

@media (max-width:768px){
    .phieuNhapPage .header h1{
        font-size:30px;
    }

    .phieuNhapPage .inline{
        flex-direction:column;
        align-items:stretch;
    }

    .phieuNhapPage .btn{
        width:100%;
    }

    .phieuNhapPage .summary{
        align-items:flex-start;
    }
}
</style>

<div class="phieuNhapPage">
    <div class="wrap">
        <div class="header">
            <h1>Phiếu nhập kho</h1>
            <p>Chọn nhà cung cấp, tìm sản phẩm đã có trong hệ thống và tạo phiếu nhập thực tế.</p>
        </div>

        <div id="alertBox" class="alert"></div>

        <div class="card">
            <div class="card-head">Tạo phiếu nhập mới</div>
            <div class="card-body">
                <div class="grid">
                    <div class="form-group">
                        <label for="nha_cung_cap_id">Nhà cung cấp</label>
                        <select id="nha_cung_cap_id">
                            <option value="">-- Đang tải nhà cung cấp --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="searchProductKeyword">Tìm sản phẩm đã thêm trong hệ thống</label>
                        <div class="inline">
                            <input type="text" id="searchProductKeyword" placeholder="Nhập tên sản phẩm hoặc mã SKU...">
                            <button type="button" class="btn btn-secondary" onclick="loadProducts()">Tìm</button>
                        </div>

                        <div id="productSuggestBox" class="product-suggest-box" style="display:none;">
                            <div class="product-suggest-title">Danh sách sản phẩm</div>
                            <div id="productSuggestList" class="product-suggest-list">
                                <div class="empty-text">Nhập từ khóa để tìm sản phẩm.</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group full">
                        <label for="ghi_chu">Ghi chú</label>
                        <textarea id="ghi_chu" placeholder="Ví dụ: Nhập hàng đợt 1 tháng này..."></textarea>
                    </div>
                </div>

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Tồn hiện tại</th>
                                <th>Số lượng nhập</th>
                                <th>Giá nhập</th>
                                <th>Thành tiền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="selectedItemsBody">
                            <tr>
                                <td colspan="6" class="empty-text">Chưa có sản phẩm nào trong phiếu.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="summary">
                    <div class="summary-total">Tổng tiền: <span id="tongTien">0</span> đ</div>
                    <div class="action-row">
                        <button type="button" class="btn btn-primary" onclick="loadProducts()">Tìm sản phẩm</button>
                        <button type="button" class="btn btn-success" onclick="savePhieuNhap()">Lưu phiếu nhập</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-head">Danh sách phiếu nhập</div>
            <div class="card-body">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã phiếu</th>
                                <th>Nhà cung cấp</th>
                                <th>Ngày nhập</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ghi chú</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="phieuNhapTableBody">
                            <tr>
                                <td colspan="7" class="empty-text">Đang tải dữ liệu...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const apiUrl = '../api/api_phieu_nhap.php';
const noImage = '../assets/img/no-image.jpg';
let selectedItems = [];
let productList = [];

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
    if (!path) return '/petshop/petshop/assets/img/no-image.jpg';
    if (path.startsWith('http')) return path;
    if (path.startsWith('/')) return path;
    return '/petshop/petshop/assets/uploads/products/' + path;
}

async function loadSuppliers() {
    const select = document.getElementById('nha_cung_cap_id');
    select.innerHTML = '<option value="">-- Đang tải nhà cung cấp --</option>';

    try {
        const res = await fetch(apiUrl + '?action=suppliers');
        const text = await res.text();
        const data = JSON.parse(text);

        select.innerHTML = '<option value="">-- Chọn nhà cung cấp --</option>';

        if (!data.success) {
            select.innerHTML = '<option value="">Không tải được nhà cung cấp</option>';
            showAlert(data.message || 'Không tải được nhà cung cấp.', 'error');
            return;
        }

        if (!data.data || data.data.length === 0) {
            select.innerHTML = '<option value="">Chưa có nhà cung cấp hoạt động</option>';
            return;
        }

        data.data.forEach(item => {
            const textOption = `${item.ten_nha_cung_cap}` +
                (item.nguoi_lien_he ? ` - ${item.nguoi_lien_he}` : '') +
                (item.so_dien_thoai ? ` - ${item.so_dien_thoai}` : '');

            select.innerHTML += `<option value="${item.id}">${escapeHtml(textOption)}</option>`;
        });
    } catch (e) {
        select.innerHTML = '<option value="">Lỗi tải nhà cung cấp</option>';
        showAlert('API nhà cung cấp đang lỗi. Kiểm tra file api/api_phieu_nhap.php', 'error');
        console.error(e);
    }
}

async function loadProducts() {
    const keyword = document.getElementById('searchProductKeyword').value.trim();
    const box = document.getElementById('productSuggestBox');
    const list = document.getElementById('productSuggestList');

    box.style.display = 'block';
    list.innerHTML = `<div class="empty-text">Đang tải...</div>`;

    try {
        const res = await fetch(apiUrl + '?action=products&keyword=' + encodeURIComponent(keyword));
        const text = await res.text();
        const data = JSON.parse(text);

        if (!data.success) {
            list.innerHTML = `<div class="empty-text">${escapeHtml(data.message || 'Không tải được sản phẩm.')}</div>`;
            return;
        }

        if (!data.data || data.data.length === 0) {
            list.innerHTML = `<div class="empty-text">Không tìm thấy sản phẩm phù hợp.</div>`;
            return;
        }

        productList = data.data;

        list.innerHTML = data.data.map(item => `
            <div class="product-item">
                <div class="product-left">
                    <img
                        class="product-thumb"
                        src="${imagePath(item.hinh_anh)}"
                        onerror="this.src='/petshop/petshop/assets/img/no-image.jpg'">
                    <div class="product-info">
                        <div class="product-name">${escapeHtml(item.ten_san_pham)}</div>
                        <div class="product-meta">
                            SKU: ${escapeHtml(item.ma_sku || '—')} |
                            Tồn hiện tại: ${Number(item.ton_hien_tai || 0)} |
                            Giá bán: ${formatMoney(item.gia_ban || 0)} đ
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="addProduct(${item.id})">Chọn</button>
            </div>
        `).join('');
    } catch (e) {
        list.innerHTML = `<div class="empty-text">Lỗi tải sản phẩm. Kiểm tra API.</div>`;
        console.error(e);
    }
}

function addProduct(id) {
    const found = productList.find(p => Number(p.id) === Number(id));
    if (!found) return;

    const existed = selectedItems.find(p => Number(p.san_pham_id) === Number(id));
    if (existed) {
        showAlert('Sản phẩm đã có trong phiếu nhập.', 'error');
        return;
    }

    selectedItems.push({
        san_pham_id: Number(found.id),
        ma_sku: found.ma_sku || '',
        ten_san_pham: found.ten_san_pham,
        ton_hien_tai: Number(found.ton_hien_tai || 0),
        so_luong: 1,
        gia_nhap: Number(found.gia_ban || 0)
    });

    renderSelectedItems();

    document.getElementById('searchProductKeyword').value = '';
    document.getElementById('productSuggestBox').style.display = 'none';
}

function updateItem(index, field, value) {
    const num = Number(value);
    selectedItems[index][field] = isNaN(num) ? 0 : num;
    renderSelectedItems();
}

function removeItem(index) {
    selectedItems.splice(index, 1);
    renderSelectedItems();
}

function renderSelectedItems() {
    const tbody = document.getElementById('selectedItemsBody');
    tbody.innerHTML = '';

    if (selectedItems.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="empty-text">Chưa có sản phẩm nào trong phiếu.</td></tr>`;
        document.getElementById('tongTien').innerText = '0';
        return;
    }

    let tong = 0;

    selectedItems.forEach((item, index) => {
        const soLuong = Number(item.so_luong || 0);
        const giaNhap = Number(item.gia_nhap || 0);
        const thanhTien = soLuong * giaNhap;
        tong += thanhTien;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <strong>${escapeHtml(item.ten_san_pham)}</strong><br>
                <span style="color:#64748b;font-size:13px;">SKU: ${escapeHtml(item.ma_sku || '—')}</span>
            </td>
            <td>${item.ton_hien_tai}</td>
            <td>
                <input class="qty-input" type="number" min="1" value="${soLuong}" onchange="updateItem(${index}, 'so_luong', this.value)">
            </td>
            <td>
                <input class="price-input" type="number" min="0" step="1000" value="${giaNhap}" onchange="updateItem(${index}, 'gia_nhap', this.value)">
            </td>
            <td>${formatMoney(thanhTien)} đ</td>
            <td>
                <button type="button" class="btn btn-danger" onclick="removeItem(${index})">Xóa</button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    document.getElementById('tongTien').innerText = formatMoney(tong);
}

async function savePhieuNhap() {
    const nhaCungCapId = document.getElementById('nha_cung_cap_id').value;
    const ghiChu = document.getElementById('ghi_chu').value.trim();

    if (!nhaCungCapId) {
        showAlert('Vui lòng chọn nhà cung cấp.', 'error');
        return;
    }

    if (selectedItems.length === 0) {
        showAlert('Vui lòng thêm ít nhất 1 sản phẩm.', 'error');
        return;
    }

    for (const item of selectedItems) {
        if (Number(item.so_luong) <= 0) {
            showAlert('Số lượng nhập phải lớn hơn 0.', 'error');
            return;
        }
        if (Number(item.gia_nhap) < 0) {
            showAlert('Giá nhập không hợp lệ.', 'error');
            return;
        }
    }

    const formData = new FormData();
    formData.append('action', 'create');
    formData.append('nha_cung_cap_id', nhaCungCapId);
    formData.append('ghi_chu', ghiChu);
    formData.append('items', JSON.stringify(selectedItems));

    const res = await fetch(apiUrl, {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    if (data.success) {
        showAlert(data.message, 'success');

        document.getElementById('nha_cung_cap_id').value = '';
        document.getElementById('ghi_chu').value = '';
        document.getElementById('searchProductKeyword').value = '';
        document.getElementById('productSuggestBox').style.display = 'none';

        selectedItems = [];
        renderSelectedItems();
        loadDanhSachPhieuNhap();
    } else {
        showAlert(data.message, 'error');
    }
}

async function loadDanhSachPhieuNhap() {
    const tbody = document.getElementById("phieuNhapTableBody");

    tbody.innerHTML = `
        <tr>
            <td colspan="7" class="empty-text">Đang tải dữ liệu...</td>
        </tr>
    `;

    try {
        const res = await fetch(apiUrl + "?action=list&t=" + Date.now(), {
            credentials: "same-origin",
            cache: "no-store"
        });

        const data = await res.json();

        if (!data.success) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="empty-text">${escapeHtml(data.message || "Không tải được danh sách phiếu nhập")}</td>
                </tr>
            `;
            return;
        }

        const items = data.data || [];

        if (items.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="empty-text">Chưa có phiếu nhập.</td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = items.map(p => {
            const trangThai = p.trang_thai || "draft";

            return `
                <tr>
                    <td><b>${escapeHtml(p.ma_phieu || ("PN#" + p.id))}</b></td>
                    <td>${escapeHtml(p.ten_nha_cung_cap || "-")}</td>
                    <td>${escapeHtml(p.ngay_nhap || "-")}</td>
                    <td><b>${formatMoney(p.tong_tien || 0)} đ</b></td>
                    <td>${hienTrangThaiPhieu(trangThai)}</td>
                    <td>${escapeHtml(p.ghi_chu || "—")}</td>
                    <td>
    <div style="display:flex;gap:6px;flex-wrap:wrap">

        <button class="btn btn-secondary"
            onclick="viewPhieuNhap(${p.id})">
            Chi tiết
        </button>

        <button class="btn btn-success"
            onclick="printPhieuNhap(${p.id})">
            In
        </button>

        ${trangThai === "draft" ? `
            <button class="btn btn-primary"
                onclick="confirmPhieuNhap(${p.id})">
                Xác nhận
            </button>

            <button class="btn btn-danger"
                onclick="cancelPhieuNhap(${p.id})">
                Hủy
            </button>
        ` : ""}
    </div>
</td>
                </tr>
            `;
        }).join("");

    } catch (error) {
        console.error(error);
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="empty-text">Lỗi tải dữ liệu. Kiểm tra API.</td>
            </tr>
        `;
    }
}

function hienTrangThaiPhieu(trangThai) {
    if (trangThai === "confirmed") {
        return `<span class="status confirmed">Đã nhập kho</span>`;
    }

    if (trangThai === "cancelled") {
        return `<span class="status cancelled">Đã hủy</span>`;
    }

    return `<span class="status draft">Nháp</span>`;
}

async function confirmPhieuNhap(id) {
    if (!confirm('Xác nhận phiếu nhập này? Khi xác nhận sẽ cộng số lượng vào tồn kho.')) return;

    const formData = new FormData();
    formData.append('action', 'confirm');
    formData.append('id', id);

    const res = await fetch(apiUrl, {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    if (data.success) {
        showAlert(data.message, 'success');
        loadDanhSachPhieuNhap();
    } else {
        showAlert(data.message, 'error');
    }
}

async function cancelPhieuNhap(id) {
    if (!confirm('Bạn có chắc muốn hủy phiếu nhập này?')) return;

    const formData = new FormData();
    formData.append('action', 'cancel');
    formData.append('id', id);

    const res = await fetch(apiUrl, {
        method: 'POST',
        body: formData
    });

    const data = await res.json();

    if (data.success) {
        showAlert(data.message, 'success');
        loadDanhSachPhieuNhap();
    } else {
        showAlert(data.message, 'error');
    }
}

document.getElementById('searchProductKeyword').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        loadProducts();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    loadSuppliers();
    renderSelectedItems();
    loadDanhSachPhieuNhap();
});
function viewPhieuNhap(id){
    window.location.href =
    "chi_tiet_phieu_nhap.php?id=" + id;
}

function printPhieuNhap(id){
    window.open(
        "in_phieu_nhap.php?id=" + id,
        "_blank"
    );
}
</script>

<?php include __DIR__ . "/_footer.php"; ?>