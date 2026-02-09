 const timeSlotBox = document.querySelector(".time_slot_box");

    timeSlotBox.addEventListener("click", (e) => {
        const timeSlot = e.target.closest(".time_slot, .selected_time_slot");
        if (!timeSlot) return;

        // Remove previous selection
        document.querySelectorAll(".selected_time_slot").forEach(slot => {
            slot.classList.remove("selected_time_slot");
            slot.classList.add("time_slot");
        });

        // Select clicked slot
        timeSlot.classList.remove("time_slot");
        timeSlot.classList.add("selected_time_slot");

        const timeId = timeSlot.dataset.timeId;
        localStorage.setItem("selectedTimeSlot", timeId);
    });