<style>
  .people-selector {
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

  .people-header {
    text-align: center;
    margin-bottom: 12px;
    font-size: 1.2rem;
    font-weight: bold;
    color: #ffffff;
  }

  .people-controls {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 10px;
    align-items: center;
  }

  .people-controls button {
    background: #2563eb;
    border: none;
    color: white;
    border-radius: 8px;
    font-size: 1.5rem;
    cursor: pointer;
    min-height: 48px;
  }

  .people-controls button:hover {
    background: #1d4ed8;
  }

  .people-controls h1{
    width: 80%;
    text-align: center;
    font-size: 1.2rem;
    padding: 10px;
    border-radius: 8px;
    border: none;
    outline: none;
    background: #0f172a;
    color: white;
  }
</style>

<div class="people-selector">
  <div class="people-header">Select People</div>

  <div class="people-controls">
    <button id="minus">−</button>
    <h1 id="peopleCount">1</h1>
    <button id="plus">+</button>
  </div>
</div>

<script>
  const minusBtn = document.getElementById("minus");
  const plusBtn = document.getElementById("plus");
  const peopleInput = document.getElementById("peopleCount");
  localStorage.setItem("peopleCount", peopleInput.textContent);

  minusBtn.addEventListener("click", () => {
    let value = parseInt(peopleInput.textContent) || 1;
    if (value > 1) {
      peopleInput.textContent = value - 1;
      localStorage.setItem("peopleCount", peopleInput.textContent);
    }
  });

  plusBtn.addEventListener("click", () => {
    let value = parseInt(peopleInput.textContent) || 1;
    if (value < 100) peopleInput.textContent = value + 1;
    localStorage.setItem("peopleCount", peopleInput.textContent);
  });
</script>
