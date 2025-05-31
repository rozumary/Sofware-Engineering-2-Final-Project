# CMSC 311 - Sofware Engineering 2 Final Project 
We are **Group 2** from BSCS 3A-IS. This repository contains our Software Engineering project, where we were tasked to improve the Client Appointment and Monitoring Management System for LPPO, a capstone project system originally developed by Gilbert C. Etalla, Jerwin R. Pontipedra, and Rana S. Edgar Jr.

# **Client Appointment and Monitoring Management System for Laguna Parole and Probation Office with SMS Notification (Enhanced)**


**Submitted to:**  
Ms. Micah Joy P. Formaran  

**Submitted by:**  
BSCS 3A-IS  
- Angeles, Khatrina  
- Lat, Betina Grace C.  
- Montesa, Rosemarie D.  
- Pino, Renalyn N.  
- Teano, Aedran Gabriel  

# Short Description
This study presents the development and evaluation of a web-based Client Appointment and Monitoring Management System with SMS Notification designed specifically for the Laguna Parole and Probation Office (LPPO) in Sta. Cruz, Laguna, a capstone project system originally developed by Gilbert C. Etalla, Jerwin R. Pontipedra, and Rana S. Edgar Jr.
Our goal on the other hand, is to enhance the system’s overall performance, user interface and other features for the LPPO. With Computer Science implementation, this improved version aims to make client scheduling more efficient, reduce missed appointments and help staff manage records more effectively.

# Features Added / Enhanced

_We have implemented more than (1) one CS feature. Here is the summary:_
| Feature/Enhancement            | CS Concept            | What we did                                                                                             |
|-------------------------------|----------------------|-------------------------------------------------------------------------------------------------------|
| LPPO Assistant Chatbot         | Machine Learning      | This simple chatbot helps users interact with the system more efficiently compared to FAQ’s with more limited information. |
| Email Code Verification OTP    | Security Enhancement  | Instead of using the usual XAMPP link for verification (as we’ve seen in the old system) we implemented OTP for direct verification. It's a more secure and convenient way for users to activate their account. |
| Real-time Search (Admin/Client)| Automation           | As requested by the researchers, we created real time search, allowing users to see search results as they type. Helpful for fast data access. |
| Automated Parole Assignment + Parole Officer Panel    | Automation           | Also recommended by the researchers, the goal of this feature is to automatically assign clients to officers based on certain conditions like location. |
| Database Optimization (Officer, Area Assignment tables) | Database Optimization | We improved the database by adding normalized tables. We added tables and more queries for better data flow. |
| Email Recipient from API       | Cloud Integration     | This connects to an external email API to handle email delivery. We use our own Gmail API, so we can have full access and control. |
| Assistant Bot Typing Animation | UI/UX                 | Just a basic animation, to make the chatbot look more interactive.                                     |
| Toggle Password Visibility     | UI/UX                 | Small UI improvement.                                                                                  |
| UI Redesign (Red-Yellow theme) | UI/UX                 | We changed the UI to match the formal tone needed for parole and probation work.                       |
| Client Status + Proper Message Popup | Backend Management | Improves the way users receive feedback on their actions.                                             |
| CRUD Enhancement              | Backend Management    | The system doesn’t have a complete set of CRUD so we added more CRUD functionality.                    |
| Denied and Revoked Sections | Backend Management | These features help organize user status better.                                                      |
| Archived User Section          | Backend Management    | We also added an archive user section so we can see inactive users easily.                            |


# Technologies Used
- **XAMPP** – to run the local server environment  
- **MySQL** – for storing the system’s database  
- **phpMyAdmin** – for managing the database through a web interface  
- **SQL Database** – with added tables  
- **Visual Studio 2019 or later** – for editing and managing the project  

---

# Installation Instructions

### System Requirements
- **OS**: Windows 10 or later  
- **RAM**: At least 4GB  
- **XAMPP**: PHP 7.4+ and MySQL  
- **Visual Studio**: 2019 or later  
- **Web browser**: Chrome or Edge recommended  

# How to Use / Run the Project 
1. Download and install [XAMPP](https://www.apachefriends.org/index.html).  
2. Open the XAMPP Control Panel and start **Apache** and **MySQL**.  
3. Copy the project folder to:  
   `C:\xampp\htdocs\probation_project_v07`  
4. Open your browser and navigate to:  
   `http://localhost/phpmyadmin`  
5. Create a new database (ex: `probasyon_db`).  
6. Click **Import** and select the `.sql` file from the project folder.  
7. Open the project in **Visual Studio**.  
8. Check the database connection string in your config files (update if needed).  
9. Run the project via browser at:  
   `http://localhost/probation_project_v07`  

---

## Default Login (For Testing)
**Create your own account**  
- **Username**: `sample@gmail.com`  
- **Password**: `Sample#123`  

_A verification code will be sent to you in your email to activate your account._

---

# Demo Video Link
[[Watch Demo Video Here](https://drive.google.com/file/d/1w9La4JLXZIyGT1uAqimcH4Ka4Fnju3FV/view?usp=sharing)]

---

# Folder Structure


├── src/                     
│   ├── assets/              
│   ├── database/            
│   ├── inc/                 
│   ├── includes/            
│   ├── js/                  
│   ├── phpmailer/           
│   ├── z_pages/             
│   ├── about_us.php         
│   ├── activate.php         
│   ├── add_admin.php        
│   ├── add_as_client.php    
│   ├── add_officers.php     
│   ├── add_petitioner.php   
│   ├── admin_dashboard.php  
│   └── archived_users.php   # ...other PHP files
│

├── docs/             
│   ├── PPT Presentation.pdf<br/>
│   ├── SRS.pdf             
│   └── Technical Documentation.pdf

<br/>
│
└── README.md


---

## Contributors
- MONTESA – Developer, Documentation
- LAT – Tester, Documentation 
- PINO – Tester, Documentation 
- ANGELES – Contributor
- TEANO - Contributor

---

© 2025 BSCS 3A-IS | All rights reserved.

