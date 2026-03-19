<?php

/**
 * Map Block Template.
 */

$id = 'map-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'map';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}
?>

<?php if (have_rows('map-section')) :  while (have_rows('map-section')) : the_row(); 
$title1 = get_sub_field('title_row_1');
$title2 = get_sub_field('title_row_2');
$map_code = get_sub_field('map_code');

?>
<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> map-sec px-4 md:px-10 py-[60px] md:py-[120px]">
  <div class="wrapper">
      <?php if ($title1 || $title2) : ?>
        <div class="serve-heading md:mb-[80px] md-[32px]">
          <h2 class="flex flex-col font-heading font-bold text-[clamp(36px,4.5vw,68px)] leading-[clamp(44px,5.2vw,78px)] tracking-[-0.02em]">
            <span class="font-bold text-neutral-800"><?= wp_kses_post($title1) ?></span>
            <span class="font-light text-neutral-500"><?= wp_kses_post($title2) ?></span>
          </h2>
        </div>
      <?php endif; ?>
    <div class="map__iframe">
      <?php echo $map_code; ?>


<div id="map-section">
  <div id="map-canvas-wrap">
    <canvas id="map-canvas"></canvas>
  </div>
</div>





    </div>
  </div>
</section>
<?php endwhile; endif; ?>



<script src="https://cdn.jsdelivr.net/npm/d3@7/dist/d3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/topojson-client@3/dist/topojson-client.min.js"></script>
<script>
(function() {
  const wrap   = document.getElementById('map-canvas-wrap');
  const canvas = document.getElementById('map-canvas');
  const ctx    = canvas.getContext('2d');

  /* ── Markers config ── */
  const markers = [
    { label: 'United Kingdom', city: 'London',  lon: -0.1276,  lat: 51.5072, color: '#e84040', tipColor: 'tip-red'  },
    { label: 'China',          city: 'Jiangsu', lon: 118.7969, lat: 32.0603, color: '#2563be', tipColor: 'tip-blue' },
  ];

  const W = 1400, H = 650;
  canvas.width  = W;
  canvas.height = H;

  const proj = d3.geoNaturalEarth1()
    .scale(W / 6.2)
    .translate([W * 0.5, H * 0.52]);

  function placeDots() {
    document.querySelectorAll('.map-marker').forEach(e => e.remove());
    const rect = canvas.getBoundingClientRect();
    const scaleX = rect.width  / W;
    const scaleY = rect.height / H;

    markers.forEach(function(m) {
      const coords = proj([m.lon, m.lat]);
      const px = coords[0] * scaleX;
      const py = coords[1] * scaleY;

      const el = document.createElement('div');
      el.className = 'map-marker';
      el.style.left = px + 'px';
      el.style.top  = py + 'px';
      el.innerHTML =
        '<div class="map-tooltip">' +
          '<span class="tip-country ' + m.tipColor + '">' + m.label + '</span>' +
          '<span class="tip-city">' + m.city + '</span>' +
        '</div>' +
        '<div class="map-dot" style="background:' + m.color + ';"></div>';
      wrap.appendChild(el);
    });
  }

  fetch('https://cdn.jsdelivr.net/npm/world-atlas@2/countries-110m.json')
    .then(function(r) { return r.json(); })
    .then(function(world) {
      var land = topojson.feature(world, world.objects.land);

      /* draw dots on offscreen canvas */
      var off = document.createElement('canvas');
      off.width = W; off.height = H;
      var oc = off.getContext('2d');
      var p2 = d3.geoPath(proj, oc);
      oc.fillStyle = '#fff';
      oc.beginPath(); p2(land); oc.fill();
      var img = oc.getImageData(0, 0, W, H);

      var SP = 8, R = 2.4;
      for (var x = SP; x < W; x += SP) {
        for (var y = SP; y < H; y += SP) {
          var i = (y * W + x) * 4;
          if (img.data[i] > 128) {
            ctx.beginPath();
            ctx.arc(x, y, R, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(200,200,195,0.85)';
            ctx.fill();
          }
        }
      }
      placeDots();

      /* reposition dots on window resize */
      window.addEventListener('resize', placeDots);
    });
})();
</script>
<!-- End Dotted World Map -->






      <!-- Dotted World Map with Tooltips -->
<style>
  #map-section {
    position: relative;
    width: 100%;
    background: #000;
    overflow: hidden;
    padding: 40px 0;
  }
  #map-canvas-wrap {
    position: relative;
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
  }
  #map-canvas {
    display: block;
    width: 100%;
    height: auto;
  }
  .map-marker {
    position: absolute;
    transform: translate(-50%, -50%);
    cursor: pointer;
    z-index: 10;
  }
  .map-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    transition: transform 0.2s ease;
    margin: 0 auto;
  }
  .map-marker:hover .map-dot {
    transform: scale(1.6);
  }
  .map-tooltip {
    position: absolute;
    bottom: calc(100% + 12px);
    left: 50%;
    transform: translateX(-50%) translateY(6px);
    background: #ffffff;
    border-radius: 10px;
    padding: 8px 18px 10px;
    white-space: nowrap;
    text-align: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
    box-shadow: 0 4px 20px rgba(0,0,0,0.35);
    min-width: 130px;
    font-family: sans-serif;
  }
  .map-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 7px solid transparent;
    border-top-color: #ffffff;
  }
  .map-marker:hover .map-tooltip {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }
  .map-tooltip .tip-country {
    display: block;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 2px;
  }
  .map-tooltip .tip-city {
    display: block;
    font-size: 12px;
    color: #888888;
  }
  .tip-red   { color: #e84040; }
  .tip-blue  { color: #2563be; }
</style>