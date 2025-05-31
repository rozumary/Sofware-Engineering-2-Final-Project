# Sofware Engineering 2 (CMSC 311) Final Project
We are Group 2 from BSCS 3AIS. This repository contains our Software Engineering project, where we were tasked to improve the Client Appointment and Monitoring Management System for LPPO, a capstone project system originally developed by Gilbert C. Etalla, Jerwin R. Pontipedra, and Rana S. Edgar Jr.


			


# **Client Appointment and Monitoring Management System for Laguna Parole and Probation Office with SMS Notification (Improved)**


**Submitted to:**  
Ms. Micah Joy P. Formaran  

**Submitted by:**  
BSCS 3A-IS  
- Angeles, Khatrina  
- Lat, Betina Grace C.  
- Montesa, Rosemarie D.  
- Pino, Renalyn N.  
- Teano, Aedran Gabriel  

# I. System Overview and Architecture
This study presents the development and evaluation of a web-based Client Appointment and Monitoring Management System with SMS Notification designed specifically for the Laguna Parole and Probation Office (LPPO) in Sta. Cruz, Laguna, a capstone project system originally developed by Gilbert C. Etalla, Jerwin R. Pontipedra, and Rana S. Edgar Jr.
Our goal on the other hand, is to enhance the system’s overall performance, user interface and other features for the LPPO. With Computer Science implementation, this improved version aims to make client scheduling more efficient, reduce missed appointments and help staff manage records more effectively.

# Summary of Enhancements and Rationale

_We have implemented more than (1) one CS feature. Here is the summary:_
| Feature/Enhancement            | CS Concept            | What we did                                                                                             |
|-------------------------------|----------------------|-------------------------------------------------------------------------------------------------------|
| LPPO Assistant Chatbot         | Machine Learning      | This simple chatbot helps users interact with the system more efficiently compared to FAQ’s with more limited information. |
| Email Code Verification OTP    | Security Enhancement  | Instead of using the usual XAMPP link for verification (as we’ve seen in the old system) we implemented OTP for direct verification. It's a more secure and convenient way for users to activate their account. |
| Real-time Search (Admin/Client)| Automation           | As requested by the researchers, we created real time search, allowing users to see search results as they type. Helpful for fast data access. |
| Automated Parole Assignment    | Automation           | Also recommended by the researchers, the goal of this feature is to automatically assign clients to officers based on certain conditions like location. |
| Database Optimization (Officer, Area Assignment tables) | Database Optimization | We improved the database by adding normalized tables. We added tables and more queries for better data flow. |
| Email Recipient from API       | Cloud Integration     | This connects to an external email API to handle email delivery. We use our own Gmail API, so we can have full access and control. |
| Assistant Bot Typing Animation | UI/UX                 | Just a basic animation, to make the chatbot look more interactive.                                     |
| Toggle Password Visibility     | UI/UX                 | Small UI improvement.                                                                                  |
| UI Redesign (Red-Yellow theme) | UI/UX                 | We changed the UI to match the formal tone needed for parole and probation work.                       |
| Client Status + Proper Message Popup | Backend Management | Improves the way users receive feedback on their actions.                                             |
| CRUD Enhancement              | Backend Management    | The system doesn’t have a complete set of CRUD so we added more CRUD functionality.                    |
| Archive, Denied, and Revoked Sections | Backend Management | These features help organize user status better.                                                      |
| Archived User Section          | Backend Management    | We also added an archive user section so we can see inactive users easily.                            |



# III.  Updated UI/UX Screenshots (if applicable) - 100% Progress

**UI/UX Red-Yellow Theme**

_The old design used overly pastel colors, which didn’t align well with the serious and formal nature of parole and probation work. So, we changed the theme to a red and yellow color scheme to reflect a more formal and straightforward look._


![Screenshot 2025-05-31 165424](https://github.com/user-attachments/assets/0c90c67a-8189-4119-83df-d2e9cb1c5646)

![Screenshot 2025-05-31 165558](https://github.com/user-attachments/assets/b8993849-fee2-4304-ba06-85206a9829a3)


_We improved the buttons, tables, hover effects, and the overall look of the system._
![Screenshot 2025-05-31 175510](https://github.com/user-attachments/assets/6d7bca27-52be-4a86-a552-75d6defa5925)

![Screenshot 2025-05-31 032827](https://github.com/user-attachments/assets/ae598407-09fa-4e9a-aa45-6c3d8a183920)

_This interface shown is for both admin and client side._
# IV.  Testing Approach and Results

**LPPO Assistant Bot**
![Screenshot 2025-05-31 161640](https://github.com/user-attachments/assets/304af5fb-1665-4cfb-b1b5-d3817f68e67c)
![Screenshot 2025-05-31 161651](https://github.com/user-attachments/assets/e0bedbbf-e525-4151-b975-8e3d5e5985e8)

_Here, the user can type simple questions and concerns about probation._

**Real-Time Search (For Admin)**
![Screenshot 2025-05-31 162311](https://github.com/user-attachments/assets/7eaa3b75-f3c0-40d2-9c5d-f310ec6ee511)

**Real-Time Search (For Client)**
![Screenshot 2025-05-31 032827](https://github.com/user-attachments/assets/5ca9cc44-3371-4eab-8c3b-770e81e66bc9)
![Screenshot 2025-05-31 162311](https://github.com/user-attachments/assets/5aa971d4-0f54-448b-85c8-0ef4b18073d0)

_As recommended by the researcher, we replaced the previous method of clicking names and waiting for results with a real-time search feature. Now, users can simply type and instantly see the results, making the process faster and more convenient._

**Email Creation - Registration Form **
![Screenshot 2025-05-31 162951](https://github.com/user-attachments/assets/948cd478-32f9-4f88-8734-3a11953f20d2)

_User registration panel._


_This is Email API Integration. Now, after clicking the registration, a code will be sent to their email. This code will then be used to verify and activate their account. Instead of clicking the xampp link which is less secure, the user can just type the code directly on the website and the process will continue smoothly._
![Screenshot 2025-05-31 163451](https://github.com/user-attachments/assets/d74124eb-83ce-4abf-ad0d-8c512902a013)

Old system email:
![Screenshot 2025-05-31 164248](https://github.com/user-attachments/assets/3396204a-96e4-4316-a93d-093b32439eac)

_Now the user will just type the code to directly activate their account._
![Screenshot 2025-05-31 163843](https://github.com/user-attachments/assets/099eb715-5a9a-44ee-a17c-944fe6d1ced8)

![Screenshot 2025-05-31 163901](https://github.com/user-attachments/assets/1a506fe8-82fe-420a-abe7-a57cb8ed05d3)

_Now, a new account has been activated._


**Automated Parole Assignment**

![Screenshot 2025-05-31 173329](https://github.com/user-attachments/assets/c7e41f9d-0e5b-4a3e-8be4-139857d99d2e)

We added Parole Officer Panel, so we can easily add, update or assign parole instead of manually adding them on SQL database. This way, we can easily assign parole based on their municipality/location.
![Screenshot 2025-05-31 170600](https://github.com/user-attachments/assets/7b216d72-e75a-4e59-a678-0cf24346e694)

_So for example we are assigning based on Pila._
![Screenshot 2025-05-31 170814](https://github.com/user-attachments/assets/26a81e8e-970d-48c2-aae7-9fb57ec21d02)

_Since user is from that location, there is specific parole officer assigned there automatically._


_So when we click Pila, the assigned parole is automatically listed._
![Screenshot 2025-05-31 170957](https://github.com/user-attachments/assets/8a6ed557-ffa3-402e-96e7-f47f02efc617)


_This is based on what we added on the Parole Officer panel. We connected those databases to make this feature work correctly since syncing them both in area assignment was kind of challenging. So, in order to assign more parole officers, it’s up to the admin to add them to the panel, and this will automatically reflect on the system._






**ADDITIONAL SECTIONS (BACKEND MANAGEMENT):**

**Archive Accounts**

![Screenshot 2025-05-31 165950](https://github.com/user-attachments/assets/ed933e36-5af4-45d1-ada2-f21d2c66f260)

_It was also recommended by the researchers to implement a feature that tracks user inactivity._
**Denied Reason Section**
![Screenshot 2025-05-31 171222](https://github.com/user-attachments/assets/5160dbdd-be1e-4e9e-be8d-c57c8d670de8)

_Here we added the Reason Section why users get denied._

**Revoked Reason Section**
![Screenshot 2025-05-31 171337](https://github.com/user-attachments/assets/cf708247-00a3-4187-8b69-0d29123d4312)


_Here we added the Reason Section why users get revoked._


**Toggle Password Visibility**

![Screenshot 2025-05-31 172114](https://github.com/user-attachments/assets/8899b41f-5ac5-4d4b-868a-9df9aeb7be4b)

**Proper Message Popup**
![Screenshot 2025-05-31 172319](https://github.com/user-attachments/assets/ef049f0d-f2e5-4afc-ae57-3b25a12a4b79)


**Status of the Client**
![Screenshot 2025-05-31 172419](https://github.com/user-attachments/assets/fb0b8922-d8f2-4ed5-aa5f-0017431b52da)

_We also added a client status feature since the old system didn’t have that section. This way, users can easily see each client’s current status._


## Technologies Used
- **XAMPP** – to run the local server environment  
- **MySQL** – for storing the system’s database  
- **phpMyAdmin** – for managing the database through a web interface  
- **SQL Database** – with added tables  
- **Visual Studio 2019 or later** – for editing and managing the project  

---

## Installation Instructions

### System Requirements
- **OS**: Windows 10 or later  
- **RAM**: At least 4GB  
- **XAMPP**: PHP 7.4+ and MySQL  
- **Visual Studio**: 2019 or later  
- **Web browser**: Chrome or Firefox recommended  

### How to Use / Run the Project 
1. Download and install [XAMPP](https://www.apachefriends.org/index.html).  
2. Open the XAMPP Control Panel and start **Apache** and **MySQL**.  
3. Copy the project folder to:  
   `C:\xampp\htdocs\probation_project_v07`  
4. Open your browser and navigate to:  
   `http://localhost/phpmyadmin`  
5. Create a new database (e.g., `probation_db`).  
6. Click **Import** and select the `.sql` file from the project folder.  
7. Open the project in **Visual Studio**.  
8. Check the database connection string in your config files (update if needed).  
9. Run the project via browser at:  
   `http://localhost/probation_project_v07`  

---

## Default Login (For Testing)
**Admin**  
- **Username**: `admin`  
- **Password**: `admin123`  


---

## Demo Video Link
[Watch Demo Video Here](#) *(Insert YouTube or drive link)*

---

## Contributors
- MONTESA – Developer  
- LAT – Documentation
- PINO– Documentation
- ANGELES – Contributor
- TEANO - Contributor

---

© 2025 BSCS 3A-IS | All rights reserved.

