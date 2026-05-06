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
    --success-bg:#dcfce7;
    --success-text:#166534;
    --danger-bg:#fee2e2;
    --danger-text:#991b1b;
    --secondary:#64748b;
    --secondary-hover:#475569;
    --shadow:0 10px 30px rgba(15,23,42,.08);
    --radius:18px;
}

.page-wrap{
    padding:28px;
    width:100%;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    margin-bottom:22px;
    flex-wrap:wrap;
}

.page-title{
    display:flex;
    flex-direction:column;
    gap:6px;
}

.page-title h1{
    margin:0;
    font-size:34px;
    line-height:1.2;
    font-weight:800;
    color:#0f172a;
}

.page-title p{
    margin:0;
    color:var(--muted);
    font-size:15px;
}

.toolbar-card,
.table-card,
.stats-card{
    background:var(--card);
    border-radius:var(--radius);
    box-shadow:var(--shadow);
    border:1px solid rgba(226,232,240,.8);
}

.toolbar-card{
    padding:18px;
    margin-bottom:20px;
}

.toolbar{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    align-items:center;
}

.search-box{
    flex:1;
    min-width:280px;
}

.search-box input{
    width:100%;
    height:48px;
    border:1px solid var(--line);
    border-radius:14px;
    padding:0 16px;
    font-size:15px;
    outline:none;
    transition:.2s ease;
}

.search-box input:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 4px rgba(37,99,235,.12);
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:16px;
    margin-bottom:20px;
}

.stats-card{
    padding:18px;
}

.stats-label{
    color:var(--muted);
    font-size:14px;
    margin-bottom:10px;
}

.stats-value{
    font-size:28px;
    font-weight:800;
    color:#0f172a;
}

.table-card{
    overflow:hidden;
}

.table-card-header{
    padding:18px 20px;
    border-bottom:1px solid var(--line);
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.table-card-header h2{
    margin:0;
    font-size:20px;
    font-weight:800;
}

.table-card-header span{
    color:var(--muted);
    font-size:14px;
}

.table-wrap{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
    min-width:1100px;
}

thead th{
    background:#f8fafc;
    color:#475569;
    text-align:left;
    font-size:14px;
    font-weight:700;
    padding:16px;
    border-bottom:1px solid var(--line);
}

tbody td{
    padding:18px 16px;
    border-bottom:1px solid #eef2f7;
    vertical-align:middle;
}

tbody tr:hover{
    background:#f8fbff;
}

.supplier-name{
    font-weight:700;
    color:#0f172a;
}

.sub-text{
    color:var(--muted);
    font-size:13px;
    margin-top:4px;
}

.badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:34px;
    padding:0 14px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
}

.badge-success{
    background:var(--success-bg);
    color:var(--success-text);
}

.badge-danger{
    background:var(--danger-bg);
    color:var(--danger-text);
}

.btn{
    border:none;
    border-radius:12px;
    height:44px;
    padding:0 18px;
    font-weight:700;
    font-size:14px;
    cursor:pointer;
    transition:.2s ease;
}

.btn-primary{
    background:var(--primary);
    color:#fff;
}

.btn-primary:hover{
    background:var(--primary-hover);
}

.btn-secondary{
    background:var(--secondary);
    color:#fff;
}

.btn-secondary:hover{
    background:var(--secondary-hover);
}

.btn-warning{
    background:#f59e0b;
    color:#fff;
}

.btn-danger{
    background:#ef4444;
    color:#fff;
}

.btn-ghost{
    background:#eef2ff;
    color:#3730a3;
}

.action-group{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
}

.alert{
    display:none;
    margin-bottom:18px;
    padding:14px 16px;
    border-radius:14px;
    font-weight:600;
}

.alert.success{
    display:block;
    background:#ecfdf3;
    color:#166534;
}

.alert.error{
    display:block;
    background:#fef2f2;
    color:#991b1b;
}

.empty-state{
    text-align:center;
    padding:42px 20px;
    color:var(--muted);
}

.modal{
    position:fixed;
    inset:0;
    background:rgba(15,23,42,.45);
    display:none;
    align-items:center;
    justify-content:center;
    padding:20px;
    z-index:9999;
}

.modal.show{
    display:flex;
}

.modal-content{
    width:100%;
    max-width:820px;
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 18px 50px rgba(15,23,42,.2);
}

.modal-header{
    padding:20px 24px;
    border-bottom:1px solid var(--line);
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.modal-header h3{
    margin:0;
    font-size:22px;
    font-weight:800;
}

.modal-body{
    padding:24px;
}

.modal-footer{
    padding:18px 24px;
    border-top:1px solid var(--line);
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.form-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.form-group{
    display:flex;
    flex-direction:column;
    gap:8px;
}

.form-group.full{
    grid-column:1 / -1;
}

.form-group label{
    font-size:14px;
    font-weight:700;
    color:#334155;
}

.form-group input,
.form-group textarea,
.form-group select{
    width:100%;
    border:1px solid var(--line);
    border-radius:14px;
    padding:12px 14px;
    font-size:15px;
    outline:none;
}

.form-group textarea{
    min-height:110px;
    resize:vertical;
}

@media(max-width:768px){
    .page-wrap{
        padding:16px;
    }

    .stats-grid,
    .form-grid{
        grid-template-columns:1fr;
    }
}
</style>

<div class="page-wrap">

    <div class="page-header">
        <div class="page-title">
            <h1>Quản lý nhà cung cấp</h1>
            <p>Theo dõi thông tin đối tác cung ứng cho hệ thống petshop.</p>
        </div>

        <button class="btn btn-primary" onclick="openCreateModal()">
            + Thêm nhà cung cấp
        </button>
    </div>

    <div id="alertBox" class="alert"></div>

    <div class="stats-grid">
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
            <div class="stats-label">Có email</div>
            <div class="stats-value" id="statHasEmail">0</div>
        </div>
    </div>

    <div class="toolbar-card">
        <div class="toolbar">
            <div class="search-box">
                <input
                    type="text"
                    id="searchKeyword"
                    placeholder="Tìm theo tên, email, số điện thoại...">
            </div>

            <button class="btn btn-secondary" onclick="loadSuppliers()">
                Tìm kiếm
            </button>

            <button class="btn btn-ghost" onclick="resetSearch()">
                Làm mới
            </button>
        </div>
    </div>

    <div class="table-card">

        <div class="table-card-header">
            <div>
                <h2>Danh sách nhà cung cấp</h2>
                <span>Hiển thị toàn bộ dữ liệu trong hệ thống</span>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên nhà cung cấp</th>
                        <th>Người liên hệ</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody id="supplierTableBody">
                    <tr>
                        <td colspan="9" class="empty-state">
                            Đang tải dữ liệu...
                        </td>
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

                    <div class="form-group">
                        <label>Tên nhà cung cấp</label>
                        <input type="text" name="ten_nha_cung_cap" id="ten_nha_cung_cap" required>
                    </div>

                    <div class="form-group">
                        <label>Người liên hệ</label>
                        <input type="text" name="nguoi_lien_he" id="nguoi_lien_he">
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="so_dien_thoai" id="so_dien_thoai">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email">
                    </div>

                    <div class="form-group full">
                        <label>Địa chỉ</label>
                        <input type="text" name="dia_chi" id="dia_chi">
                    </div>

                    <div class="form-group full">
                        <label>Ghi chú</label>
                        <textarea name="ghi_chu" id="ghi_chu"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Trạng thái</label>

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

function showAlert(message, type='success'){
    const box = document.getElementById('alertBox');

    box.className = 'alert ' + type;
    box.innerText = message;

    setTimeout(()=>{
        box.className='alert';
        box.innerText='';
    },3000);
}

function openCreateModal(){
    currentMode='create';

    document.getElementById('modalTitle').innerText='Thêm nhà cung cấp';

    document.getElementById('supplierForm').reset();

    document.getElementById('id').value='';

    document.getElementById('supplierModal').classList.add('show');
}

function closeModal(){
    document.getElementById('supplierModal').classList.remove('show');
}

function resetSearch(){
    document.getElementById('searchKeyword').value='';
    loadSuppliers();
}

function updateStats(data){
    document.getElementById('statTotal').innerText = data.length;
    document.getElementById('statActive').innerText =
        data.filter(x=>Number(x.trang_thai)===1).length;

    document.getElementById('statInactive').innerText =
        data.filter(x=>Number(x.trang_thai)!==1).length;

    document.getElementById('statHasEmail').innerText =
        data.filter(x=>(x.email||'').trim()!=='').length;
}

async function loadSuppliers(){

    const keyword = document.getElementById('searchKeyword').value.trim();

    const res = await fetch(
        apiUrl + '?action=list&keyword=' + encodeURIComponent(keyword)
    );

    const data = await res.json();

    const tbody = document.getElementById('supplierTableBody');

    tbody.innerHTML='';

    if(!data.success){
        tbody.innerHTML=`
            <tr>
                <td colspan="9" class="empty-state">
                    ${data.message}
                </td>
            </tr>
        `;
        return;
    }

    const items = data.data || [];

    updateStats(items);

    if(items.length===0){
        tbody.innerHTML=`
            <tr>
                <td colspan="9" class="empty-state">
                    Chưa có dữ liệu
                </td>
            </tr>
        `;
        return;
    }

    items.forEach(item=>{

        const tr=document.createElement('tr');

        tr.innerHTML=`
            <td>#${item.id}</td>

            <td>
                <div class="supplier-name">
                    ${item.ten_nha_cung_cap || ''}
                </div>

                <div class="sub-text">
                    ${item.ghi_chu || 'Không có ghi chú'}
                </div>
            </td>

            <td>${item.nguoi_lien_he || '—'}</td>
            <td>${item.so_dien_thoai || '—'}</td>
            <td>${item.email || '—'}</td>
            <td>${item.dia_chi || '—'}</td>

            <td>
                ${
                    Number(item.trang_thai)===1
                    ? '<span class="badge badge-success">Đang hoạt động</span>'
                    : '<span class="badge badge-danger">Ngưng hợp tác</span>'
                }
            </td>

            <td>${item.ngay_tao || '—'}</td>

            <td>
                <div class="action-group">
                    <button class="btn btn-warning" onclick="editSupplier(${item.id})">
                        Sửa
                    </button>

                    <button class="btn btn-danger" onclick="deleteSupplier(${item.id})">
                        Xóa
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(tr);
    });
}

async function editSupplier(id){

    const res = await fetch(apiUrl + '?action=detail&id=' + id);

    const data = await res.json();

    if(!data.success){
        showAlert(data.message,'error');
        return;
    }

    currentMode='update';

    document.getElementById('modalTitle').innerText='Cập nhật nhà cung cấp';

    const item=data.data;

    document.getElementById('id').value=item.id || '';
    document.getElementById('ten_nha_cung_cap').value=item.ten_nha_cung_cap || '';
    document.getElementById('nguoi_lien_he').value=item.nguoi_lien_he || '';
    document.getElementById('so_dien_thoai').value=item.so_dien_thoai || '';
    document.getElementById('email').value=item.email || '';
    document.getElementById('dia_chi').value=item.dia_chi || '';
    document.getElementById('ghi_chu').value=item.ghi_chu || '';
    document.getElementById('trang_thai').value=item.trang_thai || 0;

    document.getElementById('supplierModal').classList.add('show');
}

async function saveSupplier(){

    const form = document.getElementById('supplierForm');

    const formData = new FormData(form);

    formData.append(
        'action',
        currentMode==='create' ? 'create' : 'update'
    );

    const res = await fetch(apiUrl,{
        method:'POST',
        body:formData
    });

    const data = await res.json();

    if(data.success){
        closeModal();
        showAlert(data.message,'success');
        loadSuppliers();
    }else{
        showAlert(data.message,'error');
    }
}

async function deleteSupplier(id){

    if(!confirm('Bạn có chắc muốn xóa?')) return;

    const fd = new FormData();

    fd.append('action','delete');
    fd.append('id',id);

    const res = await fetch(apiUrl,{
        method:'POST',
        body:fd
    });

    const data = await res.json();

    if(data.success){
        showAlert(data.message,'success');
        loadSuppliers();
    }else{
        showAlert(data.message,'error');
    }
}

document.getElementById('searchKeyword').addEventListener('keydown',function(e){
    if(e.key==='Enter'){
        loadSuppliers();
    }
});

document.getElementById('supplierModal').addEventListener('click',function(e){
    if(e.target===this){
        closeModal();
    }
});

loadSuppliers();
</script>

<?php include __DIR__ . "/_footer.php"; ?>