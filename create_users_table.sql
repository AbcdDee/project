-- SQL script to create the 'cust_signin' table in the 'istudio' database
-- Run this in phpMyAdmin or MySQL command line

CREATE TABLE IF NOT EXISTS cust_signin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    mobile VARCHAR(15),
    gender ENUM('Male','Female','Other'),
    language VARCHAR(50),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optional: Insert a sample user (password: 'password123' hashed)
-- INSERT INTO cust_signin (full_name, username, email, password) VALUES ('Admin User', 'admin', 'admin@example.com', '$2y$10$examplehashedpassword');
