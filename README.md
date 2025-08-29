# 🌐 CivicSight – Smart Community GIS Reporter

**CivicSight** is a smartphone-based GIS app that enables citizens to report real-world issues like potholes, garbage dumping, and disaster-related damage. The platform allows government agencies and NGOs to visualize and respond to these reports in real-time using an interactive web-based dashboard.

---

## 🎯 Project Goal

To empower citizens to report local issues using their smartphones and enable real-time, map-based monitoring and response by responsible authorities.

---

## 📱 Mobile App Features

### 1. Multi-Issue Reporting System
- 📷 Take a photo
- 🗺️ GPS auto-captured
- 🧾 Select issue type:
  - 🕳️ Pothole / Road Damage  
  - 🗑️ Garbage Dump / Overflowing Bin  
  - 🌪️ Disaster Damage (Flood, Fire, etc.)
- 📝 Add optional description
- 📅 Automatically timestamped
- ⬆️ Submit the report

### 2. View Nearby Reports
- 🔍 Map view with issue markers
- 📈 Heatmap overlay toggle
- 🧭 Navigation to nearby issues

### 3. Offline Support
- 💾 Save reports locally when offline
- 🔄 Automatically sync when reconnected to internet

---

## 🛠️ Admin Dashboard (Web App)

### 1. Interactive Map View
- 🗺️ Filter by issue type, date, urgency
- 🌡️ View heatmaps of report density
- 👁️ Click markers to view image and report details

### 2. Status Tracking
- 🚦 Update issue status: Pending / In Progress / Resolved
- 👷 Assign to field teams or departments
- 📩 Notify teams via email/SMS

### 3. Analytics & Reports
- 📊 Generate statistics by area, issue type, and response time
- 📁 Export data for audits or planning reports

---

## 🧰 Technical Stack

### 📱 Mobile App
- `Flutter` (cross-platform: Android/iOS)
- `Google Maps SDK` or `Mapbox`
- `SQLite` for offline local storage
- `Firebase` or custom `REST API` for backend sync

### 🌐 Admin Dashboard
- `React.js` or `Vue.js` frontend
- `Flask`, `Django`, or `Node.js` backend
- `PostgreSQL + PostGIS` for spatial database
- `Leaflet.js` or `Mapbox GL JS` for maps

---

## 📡 Data Flow Overview

```mermaid
graph TD
  A[User Report] --> B[GPS, Photo, Issue Type Captured]
  B --> C[Data Sent to Server]
  C --> D[Stored in PostGIS]
  D --> E[Admin Dashboard Map & Heatmaps]
  E --> F[Response Actions: Assign / Resolve]
  F --> G[Notify User (optional)]
