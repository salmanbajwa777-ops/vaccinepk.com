-- Vaccine.Pk — vaccine alias search, step 3
-- Spec: ~/Desktop/vsc/VACCINE_ALIAS_SEARCH_SPEC.md
-- Run in phpMyAdmin on the vaccinepk.com WordPress database.
--
-- PART 1 is READ-ONLY. Run it first and send the results (screenshots are fine).
-- PART 2 creates one new empty table. It touches no existing table.
-- If your table prefix isn't `wp_`, replace it everywhere (the first query shows it).

-- =====================================================================
-- PART 1 — read-only checks
-- =====================================================================

-- 1a. Confirms the prefix and that Pods created the alias table.
SHOW TABLES LIKE '%pods_vaccine_alias%';

-- 1b. The alias table's columns. This tells me how Pods stored the fields,
--     especially whether `vaccine` and `brand` have their own columns or live
--     in the podsrel table.
DESCRIBE `wp_pods_vaccine_alias`;

-- 1c. The live vaccine and brand list, so the seed uses real IDs and titles.
SELECT ID, post_type, post_title
FROM `wp_posts`
WHERE post_type IN ('vaccine', 'brand')
  AND post_status = 'publish'
ORDER BY post_type, post_title;

-- =====================================================================
-- PART 2 — create the misses table (spec §3.2)
-- =====================================================================

CREATE TABLE IF NOT EXISTS `wp_search_misses` (
  `term_key`    VARCHAR(100) NOT NULL COMMENT 'normalized: lowercase, a-z0-9 only',
  `last_term`   VARCHAR(190) NOT NULL COMMENT 'last raw spelling seen',
  `hits`        INT UNSIGNED NOT NULL DEFAULT 1,
  `first_seen`  DATETIME NOT NULL,
  `last_seen`   DATETIME NOT NULL,
  `resolved`    TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = alias added or judged junk',
  PRIMARY KEY (`term_key`),
  KEY `open_by_hits` (`resolved`, `hits`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Verify:
-- SHOW TABLES LIKE '%search_misses%';
