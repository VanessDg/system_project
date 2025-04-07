// map centered at Pangasinan
const map = L.map('map').setView([15.9167, 120.3333], 10);


// Add OpenStreetMap tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 18
}).addTo(map);

// Add pins from DB
if (typeof locations !== 'undefined') {
  locations.forEach(loc => {
    L.marker([loc.latitude, loc.longitude])
      .addTo(map)
      .bindPopup(`<strong>${loc.name}</strong><br>Category: ${loc.category}`);
  });
}

// Handle map click to add a new marker and update form
let marker;
map.on('click', function(e) {
  const { lat, lng } = e.latlng;
  if (marker) map.removeLayer(marker);
  marker = L.marker([lat, lng]).addTo(map);
  document.getElementById('lat').value = lat;
  document.getElementById('lng').value = lng;
});

// Toggle form visibility
function toggleForm() {
  const form = document.getElementById('formContainer');
  form.style.display = form.style.display === 'block' ? 'none' : 'block';
}

