-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 27, 2025 at 06:26 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ess_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
CREATE TABLE IF NOT EXISTS `banks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Bank of Baroda', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(2, 'Bank of India', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(3, 'Bank of Maharashtra', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(4, 'Canara Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(5, 'Central Bank of India', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(6, 'Indian Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(7, 'Indian Overseas Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(8, 'Punjab & Sind Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(9, 'Punjab National Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(10, 'State Bank of India', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(11, 'UCO Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(12, 'Union Bank of India', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(13, 'HDFC Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(14, 'ICICI Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(15, 'Axis Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(16, 'Kotak Mahindra Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(17, 'IndusInd Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(18, 'Yes Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(19, 'IDFC First Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(20, 'Federal Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(21, 'South Indian Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(22, 'RBL Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(23, 'Bandhan Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(24, 'CSB Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(25, 'Dhanlaxmi Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(26, 'Karnataka Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(27, 'Karur Vysya Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(28, 'Tamilnad Mercantile Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(29, 'City Union Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(30, 'Jammu & Kashmir Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(31, 'Jammu & Kashmir Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(32, 'Nainital Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(33, 'IDBI Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(34, 'Au Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(35, 'Capital Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(36, 'Equitas Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(37, 'Ujjivan Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(38, 'Utkarsh Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(39, 'Jana Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(40, 'ESAF Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(41, 'Suryoday Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(42, 'Fincare Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(43, 'North East Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(44, 'Shivalik Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(45, 'Unity Small Finance Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(46, 'India Post Payments Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(47, 'Fino Payments Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(48, 'Paytm Payments Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(49, 'Airtel Payments Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(50, 'Andhra Pradesh Grameena Vikas Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(51, 'Assam Gramin Vikash Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(52, 'Kerala Gramin Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(53, 'Madhya Pradesh Gramin Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(54, 'Saptagiri Grameena Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(55, 'Baroda Rajasthan Kshetriya Gramin Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(56, 'Citi Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(57, 'HSBC', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(58, 'Deutsche Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(59, 'Standard Chartered Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(60, 'DBS Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(61, 'Bank of America', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(62, 'Barclays Bank', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(63, 'BNP Paribas', '2025-02-16 11:26:39', '2025-02-16 11:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `organisation_id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb3_unicode_ci NOT NULL,
  `branch_email` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `building_no` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `premises_name` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `landmark` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `road_street` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `pincode` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `district` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `branches_organisation_id_foreign` (`organisation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `organisation_id`, `name`, `mobile`, `branch_email`, `building_no`, `premises_name`, `landmark`, `road_street`, `pincode`, `district`, `state`, `country`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nehru Place, New Delhi', '6394877241', 'xyz@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb3_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `country_code`, `created_at`, `updated_at`) VALUES
(1, 'India', 'IND', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `document_uploads`
--

DROP TABLE IF EXISTS `document_uploads`;
CREATE TABLE IF NOT EXISTS `document_uploads` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `document_type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `document_uploads_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_types`
--

DROP TABLE IF EXISTS `employee_types`;
CREATE TABLE IF NOT EXISTS `employee_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `employee_types`
--

INSERT INTO `employee_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'permanent', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(2, 'contract', '2025-02-16 11:26:39', '2025-02-16 11:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `emp_bank_details`
--

DROP TABLE IF EXISTS `emp_bank_details`;
CREATE TABLE IF NOT EXISTS `emp_bank_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `per_bank_name` bigint NOT NULL,
  `per_branch_name` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `per_account_number` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `per_ifsc_code` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `sal_bank_name` bigint NOT NULL,
  `sal_branch_name` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `sal_account_number` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `sal_ifsc_code` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `passport_number` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `issuing_country` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `passport_issue_date` date DEFAULT NULL,
  `passport_expiry_date` date DEFAULT NULL,
  `active_visa` enum('Yes','No') COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `visa_expiry_date` date DEFAULT NULL,
  `vehicle_type` enum('Car','Bike') COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vehicle_model` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vehicle_owner` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `vehicle_number` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `insurance_provider` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `insurance_expiry_date` date DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_bank_details_per_bank_name_foreign` (`per_bank_name`),
  KEY `emp_bank_details_sal_bank_name_foreign` (`sal_bank_name`),
  KEY `emp_bank_details_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_contact_details`
--

DROP TABLE IF EXISTS `emp_contact_details`;
CREATE TABLE IF NOT EXISTS `emp_contact_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `per_building_no` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `per_name_of_premises` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `per_nearby_landmark` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `per_road_street` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `per_country` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `per_pincode` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `per_district` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `per_city` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `per_state` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cor_building_no` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cor_name_of_premises` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cor_nearby_landmark` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cor_road_street` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cor_country` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cor_pincode` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cor_district` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cor_city` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `cor_state` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `offical_phone_number` varchar(15) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `alternate_phone_number` varchar(15) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email_address` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `offical_email_address` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `emergency_contact_person` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `emergency_contact_number` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_contact_details_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `emp_contact_details`
--

INSERT INTO `emp_contact_details` (`id`, `per_building_no`, `per_name_of_premises`, `per_nearby_landmark`, `per_road_street`, `per_country`, `per_pincode`, `per_district`, `per_city`, `per_state`, `cor_building_no`, `cor_name_of_premises`, `cor_nearby_landmark`, `cor_road_street`, `cor_country`, `cor_pincode`, `cor_district`, `cor_city`, `cor_state`, `offical_phone_number`, `alternate_phone_number`, `email_address`, `offical_email_address`, `emergency_contact_person`, `emergency_contact_number`, `user_id`, `created_at`, `updated_at`) VALUES
(2, '1102,11th floor', 'Neo Sky building,', 'Shaki naaka', 'Kokan Nagar', 'India', '110005', 'Central Delhi', 'Central Delhi', 'Delhi', '1102,11th floor', 'Neo Sky building,', 'Shaki naaka', 'Kokan Nagar', 'India', '110005', 'Central Delhi', 'Central Delhi', 'Delhi', '6394877241', '2134324324', 'akashsngh681681@gmail.com', 'amitgupt2603@gmail.com', 'Abhay', '3123132312', 2, '2025-02-20 00:13:55', '2025-02-20 00:13:55');

-- --------------------------------------------------------

--
-- Table structure for table `emp_details`
--

DROP TABLE IF EXISTS `emp_details`;
CREATE TABLE IF NOT EXISTS `emp_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_type` bigint NOT NULL,
  `employee_no` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `employee_name` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `Joining_date` date DEFAULT NULL,
  `reporting_manager` bigint NOT NULL,
  `total_experience` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `designation` bigint NOT NULL,
  `department` bigint NOT NULL,
  `gender` enum('Male','Female','other') COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `blood_group` enum('A+','A-','B+','B-','O+','O-','AB+','AB-') COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `nationality` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `religion` enum('Hinduism','Islam','Christianity','Sikhism','Buddhism','Jainism','Zoroastrianism','Judaism','Baha i Faith','Other') COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `marital_status` enum('Single','Married','Divorced') COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `anniversary_date` date DEFAULT NULL,
  `universal_account_number` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `provident_fund` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `esic_no` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_details_employee_type_foreign` (`employee_type`),
  KEY `emp_details_reporting_manager_foreign` (`reporting_manager`),
  KEY `emp_details_designation_foreign` (`designation`),
  KEY `emp_details_department_foreign` (`department`),
  KEY `emp_details_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_educations`
--

DROP TABLE IF EXISTS `emp_educations`;
CREATE TABLE IF NOT EXISTS `emp_educations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_type` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `degree` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `university_board` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `institution` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `passing_year` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `percentage_cgpa` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `certification_name` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `marks_obtained` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `out_of_marks_total_marks` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `date_of_certificate` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_educations_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_family_details`
--

DROP TABLE IF EXISTS `emp_family_details`;
CREATE TABLE IF NOT EXISTS `emp_family_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `relation` enum('Spouce','Child','Parent','Sibiling','Other') COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `age` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `dependent` enum('Yes','No') COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `phone_number` varchar(15) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_family_details_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emp_previous_employments`
--

DROP TABLE IF EXISTS `emp_previous_employments`;
CREATE TABLE IF NOT EXISTS `emp_previous_employments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `employer_name` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `last_drawn_annual_salary` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `relevant_experience` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `reason_for_leaving` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `major_responsibilities` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_previous_employments_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
CREATE TABLE IF NOT EXISTS `features` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `features_module_id_foreign` (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `module_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'show.checkin', NULL, NULL),
(2, 1, 'show.checkout', NULL, NULL),
(3, 2, 'employee.edit', NULL, NULL),
(4, 2, 'employee.show', NULL, NULL),
(5, 3, 'leave.approve', NULL, NULL),
(6, 3, 'leave.show', NULL, NULL),
(7, 4, 'organisation.edit', NULL, NULL),
(8, 4, 'organisation.show', NULL, NULL),
(9, 6, 'hr.edit', NULL, NULL),
(10, 6, 'hr.show', NULL, NULL),
(11, 7, 'setting.edit', NULL, NULL),
(12, 7, 'setting.show', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hr_policies`
--

DROP TABLE IF EXISTS `hr_policies`;
CREATE TABLE IF NOT EXISTS `hr_policies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `policy_categorie_id` bigint UNSIGNED NOT NULL,
  `policy_title` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `policy_content` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `docLink` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `iconLink` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `imgLink` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hr_policies_policy_categorie_id_foreign` (`policy_categorie_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hr_policy_categories`
--

DROP TABLE IF EXISTS `hr_policy_categories`;
CREATE TABLE IF NOT EXISTS `hr_policy_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `organisation_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hr_policy_categories_organisation_id_foreign` (`organisation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_02_04_050642_create_organisations_table', 1),
(6, '2025_02_04_051917_create_branches_table', 1),
(7, '2025_02_04_062624_create_features_table', 1),
(8, '2025_02_04_064406_create_modules_table', 1),
(9, '2025_02_04_064508_create_organisation_buy_modules_table', 1),
(10, '2025_02_04_064542_create_permissions_table', 1),
(11, '2025_02_07_063933_create_organisation_departments_table', 1),
(12, '2025_02_07_064029_create_organisation_designations_table', 1),
(13, '2025_02_11_043332_create_emp_details_table', 1),
(14, '2025_02_11_050652_create_emp_contact_details_table', 1),
(15, '2025_02_11_053257_create_emp_bank_details_table', 1),
(16, '2025_02_11_055105_create_emp_family_details_table', 1),
(17, '2025_02_11_055907_create_emp_previous_employments_table', 1),
(18, '2025_02_11_060937_create_banks_table', 1),
(19, '2025_02_11_063521_create_employee_types_table', 1),
(20, '2025_02_13_123305_create_qualifications_table', 1),
(21, '2025_02_13_123403_create_qualification_types_table', 1),
(22, '2025_02_13_123449_create_qualification_categories_table', 1),
(23, '2025_02_16_033503_create_emp_educations_table', 1),
(24, '2025_02_17_114259_create_document_uploads_table', 2),
(25, '2025_02_20_060915_create_countries_table', 3),
(28, '2025_02_25_091325_create_organisation_config_mails_table', 4),
(29, '2025_02_27_053212_create_user_home_page_statuses_table', 5),
(30, '2025_02_27_053330_create_hr_policy_categories_table', 6),
(32, '2025_02_27_053444_create_hr_policies_table', 7),
(34, '2025_02_27_053527_create_thought_of_the_days_table', 8),
(35, '2025_02_27_053557_create_news_and_events_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(2, 'Employee Details', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(3, 'Leave & Attendance', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(4, 'Organizations Chart', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(5, 'PMS', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(6, 'HR Policy', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(7, 'Settings', '2025-02-16 11:26:39', '2025-02-16 11:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `news_and_events`
--

DROP TABLE IF EXISTS `news_and_events`;
CREATE TABLE IF NOT EXISTS `news_and_events` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `organisation_id` bigint UNSIGNED NOT NULL,
  `creationDate` date DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_and_events_organisation_id_foreign` (`organisation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organisations`
--

DROP TABLE IF EXISTS `organisations`;
CREATE TABLE IF NOT EXISTS `organisations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `building_no` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `premises_name` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `landmark` varchar(150) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `road_street` varchar(150) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `pincode` varchar(15) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `district` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `country` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organisations_email_unique` (`email`),
  UNIQUE KEY `organisations_mobile_unique` (`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `organisations`
--

INSERT INTO `organisations` (`id`, `name`, `email`, `email_verified_at`, `password`, `mobile`, `building_no`, `premises_name`, `landmark`, `road_street`, `pincode`, `district`, `state`, `country`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'SIL Tech PVT', 'info@siltech.co.in', NULL, '$2y$10$Y32SbKRg4eADWwt2DURN6.vMjh3cc5Gvxi7pokaFhW.5m75LU489W', '6394877241', 'A-112', 'Centrum', 'Petrol pump', 'Gandhi Road', '110005', 'Mumbai', 'maharashtra', 'India', NULL, '2025-02-16 11:26:39', '2025-02-16 11:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `organisation_buy_modules`
--

DROP TABLE IF EXISTS `organisation_buy_modules`;
CREATE TABLE IF NOT EXISTS `organisation_buy_modules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_id` bigint UNSIGNED NOT NULL,
  `organisation_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organisation_buy_modules_module_id_foreign` (`module_id`),
  KEY `organisation_buy_modules_organisation_id_foreign` (`organisation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `organisation_buy_modules`
--

INSERT INTO `organisation_buy_modules` (`id`, `module_id`, `organisation_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(2, 2, 1, '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(3, 3, 1, '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(4, 4, 1, '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(5, 5, 1, '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(6, 6, 1, '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(7, 7, 1, '2025-02-16 11:26:39', '2025-02-16 11:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `organisation_config_mail`
--

DROP TABLE IF EXISTS `organisation_config_mail`;
CREATE TABLE IF NOT EXISTS `organisation_config_mail` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `MAIL_MAILER` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_HOST` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_PORT` varchar(10) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_USERNAME` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_PASSWORD` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_ENCRYPTION` varchar(10) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_FROM_ADDRESS` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_FROM_NAME` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `organisation_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organisation_config_mail_organisation_id_unique` (`organisation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `organisation_config_mail`
--

INSERT INTO `organisation_config_mail` (`id`, `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`, `organisation_id`, `created_at`, `updated_at`) VALUES
(4, 'smtp', 'smtp.gmail.com', '587', 'akashsngh681681@gmail.com', 'jfftxnrilxdbwwgy', 'tls', 'akashsngh681681@gmail.com', 'ess_portal', 1, '2025-02-25 06:09:28', '2025-02-25 06:09:28');

-- --------------------------------------------------------

--
-- Table structure for table `organisation_config_mails`
--

DROP TABLE IF EXISTS `organisation_config_mails`;
CREATE TABLE IF NOT EXISTS `organisation_config_mails` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `MAIL_MAILER` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_HOST` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_PORT` varchar(10) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_USERNAME` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_PASSWORD` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_ENCRYPTION` varchar(10) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_FROM_ADDRESS` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `MAIL_FROM_NAME` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `organisation_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `organisation_config_mails_organisation_id_unique` (`organisation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organisation_departments`
--

DROP TABLE IF EXISTS `organisation_departments`;
CREATE TABLE IF NOT EXISTS `organisation_departments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `organisation_id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organisation_departments_organisation_id_foreign` (`organisation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `organisation_departments`
--

INSERT INTO `organisation_departments` (`id`, `organisation_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'HR', '2025-02-17 05:00:52', '2025-02-17 05:00:52'),
(2, 1, 'Developer', '2025-02-17 23:29:00', '2025-02-17 23:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `organisation_designations`
--

DROP TABLE IF EXISTS `organisation_designations`;
CREATE TABLE IF NOT EXISTS `organisation_designations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `organisation_id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint UNSIGNED NOT NULL,
  `department_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organisation_designations_organisation_id_foreign` (`organisation_id`),
  KEY `organisation_designations_branch_id_foreign` (`branch_id`),
  KEY `organisation_designations_department_id_foreign` (`department_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `organisation_designations`
--

INSERT INTO `organisation_designations` (`id`, `organisation_id`, `branch_id`, `department_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'HR admin', '2025-02-17 05:01:02', '2025-02-17 05:01:02'),
(2, 1, 1, 2, 'Laravel Devloper', '2025-02-17 23:30:17', '2025-02-17 23:30:17');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `organisation_designations_id` bigint UNSIGNED NOT NULL,
  `feature_id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint UNSIGNED NOT NULL,
  `organisation_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_organisation_designations_id_foreign` (`organisation_designations_id`),
  KEY `permissions_feature_id_foreign` (`feature_id`),
  KEY `permissions_branch_id_foreign` (`branch_id`),
  KEY `permissions_organisation_id_foreign` (`organisation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb3_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

DROP TABLE IF EXISTS `qualifications`;
CREATE TABLE IF NOT EXISTS `qualifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Degree', '2025-02-16 11:26:39', '2025-02-16 11:26:39'),
(2, 'Certificate', '2025-02-16 11:26:39', '2025-02-16 11:26:39');

-- --------------------------------------------------------

--
-- Table structure for table `qualification_categories`
--

DROP TABLE IF EXISTS `qualification_categories`;
CREATE TABLE IF NOT EXISTS `qualification_categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `qualification_id` bigint NOT NULL,
  `qualification_type_id` bigint NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qualification_categories_qualification_id_foreign` (`qualification_id`),
  KEY `qualification_categories_qualification_type_id_foreign` (`qualification_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qualification_types`
--

DROP TABLE IF EXISTS `qualification_types`;
CREATE TABLE IF NOT EXISTS `qualification_types` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `qualification_id` bigint NOT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `qualification_types_qualification_id_foreign` (`qualification_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `thought_of_the_days`
--

DROP TABLE IF EXISTS `thought_of_the_days`;
CREATE TABLE IF NOT EXISTS `thought_of_the_days` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `creationDate` date DEFAULT NULL,
  `thought` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `organisation_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `thought_of_the_days_organisation_id_foreign` (`organisation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `organisation_id` bigint NOT NULL,
  `employeeID` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_organisation_id_foreign` (`organisation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `organisation_id`, `employeeID`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(25, 1, 'STMP', 'akash.s', 'akash.tech.0394@gmail.com', NULL, '$2y$10$eTwgM8cT0/zcGgVvsm.T1.JAW8LcOcOf0u/jTigUTRn/lFqI4eRg.', NULL, '2025-02-26 22:54:33', '2025-02-26 22:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_home_page_statuses`
--

DROP TABLE IF EXISTS `user_home_page_statuses`;
CREATE TABLE IF NOT EXISTS `user_home_page_statuses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `homePageStatus` enum('0','1') COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_home_page_statuses_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
