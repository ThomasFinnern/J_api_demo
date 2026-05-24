--
-- Table structure for table `#__secondhand_books`
--
CREATE TABLE if not exists `#__secondhand_books` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci,

  `published` tinyint(4) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_createdby` (`created_by`),
  KEY `published` (`published`),
  KEY `idx_alias` (`alias`)

) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


