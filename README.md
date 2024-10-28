Cannot give the whole directory as it says the limit is 100 files so made a copy of job portal in this composer files are not there which are necessory for real time email transfer you can download it on google make sure to change your_username and your_pass of smtp in pending_application file.

Following is the database structure used for the Job_portal :-

create database job_portal;
use job_portal;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,  -- Employee email
    password VARCHAR(255) NOT NULL,  -- Store hashed passwords
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,  -- Company name
    email VARCHAR(255) UNIQUE NOT NULL,  -- Employer's email
    password VARCHAR(255) NOT NULL,  -- Store hashed passwords for employer login
    description TEXT,  -- Company description
    website VARCHAR(255),  -- Company website
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,  -- Job title or role (e.g., Developer, Designer)
    description TEXT,  -- Job description
    company_id INT,  -- Linked to the company posting the job
    location VARCHAR(255),  -- Job location
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT,  -- Reference to the job being applied for
    user_id INT,  -- Reference to the employee applying
    resume_path VARCHAR(255) NOT NULL,  -- File path to the uploaded resume
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',  -- Status of the application
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
