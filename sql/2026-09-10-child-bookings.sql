-- Vaccine.Pk — /book-child-vaccination page booking submissions
-- Run this once in phpMyAdmin BEFORE deploying the functions.php /
-- template-vaccination-booking.php changes that read from and write to
-- wp_child_bookings.
-- Replace `wp_` below with your real table prefix if it differs.

CREATE TABLE IF NOT EXISTS `wp_child_bookings` (
  `id`                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_name`       VARCHAR(190) NOT NULL,
  `f_h_name`          VARCHAR(190) NULL,
  `phone`             VARCHAR(40)  NOT NULL,
  `gender`            VARCHAR(20)  NULL,
  `email`             VARCHAR(190) NOT NULL,
  `child_name`        VARCHAR(190) NOT NULL,
  `child_dob`         DATE NULL,
  `city_id`           BIGINT UNSIGNED NULL,
  `city_name`         VARCHAR(190) NOT NULL,
  `selected_vaccines` TEXT NULL,
  `appointment_date`  DATE NULL,
  `time_slot`         VARCHAR(60) NULL,
  `location_type`     ENUM('clinic','home') NOT NULL DEFAULT 'clinic',
  `home_address`      VARCHAR(500) NULL,
  `notes`             TEXT NULL,
  `status`            ENUM('new','confirmed','done','cancelled') NOT NULL DEFAULT 'new',
  `created_at`        DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  KEY `created_at` (`created_at`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
