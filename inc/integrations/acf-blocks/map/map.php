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



<div id="wmap-section">
  <div id="wmap-tilt">
    <div id="wmap-inner">
      <canvas id="wmap-canvas"></canvas>
    </div>
  </div>
</div>






    </div>
  </div>
</section>
<?php endwhile; endif; ?>



<!-- ===== Dotted World Map | Dot → Pin + Tooltip on Hover ===== -->
<style>
  #wmap-section {
    width: 100%;
    background: #fff;
    overflow: hidden;
    padding: 40px 0 60px;
  }

  /* Perspective tilt wrapper — matches your SVG look */
  #wmap-tilt {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    transform: perspective(1100px) rotateX(22deg) rotateY(-10deg) rotateZ(3deg) scale(1.05);
    transform-origin: 55% 45%;
  }

  #wmap-inner {
    position: relative;
    width: 100%;
  }

  #wmap-canvas {
    display: block;
    width: 100%;
    height: auto;
  }

  /* ── Marker base ── */
  .wmap-marker {
    position: absolute;
    transform: translate(-50%, -50%);
    cursor: pointer;
    z-index: 20;
  }

  /* Default state: small colored dot */
  .wmap-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    transition: opacity 0.2s;
  }

  /* Pin — hidden by default, shown on hover */
  .wmap-pin {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%) translateY(50%) scale(0);
    transform-origin: bottom center;
    transition: transform 0.2s ease;
    pointer-events: none;
  }

  .wmap-marker:hover .wmap-dot {
    opacity: 0;
  }
  .wmap-marker:hover .wmap-pin {
    transform: translateX(-50%) translateY(50%) scale(1);
  }

  /* Tooltip — hidden by default */
  .wmap-tooltip {
    position: absolute;
    bottom: calc(100% + 44px); /* above the pin */
    left: 50%;
    transform: translateX(-50%) translateY(6px);
    background: #fff;
    border-radius: 10px;
    padding: 8px 18px 10px;
    white-space: nowrap;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.14);
    border: 1px solid rgba(0,0,0,0.07);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
    min-width: 135px;
  }
  .wmap-tooltip::after {
    content: '';
    position: absolute;
    top: 100%; left: 50%;
    transform: translateX(-50%);
    border: 7px solid transparent;
    border-top-color: #fff;
  }
  .wmap-marker:hover .wmap-tooltip {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }

  .wmap-tip-country {
    display: block;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 3px;
  }
  .wmap-tip-city {
    display: block;
    font-size: 12px;
    color: #999;
  }
  .wmap-red  { color: #e84040; }
  .wmap-blue { color: #2563be; }
</style> 



<script src="https://cdn.jsdelivr.net/npm/d3@7/dist/d3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/topojson-client@3/dist/topojson-client.min.js"></script>
<script>
(function () {

  /* ── MARKER CONFIG — edit locations here ── */
  var MARKERS = [
    { label: 'United Kingdom', city: 'London',  lon: -0.1276,  lat: 51.5072, color: '#e84040', cls: 'wmap-red'  },
    { label: 'China',          city: 'Jiangsu', lon: 118.7969, lat: 32.0603, color: '#2563be', cls: 'wmap-blue' },
  ];

  var inner  = document.getElementById('wmap-inner');
  var canvas = document.getElementById('wmap-canvas');
  var ctx    = canvas.getContext('2d');
  var CW = 1400, CH = 620;
  canvas.width = CW; canvas.height = CH;

  var proj = d3.geoNaturalEarth1()
    .scale(CW / 6.2)
    .translate([CW * 0.5, CH * 0.52]);

  /* SVG pin path */
  function makePinSVG(color) {
    return '<svg width="26" height="36" viewBox="0 0 26 36" xmlns="http://www.w3.org/2000/svg">'
      + '<path d="M13 0C7.48 0 3 4.48 3 10C3 18.5 13 36 13 36C13 36 23 18.5 23 10C23 4.48 18.52 0 13 0Z" fill="' + color + '"/>'
      + '<circle cx="13" cy="10" r="4.5" fill="#fff"/>'
      + '</svg>';
  }

  function placeMarkers() {
    document.querySelectorAll('.wmap-marker').forEach(function(e) { e.remove(); });
    var rect   = canvas.getBoundingClientRect();
    var sx = rect.width  / CW;
    var sy = rect.height / CH;

    MARKERS.forEach(function(m) {
      var pt = proj([m.lon, m.lat]);
      var px = pt[0] * sx;
      var py = pt[1] * sy;

      var el = document.createElement('div');
      el.className = 'wmap-marker';
      el.style.left = px + 'px';
      el.style.top  = py + 'px';
      el.innerHTML =
        '<div class="wmap-tooltip">'
          + '<span class="wmap-tip-country ' + m.cls + '">' + m.label + '</span>'
          + '<span class="wmap-tip-city">' + m.city + '</span>'
        + '</div>'
        + '<div class="wmap-pin">' + makePinSVG(m.color) + '</div>'
        + '<div class="wmap-dot" style="background:' + m.color + ';"></div>';

      inner.appendChild(el);
    });
  }

  fetch('https://cdn.jsdelivr.net/npm/world-atlas@2/countries-110m.json')
    .then(function(r) { return r.json(); })
    .then(function(world) {
      var land = topojson.feature(world, world.objects.land);

      /* render land mask on offscreen canvas */
      var off = document.createElement('canvas');
      off.width = CW; off.height = CH;
      var oc = off.getContext('2d');
      oc.fillStyle = '#fff';
      oc.beginPath();
      d3.geoPath(proj, oc)(land);
      oc.fill();
      var px = oc.getImageData(0, 0, CW, CH);

      /* draw dots */
      var SP = 9, R = 3.2;
      for (var x = SP; x < CW; x += SP) {
        for (var y = SP; y < CH; y += SP) {
          var i = (y * CW + x) * 4;
          if (px.data[i] > 128) {
            ctx.beginPath();
            ctx.arc(x, y, R, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(185,185,185,0.72)';
            ctx.fill();
          }
        }
      }

      placeMarkers();
      window.addEventListener('resize', placeMarkers);
    });

})();
</script>
<!-- ===== End World Map ===== -->