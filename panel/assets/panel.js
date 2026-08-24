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

  var fileError = document.getElementById('image_file_error');

  function setFileError(message) {
    if (!fileError) return;
    fileError.textContent = message || '';
    fileError.hidden = !message;
  }

  if (fileInput) {
    /* Zu große Bilder gleich im Browser abfangen – sonst bricht der Upload
       erst auf dem Server ab, teils ohne brauchbare Meldung. */
    var maxBytes = parseInt(fileInput.getAttribute('data-max-bytes') || '0', 10);
    var maxLabel = fileInput.getAttribute('data-max-label') || '';

    fileInput.addEventListener('change', function () {
      setFileError('');
      var file = fileInput.files && fileInput.files[0];
      if (!file) return;

      if (maxBytes > 0 && file.size > maxBytes) {
        var mb = (file.size / 1048576).toFixed(1).replace('.', ',');
        setFileError('Dieses Bild ist ' + mb + ' MB groß – erlaubt sind maximal ' + maxLabel +
                     '. Bitte das Bild verkleinern und erneut auswählen.');
        fileInput.value = '';
        showPreview(selectInput && selectInput.value ? '../' + selectInput.value : '');
        return;
      }

      showPreview(URL.createObjectURL(file));
    });
  }

  if (selectInput) {
    selectInput.addEventListener('change', function () {
      if (fileInput) fileInput.value = '';
      setFileError('');
      showPreview(selectInput.value ? '../' + selectInput.value : '');
    });
  }
})();
