<?php
// include("config.php"); // nếu cần kết nối database
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý dịch vụ</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
        }
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: #fff;
        }
        .sidebar .nav-link {
            color: #ddd;
            transition: 0.3s;
        }
        .sidebar .nav-link:hover {
            background: #495057;
            color: #fff;
            border-radius: 6px;
        }
        .service-menu {
            margin-top: 8px;
            padding-left: 10px;
        }
        .menu-header {
            font-size: 0.9rem;
            font-weight: bold;
            color: #bbb;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .menu-item {
            display: block;
            color: #ddd;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            margin-bottom: 5px;
        }
        .menu-item:hover {
            background-color: #495057;
            color: #fff;
        }
        .menu-item.active {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .service-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 20px;
            transition: transform 0.2s ease;
        }
        .service-card:hover {
            transform: translateY(-5px);
        }
        .service-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .service-card .card-body {
            padding: 20px;
        }
        .service-card h4 {
    color: #444444; /* xám đậm */
    margin-bottom: 10px;
    font-weight: 600;
}

}

        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <nav class="sidebar p-3">
        <h4 class="text-white mb-4"><i class="fas fa-paw"></i> PetShop Admin</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDichVu" aria-expanded="true" aria-controls="collapseDichVu">
                    <i class="fas fa-concierge-bell"></i> DỊCH VỤ
                </a>
                <div id="collapseDichVu" class="collapse show">
                    <div class="service-menu">
                        <h6 class="menu-header">Danh mục dịch vụ</h6>
                        <a class="menu-item" href="spa.php"><i class="fas fa-cut"></i> Spa – Cắt tỉa lông</a>
                        <a class="menu-item" href="ho_boi.php"><i class="fas fa-swimmer"></i> Hồ bơi – Sân chơi thú cưng</a>
                        <a class="menu-item" href="khach_san.php"><i class="fas fa-hotel"></i> Hotel thú cưng – Day Care</a>
                    </div>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Nội dung chính -->
    <div class="content flex-grow-1">
        <h2 class="mb-4">Danh sách dịch vụ</h2>

        <!-- Card dịch vụ với hình ảnh -->
        <div class="service-card">
           <img src="../uploads/dichvuspa.jpg" alt="Spa thú cưng">
            <div class="card-body">
                <h4><i class="fas fa-cut"></i> Spa – Cắt tỉa lông</h4>
                <p>Dịch vụ spa chuyên nghiệp giúp thú cưng sạch sẽ, thơm tho và tạo kiểu lông đẹp mắt.</p>
            </div>
        </div>

        <div class="service-card">
            <img src="../uploads/ho_boi.jpg" alt="Hồ bơi thú cưng">
            <div class="card-body">
                <h4><i class="fas fa-swimmer"></i> Hồ bơi – Sân chơi thú cưng</h4>
                <p>Khu vui chơi và hồ bơi dành riêng cho thú cưng, giúp chúng vận động và giải trí an toàn.</p>
            </div>
        </div>

        <div class="service-card">
             <img src="../uploads/hotel.jpg" alt="Hotel thú cưng">
            <div class="card-body">
                <h4><i class="fas fa-hotel"></i> Hotel thú cưng – Day Care</h4>
                <p>Dịch vụ lưu trú và chăm sóc thú cưng với không gian tiện nghi, an toàn và thân thiện.</p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
