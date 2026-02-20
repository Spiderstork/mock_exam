<?php
include "check_title.php";
include '../db/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: booking.php");
    exit();
}

// Grab POST data to pre-fill the form
$edit_id      = $_POST['edit_id'] ?? '';
$booking_name = $_POST['booking_name'] ?? '';
$email        = $_POST['email'] ?? '';
$arrive_date  = $_POST['arrive_date'] ?? '';
$seats        = $_POST['seats'] ?? '';
$max_seats    = $_POST['max_seats'] ?? '';
$timeslot_id  = $_POST['timeslot_id'] ?? '';
$start_time   = $_POST['start_time'] ?? '';
$end_time     = $_POST['end_time'] ?? '';
$canceled     = $_POST['canceled'] ?? '';

if (!$arrive_date) {
    echo json_encode([]);
    exit;
}

// Convert date to day of week (1=Monday, 7=Sunday)
$day_of_week = date('N', strtotime($arrive_date));

// Fetch time slots for that day
$sql = "SELECT id, start_time, end_time FROM time_slot WHERE day_of_week = ? AND removed = 0 ORDER BY start_time ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $day_of_week);
$stmt->execute();
$result = $stmt->get_result();
$time_slots = $result->fetch_all(MYSQLI_ASSOC);

// Display edit form
echo "<h2>Edit Booking</h2>";
echo "<form action='update.php' method='POST'>";

echo "<input type='hidden' name='edit_id' value='".htmlspecialchars($edit_id)."'>";

echo "<label>Name:</label>";
echo "<input type='text' name='booking_name' value='".htmlspecialchars($booking_name)."' required>";

echo "<label>Email:</label>";
echo "<input type='email' name='email' value='".htmlspecialchars($email)."' required>";

echo "<label>Seats:</label>";
echo "<input type='number' name='seats' value='".htmlspecialchars($seats)."' min='1' required>";

echo "<label>cancel:</label>";
echo "<input type='checkbox' name='canceled' " . ($canceled ? "checked" : "") . ">";

echo "<label>Arrival Date:</label>";
echo "<input type='date' id='arrive_date' name='arrive_date' value='".htmlspecialchars($arrive_date)."' required>";

echo "<label>Time Slot:</label>";
echo "<select id='timeslot_id' name='timeslot_id' required>";
echo "<option value=''>Select a time slot</option>";

foreach ($time_slots as $slot) {
    $selected = ($slot['id'] == $timeslot_id) ? "selected" : "";
    echo "<option value='" . htmlspecialchars($slot['id']) . "' $selected>";
    echo htmlspecialchars($slot['start_time'] . " - " . $slot['end_time']);
    echo "</option>";
}

echo "</select>";
echo "<button type='submit' id='edit' name='edit' value='1'>Submit</button>";
echo "</form>";
?>

<script>
document.getElementById('arrive_date').addEventListener('change', function() {
    const date = this.value;
    const select = document.getElementById('timeslot_id');

    // Clear existing options
    select.innerHTML = "<option value=''>Select a time slot</option>";

    if (!date) return;

    // Fetch new slots
    fetch('get_time_slots.php?arrive_date=' + encodeURIComponent(date))
        .then(response => response.json())
        .then(slots => {
            slots.forEach(slot => {
                const option = document.createElement('option');
                option.value = slot.id;
                option.textContent = slot.start_time + " - " + slot.end_time;
                select.appendChild(option);
            });
        })
        .catch(err => console.error('Error fetching time slots:', err));
});
</script>