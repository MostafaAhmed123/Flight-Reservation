<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="company_page.css">
  <title>Edit Flights</title>
</head>
<body>
  <h2>Edit Flights</h2>
  <form id="flight-edit-form">
    <label for="edit-flight-number">Flight Number:</label>
    <input type="text" id="edit-flight-number" name="edit-flight-number" value="" required>

    <label for="edit-destination">Destination:</label>
    <input type="text" id="edit-destination" name="edit-destination" value="" required>

    <label for="edit-departure-time">Departure Time:</label>
    <input type="text" id="edit-departure-time" name="edit-departure-time" value="" required>

    <label for="edit-arrival-time">Arrival Time:</label>
    <input type="text" id="edit-arrival-time" name="edit-arrival-time" value="" required>

    <button type="button" onclick="saveFlightEdit()">Save</button>
  </form>
  <script src="edit_flight.js"></script>
</body>
</html>
