<?php
$conn = new mysqli("localhost", "root", "", "civic_sight");

// Handle delete request
if (isset($_GET['delete'])) {
  $id = (int) $_GET['delete'];
  $conn->query("DELETE FROM reports WHERE id = $id");
  echo "<p style='color:red'>Report ID $id deleted.</p>";
}

// Handle priority update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_priority'])) {
  $id = (int) $_POST['report_id'];
  $priority = $_POST['priority'];
  $conn->query("UPDATE reports SET priority = '$priority' WHERE id = $id");
  echo "<p style='color:green'>Updated priority for Report ID $id.</p>";
}

$result = $conn->query("SELECT * FROM reports ORDER BY FIELD(priority, 'High', 'Normal', 'Low'), timestamp DESC");

echo "<h1>My Submitted Reports</h1>";

if ($result->num_rows > 0) {
  echo "<table border='1' cellpadding='8'>
    <tr>
      <th>ID</th><th>Type</th><th>Location</th><th>Description</th><th>Time</th><th>Status</th><th>Priority</th><th>Photo</th><th>Actions</th>
    </tr>";

  while ($row = $result->fetch_assoc()) {
    echo "<tr>
      <td>{$row['id']}</td>
      <td>{$row['type']}</td>
      <td>{$row['gps']}</td>
      <td>{$row['description']}</td>
      <td>{$row['timestamp']}</td>
      <td>{$row['status']}</td>
      <td>
        <form method='post' style='display:inline;'>
          <input type='hidden' name='report_id' value='{$row['id']}'>
          <select name='priority'>
            <option value='Low' " . ($row['priority'] == 'Low' ? 'selected' : '') . ">Low</option>
            <option value='Normal' " . ($row['priority'] == 'Normal' ? 'selected' : '') . ">Normal</option>
            <option value='High' " . ($row['priority'] == 'High' ? 'selected' : '') . ">High</option>
          </select>
          <button type='submit' name='update_priority'>Update</button>
        </form>
      </td>
      <td>";
        if ($row['photo']) {
          echo "<img src='uploads/{$row['photo']}' width='100'>";
        } else {
          echo "No Photo";
        }
    echo "</td>
      <td>
        <a href='?delete={$row['id']}' onclick=\"return confirm('Delete this report?');\">🗑️ Delete</a>
      </td>
    </tr>";
  }
  echo "</table>";
} else {
  echo "<p>No reports submitted yet.</p>";
}
?>