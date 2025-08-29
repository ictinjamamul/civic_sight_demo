<?php
$conn = new mysqli("localhost", "root", "", "civic_sight");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $type = $_POST['type'];
  $gps_coords = $_POST['gps'] ?? '';
  $description = $_POST['description'] ?? '';
  $timestamp = date("Y-m-d H:i:s");
  $photo_name = '';

  // Set the response content type to JSON
  header('Content-Type: application/json');

  // Check if GPS coordinates are empty
  if (empty($gps_coords)) {
      echo json_encode(['status' => 'error', 'message' => 'GPS coordinates cannot be empty.']);
      exit();
  }
  
  // Separate latitude and longitude from the GPS string
  list($lat, $lng) = explode(',', $gps_coords);

  // Set a tolerance for "same location" (e.g., 50 meters)
  $tolerance_km = 0.05;

  // Use a Haversine formula query to find duplicates within the tolerance radius
  $sql = "SELECT id, (6371 * acos(
            cos(radians(?)) * cos(radians(SUBSTRING_INDEX(gps, ',', 1))) * cos(radians(SUBSTRING_INDEX(gps, ',', -1)) - radians(?))
            + sin(radians(?)) * sin(radians(SUBSTRING_INDEX(gps, ',', 1)))
          )) AS distance
          FROM reports
          WHERE type = ?
          HAVING distance < ?
          ORDER BY distance LIMIT 1";

  $stmt_check = $conn->prepare($sql);
  $stmt_check->bind_param("dddsd", $lat, $lng, $lat, $type, $tolerance_km);
  $stmt_check->execute();
  $result_check = $stmt_check->get_result();

  if ($result_check->num_rows > 0) {
    // A similar report already exists.
    $existing_report = $result_check->fetch_assoc();
    $existing_id = $existing_report['id'];
    echo json_encode(['status' => 'duplicate', 'id' => $existing_id]);
    exit();
  }
  
  // No duplicate found, proceed with file upload and insertion
  if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $photo_name = uniqid() . "_" . basename($_FILES['photo']['name']);
    $target = "uploads/" . $photo_name;
    move_uploaded_file($_FILES['photo']['tmp_name'], $target);
  }

  $stmt = $conn->prepare("INSERT INTO reports (type, gps, description, photo, timestamp) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $type, $gps_coords, $description, $photo_name, $timestamp);
  $stmt->execute();

  $report_id = $stmt->insert_id;
  echo json_encode(['status' => 'success', 'id' => $report_id]);
  exit();
}
?>