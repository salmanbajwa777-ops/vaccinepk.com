-- Vaccine.Pk — /flu page booking submissions
-- Run this once in phpMyAdmin BEFORE deploying the functions.php / single-flu-page.php
-- changes that read from and write to wp_flu_bookings.
-- Replace `wp_` below with your real table prefix if it differs.
--
-- Price/charge are stored as a SNAPSHOT at booking time (brand_price_snapshot,
-- service_charge_snapshot, total_snapshot) — if Brand price or the Flu Bookings
-- Settings charge tiers change later, past bookings must not silently reprice.

CREATE TABLE IF NOT EXISTS `wp_flu_bookings` (
  `id`                      BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name`               VARCHAR(190) NOT NULL,
  `whatsapp_number`         VARCHAR(40)  NOT NULL,
  `email`                   VARCHAR(190) NOT NULL,
  `city_id`                 BIGINT UNSIGNED NULL,
  `city_name`               VARCHAR(190) NOT NULL,
  `address`                 VARCHAR(500) NULL,
  `brand_id`                BIGINT UNSIGNED NULL,
  `brand_name`              VARCHAR(190) NOT NULL,
  `people_count`            SMALLINT UNSIGNED NOT NULL,
  `brand_price_snapshot`    DECIMAL(10,2) NOT NULL,
  `service_charge_snapshot` DECIMAL(10,2) NOT NULL,
  `total_snapshot`          DECIMAL(10,2) NOT NULL,
  `preferred_date`          DATE NULL,
  `time_slot`               VARCHAR(60) NULL,
  `location_type`           ENUM('clinic','home') NOT NULL DEFAULT 'clinic',
  `status`                  ENUM('new','confirmed','done','cancelled') NOT NULL DEFAULT 'new',
  `created_at`              DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`),
  KEY `brand_id` (`brand_id`),
  KEY `created_at` (`created_at`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
