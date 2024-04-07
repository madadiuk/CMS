
# CryptoShow Management System (CMS)

## Project Overview
The CryptoShow Management System (CMS) is designed to facilitate the organization and management of computer hardware and software exhibitions, with a special focus on cryptographic devices. Developed for a society of computer hobbyists, including cybersecurity experts and computer history enthusiasts, CMS aims to streamline the planning and execution of regular exhibitions, enhancing both the organizer and attendee experience.

## Features
- **User Registration and Profile Management:** Allows attendees and exhibitors to sign up, manage their profiles, and register for upcoming shows.
- **Device Registration:** Enables exhibitors to list and describe the cryptographic devices they plan to bring, enriching the exhibition narrative and visitor learning experience.
- **Event Planning and Management:** Tools for organizers to schedule shows, manage exhibits, and communicate updates to participants.
- **Interactive Show Map:** A mobile-friendly feature to help attendees navigate the venue, find exhibits, and learn more about the displayed devices.

## Technology Stack
- **Frontend:** HTML5 and CSS for a responsive and accessible web interface.
- **Backend:** Pure PHP for server-side logic, handling user registrations, device listings, event management, and more.
- **Database:** MySQL (consider extending the supplied data design and components as needed).

## User Experience Focus
The CMS project is grounded in a user-centered design philosophy, aiming to meet the diverse needs of our community of computer hobbyists and the general public. We prioritize ease of use, informative content, and interactive features to foster an engaging and educational experience.

## Getting Started
Instructions on how to set up the project locally, including requirements, installation steps, and configuration guidelines.

## Contributing
We welcome contributions from the community. This section includes guidelines for submitting pull requests, reporting bugs, and suggesting enhancements.

## License
Details about the project's license and terms of use.

## Contact
Information on how to reach the development team, report issues, or provide feedback.

##Discussion

The CryptoShow Management System (CMS) is envisioned as a comprehensive tool to address the specific needs of organizing and managing exhibitions of cryptographic devices and computer history artifacts. By leveraging HTML5 and CSS, the project ensures broad accessibility and a responsive user interface adaptable to various devices and screen sizes. The choice of Pure PHP as the backend technology allows for robust server-side processing capabilities, essential for handling dynamic content such as user profiles, device registrations, and event management tasks.

This project is not just about managing logistical details; it aims to enhance user engagement through features like interactive maps and detailed device descriptions. By focusing on user experience, CMS intends to serve both the dedicated members of the computer hobbyist society and the wider public with an interest in cryptography and computer history, ensuring that each exhibition is informative, engaging, and seamlessly organized.

## Getting started
Run the project locally by following these steps:
docker-compose up -d --build
## Contributing
docker-compose exec cms-app bash
## How goto bash in mariadb
docker exec -it cms-mariadb bash 

## How to connect to mariadb
mariadb -u root -p


password is: secret

## How to create database
-- Disable foreign key checks to ease dropping tables
SET FOREIGN_KEY_CHECKS=0;

-- Drop the database if it exists and create anew
DROP DATABASE IF EXISTS cryptoshow_db;
CREATE DATABASE cryptoshow_db;
USE cryptoshow_db;

-- Create a user specifically for this database
CREATE USER IF NOT EXISTS 'cryptoshowuser'@'localhost' IDENTIFIED BY 'cryptoshowpass';
GRANT SELECT, INSERT, UPDATE, DELETE ON cryptoshow_db.* TO 'cryptoshowuser'@'localhost';

-- Table structure for `registered_user`
DROP TABLE IF EXISTS `registered_user`;
CREATE TABLE `registered_user` (
`user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_nickname` VARCHAR(20) COLLATE utf8_unicode_ci DEFAULT NULL,
`user_name` VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL,
`user_email` VARCHAR(50) COLLATE utf8_unicode_ci DEFAULT NULL,
`user_hashed_password` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
`user_device_count` TINYINT(5) UNSIGNED NOT NULL DEFAULT 0,
`user_registered_timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Table structure for `crypto_device`
DROP TABLE IF EXISTS `crypto_device`;
CREATE TABLE `crypto_device` (
`crypto_device_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`fk_user_id` INT(10) UNSIGNED NOT NULL,
`crypto_device_name` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
`crypto_device_image_name` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
`crypto_device_record_visible` BOOLEAN DEFAULT FALSE,
`crypto_device_registered_timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`fk_user_id`) REFERENCES `registered_user`(`user_id`),
PRIMARY KEY (`crypto_device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Table structure for `event`
DROP TABLE IF EXISTS `event`;
CREATE TABLE `event` (
`event_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`event_name` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
`event_date` DATE DEFAULT NULL,
`event_venue` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Table structure for `user_event`
DROP TABLE IF EXISTS `user_event`;
CREATE TABLE `user_event` (
`fk_user_id` INT(10) UNSIGNED NOT NULL,
`fk_event_id` INT(10) UNSIGNED NOT NULL,
FOREIGN KEY (`fk_user_id`) REFERENCES `registered_user`(`user_id`),
FOREIGN KEY (`fk_event_id`) REFERENCES `event`(`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Enable foreign key checks after modifications
SET FOREIGN_KEY_CHECKS=1;

## Insert some sample data

INSERT INTO `registered_user` (`user_nickname`, `user_name`, `user_email`, `user_hashed_password`, `user_device_count`) VALUES
('Nick01', 'Nick Fury', 'nick01@example.com', 'hashedpassword01', 2),
('JaneDoe', 'Jane Doe', 'janedoe@example.com', 'hashedpassword02', 1),
('JohnDoe', 'John Doe', 'johndoe@example.com', 'hashedpassword03', 3),
('AliceW', 'Alice Wonderland', 'alice@example.com', 'hashedpassword04', 1),
('BobBuilder', 'Bob the Builder', 'bobbuilder@example.com', 'hashedpassword05', 2),
('CharlieC', 'Charlie Chaplin', 'charliec@example.com', 'hashedpassword06', 1);


INSERT INTO `crypto_device` (`fk_user_id`, `crypto_device_name`, `crypto_device_image_name`, `crypto_device_record_visible`) VALUES
(1, 'Bitcoin Miner', 'miner01.jpg', TRUE),
(2, 'Ethereum Rig', 'rig01.jpg', TRUE),
(1, 'Litecoin Miner', 'miner02.jpg', TRUE),
(3, 'Zcash Miner', 'miner03.jpg', FALSE),
(4, 'Monero Rig', 'rig02.jpg', TRUE),
(5, 'Dash Miner', 'miner04.jpg', TRUE);


INSERT INTO `event` (`event_name`, `event_date`, `event_venue`) VALUES
('CryptoCon 2024', '2024-07-20', 'New York'),
('Blockchain Expo 2024', '2024-08-15', 'London'),
('Decentralized Web Summit', '2024-09-05', 'San Francisco'),
('Ethereum Developer Conference', '2024-10-12', 'Tokyo'),
('NFT NYC', '2024-11-01', 'New York'),
('Bitcoin 2025: A New Era', '2025-01-25', 'Dubai');


INSERT INTO `user_event` (`fk_user_id`, `fk_event_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3),
(4, 2),
(5, 4);