const monthYear = document.getElementById("monthYear");
const daysContainer = document.getElementById("days");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");
let selectedDate = localStorage.getItem("selectedDate") || null;

let currentDate = new Date();

// Helper to format YYYY-MM-DD
function formatDate(year, month, day) {
    const m = String(month).padStart(2, "0"); // month 1-12
    const d = String(day).padStart(2, "0");
    return `${year}-${m}-${d}`;
}

function renderCalendar() {
    daysContainer.innerHTML = "";

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth(); // 0-indexed
    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    monthYear.textContent = `${months[month]} ${year}`;

    // Empty cells before first day
    for (let i = 0; i < firstDay; i++) {
        const empty = document.createElement("div");
        empty.classList.add("other-month");
        daysContainer.appendChild(empty);
    }

    // Days of the month
    for (let day = 1; day <= lastDate; day++) {
        const dayEl = document.createElement("div");
        dayEl.textContent = day;

        const cellDateStr = formatDate(year, month + 1, day);

        // Today
        const today = new Date();
        const todayStr = formatDate(today.getFullYear(), today.getMonth() + 1, today.getDate());
        if (cellDateStr === todayStr) {
            dayEl.classList.add("today");
        }

        // Past dates
        if (new Date(cellDateStr) < new Date(todayStr)) {
            dayEl.classList.add("before");
            dayEl.style.pointerEvents = "none";
        }

        // Selected date
        if (cellDateStr === selectedDate) {
            dayEl.classList.remove("today");
            dayEl.classList.add("selected_day");
        }

        daysContainer.appendChild(dayEl);
    }
}

// Get day of the week 0-6
function getDayOfWeek(dateString) {
    return new Date(dateString).getDay();
}

// Fetch time slots
function getTimeSlots(dayOfWeek) {
    fetch(`get_time_slot.php?day=${dayOfWeek}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById("timeslots").innerHTML = html;
        })
        .catch(err => console.error(err));
}

// Previous / Next month buttons
prevBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

// Day click
daysContainer.addEventListener("click", (e) => {
    if (e.target.tagName === "DIV" && e.target.textContent) {
        const day = parseInt(e.target.textContent);
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth() + 1; // 1-12

        selectedDate = formatDate(year, month, day);
        localStorage.setItem("selectedDate", selectedDate);
        localStorage.setItem("selectedDayOfWeek", getDayOfWeek(selectedDate));

        getTimeSlots(getDayOfWeek(selectedDate));
        renderCalendar();
    }
});

// Initialize calendar
function start() {
    const today = new Date();
    const year = today.getFullYear();
    const month = today.getMonth() + 1;
    const day = today.getDate();

    if (!selectedDate) {
        selectedDate = formatDate(year, month, day);
        localStorage.setItem("selectedDate", selectedDate);
        localStorage.setItem("selectedDayOfWeek", getDayOfWeek(selectedDate));
    }

    getTimeSlots(getDayOfWeek(selectedDate));
    renderCalendar();
}

start();