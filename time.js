const chosenDate = localStorage.getItem("selectedDate");
function getDayOfWeek(dateString) {
    const date = new Date(dateString);
    const days = [0, 1, 2, 3, 4, 5, 6];
    return days[date.getDay()];
}

if (chosenDate) {
    console.log(`The selected date is a ${getDayOfWeek(chosenDate)}.`);
} else {
    console.log("No date has been selected.");
}