<?php
// Check if the session has already been started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Include database connection
include 'connectDB.php';

// Fetch donor's information
$query = "SELECT Donor_Name, Donor_Age, Donor_NoPhone, Donor_BloodG, Donor_Address, Donor_Gender FROM donor WHERE Donor_Email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$donor = $result->fetch_assoc();

// Close the database connection
$stmt->close();
$conn->close();
?>
<?php include "header.php"; ?>
<!DOCTYPE html>
<html>
<head>
   <title>Make an Appointment</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <style>
       @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        body {
        font-family: 'Poppins', sans-serif;
        background: url('') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        }
       .container {
           max-width: 800px;
           margin: 0 auto;
           padding: 20px;
           border: 1px solid #ccc;
           border-radius: 5px;
       }
       .form-group {
           margin-bottom: 20px;
           position: relative;
       }
       label {
           display: block;
           font-weight: bold;
           margin-bottom: 5px;
       }
       input[type="text"], input[type="search"] {
           width: 100%;
           padding: 8px;
           border: 1px solid #ccc;
           border-radius: 4px;
       }
       button {
           padding: 8px 16px;
           background-color: #4CAF50;
           color: white;
           border: none;
           border-radius: 4px;
           cursor: pointer;
       }
       .datetime-picker {
           display: flex;
           align-items: center;
       }
       .datetime-picker input[type="text"] {
           flex: 1;
           margin-right: 10px;
       }
       .dropdown {
           position: absolute;
           top: 100%;
           left: 0;
           right: 0;
           border: 1px solid #ccc;
           background-color: white;
           z-index: 1000;
           max-height: 200px;
           overflow-y: auto;
           display: none;
       }
       .dropdown div {
           padding: 8px;
           cursor: pointer;
       }
       .dropdown div:hover {
           background-color: #f0f0f0;
       }
   </style>
</head>
<body>
   <div class="container">
       <h1>MAKE AN APPOINTMENT</h1>
       <form action="add_appointment.php" method="POST">
           <div class="form-group">
               <label for="placeToDonor">Place to Donor:</label>
               <input type="search" id="placeToDonor" name="place" placeholder="Search" oninput="filterPlaces()">
               <div id="placeDropdown" class="dropdown"></div>
               <button type="button" onclick="confirmPlace()">Confirm</button>
           </div>
           <div class="form-group">
               <label for="chooseDate">Choose Date:</label>
               <div class="datetime-picker">
                   <input type="text" id="chooseDate" name="date" placeholder="Text input">
                   <button type="button" onclick="openDatePicker('#chooseDate')"><i class="far fa-calendar-alt"></i></button>
               </div>
           </div>
           <div class="form-group">
               <label for="chooseTime">Choose Time:</label>
               <div class="datetime-picker">
                   <input type="text" id="chooseTime" name="time" placeholder="Text input">
                   <button type="button" onclick="openTimePicker('#chooseTime')"><i class="far fa-clock"></i></button>
               </div>
           </div>
           <div class="form-group">
               <label>Personal Information:</label>
               <input type="text" name="txtName" placeholder="NAME" value="<?php echo htmlspecialchars($donor['Donor_Name']); ?>" required>
               <input type="text" name="txtAge" placeholder="AGE" value="<?php echo htmlspecialchars($donor['Donor_Age']); ?>" required>
               <input type="text" name="txtNomPhone" placeholder="NO. PHONE" value="<?php echo htmlspecialchars($donor['Donor_NoPhone']); ?>" required>
               <input type="text" name="txtBloodGrp" placeholder="BLOOD GROUP" value="<?php echo htmlspecialchars($donor['Donor_BloodG']); ?>" required>
               <input type="text" name="txtAddress" placeholder="ADDRESS" value="<?php echo htmlspecialchars($donor['Donor_Address']); ?>" required>
               <input type="text" name="txtGender" placeholder="GENDER" value="<?php echo htmlspecialchars($donor['Donor_Gender']); ?>" required>
               <button type="submit">SUBMIT</button>
           </div>
       </form>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
   <script>
       const places = [
        /*
           'Hospital Tengku Ampuan Rahimah',
           'Clinic Harmoni',
           'Health Centre Sejahtera',
           'MSU Health Care',
           'Medical Centre KayPoint',
           'Clinic Siti',*/
           'Hospital Enche Besar Hajjah Kalsom',
            'Hospital Kota Tinggi Kota Tinggi',
            'Hospital Mersing, Mersing',
            'Hospital Sultanah Aminah',
            'Hospital Permai, Johor Bahru',
            'Hospital Pontian, Pontian',
            'Hospital Segamat, Segamat',
            'Hospital Sultan Ismail, Johor Bahru',
            'Hospital Pakar Sultanah Fatimah, Muar',
            'Hospital Sultanah Nora Ismail, Batu Pahat',
            'Hospital Tangkak, Tangkak',
            'Hospital Temenggong Seri Maharaja Tun Ibrahim, Kulai'
       ];

       const placeInput = document.getElementById('placeToDonor');
       const placeDropdown = document.getElementById('placeDropdown');

       placeInput.addEventListener('focus', () => {
           populateDropdown(places);
           placeDropdown.style.display = 'block';
       });

       document.addEventListener('click', (event) => {
           if (!placeInput.contains(event.target) && !placeDropdown.contains(event.target)) {
               placeDropdown.style.display = 'none';
           }
       });

       function populateDropdown(places) {
           placeDropdown.innerHTML = '';
           places.forEach(place => {
               const div = document.createElement('div');
               div.textContent = place;
               div.addEventListener('click', () => {
                   placeInput.value = place;
                   placeDropdown.style.display = 'none';
               });
               placeDropdown.appendChild(div);
           });
       }

       function filterPlaces() {
           const filter = placeInput.value.toLowerCase();
           const filteredPlaces = places.filter(place => place.toLowerCase().includes(filter));
           populateDropdown(filteredPlaces);
           placeDropdown.style.display = 'block';
       }

       function openDatePicker(selector) {
           flatpickr(selector, {
               enableTime: false,
               dateFormat: "Y-m-d",
               defaultDate: new Date()
           }).open();
       }

       function openTimePicker(selector) {
           flatpickr(selector, {
               enableTime: true,
               noCalendar: true,
               dateFormat: "H:i",
               time_24hr: true,
               defaultDate: new Date()
           }).open();
       }

       function confirmPlace() {
           // Additional logic can be added here if needed
       }
   </script>
</body>
</html>
<?php include "footer.php"; ?>
