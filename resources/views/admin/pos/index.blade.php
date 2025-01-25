@extends('layouts.master-pos')
@section('title', 'Product Sale')
@push('css')
<style>
  header {
    position: relative;
    padding: 10px;
    background-color: #f8f9fa;
  }

  .calculator {
    position: absolute;
    top: 50px;
    right: 10px;
    width: 300px;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* display: none; */
    z-index: 1000;
  }

  .calculator-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background: #007bff;
    color: white;
    border-bottom: 1px solid #ddd;
  }

  .calculator-body {
    padding: 10px;
  }

  .calculator-buttons {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 5px;
  }

  .calc-btn {
    padding: 10px;
    font-size: 16px;
    border: none;
    /* background: #007bff; */
    color: white;
    border-radius: 5px;
    cursor: pointer;
  }

  .calc-btn:hover {
    background: #0056b3;
  }

  .hidden {
    display: none;
  }

  .date-wrapper {
    position: relative;
    display: inline-block;
  }

  #date-display {
    position: absolute;
    top: 60px;
    left: 0;
    z-index: 1000;
    background: #007bff;
    /* Attractive blue background */
    color: #fff;
    /* White text for contrast */
    border: 2px solid #0056b3;
    /* Slightly darker border */
    border-radius: 10px;
    /* Rounded corners */
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    /* Softer shadow for depth */
    padding: 20px;
    /* Larger padding for a spacious look */
    font-size: 18px;
    /* Increased font size for readability */
    font-family: 'Arial', sans-serif;
    text-align: center;
    visibility: hidden;
    /* Initially hidden */
    opacity: 0;
    /* Fully transparent */
    transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    /* Smooth transition */
    transform: translateY(-10px);
    /* Slight upward shift for animation */
  }

  .date-wrapper:hover #date-display {
    visibility: visible;
    /* Show on hover */
    opacity: 1;
    /* Fully visible */
    transform: translateY(0);
    /* Reset position for animation */
  }

  #date-display div {
    margin: 5px 0;
    /* Add spacing between lines */
  }

  #date-display div:first-child {
    font-size: 24px;
    /* Larger size for the day name */
    font-weight: bold;
  }

  #date-display div:last-child {
    font-size: 20px;
    /* Slightly larger size for the time */
    font-weight: 600;
  }

  #show-date {
    font-size: 16px;
    /* Slightly larger button text */
    padding: 10px 15px;
    background-color: #dc3545;
    /* Matching button color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
  }

  #show-date:hover {
    background-color: #c82333;
    /* Darker red on hover */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* Subtle shadow on hover */
  }
</style>
@endpush
@section('content')
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Sale</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <div class="buttons breadcrumb-header float-start float-lg-end">
          <a href="{{route('admin.dashboard')}}" class="btn icon icon-left btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg> Dashboard</a>
          <a href="#" class="btn icon icon-left btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="12" y1="16" x2="12" y2="12"></line>
              <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg> Sales</a>
          <a href="{{route('admin.products.index')}}" class="btn icon icon-left btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle">
              <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
              <line x1="12" y1="9" x2="12" y2="13"></line>
              <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
            Products</a>
          <div id="date-wrapper" class="date-wrapper">
            <a href="#" class="btn icon icon-left btn-danger" id="show-date">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
              </svg>
              Date & Time
            </a>
            <div id="date-display" class="date-hidden"></div>
          </div>
          <a href="#" class="btn icon icon-left btn-success" id="show-calculator">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            Calculator
          </a>
          <div id="calculator-modal" class="calculator rounded hidden">
            <div class="calculator-header rounded">
              <h4 class="text-white">Calculator</h4>
              <button id="close-calculator" class="btn btn-danger">X</button>
            </div>
            <div class="calculator-body">
              <input type="text" class="form-control mb-2" id="calculator-display" readonly />
              <!-- Buttons -->
              <div class="calculator-buttons">
                <!-- Row 1 -->
                <button class="calc-btn btn btn-primary" data-value="C">C</button>
                <button class="calc-btn btn btn-primary" data-value="DEL">DEL</button>
                <button class="calc-btn btn btn-primary" data-value="%">%</button>
                <button class="calc-btn btn btn-primary" data-value="/">÷</button>
                <!-- Row 2 -->
                <button class="calc-btn btn btn-primary" data-value="7">7</button>
                <button class="calc-btn btn btn-primary" data-value="8">8</button>
                <button class="calc-btn btn btn-primary" data-value="9">9</button>
                <button class="calc-btn btn btn-primary" data-value="*">×</button>
                <!-- Row 3 -->
                <button class="calc-btn btn btn-primary" data-value="4">4</button>
                <button class="calc-btn btn btn-primary" data-value="5">5</button>
                <button class="calc-btn btn btn-primary" data-value="6">6</button>
                <button class="calc-btn btn btn-primary" data-value="-">-</button>
                <!-- Row 4 -->
                <button class="calc-btn btn btn-primary" data-value="1">1</button>
                <button class="calc-btn btn btn-primary" data-value="2">2</button>
                <button class="calc-btn btn btn-primary" data-value="3">3</button>
                <button class="calc-btn btn btn-primary" data-value="+">+</button>
                <!-- Row 5 -->
                <button class="calc-btn btn btn-primary" data-value="0">0</button>
                <button class="calc-btn btn btn-primary" data-value=".">.</button>
                <button class="calc-btn btn btn-success" data-value="=">=</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Basic Tables start -->
  <section class="section">
    <div class="card">
      <div class="card-body" id="cart">
      </div>
    </div>
  </section>
  <!-- Basic Tables end -->
</div>
@endsection
@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const dateDisplay = document.getElementById('date-display');

    function formatTime(date) {
      let hours = date.getHours();
      const minutes = date.getMinutes();
      const ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12 || 12; // Convert to 12-hour format
      const minutesStr = minutes < 10 ? `0${minutes}` : minutes;
      return `${hours}:${minutesStr} ${ampm}`;
    }

    function updateDateTime() {
      const now = new Date();
      const dayName = now.toLocaleDateString('en-US', {
        weekday: 'long'
      });
      const formattedTime = formatTime(now);
      const formattedDate = now.toLocaleDateString('en-US');
      dateDisplay.innerHTML = `
      <div>${dayName}</div>
      <div>${formattedDate}</div>
      <div>${formattedTime}</div>
    `;
    }

    // Initialize date and time
    updateDateTime();

    // Optionally, keep updating time every minute
    setInterval(updateDateTime, 60000);
  });


  document.addEventListener('DOMContentLoaded', function() {
    const calculatorModal = document.getElementById('calculator-modal');
    const showCalculator = document.getElementById('show-calculator');
    const closeCalculator = document.getElementById('close-calculator');

    // Show the calculator
    showCalculator.addEventListener('click', (e) => {
      e.preventDefault();
      calculatorModal.classList.toggle('hidden');
    });

    // Close the calculator
    closeCalculator.addEventListener('click', () => {
      calculatorModal.classList.add('hidden');
    });

    const display = document.getElementById('calculator-display');
    const buttons = document.querySelectorAll('.calc-btn');

    let currentInput = '';

    // Function to update the display
    const updateDisplay = () => {
      display.value = currentInput || '0';
    };

    // Add event listeners to buttons
    buttons.forEach((button) => {
      button.addEventListener('click', () => {
        const value = button.getAttribute('data-value');

        switch (value) {
          case 'C': // Clear the display
            currentInput = '';
            break;

          case 'DEL': // Delete the last character
            currentInput = currentInput.slice(0, -1);
            break;

          case '%': // Calculate percentage
            if (currentInput) {
              currentInput = String(parseFloat(currentInput) / 100);
            }
            break;

          case '=': // Evaluate the expression
            try {
              currentInput = String(eval(currentInput.replace('÷', '/').replace('×', '*')));
            } catch (error) {
              currentInput = 'Error';
            }
            break;

          default: // Add the button value to the input
            currentInput += value;
            break;
        }

        updateDisplay();
      });
    });

    // Initialize the display
    updateDisplay();
  });
</script>
@endpush