-- Vaccine.Pk — /book-travel-vaccination page booking submissions
-- Run this once in phpMyAdmin BEFORE deploying the functions.php /
-- template-vaccination-booking.php changes that read from and write to
-- wp_travel_bookings.
-- Replace `wp_` below with your real table prefix if it differs.

CREATE TABLE IF NOT EXISTS `wp_travel_bookings` (
  `id`                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name`         VARCHAR(190) NOT NULL,
  `f_h_name`          VARCHAR(190) NULL,
  `phone`             VARCHAR(40)  NOT NULL,
  `gender`            VARCHAR(20)  NULL,
  `email`             VARCHAR(190) NOT NULL,
  `dob`               DATE NULL,
  `passport`          VARCHAR(60)  NULL,
  `destination`       VARCHAR(190) NOT NULL,
  `travel_date`       DATE NULL,
  `travel_purpose`    VARCHAR(60)  NULL,
  `certificate`       VARCHAR(60)  NULL,
  `city_id`           BIGINT UNSIGNED NULL,
  `city_name`         VARCHAR(190) NOT NULL,
  `selected_vaccines` TEXT NULL,
  `appointment_date`  DATE NULL,
  `time_slot`         VARCHAR(60) NULL,
  `location_type`     ENUM('clinic','home') NOT NULL DEFAULT 'clinic',
  `home_address`      VARCHAR(500) NULL,
  `previous_vaccines` VARCHAR(100) NULL,
  `notes`             TEXT NULL,
  `status`            ENUM('new','confirmed','done','cancelled') NOT NULL DEFAULT 'new',
  `created_at`        DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  KEY `created_at` (`created_at`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
