  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Court Reservation System</title>
    <style>
      /* Add your styling here */
      .court {
        width: 100px;
        height: 100px;
        margin: 10px;
        background-color: #ddd;
        border: 1px solid #999;
        text-align: center;
        line-height: 100px;
        cursor: pointer;
      }
      .reserved {
        background-color: #ff0000; /* Change to your desired color for reserved courts */
      }
    </style>
  </head>
  <body>

    <h1>Court Reservation System</h1>

    <div id="courts-container">
      <!-- Generate court elements dynamically using JavaScript -->
    </div>

    <script>
      // Number of courts
      const totalCourts = 11;

      // Function to initialize the court layout
      function initializeCourts() {
        const courtsContainer = document.getElementById('courts-container');

        for (let i = 1; i <= totalCourts; i++) {
          const court = document.createElement('div');
          court.classList.add('court');
          court.setAttribute('data-court-number', i);
          court.textContent = `Court ${i}`;
          court.addEventListener('click', reserveCourt);
          courtsContainer.appendChild(court);
        }
      }

      // Function to handle court reservation
      function reserveCourt(event) {
        const selectedCourt = event.target;

        // Check if the court is already reserved
        if (selectedCourt.classList.contains('reserved')) {
          alert('This court is already reserved. Please choose another one.');
        } else {
          // Reserve the court
          selectedCourt.classList.add('reserved');
          alert(`Court ${selectedCourt.getAttribute('data-court-number')} reserved successfully!`);
        }
      }

      // Initialize the court layout
      initializeCourts();
    </script>

  </body>
  </html>
