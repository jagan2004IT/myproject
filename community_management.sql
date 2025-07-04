-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database-2.c94k8mya6u71.eu-north-1.rds.amazonaws.com
-- Generation Time: Feb 23, 2025 at 02:06 PM
-- Server version: database-5.c94k8mya6u71.eu-north-1.rds.amazonaws.com
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `community_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `content`, `image_path`, `created_at`) VALUES
(5, 'We\\\'re excited to announce the launch of a new feature on our platform: real-time chat for students and tutors. This feature is now live and available for use.', 'uploads/one.jpeg', '2025-01-02 06:39:23'),
(6, 'Join us for our annual conference on web development. Learn about the latest trends and technologies from industry experts. Date: March 12, 2025', 'uploads/two.jpeg', '2025-01-02 06:39:54'),
(7, 'Our platform will be down for scheduled maintenance from 11:00 PM to 2:00 AM tomorrow', 'uploads/three.jpeg', '2025-01-02 06:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `facility_id`, `user_id`, `booking_date`, `start_time`, `end_time`, `status`, `created_at`) VALUES
(4, 1, 1, '2025-01-03', '12:34:00', '13:35:00', 'approved', '2025-01-02 07:04:38');

-- --------------------------------------------------------

--
-- Table structure for table `community_events`
--

CREATE TABLE `community_events` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `community_events`
--

INSERT INTO `community_events` (`id`, `event_name`, `event_date`, `event_description`, `created_at`) VALUES
(1, 'bbqgh', '2024-12-20', 'bbq showers ', '2024-12-19 10:06:58'),
(3, 'christmas', '2024-12-25', 'chrismas joy of happiness', '2024-12-19 10:07:34'),
(4, 'fgg', '2025-01-02', 'gfcgfch', '2025-02-20 15:11:36');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'room stay', 'you can stay it in a room ', '2024-12-19 07:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feedback_content` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `feedback_content`, `submitted_at`) VALUES
(1, 1, 'indhuedgdfrhx', '2024-12-26 09:31:03'),
(10, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 07:47:54'),
(11, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 07:49:06'),
(12, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 07:51:02'),
(13, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 07:51:19'),
(14, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 07:55:07'),
(15, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 07:55:35'),
(16, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 07:57:39'),
(17, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 07:57:56'),
(18, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 07:59:55'),
(19, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 08:00:31'),
(20, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 08:00:44'),
(21, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 08:02:37'),
(22, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 08:02:53'),
(23, 1, 'fhgjuhik fhvgiu ghjuyhu', '2025-01-02 08:04:18');

-- --------------------------------------------------------

--
-- Table structure for table `found_items`
--

CREATE TABLE `found_items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text DEFAULT NULL,
  `found_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laundry_alerts`
--

CREATE TABLE `laundry_alerts` (
  `alert_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `alert_message` varchar(255) NOT NULL,
  `alert_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `laundry_alerts`
--

INSERT INTO `laundry_alerts` (`alert_id`, `user_id`, `alert_message`, `alert_date`) VALUES
(1, 1, 'laundry is available ', '2024-12-26 07:20:50'),
(2, 3, 'laundry is available ', '2025-01-02 07:10:39'),
(3, 1, 'laundry is available ', '2025-02-20 15:05:38');

-- --------------------------------------------------------

--
-- Table structure for table `lost_items`
--

CREATE TABLE `lost_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text DEFAULT NULL,
  `report_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'reported'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `lost_items`
--

INSERT INTO `lost_items` (`id`, `user_id`, `item_name`, `item_description`, `report_date`, `status`) VALUES
(1, 1, 'dress', 'dress rghgctj ', '2024-12-26 07:32:00', 'claimed'),
(23, 1, 'dress', 'fhftuy', '2025-01-02 08:28:19', 'claimed');

-- --------------------------------------------------------

--
-- Table structure for table `lost_item_feedback`
--

CREATE TABLE `lost_item_feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lost_item_id` int(11) NOT NULL,
  `feedback_content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_requests`
--

CREATE TABLE `maintenance_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `priority` enum('Low','Medium','High') NOT NULL,
  `status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `maintenance_requests`
--

INSERT INTO `maintenance_requests` (`id`, `user_id`, `request_type`, `description`, `priority`, `status`, `payment_status`, `created_at`) VALUES
(1, 1, 'Cleaning', 'degxdhdfyh', 'Medium', 'Completed', 'Paid', '2024-12-19 09:45:21');

-- --------------------------------------------------------

--
-- Table structure for table `news_feed`
--

CREATE TABLE `news_feed` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `news_feed`
--

INSERT INTO `news_feed` (`id`, `content`, `image_path`, `created_at`) VALUES
(4, 'The parking lot will undergo repairs on January 12th, 2025 from 9:00 AM - 5:00 PM. During this time, access to certain parking spots may be restricted. Please follow the posted signs and park in alternative spots if needed', 'admin/uploads/news/four.jpg', '2025-01-02 06:52:43'),
(10, 'The community pool will be closed for routine maintenance on January 18th, 2025 from 9:00 AM - 3:00 PM. Please plan accordingly. We appreciate your understanding and will notify you once the pool is ready for use again', 'uploads/five.jpg', '2025-01-02 07:01:56');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `maintenance_request_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('Success','Failed','Pending') DEFAULT 'Pending',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `maintenance_request_id`, `amount`, `status`, `payment_date`) VALUES
(1, 1, 1, 50.00, 'Success', '2024-12-19 09:45:23');

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `poll_id` int(11) NOT NULL,
  `poll_title` varchar(255) NOT NULL,
  `poll_description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`poll_id`, `poll_title`, `poll_description`, `created_at`) VALUES
(1, 'want to put street lights ', 'street lights ', '2024-12-19 11:51:15');

-- --------------------------------------------------------

--
-- Table structure for table `poll_questions`
--

CREATE TABLE `poll_questions` (
  `question_id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `question_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `poll_questions`
--

INSERT INTO `poll_questions` (`question_id`, `poll_id`, `question_text`) VALUES
(1, 1, 'want to put '),
(2, 1, 'want to stree');

-- --------------------------------------------------------

--
-- Table structure for table `poll_responses`
--

CREATE TABLE `poll_responses` (
  `response_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `response` text NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `poll_responses`
--

INSERT INTO `poll_responses` (`response_id`, `user_id`, `poll_id`, `response`, `question_id`) VALUES
(5, 1, 1, 'yes', 1),
(6, 1, 1, 'yes', 2);

-- --------------------------------------------------------

--
-- Table structure for table `rent_payments`
--

CREATE TABLE `rent_payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_type` enum('Rent','Utilities') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('Pending','Paid') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `month` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rent_payments`
--

INSERT INTO `rent_payments` (`id`, `user_id`, `payment_type`, `amount`, `due_date`, `status`, `created_at`, `month`) VALUES
(4, 1, 'Rent', 20000.00, '2025-01-02', 'Paid', '2025-01-02 07:38:37', 'January 2025');

-- --------------------------------------------------------

--
-- Table structure for table `rent_payment_receipts`
--

CREATE TABLE `rent_payment_receipts` (
  `id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `receipt_number` varchar(255) NOT NULL,
  `receipt_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rent_payment_receipts`
--

INSERT INTO `rent_payment_receipts` (`id`, `payment_id`, `receipt_number`, `receipt_date`) VALUES
(3, 4, 'REC-67764421D1A53', '2025-01-02'),
(4, 4, 'REC-67764D942F36A', '2025-01-02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `apartment_number` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `contact` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `apartment_number`, `password`, `created_at`, `contact`) VALUES
(1, 'indhuja', '123', '$2y$10$Iok/wBA95avXNCZRo8mCS.IlGk9hJ1nWEyhF.RQRxxYzA.rcCYQnq', '2024-12-12 07:26:54', '5756756878'),
(3, 'manojkumar', '124', '$2y$10$pOEKTKEXjwzLCG5z86uiYO4R4M8CcnqyL3LgrlsRtwhdt1xKX1Ud.', '2024-12-13 07:28:58', '7708736654');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facility_id` (`facility_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `community_events`
--
ALTER TABLE `community_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `found_items`
--
ALTER TABLE `found_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laundry_alerts`
--
ALTER TABLE `laundry_alerts`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lost_items`
--
ALTER TABLE `lost_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `lost_item_feedback`
--
ALTER TABLE `lost_item_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `lost_item_id` (`lost_item_id`);

--
-- Indexes for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `news_feed`
--
ALTER TABLE `news_feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `maintenance_request_id` (`maintenance_request_id`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`poll_id`);

--
-- Indexes for table `poll_questions`
--
ALTER TABLE `poll_questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `poll_id` (`poll_id`);

--
-- Indexes for table `poll_responses`
--
ALTER TABLE `poll_responses`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `poll_id` (`poll_id`);

--
-- Indexes for table `rent_payments`
--
ALTER TABLE `rent_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rent_payment_receipts`
--
ALTER TABLE `rent_payment_receipts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_id` (`payment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `community_events`
--
ALTER TABLE `community_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `found_items`
--
ALTER TABLE `found_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laundry_alerts`
--
ALTER TABLE `laundry_alerts`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lost_items`
--
ALTER TABLE `lost_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `lost_item_feedback`
--
ALTER TABLE `lost_item_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news_feed`
--
ALTER TABLE `news_feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `poll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `poll_questions`
--
ALTER TABLE `poll_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `poll_responses`
--
ALTER TABLE `poll_responses`
  MODIFY `response_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rent_payments`
--
ALTER TABLE `rent_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rent_payment_receipts`
--
ALTER TABLE `rent_payment_receipts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `laundry_alerts`
--
ALTER TABLE `laundry_alerts`
  ADD CONSTRAINT `laundry_alerts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lost_items`
--
ALTER TABLE `lost_items`
  ADD CONSTRAINT `lost_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lost_item_feedback`
--
ALTER TABLE `lost_item_feedback`
  ADD CONSTRAINT `lost_item_feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `lost_item_feedback_ibfk_2` FOREIGN KEY (`lost_item_id`) REFERENCES `lost_items` (`id`);

--
-- Constraints for table `maintenance_requests`
--
ALTER TABLE `maintenance_requests`
  ADD CONSTRAINT `maintenance_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`maintenance_request_id`) REFERENCES `maintenance_requests` (`id`);

--
-- Constraints for table `poll_questions`
--
ALTER TABLE `poll_questions`
  ADD CONSTRAINT `poll_questions_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`poll_id`);

--
-- Constraints for table `poll_responses`
--
ALTER TABLE `poll_responses`
  ADD CONSTRAINT `poll_responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `poll_responses_ibfk_2` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`poll_id`) ON DELETE CASCADE;

--
-- Constraints for table `rent_payments`
--
ALTER TABLE `rent_payments`
  ADD CONSTRAINT `rent_payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rent_payment_receipts`
--
ALTER TABLE `rent_payment_receipts`
  ADD CONSTRAINT `rent_payment_receipts_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `rent_payments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
