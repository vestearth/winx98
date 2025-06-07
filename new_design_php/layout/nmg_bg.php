<div class="mng-bg-index">
  <img src="assets/images/items/1.png" data-speed="3" class="layer" style="--top: 88%;--left:34%;">
  <img src="assets/images/items/2.png" data-speed="2" class="layer" style="--top: 76%;--left: 46%;">
  <img src="assets/images/items/3.png" data-speed="-3" class="layer" style="--top: 75%;--left: 52%;">
</div>

<script>
  document.addEventListener('mousemove', parallax);

  function parallax(e) {
    this.querySelectorAll('.layer').forEach(layer => {
      const speed = layer.getAttribute('data-speed')
      const x = (window.innerWidth - e.pageX * speed) / 100
      const y = (window.innerHeight - e.pageY * speed) / 100
      layer.style.transform = `translateX(${x}px) translateY(${y}px)`
    })
  }
</script>