-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 07:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bloodbank_websys`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `Appointment_ID` int(255) NOT NULL,
  `Appointment_Location` longtext NOT NULL,
  `Appointment_Date` date NOT NULL DEFAULT current_timestamp(),
  `Appointment_Time` time NOT NULL DEFAULT current_timestamp(),
  `Appointment_Point` int(255) NOT NULL,
  `Appointment_Status` varchar(255) NOT NULL,
  `Donor_Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`Appointment_ID`, `Appointment_Location`, `Appointment_Date`, `Appointment_Time`, `Appointment_Point`, `Appointment_Status`, `Donor_Email`) VALUES
(1, 'KK Tanjong Sepat', '2023-11-09', '07:00:00', 250, 'completed', 'zsnhninaz@gmail.com'),
(2, 'Hospital Banting', '2024-01-13', '15:00:00', 70, 'Not completed', 'zsnhninaz@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `Donor_Email` varchar(255) NOT NULL,
  `Doctor_Email` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `message_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `Donor_Email`, `Doctor_Email`, `sender_email`, `message`, `message_time`) VALUES
(1, 'zsnhninaz@gmail.com', 'Zaid@gmail.com', 'zsnhninaz@gmail.com', 'Hi Try test', '2024-07-04 20:41:37'),
(2, 'zsnhninaz@gmail.com', 'Zaid@gmail.com', 'zsnhninaz@gmail.com', '', '2024-07-04 20:41:50'),
(3, 'zsnhninaz@gmail.com', 'Zaid@gmail.com', 'Zaid@gmail.com', 'Nice to meet you, how can i help you?', '2024-07-04 20:42:35'),
(4, 'zsnhninaz@gmail.com', 'Zaid@gmail.com', 'zsnhninaz@gmail.com', 'i need some motivation', '2024-07-04 20:52:41'),
(5, 'zsnhninaz@gmail.com', 'Zaid@gmail.com', 'zsnhninaz@gmail.com', 'test', '2024-07-05 07:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `Doctor_ID` int(255) NOT NULL,
  `Doctor_Name` varchar(255) NOT NULL,
  `Doctor_Email` varchar(255) NOT NULL,
  `Doctor_Pass` varchar(255) NOT NULL,
  `Doctor_Certification` varchar(255) NOT NULL,
  `Doctor_WorkingLoc` longtext NOT NULL,
  `Doctor_Aboutme` longtext NOT NULL,
  `Doctor_Position` varchar(255) NOT NULL,
  `Doctor_Register date` int(255) NOT NULL,
  `Doctor_Pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`Doctor_ID`, `Doctor_Name`, `Doctor_Email`, `Doctor_Pass`, `Doctor_Certification`, `Doctor_WorkingLoc`, `Doctor_Aboutme`, `Doctor_Position`, `Doctor_Register date`, `Doctor_Pic`) VALUES
(1, 'Dr. Siti Aminah Wahab', 'aminah@gmail.com', '222', 'MBBS, FRCS', 'Hospital Sultanah Aminah, Jalan Persiaran Abu Bakar Sultan, 80100 Johor Bahru, Johor', 'Specializes in surgery with a focus on minimally invasive procedures', 'Surgeon', 2004, 'drNatasha.png'),
(2, 'Dr. Ahmad Zaid', 'Zaid@gmail.com', '0000', 'MBBS, MD', 'Hospital Kuala Lumpur, Jalan Pahang, 50586 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur', 'Experienced General Practitioner with over 15 years of experience.', 'Consultant', 0, 'doctor3.png'),
(3, 'Dr. Zulaikha ', 'zulaikha@gmail.com', '555', 'MBBS, PhD', 'Hospital Tengku Ampuan Rahimah, Jalan Langat, 41200 Klang, Selangor', 'Renowned cardiologist with multiple publications in international journals.', 'Cardiologist', 0, 'doctor2.png'),
(4, 'Dr. Rashid Bin Ismail', 'rbismail@example.com', '333', 'MBBS, FACC', 'Hospital Tuanku Jaafar, Jalan Rasah, 70300 Seremban, Negeri Sembilan', 'Expert in cardiovascular diseases and interventions', 'Cardiologist', 0, 'doctor4.png'),
(9, 'Dr. Tan Siew Fong', 'tsfong@example.com', 'mypassword567', 'MBBS, FRACP', 'Hospital Sultanah Nur Zahirah, Jalan Sultan Mahmud, 20400 Kuala Terengganu, Terengganu', 'Pediatrician dedicated to child health and wellness.', 'Pediatrician', 1646092800, 'doctor6.png'),
(11, 'Dr. Wong Wei Ming', 'wwming@example.com', 'passwordsecure234', 'MBBS, MS Ortho', 'Hospital Queen Elizabeth, Jalan Penampang, 88200 Kota Kinabalu, Sabah', 'Orthopedic surgeon with a passion for sports medicine.', 'Orthopedic Surgeon', 1643673600, 'doctor4.png');

-- --------------------------------------------------------

--
-- Table structure for table `donation_events`
--

CREATE TABLE `donation_events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `Doctor_Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_events`
--

INSERT INTO `donation_events` (`id`, `event_name`, `date`, `location`, `description`, `Doctor_Email`) VALUES
(41, 'Blood Donation Drive at KLCC', '2024-07-15', 'Kuala Lumpur Convention Centre, Kuala Lumpur', 'Join us at KLCC for a blood donation drive. Every donor will receive a free health check-up and refreshments.', ''),
(42, 'Community Blood Donation Campaign', '2024-07-22', 'Sunway Pyramid, Petaling Jaya', 'We are organizing a community blood donation campaign at Sunway Pyramid. Come and help save lives!', ''),
(43, 'Red Cross Blood Donation Event', '2024-08-01', 'Mid Valley Megamall, Kuala Lumpur', 'The Malaysian Red Cross is hosting a blood donation event at Mid Valley Megamall. Your donation can make a difference.', ''),
(44, 'Hospital Blood Drive', '2024-08-05', 'Pantai Hospital, Kuala Lumpur', 'Pantai Hospital is conducting a blood drive. All donors will receive a thank-you gift.', ''),
(45, 'Corporate Blood Donation Program', '2024-08-12', 'Menara Maybank, Kuala Lumpur', 'Maybank is hosting a blood donation program for its employees and the public. Help us reach our goal of 500 pints.', ''),
(46, 'National Blood Center Donation Event', '2024-08-18', 'National Blood Center, Kuala Lumpur', 'Join us at the National Blood Center for a major blood donation event. Refreshments and certificates will be provided to all donors.', ''),
(47, 'University Blood Donation Campaign', '2024-09-01', 'University of Malaya, Kuala Lumpur', 'University of Malaya is organizing a blood donation campaign. Students, staff, and the public are welcome to donate.', ''),
(48, 'Community Health and Blood Donation Fair', '2024-09-10', 'Penang Times Square, George Town', 'A community health and blood donation fair will be held at Penang Times Square. Various health services and blood donation booths will be available.', ''),
(49, 'Annual Blood Donation Drive', '2024-09-25', 'IOI City Mall, Putrajaya', 'Our annual blood donation drive at IOI City Mall is back! Participate and help save lives.', ''),
(50, 'Blood Donation and Health Screening', '2024-10-05', 'Tropicana Medical Centre, Petaling Jaya', 'Tropicana Medical Centre is organizing a blood donation and health screening event. Free health checks for all donors.', ''),
(51, 'Charity Blood Donation Event', '2024-10-15', 'Gurney Plaza, George Town', 'A charity blood donation event will be held at Gurney Plaza. Donations will be used to support local hospitals.', ''),
(52, 'Public Blood Donation Initiative', '2024-10-20', 'Dataran Merdeka, Kuala Lumpur', 'A public blood donation initiative at Dataran Merdeka. Help us collect 1,000 pints of blood.', ''),
(53, 'Mobile Blood Donation Unit', '2024-10-30', 'Petronas Twin Towers, Kuala Lumpur', 'Our mobile blood donation unit will be stationed at the Petronas Twin Towers. Donate blood conveniently.', ''),
(54, 'Blood Donation Drive at Queensbay Mall', '2024-11-05', 'Queensbay Mall, Bayan Lepas', 'Join us at Queensbay Mall for a blood donation drive. Free gifts for the first 100 donors.', ''),
(55, 'Blood Donation Awareness Campaign', '2024-11-15', 'Sunway University, Subang Jaya', 'Sunway University is hosting a blood donation awareness campaign. Educate yourself and donate blood.', ''),
(56, 'Save Lives Blood Donation Event', '2024-11-25', 'Pavilion Kuala Lumpur, Kuala Lumpur', 'Save lives by donating blood at Pavilion Kuala Lumpur. Special discounts for donors at participating stores.', ''),
(57, 'Holiday Season Blood Donation Drive', '2024-12-05', 'The Gardens Mall, Kuala Lumpur', 'Celebrate the holiday season by donating blood at The Gardens Mall. Enjoy festive treats for all donors.', ''),
(58, 'Year-End Blood Donation Campaign', '2024-12-15', 'Bukit Bintang, Kuala Lumpur', 'Join us for the year-end blood donation campaign at Bukit Bintang. Let\'s end the year by saving lives.', ''),
(59, 'New Year Blood Donation Drive', '2025-01-02', 'KL Sentral, Kuala Lumpur', 'Start the new year by donating blood at KL Sentral. Be a hero and save lives.', ''),
(60, 'Blood Donation Marathon', '2025-01-10', '1 Utama Shopping Centre, Petaling Jaya', 'Participate in the blood donation marathon at 1 Utama Shopping Centre. Let\'s make a difference together.', '');

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `Donor_ID` int(255) NOT NULL,
  `Donor_Name` varchar(255) NOT NULL,
  `Donor_Email` varchar(255) NOT NULL,
  `Donor_Pass` varchar(255) NOT NULL,
  `Donor_BloodG` varchar(255) NOT NULL,
  `Donor_Address` longtext NOT NULL,
  `Donor_Gender` varchar(255) NOT NULL,
  `Donor_MartialStat` varchar(255) NOT NULL,
  `Donor_Occupation` varchar(255) NOT NULL,
  `Donor_Age` int(255) NOT NULL,
  `Donor_NoPhone` varchar(255) NOT NULL,
  `Donor_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`Donor_ID`, `Donor_Name`, `Donor_Email`, `Donor_Pass`, `Donor_BloodG`, `Donor_Address`, `Donor_Gender`, `Donor_MartialStat`, `Donor_Occupation`, `Donor_Age`, `Donor_NoPhone`, `Donor_pic`) VALUES
(1, 'SITI NUR HUSNINA', 'zsnhninaz@gmail.com', '123', 'A+', 'Batu laut', 'Female', 'Single', 'Sciencetist', 20, '1785604425', 'WIN_20230411_08_58_13_Pro.jpg'),
(4, 'siti', 'siti@gmail.com', '4444', 'O-', '789, Jalan Bukit Bintang, 55100 Kuala Lumpu', 'Female', 'Single', 'Singer', 40, '0123456787', 'WomanPic.jpg'),
(6, 'Zainab Halimah', 'ZainabH@gmail.com', '098', 'B', 'Cyberjaya', 'Female', 'Married', 'Police', 30, '0176525540', 'photo_2024-07-06_00-26-16.jpg'),
(7, 'Khairun', 'khai@gmail.com', '456', 'A+', 'Batu Enam', 'Male', 'Single', 'Sciencetist', 30, '0146853249', 'photo_2024-07-06_00-26-35.jpg'),
(8, 'Amalia Nabilah', 'ami@gmail.com', '$2y$10$aYZR6enwFMn5e7kCMkkD/eoeG77u1W2GKEoP0QGv1KfA.Md.vwmF.', 'O', 'Taman Putra perdana, sepang', 'Female', 'Single', 'Doctor', 27, '0110425477', 'abel pic pasport.png');

-- --------------------------------------------------------

--
-- Table structure for table `redeempoint`
--

CREATE TABLE `redeempoint` (
  `Redeem_Name` varchar(255) NOT NULL,
  `Redeem_ID` int(255) NOT NULL,
  `Redeem_PointValue` bigint(255) NOT NULL,
  `Redeem_Desc` longtext NOT NULL,
  `Redeem_TotalPoint` bigint(255) NOT NULL,
  `Redeem_pic` varchar(255) NOT NULL,
  `Donor_Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `redeempoint`
--

INSERT INTO `redeempoint` (`Redeem_Name`, `Redeem_ID`, `Redeem_PointValue`, `Redeem_Desc`, `Redeem_TotalPoint`, `Redeem_pic`, `Donor_Email`) VALUES
('Dry Saver', 1, 600, 'Stay dry and stand out in the rain with this new umbrella.\r\n\r\n', 0, 'UmbrellaRedeem.jpg', 'zsnhninaz@gmail.com'),
('Cool T-Shirt to show off', 2, 600, 'Don’t miss your chance to help build the blood supply and get an exclusive T-shirt.\r\n', 0, 'tShirtRedeem.jpg', 'zsnhninaz@gmail.com'),
('Hero Shirt', 3, 700, 'Show your blood donor pride with our classic Red Cross Raglan shirt.\n\n', 0, 'ShirtRedeem.jpg', 'zsnhninaz@gmail.com'),
('Hydration for Life', 4, 250, 'An eco-friendly and durable water bottle with a blood drop design, reminding donors to stay hydrated before and after their donation while contributing to a sustainable cause.\n', 0, 'waterBottle.jpeg', 'zsnhninaz@gmail.com'),
('Life Saver Keychain', 5, 100, 'A sleek and portable keychain designed with a vibrant red blood drop pendant, symbolizing the lifesaving power of blood donation.', 0, 'keychain.jpeg', 'zsnhninaz@gmail.com'),
('Carry the Lifeline', 6, 300, ' A spacious and versatile tote bag featuring the blood donation logo and motivational slogan, perfect for carrying essentials while promoting the noble act of blood donation.', 0, 'toteBag.jpeg', 'zsnhninaz@gmail.com'),
('Pulse of Giving', 7, 70, ' A silicone wristband with a bold red color and the blood donation symbol, serving as a constant reminder of the vital role played by blood donors in saving lives.', 0, 'siliconeWrist.jpeg', 'zsnhninaz@gmail.com'),
('Healing Touch', 8, 350, ' A voucher that entitles the blood donor to receive a discounted rate or complimentary service at a partnering health or wellness facility, such as a massage, acupuncture session, or therapeutic treatment.', 0, 'voucher.jpeg', 'zsnhninaz@gmail.com'),
('Badge of Honor', 9, 150, ' A durable and adjustable lanyard featuring the blood donation logo and slogan, designed to hold an identification card or badge for blood donors, making it easy to showcase their commitment to this noble cause.', 0, 'lanyard.jpeg', 'zsnhninaz@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `redemption`
--

CREATE TABLE `redemption` (
  `id` int(11) NOT NULL,
  `Donor_Email` varchar(255) NOT NULL,
  `Redeem_ID` varchar(50) NOT NULL,
  `Redeem_Points` int(11) NOT NULL,
  `Donor_Name` varchar(255) NOT NULL,
  `Donor_Address` text DEFAULT NULL,
  `Donor_NoPhone` varchar(20) DEFAULT NULL,
  `Redeem_Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `redemption`
--

INSERT INTO `redemption` (`id`, `Donor_Email`, `Redeem_ID`, `Redeem_Points`, `Donor_Name`, `Donor_Address`, `Donor_NoPhone`, `Redeem_Date`) VALUES
(1, 'zsnhninaz@gmail.com', '5', 100, 'SITI NUR HUSNINA', 'Batu laut', '1785604425', '2024-07-05 09:37:47'),
(2, 'zsnhninaz@gmail.com', '9', 150, 'SITI NUR HUSNINA', 'Batu laut', '1785604425', '2024-07-05 15:15:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`Appointment_ID`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`Doctor_ID`);

--
-- Indexes for table `donation_events`
--
ALTER TABLE `donation_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`Donor_ID`);

--
-- Indexes for table `redeempoint`
--
ALTER TABLE `redeempoint`
  ADD PRIMARY KEY (`Redeem_ID`);

--
-- Indexes for table `redemption`
--
ALTER TABLE `redemption`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `Appointment_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `Doctor_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `donation_events`
--
ALTER TABLE `donation_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `donor`
--
ALTER TABLE `donor`
  MODIFY `Donor_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `redeempoint`
--
ALTER TABLE `redeempoint`
  MODIFY `Redeem_ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `redemption`
--
ALTER TABLE `redemption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
