CREATE TABLE applicant( 
    applicantID INT AUTO_INCREMENT PRIMARY KEY, 
    first_name VARCHAR (32), 
    last_name VARCHAR (32), 
    age INT, 
    gender VARCHAR (32), 
    email VARCHAR (64), 
    contact_info VARCHAR (64), 
    date_added DATETIME DEFAULT CURRENT_TIMESTAMP 
);