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
(function () {
  var wrap   = document.getElementById('map-canvas-wrap');
  var canvas = document.getElementById('map-canvas');
  var ctx    = canvas.getContext('2d');

  /* ── Marker config — add/edit locations here ── */
  var markers = [
    { label: 'United Kingdom', city: 'London',  lon: -0.1276,  lat: 51.5072, pinColor: '#e84040', tipColor: 'tip-red'  },
    { label: 'China',          city: 'Jiangsu', lon: 118.7969, lat: 32.0603, pinColor: '#2563be', tipColor: 'tip-blue' },
  ];

  var W = 1400, H = 620;
  canvas.width  = W;
  canvas.height = H;

  var proj = d3.geoNaturalEarth1()
    .scale(W / 6.2)
    .translate([W * 0.5, H * 0.52]);

  function pinSVG(color) {
    return '<svg width="28" height="38" viewBox="0 0 28 38" fill="none" xmlns="http://www.w3.org/2000/svg">'
      + '<path d="M14 0C8.48 0 4 4.48 4 10C4 18.5 14 38 14 38C14 38 24 18.5 24 10C24 4.48 19.52 0 14 0Z" fill="' + color + '"/>'
      + '<circle cx="14" cy="10" r="5" fill="white"/>'
      + '</svg>';
  }

  function placeDots() {
    document.querySelectorAll('.map-marker').forEach(function(e) { e.remove(); });
    var rect   = canvas.getBoundingClientRect();
    var scaleX = rect.width  / W;
    var scaleY = rect.height / H;

    markers.forEach(function(m) {
      var coords = proj([m.lon, m.lat]);
      var px = coords[0] * scaleX;
      var py = coords[1] * scaleY;

      var el = document.createElement('div');
      el.className = 'map-marker';
      el.style.left = px + 'px';
      el.style.top  = py + 'px';
      el.innerHTML =
        '<div class="map-tooltip">'
        + '<span class="tip-country ' + m.tipColor + '">' + m.label + '</span>'
        + '<span class="tip-city">' + m.city + '</span>'
        + '</div>'
        + '<div class="map-pin">' + pinSVG(m.pinColor) + '</div>';
      wrap.appendChild(el);
    });
  }

  fetch('https://cdn.jsdelivr.net/npm/world-atlas@2/countries-110m.json')
    .then(function(r) { return r.json(); })
    .then(function(world) {
      var land = topojson.feature(world, world.objects.land);

      var off = document.createElement('canvas');
      off.width = W; off.height = H;
      var oc = off.getContext('2d');
      var p2 = d3.geoPath(proj, oc);
      oc.fillStyle = '#fff';
      oc.beginPath(); p2(land); oc.fill();
      var img = oc.getImageData(0, 0, W, H);

      var SP = 9, R = 3;
      for (var x = SP; x < W; x += SP) {
        for (var y = SP; y < H; y += SP) {
          var i = (y * W + x) * 4;
          if (img.data[i] > 128) {
            ctx.beginPath();
            ctx.arc(x, y, R, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(180,180,180,0.7)';
            ctx.fill();
          }
        }
      }
      placeDots();
      window.addEventListener('resize', placeDots);
    });
})();
</script>




      <!-- Dotted World Map with Tooltips -->
<style>
  #map-section {
    position: relative;
    width: 100%;
    background: #ffffff;
    overflow: hidden;
    padding: 60px 0 40px;
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
    transform: translate(-50%, -100%);
    cursor: pointer;
    z-index: 10;
  }
  .map-pin svg {
    display: block;
    margin: 0 auto;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.25));
    transition: transform 0.2s ease;
  }
  .map-marker:hover .map-pin svg {
    transform: scale(1.15);
  }
  .map-tooltip {
    position: absolute;
    bottom: calc(100% + 6px);
    left: 50%;
    transform: translateX(-50%);
    background: #ffffff;
    border-radius: 10px;
    padding: 8px 18px 10px;
    white-space: nowrap;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    min-width: 130px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    border: 1px solid rgba(0,0,0,0.06);
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
  .map-tooltip .tip-country {
    display: block;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 2px;
  }
  .map-tooltip .tip-city {
    display: block;
    font-size: 12px;
    color: #999999;
    font-weight: 400;
  }
  .tip-red  { color: #e84040; }
  .tip-blue { color: #2563be; }
</style>
