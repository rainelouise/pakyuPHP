CREATE DATABASE applicant_management;

USE applicant_management;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    birth_date DATE NOT NULL,
    gender VARCHAR(50) NOT NULL,
    email_address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(50) NOT NULL,
    applied_position VARCHAR(255) NOT NULL,
    start_date DATE NOT NULL,
    address TEXT NOT NULL,
    nationality VARCHAR(100) NOT NULL
);


CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    action VARCHAR(255) NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    keyword VARCHAR(255) DEFAULT NULL
);

CREATE TABLE search_users_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    birth_date VARCHAR(255),
    gender VARCHAR(255),
    email_address VARCHAR(255),
    phone_number VARCHAR(20),
    applied_position VARCHAR(255),
    start_date VARCHAR(255),
    address VARCHAR(255),
    nationality VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
