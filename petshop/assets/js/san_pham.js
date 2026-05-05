async function loadSanPham() {
  const table = document.querySelector("#tableSanPham tbody");

  table.innerHTML = "<tr><td colspan='8'>Đang tải...</td></tr>";

  try {
    const res = await fetch("/petshop/petshop/admin/api/api_san_pham.php?action=admin_list");
    const data = await res.json();

    console.log("DATA:", data); // debug

    if (!data.ok) {
      table.innerHTML = `<tr><td colspan="8">${data.msg}</td></tr>`;
      return;
    }

    if (!data.items || data.items.length === 0) {
      table.innerHTML = "<tr><td colspan='8'>Không có sản phẩm</td></tr>";
      return;
    }

    let html = "";

    data.items.forEach(sp => {
      html += `
        <tr>
          <td>${sp.id}</td>
          <td><img src="/petshop/petshop/assets/uploads/products/${sp.hinh_anh || 'no-image.jpg'}" width="50"></td>
          <td>${sp.ma_sku}</td>
          <td>${sp.ten_san_pham}</td>
          <td>${sp.ten_danh_muc || ''}</td>
          <td>${Number(sp.gia_ban).toLocaleString()} đ</td>
          <td>${sp.ton_kho}</td>
          <td>${sp.trang_thai == 1 ? "Bán" : "Ẩn"}</td>
          <td>
            <button onclick="editSP(${sp.id})">Sửa</button>
            <button onclick="deleteSP(${sp.id})">Xóa</button>
          </td>
        </tr>
      `;
    });

    table.innerHTML = html;

  } catch (err) {
    console.error(err);
    table.innerHTML = "<tr><td colspan='8'>Lỗi load dữ liệu</td></tr>";
  }
}