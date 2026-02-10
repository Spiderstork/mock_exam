<?php
include 'db/connect_db.php';

$sql = "UPDATE booking b
LEFT JOIN booking_bridge bb 
  ON bb.booking_id = b.id
SET b.canceled = TRUE
WHERE b.booked_at <= NOW() - INTERVAL 10 MINUTE
  AND b.canceled = FALSE
  AND bb.booking_id IS NULL;
";
if ($conn->query($sql) === TRUE) {
    echo "Old bookings cancelled successfully.";
} else {
    echo "Error cancelling old bookings: " . $conn->error;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>booking</title>
    <style>
        .container {  display: grid;
        grid-template-columns: 1fr 1fr ;
        grid-template-rows: 1fr 1fr;
        gap: 0px 0px;
        grid-auto-flow: row;
        grid-template-areas:
            "calander rs"
            "calander  rs";
        }

.calander { grid-area: calander; text-align: center; }

.rs {  display: grid;
  grid-template-columns: 1fr;
  grid-template-rows: 2.9fr 1fr;
  gap: 0px 0px;
  grid-auto-flow: row;
  grid-template-areas:
    "time_slot_container"
    "save";
  grid-area: rs;
}

.save { grid-area: save; 
    display: flex;
    flex-wrap: wrap;          /* allows breaking to next line */
    justify-content: center;   }

.time_slot_container { grid-area: time_slot_container; 
    display: flex;
    flex-direction: column;   /* stack title and slots */
    justify-content: flex-start; /* push content to top */
    align-items: center;
}   

    </style>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #8ab3ff;
            color : white;
            margin: 0;
            padding: 20px;
        }
        .button {
            background: #2563eb;
            color: white;
            font-weight: bold;
            max-width: 200px;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: clamp(2rem, 2.8vw, 1rem);       
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .button:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="calander">
            <h2>Calendar</h2>
            <?php include "cal.php"; ?>
            <h2>People Count</h2>
            <?php include "people_count.php"; ?>
    </div>
    <div class="rs">
        <div class="time_slot_container" >
            <h2>Available Time Slots</h2>
            <div class="time_slot_box" id="timeslots"></div>
        </div>
        <div class="save">
            <div class="button" id="save_button">NEXT > </div>
        </div>
    </div>
</div>

<form id="bookingForm" action="backend/payment/save_booking.php" method="POST">
    <input type="hidden" name="date" id="date_input">
    <input type="hidden" name="time_slot_id" id="time_slot_input">
    <input type="hidden" name="people_count" id="people_count_input">
</form>
</body>
</html>
<script src="calendar.js"></script>
<script src="get_time_slot.js"></script>
</script>
<script>
    console.log(localStorage.getItem("selectedDate"));
    console.log(localStorage.getItem("selectedDayOfWeek"));

    save = document.getElementById("save_button");
    save.addEventListener("click", function() {
        const selectedDate = localStorage.getItem("selectedDate");
        const selectedTimeSlot = localStorage.getItem("selectedTimeSlot");
        const peopleCount = localStorage.getItem("peopleCount");

        console.log("Saving booking with date:", selectedDate);
        console.log("Selected time slot ID:", selectedTimeSlot);
        console.log("People count:", peopleCount);

        document.getElementById("date_input").value = selectedDate;
        document.getElementById("time_slot_input").value = selectedTimeSlot;
        document.getElementById("people_count_input").value = peopleCount;

        document.getElementById("bookingForm").submit();
});
</script>




