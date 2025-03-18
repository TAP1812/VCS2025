-- database.sql

-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS student_management;

-- Use the database
USE student_management;

-- Create the student table
CREATE TABLE IF NOT EXISTS student (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(20),
    avatar_url VARCHAR(255),
    role ENUM('student', 'teacher') DEFAULT 'student'
);

-- Optionally insert a default admin user (for testing)
INSERT INTO student (username, password, first_name, last_name, email, role) VALUES (
    'admin',
    '0cc175b9c0f1b6a831c399e269772661', -- Replace with a real hashed password
    'Admin',
    'User',
    'admin@example.com',
    'teacher'
);