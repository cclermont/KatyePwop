-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 15, 2019 at 04:06 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `katye_pwop_dump_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `accident`
--

CREATE TABLE `accident` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deaths` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accident_user`
--

CREATE TABLE `accident_user` (
  `accident_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fuel`
--

CREATE TABLE `fuel` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `pumped_at` datetime DEFAULT NULL,
  `merter_reading` decimal(10,2) DEFAULT NULL,
  `qty_pumped` decimal(10,2) DEFAULT NULL,
  `price_per_gallon` decimal(10,2) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `last_mileage` decimal(10,2) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institution_image`
--

CREATE TABLE `institution_image` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `info_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_size` int(11) DEFAULT NULL,
  `info_dimensions` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:simple_array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institution_institution`
--

CREATE TABLE `institution_institution` (
  `id` int(11) NOT NULL,
  `mayor_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slogan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `all_location_access` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institution_institution_user_join`
--

CREATE TABLE `institution_institution_user_join` (
  `institution_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `institution_person`
--

CREATE TABLE `institution_person` (
  `id` int(11) NOT NULL,
  `firstname` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location_location`
--

CREATE TABLE `location_location` (
  `id` int(11) NOT NULL,
  `institution_id` int(11) DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `pay_ref` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_image`
--

CREATE TABLE `message_image` (
  `id` int(11) NOT NULL,
  `message_id` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `info_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_size` int(11) DEFAULT NULL,
  `info_dimensions` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:simple_array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_message`
--

CREATE TABLE `message_message` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `sender_institution_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `broadcasted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_message_institution_join`
--

CREATE TABLE `message_message_institution_join` (
  `message_id` int(11) NOT NULL,
  `institution_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_message_location_join`
--

CREATE TABLE `message_message_location_join` (
  `message_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_video`
--

CREATE TABLE `message_video` (
  `id` int(11) NOT NULL,
  `message_id` int(11) DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `info_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_size` int(11) DEFAULT NULL,
  `info_dimensions` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:simple_array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20190115144859'),
('20190115150612');

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_access_token`
--

CREATE TABLE `oauth2_access_token` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth2_access_token`
--

INSERT INTO `oauth2_access_token` (`id`, `client_id`, `user_id`, `token`, `expires_at`, `scope`) VALUES
(1, 1, 1, 'NDE1Mzk0NDU4ZjUzMWZiNTFlYTEyMzdhNjI0MTJiNzM4YTViMTZhZDE4N2UwMGViM2JhOGY2NTdlZWEzZDA3ZA', 1547567817, 'api user');

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_auth_code`
--

CREATE TABLE `oauth2_auth_code` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` longtext COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_client`
--

CREATE TABLE `oauth2_client` (
  `id` int(11) NOT NULL,
  `random_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uris` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `allowed_grant_types` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth2_client`
--

INSERT INTO `oauth2_client` (`id`, `random_id`, `redirect_uris`, `secret`, `allowed_grant_types`) VALUES
(1, '50tkynfz1bswks4s8sogc448g084c8wos8oos404wscg8kwk4g', 'a:0:{}', '2tj4evi7v4u8cwsg88c8wo8w88osc48sow4404s8c8os0wswc4', 'a:3:{i:0;s:8:\"password\";i:1;s:13:\"refresh_token\";i:2;s:18:\"client_credentials\";}');

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_refresh_token`
--

CREATE TABLE `oauth2_refresh_token` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth2_refresh_token`
--

INSERT INTO `oauth2_refresh_token` (`id`, `client_id`, `user_id`, `token`, `expires_at`, `scope`) VALUES
(1, 1, 1, 'ODhmNzRmNTAyN2RmYTRjYTRmYjZkZDFmM2FiMTIxZDcyNjZkYmFiMDEyODI3YTE4ZDE1ZjY4MzFhNGU3ZDQyZA', 1548773817, 'api user');

-- --------------------------------------------------------

--
-- Table structure for table `repair`
--

CREATE TABLE `repair` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `remarks` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_image`
--

CREATE TABLE `user_image` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `info_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_original_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `info_size` int(11) DEFAULT NULL,
  `info_dimensions` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:simple_array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE `user_notification` (
  `id` int(11) NOT NULL,
  `firebase_android_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `firebase_ios_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `firstname` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `image_id`, `notification_id`, `location_id`, `firstname`, `lastname`, `gender`, `birthdate`, `phone`, `created`, `modified`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-15 14:50:01', '2019-01-15 14:50:01'),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2019-01-15 15:03:14', '2019-01-15 15:03:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_session_history`
--

CREATE TABLE `user_session_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `ip` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `context` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `system` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_version` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `opened` datetime NOT NULL,
  `closed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_user`
--

CREATE TABLE `user_user` (
  `id` int(11) NOT NULL,
  `profile_id` int(11) DEFAULT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_user`
--

INSERT INTO `user_user` (`id`, `profile_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `created`, `modified`) VALUES
(1, 1, 'admin', 'admin', 'admin@katyepwop.com', 'admin@katyepwop.com', 1, NULL, '$2y$13$8tKFqvPfIaXlj/o4mISwt.MGckwbIg1VHbzcI1TSq/1U6GiThnqzi', '2019-01-15 14:50:39', NULL, NULL, 'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}', '2019-01-15 14:50:01', '2019-01-15 14:50:39'),
(2, 2, 'Carrefour', 'carrefour', 'Carrefour@yahoo.fr', 'carrefour@yahoo.fr', 1, NULL, '$2y$13$W3WM5kqNvN8hhiRRFReWQevFukL3eqPw8d65EhiosLPmGqAI.SCNi', NULL, '_z1vHpev1oY3WnNuL1cZfHw3o3fElWkQ2Mo9CpYbi0k', '2019-01-15 15:03:13', 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '2019-01-15 15:03:14', '2019-01-15 15:03:14');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `reg_no` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution_id` int(11) NOT NULL,
  `reg_date` date DEFAULT NULL,
  `cost` decimal(13,2) DEFAULT NULL,
  `make` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_driver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_category`
--

CREATE TABLE `vehicle_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institution_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accident`
--
ALTER TABLE `accident`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8F31DB6F545317D1` (`vehicle_id`);

--
-- Indexes for table `accident_user`
--
ALTER TABLE `accident_user`
  ADD PRIMARY KEY (`accident_id`,`user_id`),
  ADD KEY `IDX_A333737516D8554C` (`accident_id`),
  ADD KEY `IDX_A3337375A76ED395` (`user_id`);

--
-- Indexes for table `fuel`
--
ALTER TABLE `fuel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_31BD6FE9545317D1` (`vehicle_id`);

--
-- Indexes for table `institution_image`
--
ALTER TABLE `institution_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institution_institution`
--
ALTER TABLE `institution_institution`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_5C7FD7DA6C74E5F2` (`mayor_id`),
  ADD UNIQUE KEY `UNIQ_5C7FD7DAF5B7AF75` (`address_id`),
  ADD UNIQUE KEY `UNIQ_5C7FD7DA3DA5256D` (`image_id`),
  ADD UNIQUE KEY `UNIQ_5C7FD7DA642B8210` (`admin_id`);

--
-- Indexes for table `institution_institution_user_join`
--
ALTER TABLE `institution_institution_user_join`
  ADD PRIMARY KEY (`institution_id`,`user_id`),
  ADD UNIQUE KEY `UNIQ_B62C068CA76ED395` (`user_id`),
  ADD KEY `IDX_B62C068C10405986` (`institution_id`);

--
-- Indexes for table `institution_person`
--
ALTER TABLE `institution_person`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `location_location`
--
ALTER TABLE `location_location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8FCBAB2910405986` (`institution_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2F84F8E9545317D1` (`vehicle_id`);

--
-- Indexes for table `message_image`
--
ALTER TABLE `message_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3A9BFBB4537A1329` (`message_id`);

--
-- Indexes for table `message_message`
--
ALTER TABLE `message_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_26350A73F624B39D` (`sender_id`),
  ADD KEY `IDX_26350A73C1ACA445` (`sender_institution_id`);

--
-- Indexes for table `message_message_institution_join`
--
ALTER TABLE `message_message_institution_join`
  ADD PRIMARY KEY (`message_id`,`institution_id`),
  ADD UNIQUE KEY `UNIQ_9EB87EC710405986` (`institution_id`),
  ADD KEY `IDX_9EB87EC7537A1329` (`message_id`);

--
-- Indexes for table `message_message_location_join`
--
ALTER TABLE `message_message_location_join`
  ADD PRIMARY KEY (`message_id`,`location_id`),
  ADD KEY `IDX_49C7D981537A1329` (`message_id`),
  ADD KEY `IDX_49C7D98164D218E` (`location_id`);

--
-- Indexes for table `message_video`
--
ALTER TABLE `message_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_836125C7537A1329` (`message_id`);

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `oauth2_access_token`
--
ALTER TABLE `oauth2_access_token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_454D96735F37A13B` (`token`),
  ADD KEY `IDX_454D967319EB6921` (`client_id`),
  ADD KEY `IDX_454D9673A76ED395` (`user_id`);

--
-- Indexes for table `oauth2_auth_code`
--
ALTER TABLE `oauth2_auth_code`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1D2905B55F37A13B` (`token`),
  ADD KEY `IDX_1D2905B519EB6921` (`client_id`),
  ADD KEY `IDX_1D2905B5A76ED395` (`user_id`);

--
-- Indexes for table `oauth2_client`
--
ALTER TABLE `oauth2_client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth2_refresh_token`
--
ALTER TABLE `oauth2_refresh_token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4DD907325F37A13B` (`token`),
  ADD KEY `IDX_4DD9073219EB6921` (`client_id`),
  ADD KEY `IDX_4DD90732A76ED395` (`user_id`);

--
-- Indexes for table `repair`
--
ALTER TABLE `repair`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8EE43421545317D1` (`vehicle_id`);

--
-- Indexes for table `user_image`
--
ALTER TABLE `user_image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D95AB4053DA5256D` (`image_id`),
  ADD UNIQUE KEY `UNIQ_D95AB405EF1A9D84` (`notification_id`),
  ADD KEY `IDX_D95AB40564D218E` (`location_id`);

--
-- Indexes for table `user_session_history`
--
ALTER TABLE `user_session_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_27BE9E9EDA6A219` (`place_id`),
  ADD KEY `IDX_27BE9E9EA76ED395` (`user_id`);

--
-- Indexes for table `user_user`
--
ALTER TABLE `user_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F7129A8092FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_F7129A80A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_F7129A80C05FB297` (`confirmation_token`),
  ADD UNIQUE KEY `UNIQ_F7129A80CCFA12B8` (`profile_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_1B80E48612469DE2` (`category_id`);

--
-- Indexes for table `vehicle_category`
--
ALTER TABLE `vehicle_category`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accident`
--
ALTER TABLE `accident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fuel`
--
ALTER TABLE `fuel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `institution_image`
--
ALTER TABLE `institution_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `institution_institution`
--
ALTER TABLE `institution_institution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `institution_person`
--
ALTER TABLE `institution_person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `location_location`
--
ALTER TABLE `location_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `message_image`
--
ALTER TABLE `message_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `message_message`
--
ALTER TABLE `message_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `message_video`
--
ALTER TABLE `message_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth2_access_token`
--
ALTER TABLE `oauth2_access_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `oauth2_auth_code`
--
ALTER TABLE `oauth2_auth_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oauth2_client`
--
ALTER TABLE `oauth2_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `oauth2_refresh_token`
--
ALTER TABLE `oauth2_refresh_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `repair`
--
ALTER TABLE `repair`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_image`
--
ALTER TABLE `user_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_notification`
--
ALTER TABLE `user_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_session_history`
--
ALTER TABLE `user_session_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_user`
--
ALTER TABLE `user_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vehicle_category`
--
ALTER TABLE `vehicle_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `accident`
--
ALTER TABLE `accident`
  ADD CONSTRAINT `FK_8F31DB6F545317D1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`);

--
-- Constraints for table `accident_user`
--
ALTER TABLE `accident_user`
  ADD CONSTRAINT `FK_A333737516D8554C` FOREIGN KEY (`accident_id`) REFERENCES `accident` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_A3337375A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fuel`
--
ALTER TABLE `fuel`
  ADD CONSTRAINT `FK_31BD6FE9545317D1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`);

--
-- Constraints for table `institution_institution`
--
ALTER TABLE `institution_institution`
  ADD CONSTRAINT `FK_5C7FD7DA3DA5256D` FOREIGN KEY (`image_id`) REFERENCES `institution_image` (`id`),
  ADD CONSTRAINT `FK_5C7FD7DA642B8210` FOREIGN KEY (`admin_id`) REFERENCES `user_user` (`id`),
  ADD CONSTRAINT `FK_5C7FD7DA6C74E5F2` FOREIGN KEY (`mayor_id`) REFERENCES `institution_person` (`id`),
  ADD CONSTRAINT `FK_5C7FD7DAF5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `location_location` (`id`);

--
-- Constraints for table `institution_institution_user_join`
--
ALTER TABLE `institution_institution_user_join`
  ADD CONSTRAINT `FK_B62C068C10405986` FOREIGN KEY (`institution_id`) REFERENCES `institution_institution` (`id`),
  ADD CONSTRAINT `FK_B62C068CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `location_location`
--
ALTER TABLE `location_location`
  ADD CONSTRAINT `FK_8FCBAB2910405986` FOREIGN KEY (`institution_id`) REFERENCES `institution_institution` (`id`);

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `FK_2F84F8E9545317D1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`);

--
-- Constraints for table `message_image`
--
ALTER TABLE `message_image`
  ADD CONSTRAINT `FK_3A9BFBB4537A1329` FOREIGN KEY (`message_id`) REFERENCES `message_message` (`id`);

--
-- Constraints for table `message_message`
--
ALTER TABLE `message_message`
  ADD CONSTRAINT `FK_26350A73C1ACA445` FOREIGN KEY (`sender_institution_id`) REFERENCES `institution_institution` (`id`),
  ADD CONSTRAINT `FK_26350A73F624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user_user` (`id`);

--
-- Constraints for table `message_message_institution_join`
--
ALTER TABLE `message_message_institution_join`
  ADD CONSTRAINT `FK_9EB87EC710405986` FOREIGN KEY (`institution_id`) REFERENCES `institution_institution` (`id`),
  ADD CONSTRAINT `FK_9EB87EC7537A1329` FOREIGN KEY (`message_id`) REFERENCES `message_message` (`id`);

--
-- Constraints for table `message_message_location_join`
--
ALTER TABLE `message_message_location_join`
  ADD CONSTRAINT `FK_49C7D981537A1329` FOREIGN KEY (`message_id`) REFERENCES `message_message` (`id`),
  ADD CONSTRAINT `FK_49C7D98164D218E` FOREIGN KEY (`location_id`) REFERENCES `location_location` (`id`);

--
-- Constraints for table `message_video`
--
ALTER TABLE `message_video`
  ADD CONSTRAINT `FK_836125C7537A1329` FOREIGN KEY (`message_id`) REFERENCES `message_message` (`id`);

--
-- Constraints for table `repair`
--
ALTER TABLE `repair`
  ADD CONSTRAINT `FK_8EE43421545317D1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`);

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `FK_D95AB4053DA5256D` FOREIGN KEY (`image_id`) REFERENCES `user_image` (`id`),
  ADD CONSTRAINT `FK_D95AB40564D218E` FOREIGN KEY (`location_id`) REFERENCES `location_location` (`id`),
  ADD CONSTRAINT `FK_D95AB405EF1A9D84` FOREIGN KEY (`notification_id`) REFERENCES `user_notification` (`id`);

--
-- Constraints for table `user_session_history`
--
ALTER TABLE `user_session_history`
  ADD CONSTRAINT `FK_27BE9E9EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user_user` (`id`),
  ADD CONSTRAINT `FK_27BE9E9EDA6A219` FOREIGN KEY (`place_id`) REFERENCES `location_location` (`id`);

--
-- Constraints for table `user_user`
--
ALTER TABLE `user_user`
  ADD CONSTRAINT `FK_F7129A80CCFA12B8` FOREIGN KEY (`profile_id`) REFERENCES `user_profile` (`id`);

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `FK_1B80E48612469DE2` FOREIGN KEY (`category_id`) REFERENCES `vehicle_category` (`id`);