<?php

/**
 * Counter Section Block Template.
 */

$id = 'counter-section-' . $block['id'];
if (!empty($block['anchor'])) {
  $id = $block['anchor'];
}

$className = 'counter-section';
if (!empty($block['className'])) {
  $className .= ' ' . $block['className'];
}

?>

<?php if (have_rows('counter-section')) : ?>
  <?php while (have_rows('counter-section')) : the_row(); ?>

    <section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> performance flex justify-center  px-4 md:px-10 pb-[60px] md:pb-[120px]">
      <div class="w-full wrapper flex items-center justify-between md:justify-evenly lg:justify-between gap-8 md:gap-4 max-[1440px]:flex-wrap flex-1">
            <?php if (have_rows('counter_list')) :  while (have_rows('counter_list')) : the_row(); ?>
              <div class="performance-item inline-flex flex-col max-md:max-w-[284px] max-md:w-full  w-max md:items-center gap-1 md:gap-3">
                  <div class="relative flex items-center justify-items-start min-[567px]:justify-center text-[40px] min-[600px]:text-[50px] min-[890px]:text-6xl leading-[48px] min-[600px]:leading-[52px] font-bold tracking-[-2%] font-[poppins]">
                      <div class="invisible text-[#262626]" aria-hidden="true"><?= wp_kses_post(get_sub_field('value')) ?></div>
                      <div class="absolute count-box tabular-nums text-[#262626]"><?= wp_kses_post(get_sub_field('value')) ?></div>
                  </div>
                  <p class="text-[14px] min-[600px]:text-base leading-[20px] md:leading-6  text-[#525252] font-body md:text-center"><?= wp_kses_post(get_sub_field('description')) ?></p>
              </div>
            <?php endwhile; endif; ?>
      </div>
    </section>

<!-- Dotted World Map with Perspective Tilt + Dot Markers + Hover Tooltips -->
<style>
  #map-section {
    position: relative;
    width: 100%;
    background: #ffffff;
    overflow: hidden;
    padding: 40px 0 60px;
  }
  #map-perspective-wrap {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    transform: perspective(900px) rotateX(18deg) rotateY(-8deg) rotateZ(2deg);
    transform-origin: center center;
  }
  #map-canvas-wrap {
    position: relative;
    width: 100%;
  }
  #map-canvas {
    display: block;
    width: 100%;
    height: auto;
  }

  /* Marker = colored dot */
  .map-marker {
    position: absolute;
    transform: translate(-50%, -50%);
    cursor: pointer;
    z-index: 10;
  }
  .map-dot-marker {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .map-marker:hover .map-dot-marker {
    transform: scale(1.6);
    box-shadow: 0 0 0 3px rgba(255,255,255,0.8);
  }

  /* Tooltip — hidden by default, shows on hover */
  .map-tooltip {
    position: absolute;
    bottom: calc(100% + 10px);
    left: 50%;
    transform: translateX(-50%) translateY(6px);
    background: #ffffff;
    border-radius: 10px;
    padding: 8px 18px 10px;
    white-space: nowrap;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    border: 1px solid rgba(0,0,0,0.07);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease, transform 0.2s ease;
    min-width: 130px;
  }
  .map-tooltip::after {
    content: '';
    position: absolute;
    top: 100%; left: 50%;
    transform: translateX(-50%);
    border: 7px solid transparent;
    border-top-color: #ffffff;
  }
  .map-marker:hover .map-tooltip {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
  }
  .tip-country {
    display: block;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 3px;
  }
  .tip-city {
    display: block;
    font-size: 12px;
    color: #999;
  }
  .tip-red  { color: #e84040; }
  .tip-blue { color: #2563be; }
</style>

<div id="map-section">
  <div id="map-perspective-wrap">
    <div id="map-canvas-wrap">
      <canvas id="map-canvas"></canvas>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/d3@7/dist/d3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/topojson-client@3/dist/topojson-client.min.js"></script>
<script>
(function () {
  var wrap   = document.getElementById('map-canvas-wrap');
  var canvas = document.getElementById('map-canvas');
  var ctx    = canvas.getContext('2d');

  /* ── Edit your markers here ── */
  var markers = [
    { label: 'United Kingdom', city: 'London',  lon: -0.1276,  lat: 51.5072, color: '#e84040', tipColor: 'tip-red'  },
    { label: 'China',          city: 'Jiangsu', lon: 118.7969, lat: 32.0603, color: '#2563be', tipColor: 'tip-blue' },
  ];

  var W = 1400, H = 620;
  canvas.width  = W;
  canvas.height = H;

  var proj = d3.geoNaturalEarth1()
    .scale(W / 6.2)
    .translate([W * 0.5, H * 0.52]);

  function placeDots() {
    document.querySelectorAll('.map-marker').forEach(function(e) { e.remove(); });
    var rect   = canvas.getBoundingClientRect();
    var scaleX = rect.width  / W;
    var scaleY = rect.height / H;

    markers.forEach(function (m) {
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
        + '<div class="map-dot-marker" style="background:' + m.color + ';"></div>';
      wrap.appendChild(el);
    });
  }

  fetch('https://cdn.jsdelivr.net/npm/world-atlas@2/countries-110m.json')
    .then(function (r) { return r.json(); })
    .then(function (world) {
      var land = topojson.feature(world, world.objects.land);

      var off = document.createElement('canvas');
      off.width = W; off.height = H;
      var oc  = off.getContext('2d');
      var p2  = d3.geoPath(proj, oc);
      oc.fillStyle = '#fff';
      oc.beginPath(); p2(land); oc.fill();
      var img = oc.getImageData(0, 0, W, H);

      var SP = 9, R = 3.2;
      for (var x = SP; x < W; x += SP) {
        for (var y = SP; y < H; y += SP) {
          var i = (y * W + x) * 4;
          if (img.data[i] > 128) {
            ctx.beginPath();
            ctx.arc(x, y, R, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(185,185,185,0.75)';
            ctx.fill();
          }
        }
      }
      placeDots();
      window.addEventListener('resize', placeDots);
    });
})();
</script>
<!-- End Dotted World Map -->



    

  <?php endwhile; ?>
<?php endif; ?> 





