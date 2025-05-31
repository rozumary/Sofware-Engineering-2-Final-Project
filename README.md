# Sofware-Engineering-2-Final-Project
We are Group 2 from BSCS 3AIS. This repository contains our Software Engineering project, where we were tasked to improve the Client Appointment and Monitoring Management System for LPPO, a capstone project system originally developed by Gilbert C. Etalla, Jerwin R. Pontipedra, and Rana S. Edgar Jr.


			


CMSC 311 – Software Engineering
Final Project




Client Appointment and Monitoring Management System for Laguna Parole and Probation Office with SMS Notification 


Software Requirements Specification (SRS)



Submitted to: 
Ms. Micah Joy P. Formaran



					

Submitted by: 

BSCS 3A-IS
Angeles, Khatrina
Lat, Betina Grace C
Montesa, Rosemarie D.
Pino, Renalyn N.
Teano, Aedran Gabriel 

System Overview and Architecture
This study presents the development and evaluation of a web-based Client Appointment and Monitoring Management System with SMS Notification designed specifically for the Laguna Parole and Probation Office (LPPO) in Sta. Cruz, Laguna, a capstone project system originally developed by Gilbert C. Etalla, Jerwin R. Pontipedra, and Rana S. Edgar Jr.
Our goal on the other hand, is to enhance the system’s overall performance, user interface and other features for the LPPO. With Computer Science implementation, this improved version aims to make client scheduling more efficient, reduce missed appointments and help staff manage records more effectively.

Summary of Enhancements and Rationale

We have implemented more than (1) one CS feature. Here is the summary: 

Feature/Enhancement
CS Concept
What we did
LPPO Assistant Chatbot
Machine Learning Algorithm
This simple chatbot helps users interact with the system more efficiently compared to FAQ’s with more limited information.
Email Code Verification OTP
Security Enhancement
Instead of using the usual XAMPP link for verification (as we’ve seen in the old system) we implemented OTP for direct verification. It's a more secure and convenient way for users to activate their account.
Real-time Search (Admin/Client)
Automation
As requested by the researchers, we created real time search, allowing users to see search results as they type. Helpful for fast data access.
Automated Parole Assignment 
Automation
Also recommended by the researchers, the goal of this feature is to automatically assign clients to officers based on certain conditions like location.
Database Optimization (Officer, Area Assignment tables)
Database Optimization
We improved the database by adding normalized tables. We added tables and more queries for better data flow.
Email Recipient from API


Cloud Integration
This connects to an external email API to handle email delivery. We use our own Gmail API, so we can have full access and control.
Assistant Bot Typing Animation
UI/UX
Just a basic animation, to make the chatbot look more interactive.
Toggle Password Visibility
UI/UX
Small UI improvement.
UI Redesign (Red-Yellow theme)
UI/UX
We changed the UI to match the formal tone needed for parole and probation work.
Client Status + Proper Message Popup
Backend Management
Improves the way users receive feedback on their actions.
CRUD Enhancement
Backend Management
The system doesn’t have a complete set of CRUD so we added more CRUD functionality.
Archive, Denied, and Revoked Sections
Backend Management
These features help organize user status better.
Archived User Section
Backend Management
We also added an archive user section so we can see inactive users easily.


III.  Updated UI/UX Screenshots (if applicable) - 100% Progress

UI/UX Red-Yellow Theme

The old design used overly pastel colors, which didn’t align well with the serious and formal nature of parole and probation work. So, we changed the theme to a red and yellow color scheme to reflect a more formal and straightforward look.

We improved the buttons, tables, hover effects, and the overall look of the system.


This interface shown is for both admin and client side.
IV.  Testing Approach and Results

LPPO Assistant Bot
Here, the user can type simple questions and concerns about probation. 
Real-Time Search (For Admin)

Real-Time Search (For Client)
As recommended by the researcher, we replaced the previous method of clicking names and waiting for results with a real-time search feature. Now, users can simply type and instantly see the results, making the process faster and more convenient.
Email Creation - Registration Form 

User registration panel.

This is Email API Integration. Now, after clicking the registration, a code will be sent to their email. This code will then be used to verify and activate their account. Instead of clicking the xampp link which is less secure, the user can just type the code directly on the website and the process will continue smoothly.

Old system email:

Now the user will just type the code to directly activate their account.

Now, a new account has been activated.



Automated Parole Assignment



We added Parole Officer Panel, so we can easily add, update or assign parole instead of manually adding them on SQL database. This way, we can easily assign parole based on their municipality/location.

So for example we are assigning based on Pila.
Since user is from that location, there is specific parole officer assigned there automatically.



So when we click Pila, the assigned parole is automatically listed.


This is based on what we added on the Parole Officer panel. We connected those databases to make this feature work correctly since syncing them both in area assignment was kind of challenging. So, in order to assign more parole officers, it’s up to the admin to add them to the panel, and this will automatically reflect on the system.






ADDITIONAL SECTIONS (BACKEND MANAGEMENT):

Archive Accounts


It was also recommended by the researchers to implement a feature that tracks user inactivity.
Denied Reason Section

Here we added the Reason Section why users get denied.
Revoked Reason Section


Here we added the Reason Section why users get revoked.


Toggle Password Visibility
Proper Message Popup



Status of the Client

We also added a client status feature since the old system didn’t have that section. This way, users can easily see each client’s current status.
V.  Technologies and Frameworks Used
Visual Studio – for system development


XAMPP – to run the local server environment


MySQL – for storing the system’s database


phpMyAdmin – for managing the database through a web interface


SQL DATABASE (with added tables)













VI. Developer Notes / Installation Instructions
a. System Requirements:
OS: Windows 10 or later


RAM: At least 4GB


XAMPP (PHP 7.4+ and MySQL)


Visual Studio (2019 or later)


Web browser (Chrome or Firefox recommended)


b. Installation Steps:
Download and install XAMPP.


Open the XAMPP Control Panel, then start Apache and MySQL.


Copy the project folder to the following directory:
 C:\xampp\htdocs\probation_project_v07


Open your browser and go to localhost/phpmyadmin.


Create a new database (e.g., probation_db).


Click Import and select the .sql file from the project folder to load the database.


Open the project in Visual Studio.


Check the database connection string in your config files (if needed, update it to match your MySQL settings).


Run the project via browser at http://localhost/probation_project_v07.


c. Default Login (for testing):
Admin:


Username: admin


Password: admin123


d. Developer Notes:
Make sure PHP and MySQL versions are compatible.
You can edit the Main CSS design under template not the Assets one (under Assets are for selected designs only)
Keep your database and source code in sync if changes are made.
Follow consistent naming conventions in database fields.
