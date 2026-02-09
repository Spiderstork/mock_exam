const monthYear = document.getElementById("monthYear");
const daysContainer = document.getElementById("days");
const prevBtn = document.getElementById("prev");
const nextBtn = document.getElementById("next");
let selectedDate = localStorage.getItem("selectedDate"); 




let currentDate = new Date();

function renderCalendar() {
    daysContainer.innerHTML = "";

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

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

        const today = new Date();
        if (
          day === today.getDate() &&
          month === today.getMonth() &&
          year === today.getFullYear()
        ) {
          dayEl.classList.add("today");
        }

        const cellDate = new Date(year, month, day);
        // Remove time so comparison is date-only
        today.setHours(0, 0, 0, 0);
        if (cellDate < today) {
            dayEl.classList.add("before");   
            dayEl.style.pointerEvents = "none"; 
        }

        const thisDateKey = `${year}-${month}-${day}`;

        if (thisDateKey === selectedDate) {
            dayEl.classList.remove("today");
            dayEl.classList.add("selected_day"); 
        }


        daysContainer.appendChild(dayEl);
    }
}

function getDayOfWeek(dateString) {
    const date = new Date(dateString);
    return date.getDay();
}

prevBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});
function getTimeSlots(dayOfWeek) {
    fetch(`get_time_slot.php?day=${dayOfWeek}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById("timeslots").innerHTML = html;
        })
        .catch(err => console.error(err));
}

daysContainer.addEventListener("click", (e) => {
    if (e.target.tagName === "DIV" && e.target.textContent) {
        const day = e.target.textContent;
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        selectedDate = `${year}-${month}-${day}`;
        const formattedMonth = String(month + 1).padStart(2, "0");
        const formattedDay = String(day).padStart(2, "0");
        selectedDay = `${year}-${formattedMonth}-${formattedDay}`;

        
        localStorage.setItem("selectedDate", selectedDate);
        localStorage.setItem("selectedDayOfWeek", getDayOfWeek(selectedDay));
        getTimeSlots(getDayOfWeek(selectedDay));

        renderCalendar();
    }
});

function start() {
    const day = new Date().getDate();
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    selectedDate = `${year}-${month}-${day}`;
    const formattedMonth = String(month + 1).padStart(2, "0");
    const formattedDay = String(day).padStart(2, "0");
    selectedDay = `${year}-${formattedMonth}-${formattedDay}`;

        
    localStorage.setItem("selectedDate", selectedDate);
    localStorage.setItem("selectedDayOfWeek", getDayOfWeek(selectedDay));
    getTimeSlots(getDayOfWeek(selectedDay));

    renderCalendar();
}

start();