<?php
include "include/nav.php";
include 'db/connect_db.php';

// Cancel old bookings
$sql = "
UPDATE booking b
LEFT JOIN booking_bridge bb 
  ON bb.booking_id = b.id
SET b.canceled = TRUE
WHERE b.booked_at <= NOW() - INTERVAL 10 MINUTE
  AND b.canceled = FALSE
  AND bb.booking_id IS NULL;
";

if (!$conn->query($sql) === TRUE) {
    echo "Error cancelling old bookings: " . $conn->error;
}
?>

<!-- Main Content -->
<main class="container mx-auto py-8 grid md:grid-cols-2 gap-8">

    <!-- Calendar & People Count -->
    <div class="space-y-6">
        <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-4">Select a Date</h2>
            <?php include "cal.php"; ?>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-4">People Count</h2>
            <?php include "people_count.php"; ?>
        </div>
    </div>

    <!-- Time Slots & Next Button -->
    <div class="flex flex-col justify-between h-full space-y-6">

        <div class="bg-gray-800 rounded-xl p-6 shadow-lg flex flex-col items-center space-y-4">
            <h2 class="text-2xl font-bold text-center">Available Time Slots</h2>
            <div id="timeslots" class="grid grid-cols-2 md:grid-cols-3 gap-4 w-full"></div>
        </div>

        <div class="flex justify-center">
            <button id="save_button" class="btn btn-primary btn-lg">NEXT &gt;</button>
        </div>

    </div>

</main>

<!-- Hidden Form -->
<form id="bookingForm" action="backend/payment/save_booking.php" method="POST" class="hidden">
    <input type="hidden" name="date" id="date_input">
    <input type="hidden" name="time_slot_id" id="time_slot_input">
    <input type="hidden" name="people_count" id="people_count_input">
</form>

<script src="calendar.js"></script>
<script src="get_time_slot.js"></script>
<script>
const saveBtn = document.getElementById("save_button");

saveBtn.addEventListener("click", () => {
    const selectedDate = localStorage.getItem("selectedDate");
    const selectedTimeSlot = localStorage.getItem("selectedTimeSlot");
    const peopleCount = localStorage.getItem("peopleCount");

    if (!selectedDate || !selectedTimeSlot || !peopleCount) {
        alert("Please select a date, time slot, and people count before proceeding.");
        return;
    }
    console.log("Saving booking with date:", selectedDate, "time slot ID:", selectedTimeSlot, "people count:", peopleCount);

    document.getElementById("date_input").value = selectedDate;
    document.getElementById("time_slot_input").value = selectedTimeSlot;
    document.getElementById("people_count_input").value = peopleCount;

    document.getElementById("bookingForm").submit();
});
</script>
</body>
</html>
<?php
include "include/footer.php";
?>