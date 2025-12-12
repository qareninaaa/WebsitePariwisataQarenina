// --- ambil data dari API
let dataWisata = [];

function fetchWisataAndInit(){
  fetch("../api/get_wisata.php")
    .then(r => r.json())
    .then(data => {
      dataWisata = data.map(d => ({
        id: String(d.id),
        title: d.title,
        img: d.img,
        desc: d.desc || ''
      }));

      // ❗❗ HANYA panggil renderMenuCards, BUKAN favori
      if(document.querySelector('#cards')) renderMenuCards();
    });
}
fetchWisataAndInit();


// ----- RENDER CARDS (menu page) -----
function renderMenuCards(filter = '') {
  const cardsEl = document.querySelector('#cards');
  if (!cardsEl) return;
  cardsEl.innerHTML = '';
  const q = filter.trim().toLowerCase();
  dataWisata.forEach(item => {
    if (q && !item.title.toLowerCase().includes(q) && !item.desc.toLowerCase().includes(q)) return;
    const card = document.createElement('article');
    card.className = 'card';
    card.innerHTML = `
      <img src="${item.img}" alt="${item.title}">
      <div class="card-body">
        <h3>${item.title}</h3>
        <p>${item.desc}</p>
        <div class="card-actions">
          <button class="btn small outline detail-btn" data-id="${item.id}">Detail</button>
          <button class="btn small fav-btn" data-id="${item.id}">Tambah Favorit</button>
        </div>
      </div>
    `;
    cardsEl.appendChild(card);
  });

  document.querySelectorAll('.detail-btn').forEach(btn => {
    btn.addEventListener('click', e => openModal(e.target.dataset.id, false));
  });
  document.querySelectorAll('.fav-btn').forEach(btn => {
    btn.addEventListener('click', e => addToFavorite(e.target.dataset.id));
  });
}



// ----- FAVORIT STORAGE via API -----
function getFavorit(){
  return fetch("../api/favorit_list.php?id_user=1").then(r=>r.json());
}

function addToFavorite(id){
  return fetch("../api/favorit_add.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id_user=1&id_wisata=${encodeURIComponent(id)}`
  })
  .then(r=>r.json())
  .then(res=>{
    if(res.success) alert('Berhasil ditambahkan ke favorit');
    else alert('Gagal menambahkan favorit');
  });
}

function removeFromFavorite(id){
  return fetch("../api/favorit_delete.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id_user=1&id_wisata=${encodeURIComponent(id)}`
  })
  .then(r=>r.json())
  .then(res=>{
    if(res.success) alert('Berhasil dihapus dari favorit');
    else alert('Gagal menghapus favorit');
    renderFavoritCards();
  });
}



// ----- RENDER FAVORIT PAGE -----
function renderFavoritCards(filter=''){
  const container = document.querySelector('#favCards');
  const emptyMsg = document.querySelector('#emptyMsg');
  if(!container) return;
  
  container.innerHTML = ''; // sangat penting agar tidak dobel

  getFavorit().then(favs=>{
    const q = filter.trim().toLowerCase();
    const filtered = favs.filter(i => !q || i.title.toLowerCase().includes(q) || i.desc.toLowerCase().includes(q));
    
    if(filtered.length===0){
      emptyMsg.style.display = 'block';
    } 
    else {
      emptyMsg.style.display = 'none';
      filtered.forEach(item=>{
        const card = document.createElement('article');
        card.className = 'card';
        card.innerHTML = `
          <img src="${item.img}" alt="${item.title}">
          <div class="card-body">
            <h3>${item.title}</h3>
            <p>${item.desc}</p>
            <div class="card-actions">
              <button class="btn small outline detail-btn" data-id="${item.id}">Detail</button>
              <button class="btn small danger remove-fav" data-id="${item.id}">Hapus Favorit</button>
            </div>
          </div>
        `;
        container.appendChild(card);
      });

      document.querySelectorAll('.detail-btn').forEach(btn => {
        btn.addEventListener('click', e => openModal(e.target.dataset.id, true));
      });

      document.querySelectorAll('.remove-fav').forEach(btn => {
        btn.addEventListener('click', e => removeFromFavorite(e.target.dataset.id));
      });
    }
  });
}



// ----- MODAL -----
const modal = document.querySelector('#modal');

function openModal(id, isFromFav){
  const item = dataWisata.find(i=>i.id===id);

  if(!item){
    fetch(`../api/get_wisata_by_id.php?id=${id}`).then(r=>r.json()).then(d=>{
      if(!d) return;
      document.getElementById('modal-img').src = d.gambar;
      document.getElementById('modal-title').innerText = d.nama_wisata;
      document.getElementById('modal-desc').innerText = d.deskripsi;
      modal.classList.add('show');
      setupModalButtons(id, isFromFav);
    });
    return;
  }

  document.getElementById('modal-img').src = item.img;
  document.getElementById('modal-title').innerText = item.title;
  document.getElementById('modal-desc').innerText = item.desc;

  modal.classList.add('show');
  setupModalButtons(id, isFromFav);
}

function setupModalButtons(id, isFromFav){
  const modalFav = document.getElementById('modal-fav');
  const modalRemove = document.getElementById('modal-remove');

  if(modalFav){
    modalFav.style.display = isFromFav ? 'none' : 'inline-block';
    modalFav.onclick = () => {
      addToFavorite(id).then(()=> modal.classList.remove('show'));
    };
  }

  if(modalRemove){
    modalRemove.style.display = isFromFav ? 'inline-block' : 'none';
    modalRemove.onclick = () => {
      removeFromFavorite(id);
      modal.classList.remove('show');
      renderFavoritCards();
    };
  }
}

document.addEventListener('click', function(e){
  if(e.target.matches('.modal-close') || e.target === modal) {
    modal.classList.remove('show');
  }
});



// ----- INIT -----
document.addEventListener('DOMContentLoaded', () => {

  if(document.querySelector('#cards')){
    const si = document.getElementById('searchInput');
    si?.addEventListener('input', e => renderMenuCards(e.target.value));
  }

  if(document.querySelector('#favCards')){
    const fs = document.getElementById('favSearch');
    fs?.addEventListener('input', e => renderFavoritCards(e.target.value));

    renderFavoritCards(); // hanya dipanggil sekali
  }

});
