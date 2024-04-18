
# CryptoShow Management System (CMS)

You can find online version of the project [here](http://167.172.164.190:8085/)
GitHub repository of the project is [here](https://github.com/madadiuk/CMS)
GitLab repository of the project is [here](https://gitlab.com/madadi.uk/cryptoshow-management-system-cms)

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
## How run the project P3T environment:
if you want to run the project locally, you can follow these steps:
1. Clone the repository to your local machine or you can download the zip file and then extract it.
2. the public folder is the root of the project, so you need to set the root of the project to the public folder in P3T environment.
3. you should make a copy under class folder to include file for having the database connection.
4. next step is updating settings.php file in the config folder to have the database connection details according to P3T.
5. You can open the project in your browser by typing the URL of the project in the browser. the link of browser is according to the P3T configs environment.


## Getting started
suggested way for running this application is using docker-compose.
you can run the project by running the following command:

## Prerequisites
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
Query databases codes: Revised Database Structure


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
`user_id`  INT(10) UNSIGNED NOT NULL,
`event_name` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
`event_date` DATE DEFAULT NULL,
`event_venue` VARCHAR(255) COLLATE utf8_unicode_ci DEFAULT NULL,
PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Table structure for `user_event`
DROP TABLE IF EXISTS `user_event`;
CREATE TABLE `user_event` (
`fk_user_id` INT(10) UNSIGNED NOT NULL,
`fk_event_id` INT(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Table structure for `event_participants`This table will link users and events, indicating which users are participating in which events.
CREATE TABLE event_participants (
participant_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
fk_event_id INT(10) UNSIGNED NOT NULL,
fk_user_id INT(10) UNSIGNED NOT NULL,
PRIMARY KEY (participant_id),
FOREIGN KEY (fk_event_id) REFERENCES event(event_id),
FOREIGN KEY (fk_user_id) REFERENCES registered_user(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Table structure for `event_devices`This table will record which devices are brought to each event by participants.
CREATE TABLE event_devices (
event_device_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
fk_participant_id INT(10) UNSIGNED NOT NULL,
fk_device_id INT(10) UNSIGNED NOT NULL,
PRIMARY KEY (event_device_id),
FOREIGN KEY (fk_participant_id) REFERENCES event_participants(participant_id),
FOREIGN KEY (fk_device_id) REFERENCES crypto_device(crypto_device_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Enable foreign key checks after modifications
SET FOREIGN_KEY_CHECKS=1;


## Insert sample data into the tables

INSERT INTO `registered_user` (`user_nickname`, `user_name`, `user_email`, `user_hashed_password`, `user_device_count`) VALUES
('Nick01', 'Nick Fury', 'nick01@example.com', 'hashedpassword01', 2),
('JaneDoe', 'Jane Doe', 'janedoe@example.com', 'hashedpassword02', 1),
('JohnDoe', 'John Doe', 'johndoe@example.com', 'hashedpassword03', 3),
('AliceW', 'Alice Wonderland', 'alice@example.com', 'hashedpassword04', 1),
('BobBuilder', 'Bob the Builder', 'bobbuilder@example.com', 'hashedpassword05', 2),
('CharlieC', 'Charlie Chaplin', 'charliec@example.com', 'hashedpassword06', 1),
('Wallace', 'User Seven', 'user07@example.com', 'hashedpassword07', 3),
('Steve', 'User Eight', 'user08@example.com', 'hashedpassword08', 2),
('Phillip', 'User Nine', 'user09@example.com', 'hashedpassword09', 1),
('George', 'User Ten', 'user10@example.com', 'hashedpassword10', 2),
('Alexander', 'User Eleven', 'user11@example.com', 'hashedpassword11', 1),
('Arthur', 'User Twelve', 'user12@example.com', 'hashedpassword12', 3),
('Noah', 'User Thirteen', 'user13@example.com', 'hashedpassword13', 1),
('William ', 'User Fourteen', 'user14@example.com', 'hashedpassword14', 2),
('Stephen', 'User Fifteen', 'user15@example.com', 'hashedpassword15', 1),
('Harry', 'User Sixteen', 'user16@example.com', 'hashedpassword16', 3);



INSERT INTO `crypto_device` (`fk_user_id`, `crypto_device_name`, `crypto_device_image_name`, `crypto_device_record_visible`) VALUES
(1, 'Bitcoin Miner', 'miner01.jpg', TRUE),
(2, 'Ethereum Rig', 'rig01.jpg', TRUE),
(1, 'Litecoin Miner', 'miner02.jpg', TRUE),
(3, 'Zcash Miner', 'miner03.jpg', FALSE),
(4, 'Monero Rig', 'rig02.jpg', TRUE),
(5, 'Dash Miner', 'miner04.jpg', TRUE),
(1, 'Ripple XRP Miner', 'miner05.jpg', TRUE),
(2, 'Cardano Rig', 'rig03.jpg', TRUE),
(3, 'NEO Miner', 'miner06.jpg', FALSE),
(4, 'EOS Rig', 'rig04.jpg', TRUE),
(5, 'TRON Miner', 'miner07.jpg', TRUE),
(1, 'Stellar Lumens Miner', 'miner08.jpg', FALSE),
(2, 'IOTA Rig', 'rig05.jpg', TRUE),
(3, 'NEM Miner', 'miner09.jpg', TRUE),
(4, 'VeChain Rig', 'rig06.jpg', FALSE),
(5, 'Tezos Miner', 'miner10.jpg', TRUE);


INSERT INTO `event` (`user_id`, `event_name`, `event_date`, `event_venue`) VALUES
(1,'CryptoCon 2024', '2024-07-20', 'New York'),
(2,'Blockchain Expo 2024', '2024-08-15', 'London'),
(3,'Decentralized Web Summit', '2024-09-05', 'San Francisco'),
(4,'Ethereum Developer Conference', '2024-10-12', 'Tokyo'),
(5,'NFT NYC', '2024-11-01', 'New York'),
(6,'Bitcoin 2025: A New Era', '2025-01-25', 'Dubai'),
(7,'DeFi Conference 2025', '2025-02-20', 'Berlin'),
(8,'Crypto Mining Expo', '2025-03-15', 'Las Vegas'),
(9,'Smart Contract Symposium', '2025-04-05', 'Singapore'),
(10,'Digital Asset Summit', '2025-05-12', 'Hong Kong'),
(11,'Web3 Innovators Con', '2025-06-01', 'Sydney'),
(12,'Blockchain in Healthcare', '2025-07-25', 'Boston'),
(13,'Crypto Security Summit', '2025-08-20', 'Amsterdam'),
(14,'NFT London', '2025-09-15', 'London'),
(15,'Blockchain Developers Meet', '2025-10-05', 'Bangalore'),
(16,'Cryptocurrency Investment Strategies', '2025-11-12', 'New York');


INSERT INTO `user_event` (`fk_user_id`, `fk_event_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3),
(4, 2),
(5, 4),
(2, 6),
(3, 7),
(4, 8),
(5, 9),
(1, 10),
(2, 7),
(3, 8),
(4, 9),
(5, 10),
(1, 6);

