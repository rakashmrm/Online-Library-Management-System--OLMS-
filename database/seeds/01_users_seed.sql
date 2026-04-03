-- Resetting the users table for a fresh start
TRUNCATE TABLE users;

-- ALL users below now have the password: password123
INSERT INTO users (username, email, password, role) VALUES
('Admin', 'admin@olms.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'admin'),
('TestStudent 1', 'student1@olms.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'member'),
('TestStudent 2', 'student2@olms.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'member'),
('TestStudent 3', 'student3@olms.com', '$2y$10$ctE9miG4sQ/V4g.YGL23xubgk5qzPs7LVGmw74IMSIPL4T/gcp586', 'member');