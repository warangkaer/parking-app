<!-- Yusril Bagas Panji Pamukti -->
<!-- yusrilbagas135@gmail.com -->
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Parking App</title>
  <link rel="stylesheet" href="style.css">
</head>
<form method="POST" id="form-in-time">
  <label for="in-time">In Time</label>
  <input type="time" name="in_time" id="in-time">
  <button onclick="event.preventDefault(); inputTimeIn()" id="form-in">Enter</button>
</form>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>In Time</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="table-body"></tbody>
</table>

<script src="index.js"></script>
<body>
</body>
</html>