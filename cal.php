<style>
    .calendar {
  background: #020617;
  font-family: Arial, sans-serif;
  color: white;
  border-radius: 12px;
  padding: clamp(12px, 3vw, 20px);
  width: 100%;
  max-width: 320px;               
  margin: 0 auto;                
  box-shadow: 0 10px 25px rgba(0,0,0,0.4);
}

.calendar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: clamp(8px, 2vw, 12px);
}

.calendar-header h2 {
  margin: 0;
  font-size: clamp(1rem, 3vw, 1.3rem);
  text-align: center;
  flex: 1;                       
}

.calendar-header button {
  background: #2563eb;
  border: none;
  color: white;
  padding: 8px 12px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1rem;
  min-width: 40px;            
  min-height: 40px;
}

.weekdays, .days {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  text-align: center;
  gap: clamp(4px, 1.5vw, 6px);
}

.weekdays div {
  font-weight: bold;
  color: #93c5fd;
  font-size: clamp(0.7rem, 2.5vw, 0.9rem);
}

.days div {
  padding: clamp(8px, 2.5vw, 12px) 0;
  border-radius: 8px;
  cursor: pointer;
  font-size: clamp(0.8rem, 2.8vw, 1rem);       
  display: flex;
  align-items: center;
  justify-content: center;
}

.days div:hover {
  background: #1e293b;
}

.selected_day {
  background: #2563eb;
  color: white;
  font-weight: bold;
}

.today {
  background: #2564eb47;
  color: white;
  font-weight: bold;
}

.before {
  background: #575757;
  color: white;
  font-weight: bold;
}

.other-month {
  color: #475569;
}

</style>
<body>
  <div class="calendar">
    <div class="calendar-header">
      <button id="prev">&lt;</button>
      <h2 id="monthYear"></h2>
      <button id="next">&gt;</button>
    </div>

    <div class="weekdays">
      <div>Sun</div>
      <div>Mon</div>
      <div>Tue</div>
      <div>Wed</div>
      <div>Thu</div>
      <div>Fri</div>
      <div>Sat</div>
    </div>

    <div class="days" id="days"></div>
  </div>