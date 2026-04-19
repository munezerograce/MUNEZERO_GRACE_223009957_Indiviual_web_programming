-- Run this SQL in phpMyAdmin to fix/update your database

-- Drop existing table (if you want fresh start)
DROP TABLE IF EXISTS students;

-- Create table with all required columns
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    dob DATE,
    email VARCHAR(100),
    mobile VARCHAR(20),
    gender VARCHAR(10),
    address TEXT,
    city VARCHAR(50),
    pin_code VARCHAR(20),
    state VARCHAR(50),
    country VARCHAR(50),
    hobbies VARCHAR(255),
    course VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
