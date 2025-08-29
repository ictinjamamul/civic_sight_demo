CREATE DATABASE IF NOT EXISTS civic_sight;
USE civic_sight;

CREATE TABLE reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type VARCHAR(100),
  gps TEXT,
  description TEXT,
  photo VARCHAR(255),
  timestamp DATETIME,
  status ENUM('Pending', 'In Progress', 'Resolved') DEFAULT 'Pending'
);
