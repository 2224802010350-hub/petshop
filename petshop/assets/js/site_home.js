const IMG_BASE = "/PETSHOP/uploads/san_pham/";
function imgUrl(file){
  if (!file) return "/PETSHOP/assets/img/no-image.png";
  return IMG_BASE + file;
}

async function loadHomeProducts(){
  const box = document.getElementById("home-products");
  if (!box) return;

  box.innerHTML = "Đang tải...";

  const r = await fetch("/PETSHOP/api/api_trang_chu.php");
  const d = await r.json().catch(()=>null);

  // hỗ trợ nhiều kiểu trả về
  const items = (d && d.items) ? d.items : (Array.isArray(d) ? d : []);

  if (!items.length){
    box.innerHTML = "";
    const empty = document.getElementById("home-empty");
    if (empty) empty.style.display = "block";
    return;
  }

  box.innerHTML = items.map(sp => `
    <div class="card card--hover">
      <a href="/PETSHOP/trang_khach/chi_tiet.php?id=${sp.id}">
        <img class="card__img"
             src="${imgUrl(sp.hinh_anh)}"
             onerror="this.onerror=null;this.src='/PETSHOP/assets/img/no-image.png';"
             alt="">
      </a>
      <div class="card__body">
        <a class="card__title" href="/PETSHOP/trang_khach/chi_tiet.php?id=${sp.id}">
          ${sp.ten_san_pham}
        </a>
        <div class="rowLine">
          <div class="card__price">${Number(sp.gia_ban||0).toLocaleString('vi-VN')} ₫</div>
          <div class="muted">Tồn: <b>${sp.ton_kho ?? 0}</b></div>
        </div>
        <button class="btn btn--small w100" onclick="addToCart(${sp.id})">Thêm giỏ hàng</button>
      </div>
    </div>
  `).join("");
}

document.addEventListener("DOMContentLoaded", loadHomeProducts);
