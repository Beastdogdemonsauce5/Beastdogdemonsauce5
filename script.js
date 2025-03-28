document.addEventListener('DOMContentLoaded', function() {
  const footer = document.querySelector('footer');
  const threshold = 100;

  function updateFooter() {
    if (window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - threshold) {
      footer.classList.add('expanded');
    } else {
      footer.classList.remove('expanded');
    }
  }

  window.addEventListener('scroll', updateFooter);
  window.addEventListener('resize', updateFooter);
  footer.addEventListener('mouseenter', function() {
    footer.classList.add('expanded');
  });
  footer.addEventListener('mouseleave', updateFooter);
  updateFooter();
});

function calculateCarbonFootprint() {
  const item = document.getElementById('item-select').value;
  const usageInput = document.getElementById('usage-input');
  const usage = parseFloat(usageInput.value);
  const resultBox = document.getElementById('result-box');

  const factors = {
    smartHome: 0.5,
    vehicle: 2.3,
    industrial: 5.0
  };

  if (isNaN(usage) || usage < 0) {
    resultBox.innerHTML = "<p>Please enter a valid usage amount.</p>";
    return;
  }

  const emission = usage * (factors[item] || 1);
  resultBox.innerHTML = "<p>Estimated Carbon Footprint: " + emission.toFixed(2) + " kg CO2</p>";
}

function changeFontSize(size) {
  if (size === 'small') {
    document.body.style.fontSize = '14px';
  } else if (size === 'medium') {
    document.body.style.fontSize = '18px';
  } else if (size === 'large') {
    document.body.style.fontSize = '22px';
  }
}

function toggleDarkMode() {
  document.body.classList.toggle('dark-mode');
}
