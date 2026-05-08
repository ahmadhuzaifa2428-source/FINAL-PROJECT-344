/* Remove old database */
DROP DATABASE IF EXISTS real_estate_portal_db;

/* Create database */
CREATE DATABASE real_estate_portal_db;

/* Use database */
USE real_estate_portal_db;

/* Remove old procedures */
DROP PROCEDURE IF EXISTS AddOrUpdateUser;
DROP PROCEDURE IF EXISTS ProcessTransaction;

/* Remove old trigger */
DROP TRIGGER IF EXISTS AfterTransactionInsert;

/* Remove old view */
DROP VIEW IF EXISTS PropertyListingView;



/* Users Table */
CREATE TABLE Users (
    userId INT NOT NULL UNIQUE AUTO_INCREMENT,
    userName VARCHAR(50) NOT NULL UNIQUE,
    contactInfo VARCHAR(200),
    passwordHash VARCHAR(255) NOT NULL,
    userType ENUM('agent', 'buyer', 'renter') NOT NULL,
    PRIMARY KEY (userId)
);



/* Properties Table */
CREATE TABLE Properties (
    propertyId INT NOT NULL UNIQUE AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    propertyType VARCHAR(50) NOT NULL,
    address VARCHAR(200) NOT NULL,
    city VARCHAR(100) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    status ENUM('available', 'sold', 'rented') NOT NULL DEFAULT 'available',
    imagePath VARCHAR(255) DEFAULT 'assets/images/property1.jpg',
    agentId INT NOT NULL,
    PRIMARY KEY (propertyId),
    FOREIGN KEY (agentId) REFERENCES Users(userId)
);



/* Inquiries Table */
CREATE TABLE Inquiries (
    inquiryId INT NOT NULL UNIQUE AUTO_INCREMENT,
    userId INT NOT NULL,
    propertyId INT NOT NULL,
    message VARCHAR(255) NOT NULL,
    inquiryDate DATETIME NOT NULL,
    PRIMARY KEY (inquiryId),
    FOREIGN KEY (userId) REFERENCES Users(userId),
    FOREIGN KEY (propertyId) REFERENCES Properties(propertyId)
);



/* Transactions Table */
CREATE TABLE Transactions (
    transactionId INT NOT NULL UNIQUE AUTO_INCREMENT,
    propertyId INT NOT NULL,
    userId INT NOT NULL,
    transactionType ENUM('sale', 'rental') NOT NULL,
    transactionDate DATETIME NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    PRIMARY KEY (transactionId),
    FOREIGN KEY (propertyId) REFERENCES Properties(propertyId),
    FOREIGN KEY (userId) REFERENCES Users(userId)
);



/* Favorites Table */
CREATE TABLE Favorites (
    favoriteId INT NOT NULL UNIQUE AUTO_INCREMENT,
    userId INT NOT NULL,
    propertyId INT NOT NULL,
    savedDate DATETIME NOT NULL,
    PRIMARY KEY (favoriteId),
    UNIQUE KEY unique_favorite (userId, propertyId),
    FOREIGN KEY (userId) REFERENCES Users(userId),
    FOREIGN KEY (propertyId) REFERENCES Properties(propertyId)
);



/* Sample Users */
INSERT INTO Users
(userName, contactInfo, passwordHash, userType)
VALUES
(
    'agent_maria',
    'maria@email.com',
    '$2y$12$YfA/rFsr3LMdkuPsJE5yeOSEmvRw/6.68da6luxebIyW0rLT8Uiyy',
    'agent'
),
(
    'buyer_james',
    'james@email.com',
    '$2y$12$YfA/rFsr3LMdkuPsJE5yeOSEmvRw/6.68da6luxebIyW0rLT8Uiyy',
    'buyer'
),
(
    'renter_lisa',
    'lisa@email.com',
    '$2y$12$YfA/rFsr3LMdkuPsJE5yeOSEmvRw/6.68da6luxebIyW0rLT8Uiyy',
    'renter'
);



/* Sample Properties */
INSERT INTO Properties
(title, propertyType, address, city, price, status, imagePath, agentId)
VALUES
(
    'Modern Family House',
    'House',
    '15 Main Street',
    'New York',
    850000.00,
    'available',
    'assets/images/property1.jpg',
    1
),
(
    'Luxury Condo',
    'Condo',
    '88 Downtown Ave',
    'Brooklyn',
    620000.00,
    'available',
    'assets/images/property2.jpg',
    1
),
(
    'Rental Apartment',
    'Apartment',
    '120 River Road',
    'Queens',
    2400.00,
    'available',
    'assets/images/property3.jpg',
    1
);



/* Sample Inquiries */
INSERT INTO Inquiries
(userId, propertyId, message, inquiryDate)
VALUES
(
    2,
    1,
    'I am interested in this property.',
    NOW()
),
(
    3,
    2,
    'Is this condo still available?',
    NOW()
),
(
    2,
    3,
    'Can I schedule a viewing?',
    NOW()
);



/* Sample Transactions */
INSERT INTO Transactions
(propertyId, userId, transactionType, transactionDate, amount)
VALUES
(
    1,
    2,
    'sale',
    NOW(),
    850000.00
),
(
    2,
    3,
    'rental',
    NOW(),
    2400.00
),
(
    3,
    2,
    'rental',
    NOW(),
    2200.00
);



/* Sample Favorites */
INSERT INTO Favorites
(userId, propertyId, savedDate)
VALUES
(
    2,
    1,
    NOW()
),
(
    2,
    2,
    NOW()
),
(
    3,
    3,
    NOW()
);



/* Property Listing View */
CREATE VIEW PropertyListingView AS
SELECT
    p.propertyId,
    p.title,
    p.propertyType,
    p.city,
    p.price,
    p.status,
    p.imagePath,
    u.userName AS agentName
FROM Properties p
JOIN Users u
ON p.agentId = u.userId;



/* Add Or Update User Procedure */
DELIMITER $$

CREATE PROCEDURE AddOrUpdateUser(
    IN p_userId INT,
    IN p_userName VARCHAR(50),
    IN p_contactInfo VARCHAR(200),
    IN p_passwordHash VARCHAR(255),
    IN p_userType VARCHAR(20)
)
BEGIN
    IF p_userId IS NULL THEN

        INSERT INTO Users
        (userName, contactInfo, passwordHash, userType)
        VALUES
        (p_userName, p_contactInfo, p_passwordHash, p_userType);

    ELSE

        UPDATE Users
        SET
            userName = p_userName,
            contactInfo = p_contactInfo,
            passwordHash = p_passwordHash,
            userType = p_userType
        WHERE userId = p_userId;

    END IF;
END $$

DELIMITER ;



/* Process Transaction Procedure */
DELIMITER $$

CREATE PROCEDURE ProcessTransaction(
    IN p_propertyId INT,
    IN p_userId INT,
    IN p_transactionType VARCHAR(20),
    IN p_amount DECIMAL(12,2)
)
BEGIN
    INSERT INTO Transactions
    (propertyId, userId, transactionType, transactionDate, amount)
    VALUES
    (p_propertyId, p_userId, p_transactionType, NOW(), p_amount);
END $$

DELIMITER ;



/* Update Property Status Trigger */
DELIMITER $$

CREATE TRIGGER AfterTransactionInsert
AFTER INSERT ON Transactions
FOR EACH ROW
BEGIN
    IF NEW.transactionType = 'sale' THEN

        UPDATE Properties
        SET status = 'sold'
        WHERE propertyId = NEW.propertyId;

    ELSEIF NEW.transactionType = 'rental' THEN

        UPDATE Properties
        SET status = 'rented'
        WHERE propertyId = NEW.propertyId;

    END IF;
END $$

DELIMITER ;