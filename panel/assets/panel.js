/* Kleine Helfer im Admin-Panel. Ohne dieses Skript bleibt alles bedienbar. */
(function () {
  'use strict';

  /* Sicherheitsabfrage vor dem Löschen. */
  document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!window.confirm(form.getAttribute('data-confirm'))) {
        event.preventDefault();
      }
    });
  });

  /* Vorschau des Bildes: bei Upload sofort, sonst beim Wechsel der Auswahl. */
  var preview = document.getElementById('image-preview');
  var fileInput = document.getElementById('image_file');
  var selectInput = document.getElementById('image');

  function showPreview(src) {
    if (!preview) return;
    preview.innerHTML = '';
    if (!src) return;
    var img = document.createElement('img');
    img.src = src;
    img.alt = '';
    preview.appendChild(img);
  }

  if (fileInput) {
    fileInput.addEventListener('change', function () {
      var file = fileInput.files && fileInput.files[0];
      if (!file) return;
      showPreview(URL.createObjectURL(file));
    });
  }

  if (selectInput) {
    selectInput.addEventListener('change', function () {
      if (fileInput) fileInput.value = '';
      showPreview(selectInput.value ? '../' + selectInput.value : '');
    });
  }
})();
