# KIDOCCINE

## Vaccine Management System: Interactive Communication Model for Kids' Vaccination Supply Chain

## Webiste

**Live URL**: https://kidoccine.org/

**Repo**: https://github.com/kiranc2001/Kidoccine_VaccineManagementSystem

**Screenshots**: https://github.com/kiranc2001/Kidoccine_VaccineManagementSystem/tree/main/screenshots

**For more detailed explaination**:

**Medium**: https://medium.com/@kirangowda0212/medium-blog-post-building-an-interactive-vaccine-supply-chain-model-revolutionizing-kids-b339ae5b200b 

### Project Overview
This project implements an **Interactive Communication Model for Vaccine Supply Management**, specifically tailored for children's vaccination in India under the Universal Immunization Programme (UIP). It addresses key challenges in vaccine supply chains, such as real-time tracking, inventory management, stakeholder coordination (admins, hospitals, parents), and efficient distribution to prevent shortages and ensure timely immunizations.

The system is a web-based application that:
- Allows admins to manage hospitals, parents, and vaccines.
- Enables hospitals to request access, add vaccine stocks, and update vaccination statuses.
- Empowers parents to register, book vaccines, receive email confirmations, and get PDF certificates post-vaccination.
- Integrates real-time communication via emails for bookings, approvals, and updates.

Inspired by India's UIP (covering vaccines like BCG, DPT, OPV, etc.), the system promotes equitable access, reduces wastage, and enhances transparency using modern web technologies.

### Key Features
- **User Roles**:
  - **Admin**: Dashboard for managing parents, hospitals (approve/reject requests), and vaccines (add/update/delete).
  - **Hospital**: Request access, manage vaccine inventory, view orders, update vaccination status.
  - **Parent**: Register/login, book vaccines, view orders, password recovery via OTP/email or security questions, receive PDF certificates.
- **Core Modules**:
  - Real-time inventory tracking and stock updates.
  - Email notifications (using PHPMailer) for bookings, approvals, and status changes.
  - PDF certificate generation (using TCPDF).
  - Secure authentication with password hashing (bcrypt) and session management.
- **Supply Chain Enhancements**:
  - Forecasting and planning support via inventory alerts.
  - Compliance with UIP schedules and regulatory standards.
  - Responsive design for mobile/desktop access.

### Tech Stack
- **Frontend**: HTML, CSS, JavaScript (for interactivity and validation).
- **Backend**: PHP (server-side scripting, API-like endpoints for bookings/orders).
- **Database**: MySQL (stores users, vaccines, bookings, stocks).
- **Server/Environment**: XAMPP (Apache, MySQL, PHP).
- **Libraries**:
  - PHPMailer: Email sending.
  - TCPDF: PDF generation.
- **IDE**: Visual Studio Code.
- **Hardware**: Intel i5 2.4 GHz, 500GB HDD, 4/8GB RAM.
- **OS**: Windows 7+.

### System Architecture
- **Use Case Diagram**: Actors (Admin, Hospital, Parent) interact with use cases like Login, Manage Inventory, Book Vaccine.
- **Data Flow Diagram (DFD)**: Data flows from users → database → processing (e.g., booking → email → PDF).
- **Sequence Diagram**: Step-by-step interactions, e.g., Parent books vaccine → Hospital updates status → Email/PDF sent.

### Installation & Setup
1. **Prerequisites**:
   - Install XAMPP (includes Apache, MySQL, PHP).
   - Ensure PHP extensions: `mail`, `gd` (for PDFs), `openssl` (for SMTP).

2. **Clone/Download Project**:
   ```
   git clone <repo-url>  # Or download ZIP
   ```

3. **Database Setup**:
   - Start XAMPP (Apache & MySQL).
   - Create a database named `vaccine_management` in phpMyAdmin.
   - Import the SQL schema (create tables for `users`, `hospitals`, `vaccines`, `bookings`, `stocks` – schema details in `/db/schema.sql` if provided).

4. **Configuration**:
   - Edit `config.php`:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'vaccine_management');
     // SMTP for emails
     $mail->Host = 'smtp.gmail.com';
     $mail->Username = 'your-email@gmail.com';
     $mail->Password = 'your-app-password';
     $mail->Port = 587;
     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
     ```
   - Place project files in `htdocs/vaccine-system/` (XAMPP folder).

5. **Run the Application**:
   - Access via `http://localhost/vaccine-system/`.
   - Default Admin: Username `admin`, Password `admin123` (change immediately).
   - Test parent registration and hospital requests.

### Usage
1. **As Parent**:
   - Register/Login → Browse vaccines → Book (select hospital, optional email) → Receive confirmation email.
   - Post-vaccination: Download PDF certificate.

2. **As Hospital**:
   - Submit request form (with hospital details/PDF cert) → Await admin approval (email notification).
   - Login → Add vaccines/prices → View orders → Update status (triggers parent email).

3. **As Admin**:
   - Login → Approve hospital requests → Manage parents/vaccines → View reports.


### Challenges & Limitations
- Offline mode not supported (requires internet for emails/PDFs).
- Scalability: Suitable for small-medium scale; for large, migrate to cloud (e.g., AWS RDS).
- Network issues may delay emails (use reliable SMTP like Gmail).

### Future Enhancements
- Integrate blockchain/IoT for real-time tracking (from literature survey).
- AI-based demand forecasting.
- Mobile app integration.
- Analytics dashboard for UIP compliance reports.

### Contributing
- Fork the repo, create a branch, submit PRs.
- Report issues via GitHub.

### References
- UIP Guidelines (MoHFW, India).
- Literature: Blockchain in SCM (2023), COVID-19 Vaccine SCM (2022).

## Contact

**Email**: kirangowda0212@gmail.com  

**LinkedIn**: https://www.linkedin.com/in/kiran-c-gowda-2507021b9/
