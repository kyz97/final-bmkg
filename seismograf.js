// Animasi seismograf di header (tema BMKG: pemantauan getaran gempa)
// Garis hijau berjalan terus. Panggil getarkan() untuk memicu "gempa".
(function(){
  const c = document.getElementById('seismo');
  if(!c) return;
  const ctx = c.getContext('2d');
  const diam = matchMedia('(prefers-reduced-motion: reduce)').matches;
  const LANGKAH = 2;            // jarak antar titik (px)
  let w, h, pts = [], energi = 0, fase = 0;

  function ukur(){
    const dpr = window.devicePixelRatio || 1;
    const r = c.parentElement.getBoundingClientRect();
    w = r.width; h = r.height;
    c.width = w * dpr; c.height = h * dpr;
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    pts = new Array(Math.ceil(w / LANGKAH) + 2).fill(0);
  }

  // Picu getaran: kekuatan 0.3 (kecil) sampai 1.5 (besar)
  window.getarkan = function(kekuatan){
    if(diam) return;
    energi = Math.min(1.6, energi + (kekuatan || 1));
    const m = document.querySelector('main');
    if(m){ m.classList.remove('getar'); void m.offsetWidth; m.classList.add('getar'); }
  };

  function langkah(){
    fase += 0.9;
    const acak = (Math.random() - 0.5) * 2;
    pts.push(acak * 1.2 + energi * (Math.sin(fase) * 0.6 + acak * 0.8) * h * 0.38);
    pts.shift();
    energi = energi < 0.01 ? 0 : energi * 0.965;
  }

  function gambar(){
    ctx.clearRect(0, 0, w, h);
    ctx.beginPath();
    pts.forEach((v, i) => i ? ctx.lineTo(i * LANGKAH, h / 2 + v) : ctx.moveTo(0, h / 2 + v));
    ctx.strokeStyle = 'rgba(214, 66, 8, ' + (0.7 + Math.min(energi, 1) * 0.3) + ')';
    ctx.lineWidth = 1.8;
    ctx.stroke();
  }

  function putar(){ langkah(); gambar(); requestAnimationFrame(putar); }

  ukur();
  window.addEventListener('resize', ukur);
  if(diam){ gambar(); return; }
  putar();

  // Getaran kecil acak tiap beberapa detik, biar terasa "hidup"
  (function acakKecil(){
    setTimeout(() => { energi = Math.max(energi, 0.25); acakKecil(); }, 5000 + Math.random() * 7000);
  })();
})();