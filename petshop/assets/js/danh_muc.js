async function tai() {
    const res = await fetch('/petshop/api/api_danh_muc.php');
    const data = await res.json();
  
    const tbody = document.querySelector('#tb tbody');
    tbody.innerHTML = '';
    data.forEach(dm => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${dm.id}</td>
        <td><input data-ten="${dm.id}" value="${dm.ten_danh_muc}"></td>
        <td>
          <select data-loai="${dm.id}">
            ${['CHO','MEO','PHU_KIEN','DICH_VU'].map(x=>`<option ${x===dm.loai?'selected':''} value="${x}">${x}</option>`).join('')}
          </select>
        </td>
        <td>
          <button data-sua="${dm.id}">Luu</button>
          <button data-xoa="${dm.id}">Xoa</button>
        </td>`;
      tbody.appendChild(tr);
    });
  }
  
  document.getElementById('formThem').addEventListener('submit', async (e)=>{
    e.preventDefault();
    const msg = document.getElementById('msg');
    const fd = new FormData(e.target);
    fd.append('action','create');
  
    const res = await fetch('/petshop/api/api_danh_muc.php',{method:'POST', body:fd});
    const data = await res.json().catch(()=> ({}));
    msg.textContent = res.ok ? 'OK' : (data.thong_bao || 'Loi');
    if(res.ok){ e.target.reset(); tai(); }
  });
  
  document.addEventListener('click', async (e)=>{
    const idSua = e.target.getAttribute('data-sua');
    const idXoa = e.target.getAttribute('data-xoa');
  
    if(idSua){
      const ten = document.querySelector(`input[data-ten="${idSua}"]`).value;
      const loai = document.querySelector(`select[data-loai="${idSua}"]`).value;
      const fd = new FormData();
      fd.append('action','update'); fd.append('id',idSua);
      fd.append('ten_danh_muc',ten); fd.append('loai',loai);
      await fetch('/petshop/api/api_danh_muc.php',{method:'POST', body:fd});
      tai();
    }
  
    if(idXoa){
      if(!confirm('Xoa danh muc?')) return;
      const fd = new FormData();
      fd.append('action','delete'); fd.append('id',idXoa);
      await fetch('/petshop/api/api_danh_muc.php',{method:'POST', body:fd});
      tai();
    }
  });
  
  tai();
  