<?php
$conn = new mysqli("localhost", "root", "", "civic_sight");
$result = $conn->query("SELECT * FROM reports ORDER BY timestamp DESC");

echo "<h1>All Community Reports</h1>";
echo "<table border='1' cellpadding='8'><tr>
  <th>ID</th><th>Type</th><th>Location</th><th>Description</th><th>Photo</th><th>Time</th><th>Status</th>
</tr>";

while ($row = $result->fetch_assoc()) {
  echo "<tr>
    <td>{$row['id']}</td>
    <td>{$row['type']}</td>
    <td>{$row['gps']}</td>
    <td>{$row['description']}</td>
    <td>";
      if ($row['photo']) {
        echo "<img src='uploads/{$row['photo']}' width='100'>";
      }
  echo "</td>
    <td>{$row['timestamp']}</td>
    <td>{$row['status']}</td>
  </tr>";
}
echo "</table>";
?>
