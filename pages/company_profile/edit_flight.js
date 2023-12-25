// Retrieve flight details from query parameters
const urlParams = new URLSearchParams(window.location.search);
const editFlightNumber = urlParams.get('flightNumber') || '';
const editDestination = urlParams.get('destination') || '';
const editDepartureTime = urlParams.get('departureTime') || '';
const editArrivalTime = urlParams.get('arrivalTime') || '';

// Populate the form fields with the retrieved flight details
document.getElementById('edit-flight-number').value = editFlightNumber;
document.getElementById('edit-destination').value = editDestination;
document.getElementById('edit-departure-time').value = editDepartureTime;
document.getElementById('edit-arrival-time').value = editArrivalTime;

function saveFlightEdit() {
  // You can add additional logic to save the changes to a server or perform other actions

  // Navigate back to the main page
  window.location.href = 'index.html';
}
