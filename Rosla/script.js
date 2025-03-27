


function calculateCarbonFootprint() {
    var item = document.getElementById('item-select').value;
    var usage = parseFloat(document.getElementById('usage-input').value);
    var resultBox = document.getElementById('result-box');
  
    var factors = {
      smartHome: 0.5,
      vehicle: 2.3,
      industrial: 5.0
    };
  
    if (isNaN(usage) || usage < 0) {
      resultBox.innerHTML = "<p>Please enter a valid usage amount.</p>";
      return;
    }
  
    var emission = usage * (factors[item] || 1);
    resultBox.innerHTML = "<p>Estimated Carbon Footprint: " + emission.toFixed(2) + " kg CO2</p>";
  }
  
  function changeFontSize(size) {
    var body = document.body;
    if (size === 'small') {
      body.style.fontSize = '14px';
    } else if (size === 'medium') {
      body.style.fontSize = '18px';
    } else if (size === 'large') {
      body.style.fontSize = '22px';
    }
  }

  function toggleDarkMode() {
    var body = document.body;
    body.classList.toggle('dark-mode');
  }
  