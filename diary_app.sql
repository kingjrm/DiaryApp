SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_moods`
--

CREATE TABLE `daily_moods` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mood` varchar(50) NOT NULL,
  `note` text DEFAULT NULL,
  `mood_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diary_entries`
--

CREATE TABLE `diary_entries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `mood` varchar(50) DEFAULT NULL,
  `entry_date` date NOT NULL,
  `font_family` varchar(50) DEFAULT 'font-poppins',
  `position_x` float DEFAULT 0,
  `position_y` float DEFAULT 0,
  `rotation` float DEFAULT 0,
  `z_index` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `background_color` varchar(7) DEFAULT '#ffffff',
  `background_image` varchar(255) DEFAULT NULL,
  `text_color` varchar(7) DEFAULT '#000000',
  `text_bold` tinyint(1) DEFAULT 0,
  `text_italic` tinyint(1) DEFAULT 0,
  `text_underline` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diary_entries`
--

INSERT INTO `diary_entries` (`id`, `user_id`, `title`, `content`, `mood`, `entry_date`, `font_family`, `position_x`, `position_y`, `rotation`, `z_index`, `created_at`, `updated_at`, `background_color`, `background_image`, `text_color`, `text_bold`, `text_italic`, `text_underline`) VALUES
(1, 1, 'New Year New Me', 'HAHAHA HATDOG ASDKAJDLWDJAWLKDJKAW HATDOGG HAHAHA HATDOG ASDKAJDLWDJAWLKDJKAW HATDOGG HAHAHA HATDOG ASDKAJDLWDJAWLKDJKAW HATDOGG HAHAHA HATDOG ASDKAJDLWDJAWLKDJKAW HATDOGG HAHAHA HATDOG ASDKAJDLWDJAWLKDJKAW HATDOGG HAHAHA HATDOG ASDKAJDLWDJAWLKDJKAW HATDOGG HAHAHA HATDOG ASDKAJDLWDJAWLKDJKAW HATDOGG HAHAHA HATDOG ASDKAJDLWDJAWLKDJKAW HATDOGG HAHAHA HATDOG ASDKAJDLWDJAWLKDJKAW HATDOGG ', 'Calm', '2026-01-11', 'font-pixelify', 20, 20, 0, 0, '2026-01-11 13:24:13', '2026-01-11 14:29:16', '#ffffff', NULL, '#b84cd6', 0, 0, 0),
(2, 1, 'New Year New Me', 'HAHAHA HATDOG ASDKAJDLWDJAWLKDJKAW', 'Calm', '2026-01-11', 'font-pixelify', 300, 20, 0, 1, '2026-01-11 13:24:56', '2026-01-11 13:38:11', '#ffffff', NULL, '#000000', 0, 0, 0),
(4, 1, 'asdasdsd', 'asdasd', 'Anxious', '2026-01-11', 'font-inter', 20, 340, 0, 3, '2026-01-11 13:27:43', '2026-01-11 14:30:25', '#fd883a', NULL, '#000000', 0, 0, 0),
(5, 1, 'asdad', 'asdad', 'Happy', '2026-01-11', 'font-shadows', 300, 340, 0, 4, '2026-01-11 13:31:01', '2026-01-11 14:11:20', '#45b073', NULL, '#f2f2f2', 0, 0, 0),
(6, 1, 'adasd', 'asdasd', 'Happy', '2026-01-11', 'font-caveat', 260, 300, 0, 5, '2026-01-11 14:14:18', '2026-01-11 14:14:18', '#ffffff', NULL, '#000000', 0, 0, 0),
(7, 1, 'asdad', 'adasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsdadasdasdasdadadsd', 'Happy', '2026-01-11', 'font-caveat', 500, 300, 0, 6, '2026-01-11 14:16:39', '2026-01-11 16:34:42', '#37318c', NULL, '#ebebeb', 1, 1, 0),
(8, 4, 'asdasd', 'GAGU', 'Happy', '2026-01-11', 'font-poppins', 300, 20, 0, 1, '2026-01-11 15:53:12', '2026-01-11 15:53:12', '#ffffff', NULL, '#000000', 0, 0, 0),
(9, 4, 'asdadasd', 'adsasdasdasdasdasd', 'Excited', '2026-01-11', 'font-poppins', 580, 20, 0, 2, '2026-01-11 15:53:23', '2026-01-11 15:53:23', '#ffffff', NULL, '#000000', 0, 0, 0),
(10, 1, 'haha', 'heyy', 'Happy', '2026-01-12', 'font-shadows', 300, 20, 0, 1, '2026-01-12 13:55:57', '2026-01-12 13:55:57', '#ffffff', NULL, '#000000', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `diary_images`
--

CREATE TABLE `diary_images` (
  `id` int(11) NOT NULL,
  `diary_entry_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `path` varchar(500) NOT NULL,
  `thumbnail_path` varchar(500) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otps`
--

CREATE TABLE `otps` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otps`
--

INSERT INTO `otps` (`id`, `user_id`, `otp`, `expires_at`, `used`, `created_at`) VALUES
(3, 4, '927999', '2026-01-11 07:53:25', 0, '2026-01-11 14:43:25'),
(4, 5, '608849', '2026-01-11 09:06:01', 0, '2026-01-11 15:56:01');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `is_verified`, `created_at`, `updated_at`) VALUES
(1, 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMIN', 1, '2026-01-11 13:19:43', '2026-01-11 16:24:56'),
(4, 'lacernakingjerome@gmail.com', '$2y$10$MjdSRco.3Rc/8paxf81rS.XlgNaKhAKMi7WXtqzuUNtAXpIO8L5Bm', 'Jerome', 0, '2026-01-11 14:43:25', '2026-01-11 14:43:25'),
(5, 'beriaalie@gmail.com', '$2y$10$TiBBfAhaKnOjWAajOL1SMeenjAC0mQG2F9zCPqyIcDFNLeKpL6WyW', 'Miles ', 0, '2026-01-11 15:56:01', '2026-01-11 15:56:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_preferences`
--

CREATE TABLE `user_preferences` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `writing_font` varchar(100) DEFAULT 'Poppins',
  `scrapbook_theme` varchar(50) DEFAULT 'classic',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `avatar_path` varchar(500) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `timezone` varchar(50) DEFAULT 'UTC',
  `date_format` varchar(20) DEFAULT 'Y-m-d'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_preferences`
--

INSERT INTO `user_preferences` (`id`, `user_id`, `writing_font`, `scrapbook_theme`, `created_at`, `updated_at`, `avatar_path`, `bio`, `timezone`, `date_format`) VALUES
(1, 1, 'Caveat', 'classic', '2026-01-11 16:24:42', '2026-01-11 16:34:05', NULL, '', 'UTC', 'Y-m-d');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_logs_user` (`user_id`);

--
-- Indexes for table `daily_moods`
--
ALTER TABLE `daily_moods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_date` (`user_id`,`mood_date`),
  ADD KEY `idx_daily_moods_user_date` (`user_id`,`mood_date`);

--
-- Indexes for table `diary_entries`
--
ALTER TABLE `diary_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_date` (`user_id`,`entry_date`),
  ADD KEY `idx_diary_entries_user_date` (`user_id`,`entry_date`);

--
-- Indexes for table `diary_images`
--
ALTER TABLE `diary_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diary_entry_id` (`diary_entry_id`);

--
-- Indexes for table `otps`
--
ALTER TABLE `otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_otps_user_expires` (`user_id`,`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx_user_preferences_user` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_moods`
--
ALTER TABLE `daily_moods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diary_entries`
--
ALTER TABLE `diary_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `diary_images`
--
ALTER TABLE `diary_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otps`
--
ALTER TABLE `otps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_preferences`
--
ALTER TABLE `user_preferences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `daily_moods`
--
ALTER TABLE `daily_moods`
  ADD CONSTRAINT `daily_moods_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diary_entries`
--
ALTER TABLE `diary_entries`
  ADD CONSTRAINT `diary_entries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `diary_images`
--
ALTER TABLE `diary_images`
  ADD CONSTRAINT `diary_images_ibfk_1` FOREIGN KEY (`diary_entry_id`) REFERENCES `diary_entries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `otps`
--
ALTER TABLE `otps`
  ADD CONSTRAINT `otps_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_preferences`
--
ALTER TABLE `user_preferences`
  ADD CONSTRAINT `user_preferences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
