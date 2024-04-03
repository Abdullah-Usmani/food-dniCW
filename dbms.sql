-- Active: 1712127514804@@127.0.0.1@3306@hungerstation

CREATE DATABASE HungerStation
    DEFAULT CHARACTER SET = 'utf8mb4';

USE HungerStation;

-- FIX THE DIAGRAM, get rid of spaces in the ERD
-- Should add 'WHERE' checks, 
-- Username must be more than 8 char
-- Password must have Uppercase char, Number
-- Phone Number must be valid, 10 digit >
-- Phone Number must be valid, begins with 00
-- AGE MUST BE ABOVE 18, etc.

CREATE TABLE Customer (
    CustomerID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(30) NOT NULL UNIQUE,
    Password VARCHAR(30) NOT NULL,
    Email TEXT,
    Name TEXT,
    Address VARCHAR(50) NOT NULL,
    PhoneNumber INT NOT NULL
);

CREATE TABLE MenuItem (
    ItemID INT PRIMARY KEY AUTO_INCREMENT,
    ItemName VARCHAR(30) NOT NULL,
    Description TEXT,
    ImageURL TEXT,
    Price REAL NOT NULL DEFAULT 2.50,
    AvailabilityStatus BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE MenuCategory (
    CategoryID INT PRIMARY KEY AUTO_INCREMENT,
    CategoryName VARCHAR(30) NOT NULL DEFAULT 'Unspecified'
);

--RENAME TABLE - can't use ORDER, changed to ORDERS NOW
--OrderStatus = delivered yes/no
CREATE TABLE Orders (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT NOT NULL,
    OrderDateTime DATETIME NOT NULL,
    Price REAL NOT NULL DEFAULT 0.00,
    OrderStatus BOOLEAN NOT NULL DEFAULT 0,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)
);
CREATE TABLE Payment (
    OrderID INT PRIMARY KEY AUTO_INCREMENT,
    CustomerID INT NOT NULL,
    OrderDateTime DATETIME NOT NULL,
    Price REAL NOT NULL DEFAULT 0.00,
    OrderStatus BOOLEAN NOT NULL DEFAULT 0,
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID)

);
-- default price for items
-- RENAME to ITEM
-- ADD STOCK COLUMN, HOW MANY OF THESE ITEMS AVAILIABLE?
--ITEMID ARROW IS MISSING TO FOREIGN KEY
CREATE TABLE OrderItem (
    OrderItemID INT PRIMARY KEY AUTO_INCREMENT,
    OrderID INT NOT NULL,
    ItemID INT NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (ItemID) REFERENCES MenuItem(ItemID)
);