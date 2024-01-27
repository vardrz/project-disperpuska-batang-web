CREATE TABLE `publics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `area` varchar(45) DEFAULT NULL,
  `phone` decimal(10,0) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `staffs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `role` varchar(120) NOT NULL,
  `nip` varchar(120) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `archives` (
  `id` int NOT NULL AUTO_INCREMENT,
  `on_date` date DEFAULT NULL,
  `archives_number` varchar(120) NOT NULL,
  `institute` varchar(200) NOT NULL,
  `isi` text,
  `status` enum('internal','public') DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `borrow` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publics_id` int NOT NULL,
  `archives_id` int NOT NULL,
  `notes` text,
  `needs` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_publics` (`publics_id`),
  KEY `fk_archives` (`archives_id`),
  CONSTRAINT `fk_archives` FOREIGN KEY (`archives_id`) REFERENCES `archives` (`id`),
  CONSTRAINT `fk_publics` FOREIGN KEY (`publics_id`) REFERENCES `publics` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;