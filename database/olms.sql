-- ========================================================
-- DATABASE SETUP & SAFETY CLEAR
-- ========================================================

DROP DATABASE IF EXISTS `olms`;
CREATE DATABASE `olms`;
USE `olms`;

-- --------------------------------------------------------
-- OLMS Master Database Structure
-- --------------------------------------------------------

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

-- 1. Create the `users` table
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member') DEFAULT 'member',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default Admin & Generic Test Users
-- All passwords are: password123
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'admin', 'admin@library.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'admin'),
(2, 'MemberOne', 'member1@olms.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'member'),
(3, 'MemberTwo', 'member2@olms.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'member'),
(4, 'MemberThree', 'member3@olms.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'member'),
(5, 'MemberFour', 'member4@olms.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'member'),
(6, 'MemberFive', 'member5@olms.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'member'),
(7, 'Test', 'test@olms.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'member');


-- 2. Create the `books` table
CREATE TABLE `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT 'default-cover.jpg',
  `total_qty` int(11) NOT NULL DEFAULT 0,
  `available_qty` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Book data with matched quantities for the active transactions below
INSERT INTO `books` (title, author, category, cover_image, total_qty, available_qty) VALUES
('To Kill a Mockingbird', 'Harper Lee', 'Fiction', 'To Kill a Mockingbird.jpg', 5, 3), 
('1984', 'George Orwell', 'Dystopian Fiction', '1984.jpg', 4, 3), 
('The Great Gatsby', 'F. Scott Fitzgerald', 'Classic Fiction', 'The Great Gatsby.jpg', 4, 4), 
('A Brief History of Time', 'Stephen Hawking', 'Science', 'A Brief History of Time.jpg', 3, 2), 
('The Diary of a Young Girl', 'Anne Frank', 'Biography', 'The Diary of a Young Girl.jpg', 3, 2);


-- 3. Create the `transactions` table
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `due_date` datetime DEFAULT NULL,
  `returned_date` datetime DEFAULT NULL,
  `status` enum('active','returned') DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Transaction History for 'Test' and other generic members
INSERT INTO `transactions` (user_id, book_id, borrow_date, due_date, returned_date, status) VALUES
-- User 7 (Test) Past History
(7, 1, '2026-03-01 10:00:00', '2026-03-15 10:00:00', '2026-03-12 14:30:00', 'returned'),
(7, 2, '2026-03-10 11:15:00', '2026-03-24 11:15:00', '2026-03-20 09:45:00', 'returned'),
(7, 5, '2026-03-18 09:20:00', '2026-04-01 09:20:00', '2026-03-30 16:10:00', 'returned'),

-- User 7 (Test) Currently Borrowed
(7, 4, '2026-04-01 09:00:00', '2026-04-15 09:00:00', NULL, 'active'),
(7, 1, '2026-04-04 08:30:00', '2026-04-18 08:30:00', NULL, 'active'),

-- Community Active Reads
(3, 1, '2026-03-28 16:00:00', '2026-04-11 16:00:00', NULL, 'active'),
(5, 2, '2026-04-02 13:00:00', '2026-04-16 13:00:00', NULL, 'active'),

-- Community Past History
(4, 5, '2026-02-10 08:30:00', '2026-02-24 08:30:00', '2026-02-22 11:00:00', 'returned');


-- 4. Create the `reviews` table
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT 5,
  `comment` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Generic Reader Reviews
INSERT INTO `reviews` (book_id, user_id, rating, comment, created_at) VALUES
(1, 7, 5, 'An absolute masterpiece. Highly recommend!', '2026-03-13 09:00:00'),
(2, 7, 4, 'Thought-provoking and essential.', '2026-03-21 10:30:00'),
(5, 7, 5, 'Heartbreaking and sobering history.', '2026-03-31 09:12:00'),
(3, 7, 5, 'The imagery is perfectly woven together.', '2025-12-19 08:15:00'),
(4, 4, 5, 'Fascinating and accessible science.', '2026-04-02 09:30:00');

COMMIT;