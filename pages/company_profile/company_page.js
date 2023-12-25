
// function showFlights(){
//   // Assuming box is a variable that you're appending HTML content to
// //   box += `
// //   <tbody id="flights-container">
// //   <tr>
// //     <td>Flight 1</td>
// //     <td>Destination A</td>
// //     <td>08:00 AM</td>
// //     <td>10:00 AM</td>
// //     <td><button class="edit-btn-flight" onclick="openEditFlightPage(0)">Edit</button></td>
// //   </tr>
// //   <tr>
// //     <td>Flight 2</td>
// //     <td>Destination B</td>
// //     <td>10:30 AM</td>
// //     <td>12:30 PM</td>
// //     <td><button class="edit-btn-flight" onclick="openEditFlightPage(1)">Edit</button></td>
// //   </tr>
// //   <tr>
// //     <td>Flight 3</td>
// //     <td>Destination C</td>
// //     <td>01:00 PM</td>
// //     <td>03:00 PM</td>
// //     <td><button class="edit-btn-flight" onclick="openEditFlightPage(2)">Edit</button></td>
// //   </tr>
// //   <!-- Add more flights as needed -->
// // </tbody>
    
// //   `;
//   // Assuming you want to append the generated HTML to a container, e.g., an element with id="flights-container"
//   document.getElementById('flights-container').innerHTML = box;
// }

function openEditFlightPage(index) {
  const table = document.getElementById('flights-container');
  const rows = table.querySelectorAll('tbody tr');
  //console.log(index)
  if (index >= 0 && index < rows.length) {
      const row = rows[index];
      const flightNumber = row.cells[0].textContent;
      const destination = row.cells[1].textContent;
      const departureTime = row.cells[2].textContent;
      const arrivalTime = row.cells[3].textContent;

      // Dynamically generate the URL with the flight index
      const queryParams = `?index=${index}&flightNumber=${encodeURIComponent(flightNumber)}&destination=${encodeURIComponent(destination)}&departureTime=${encodeURIComponent(departureTime)}&arrivalTime=${encodeURIComponent(arrivalTime)}`;
      
      // Navigate to the other page with the generated URL
      window.location.href = `edit_flight.html${queryParams}`;
  }
}

// showFlights();