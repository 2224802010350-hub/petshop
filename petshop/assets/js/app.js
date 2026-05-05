async function api(url, opts = {}) {
  const res = await fetch(url, opts);
  const data = await res.json().catch(()=>({ok:false,msg:"JSON lỗi"}));
  if (!data.ok) throw new Error(data.message || data.msg || "API error");
  return data;
}

async function addToCart(id) {
  const data = await api(`/PETSHOP/api/api_gio_hang.php?action=add&id=${id}`);
  alert(data.message || "Đã thêm vào giỏ!");
  location.reload();
}

async function cartUpdate(id, qty) {
  const data = await api(`/PETSHOP/api/api_gio_hang.php?action=update&id=${id}&qty=${qty}`);
  alert(data.message || "Đã cập nhật!");
  location.reload();
}

async function cartRemove(id) {
  const data = await api(`/PETSHOP/api/api_gio_hang.php?action=remove&id=${id}`);
  alert(data.message || "Đã xóa!");
  location.reload();
}
