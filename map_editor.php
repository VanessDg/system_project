<?php 
require 'db1.php';
$locations = $pdo->query("SELECT * FROM map_editor")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Map Editor</title>
  <link rel="stylesheet" href="map_editor.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>
  <div class="sidebar">
    <h2>PangTour</h2>
    <a href="#">Dashboard</a>
    <a href="#" class="active">Map Editor</a>
    <a href="#">Heritage Sites</a>
  </div>

  <div class="content">
    <div id="map"></div>

    <!-- Add Button -->
    <button id="addBtn">+</button>

    <!-- Floating Form -->
    <div id="formContainer" class="hidden">
      <form id="locationForm" action="submit.php" method="post" enctype="multipart/form-data">
        <h2>Add New Location</h2>
        <button type="button" id="close">Close</button>
      <input type="text" name="location_name" placeholder="Location Name" required><br>
        <input type="text" name="age" placeholder="Estimated Age"><br>
        <textarea name="description" placeholder="Historical Description"required></textarea><br>
        <select name="category">
          <option value="">Select Category</option>
          <option value="church">Church</option>
          <option value="museum">Museum</option>
          <option value="landmark">Landmark</option>
        </select><br>
        <input type="hidden" id="lat" name="latitude">
        <input type="hidden" id="lng" name="longitude">
        <input type="file" name="image_path"><br>
        <button type="submit">Submit Details</button>
      </form>
    </div>
  </div>
  <script>
  document.getElementById('close').addEventListener('click', function () {
    document.getElementById('formContainer').classList.add('hidden');
  });
</script>

  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    const locations = <?php echo json_encode($locations); ?>;
    const map = L.map('map').setView([15.9167, 120.3333], 10); // Centered on Philippines

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
    }).addTo(map);

    locations.forEach(loc => {
      L.marker([loc.latitude, loc.longitude])
        .addTo(map)
        .bindPopup(`<strong>${loc.location_name}</strong><br>${loc.category}`);
    });

    map.on('click', function(e) {
      const lat = e.latlng.lat.toFixed(6);
      const lng = e.latlng.lng.toFixed(6);

      document.getElementById('lat').value = lat;
      document.getElementById('lng').value = lng;

      L.popup()
        .setLatLng(e.latlng)
        .setContent(`Coordinates selected: ${lat}, ${lng}`)
        .openOn(map);
    });

    function toggleForm() {
      const form = document.getElementById('formContainer');
      form.classList.toggle('hidden');
    }

    document.getElementById('addBtn').addEventListener('click', toggleForm);

    document.getElementById('locationForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(this);

      fetch('submit.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        console.log(data);
        if (data.success) {
          alert('Location added successfully!');
          L.marker([data.latitude, data.longitude])
            .addTo(map)
            .bindPopup(`<strong>${data.location_name}</strong><br>${data.category}`);
          this.reset();
          toggleForm();
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(err => {
        console.error(err);
        alert('Failed to submit. Try again.');
      });
    });
  </script>
</body>
</html>
