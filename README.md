# FINAL-PROJECT-344
This is my final project for CIS 344 Spring 26'


#Real Estate Agency Portal

This project is a full-stack Real Estate Agency Portal built using PHP, MySQL, HTML, CSS, phpMyAdmin, and XAMPP. The website allows agents, buyers, and renters to interact with property listings through a role-based system.

The project includes features such as user registration, secure login, role-based access control, property listings, property inquiries, favorite properties, stored procedures, a trigger, a view, password hashing, and PHP session management.

The preset accounts included in the project all use the password:
password123

The preset agent account username is:
agent_maria

The preset buyer account username is:
buyer_james

The preset renter account username is:
renter_lisa

You can also make your own users if wanted.

The main homepage file is index.php, which acts as the landing page of the website.

The login.php file handles user login and authentication.

The register.php file allows users to create accounts.

The logout.php file logs users out of the system.

The dashboard.php file displays the user dashboard after login.

The properties.php file displays all property listings.

The property_details.php file displays detailed information about selected properties.

The add_property.php file allows agents to add new properties.

The submit_inquiry.php file allows buyers and renters to send inquiries about properties.

The favorites.php file displays saved favorite properties for the logged-in user.

The save_favorite.php file saves favorite properties into the Favorites table.

The config/config.php file stores the database configuration settings.

The classes/Database.php file creates the PDO database connection.

The classes/RealEstateDatabase.php file contains the main database functions used throughout the project.

The includes/header.php file contains the website navigation bar and header section.

The includes/footer.php file contains the footer section of the website.

The includes/auth.php file protects pages using login and role-based access control.

The assets/style.css file controls the visual design and layout of the website.

The assets/images folder stores all property images used throughout the website.

The real_estate_portal_db.sql file creates the entire database structure, sample data, stored procedures, trigger, and view.

The Users table stores all agents, buyers, and renters.

The Properties table stores all property listings.

The Inquiries table stores inquiries submitted by buyers and renters.

The Transactions table stores completed property transactions.

The Favorites table stores saved favorite properties.

The project also includes the AddOrUpdateUser stored procedure, the ProcessTransaction stored procedure, the PropertyListingView SQL view, and the AfterTransactionInsert SQL trigger.

To run the project, install XAMPP, start Apache and MySQL, place the project folder inside C:\xampp\htdocs, import the real_estate_portal_db.sql file into phpMyAdmin, and open http://localhost/real_estate_portal_/ in a browser.

PLEASE NAME THE FOLDER - real_estate_portal_

