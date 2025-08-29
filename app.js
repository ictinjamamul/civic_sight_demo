let map;
let marker;

function initMap() {
  const defaultLocation = { lat: 23.8103, lng: 90.4125 }; // Dhaka, Bangladesh
  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: defaultLocation,
  });

  marker = new google.maps.Marker({
    position: defaultLocation,
    map: map,
  });

  map.addListener("click", (e) => {
    const lat = e.latLng.lat();
    const lng = e.latLng.lng();
    marker.setPosition({ lat, lng });
    document.getElementById("gps").value = `${lat},${lng}`;
  });
}

document.getElementById("reportForm").addEventListener("submit", function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  fetch("submit_report.php", {
    method: "POST",
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      window.location.href = `view_report.php?id=${data.id}`;
    } else if (data.status === 'duplicate') {
      window.location.href = `view_report.php?id=${data.id}&duplicate=1`;
    } else {
      alert(`Error: ${data.message}`);
    }
  })
  .catch(err => alert("An error occurred during submission. Please try again."));
});