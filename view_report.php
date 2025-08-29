<!DOCTYPE html>
<html>
<head>
  <title>Report Ticket - CivicSight</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    .ticket {
      border: 2px solid #444;
      padding: 20px;
      max-width: 600px;
      margin: auto;
      background: #f9f9f9;
    }
    img { max-width: 100%; height: auto; }
    button {
      margin-top: 15px;
      padding: 10px 15px;
      background-color: #007BFF;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
<div class="ticket">
<?php
$conn = new mysqli("localhost", "root", "", "civic_sight");

$id = $_GET['id'];
$is_duplicate = isset($_GET['duplicate']);

$result = $conn->query("SELECT * FROM reports WHERE id = $id");

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  if ($is_duplicate) {
    echo "<h2>⚠️ This report is a duplicate. Displaying the original submission.</h2>";
  } else {
    echo "<h2>✅ Report Submitted Successfully!</h2>";
  }
  echo "<p><strong>Report ID:</strong> " . $row['id'] . "</p>";
  echo "<p><strong>Type:</strong> " . $row['type'] . "</p>";
  echo "<p><strong>Location:</strong> " . $row['gps'] . "</p>";
  echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
  echo "<p><strong>Time:</strong> " . $row['timestamp'] . "</p>";
  echo "<p><strong>Status:</strong> " . $row['status'] . "</p>";
  if ($row['photo']) {
    echo "<p><img src='uploads/{$row['photo']}'></p>";
  }
  echo "<br><a href='submission_history.php'><button>📄 View My Submission History</button></a>";
} else {
  echo "<h2>❌ Report not found.</h2>";
}
?>
</div>
</body>
</html>