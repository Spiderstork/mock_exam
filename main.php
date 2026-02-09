<!DOCTYPE html>
<html>
<head>
  <title>My Page</title>
  <link rel="stylesheet" href="calendar.css">
</head>
<body>

  <h1>Dashboard</h1>
<div style="align-items: center; display: flex; justify-content: center;">
  <?php include "cal.php"; ?>
</div>
  <script src="calendar.js"></script>
</body>
</html>
<script>
  while (true) {
    
    const timeId = timeSlot.getAttribute("data-time-id");
    console.log("Selected time slot ID:", timeId);
    const timeSlot = document.querySelector(".time_slot.selected_time");
}
</script>