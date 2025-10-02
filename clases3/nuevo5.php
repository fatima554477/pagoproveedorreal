
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ejemplo Scroll Flotante</title>
  <style>
    .scroll-fake-wrapper {
      overflow-x: auto;
      height: 20px;
      margin-bottom: -20px;
    }

    .scroll-fake-scroll {
      height: 1px;
      width: 2000px; /* ancho artificial para forzar scroll horizontal */
    }

    .scroll-real-wrapper {
      overflow-x: auto;
    }

    .table-wrapper {
      min-width: 2000px;
      border: 1px solid #ccc;
    }

    .fixed-header-table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
    }

    .fixed-header-table th,
    .fixed-header-table td {
      padding: 8px;
      text-align: left;
      border: 1px solid #ccc;
    }

    .table-body-scroll {
      max-height: 300px;
      overflow-y: auto;
    }
  </style>
</head>
<body>

<h2>Ejemplo de Tabla con Scroll Flotante Horizontal</h2>

<div class="scroll-fake-wrapper">
  <div class="scroll-fake-scroll" id="scrollFake"></div>
</div>

<div class="scroll-real-wrapper" id="scrollReal">
  <div class="table-wrapper">
    <table class="fixed-header-table">
      <thead>
        <tr>
          <?php for ($i = 1; $i <= 20; $i++): ?>
            <th>Columna <?= $i ?></th>
          <?php endfor; ?>
        </tr>
      </thead>
    </table>
    <div class="table-body-scroll">
      <table class="fixed-header-table">
        <tbody>
          <?php for ($r = 1; $r <= 20; $r++): ?>
          <tr>
            <?php for ($i = 1; $i <= 20; $i++): ?>
              <td>Dato <?= $r ?>-<?= $i ?></td>
            <?php endfor; ?>
          </tr>
          <?php endfor; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  const fakeScroll = document.getElementById("scrollFake");
  const realScroll = document.getElementById("scrollReal");

  fakeScroll.parentElement.addEventListener("scroll", function () {
    realScroll.scrollLeft = this.scrollLeft;
  });

  realScroll.addEventListener("scroll", function () {
    fakeScroll.parentElement.scrollLeft = this.scrollLeft;
  });
</script>

</body>
</html>
