# fitness_membership  

A lightweight PHP application for managing fitness club members, their diet plans, workout routines, and progress tracking. The project also includes a bundled **PHPMailer** library for sending email notifications (e.g., membership confirmations, progress reports).

---  

## Overview  

The **fitness_membership** system provides a simple web‑based interface for fitness club staff to:

* Register new members and store their personal details.  
* Create and assign diet plans (`add_diet.php`).  
* Create and assign workout routines (`add_routine.php`).  
* Record and view members’ progress (`add_progress.php`).  
* Send automated email notifications using PHPMailer.  

All data is persisted in a MySQL database (`Database/member_db.sql`).  

---  

## Features  

| ✅ | Feature |
|---|---|
| ✅ | Member registration and profile management |
| ✅ | Diet plan creation & assignment |
| ✅ | Workout routine creation & assignment |
| ✅ | Progress logging (weight, measurements, etc.) |
| ✅ | Email notifications via PHPMailer (SMTP / OAuth2) |
| ✅ | Ready‑to‑run SQL schema (`member_db.sql`) |
| ✅ | Documentation (`Fitness Club Project.docx`) |

---  

## Tech Stack  

| Layer | Technology |
|-------|------------|
| Backend | PHP 8.x |
| Database | MySQL |
| Email | PHPMailer (bundled in `admin/PHPMailer/`) |
| Front‑end | Plain HTML/CSS (can be extended with any framework) |
| Dependency Management | Composer (for PHPMailer) |

---  

## Installation  

1. **Clone the repository**  

   ```bash
   git clone https://github.com/your-username/fitness_membership.git
   cd fitness_membership
   ```

2. **Install PHPMailer dependencies**  

   ```bash
   cd admin/PHPMailer
   composer install   # requires Composer installed globally
   ```

3. **Create the database**  

   ```sql
   -- In your MySQL client
   SOURCE Database/member_db.sql;
   ```

   *Adjust the database name, user, and password in `config.php` (or whichever configuration file you create).*

4. **Configure the application**  

   * Create a `config.php` (or edit the existing one) with your DB credentials and email settings:  

     ```php
     <?php
     define('DB_HOST', 'localhost');
     define('DB_NAME', 'fitness_membership');
     define('DB_USER', 'YOUR_DB_USER');
     define('DB_PASS', 'YOUR_DB_PASSWORD');

     // PHPMailer SMTP settings
     define('SMTP_HOST', 'smtp.example.com');
     define('SMTP_PORT', 587);
     define('SMTP_USER', 'YOUR_SMTP_USER');
     define('SMTP_PASS', 'YOUR_SMTP_PASSWORD');
     define('FROM_EMAIL', 'no-reply@example.com');
     define('FROM_NAME', 'Fitness Club');
     ```
   * Replace placeholders (`YOUR_DB_USER`, `YOUR_SMTP_USER`, etc.) with your own credentials.  

5. **Set up a web server**  

   * Place the project in the document root of Apache/Nginx (or use PHP’s built‑in server for quick testing):  

     ```bash
     php -S localhost:8000
     ```

---  

## Usage  

### Adding a member (example)

```bash
# Open