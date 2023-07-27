-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           5.7.33 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour sfsessionbk
DROP DATABASE IF EXISTS `sfsessionbk`;
CREATE DATABASE IF NOT EXISTS `sfsessionbk` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `sfsessionbk`;

-- Listage de la structure de la table sfsessionbk. categorie
DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sfsessionbk.categorie : ~5 rows (environ)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`id`, `nom`) VALUES
	(1, 'cat1'),
	(2, 'caté2'),
	(3, 'cate3'),
	(4, 'testCategorieForm'),
	(5, 'testCategorieForm2');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Listage de la structure de la table sfsessionbk. doctrine_migration_versions
DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sfsessionbk.doctrine_migration_versions : ~1 rows (environ)
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230720075706', '2023-07-20 07:57:12', 677);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;

-- Listage de la structure de la table sfsessionbk. formation
DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sfsessionbk.formation : ~4 rows (environ)
/*!40000 ALTER TABLE `formation` DISABLE KEYS */;
INSERT INTO `formation` (`id`, `nom`) VALUES
	(1, 'test1'),
	(2, 'test2'),
	(3, 'test3'),
	(4, 'testFormationForm');
/*!40000 ALTER TABLE `formation` ENABLE KEYS */;

-- Listage de la structure de la table sfsessionbk. messenger_messages
DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sfsessionbk.messenger_messages : ~0 rows (environ)
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;

-- Listage de la structure de la table sfsessionbk. module
DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_C242628BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sfsessionbk.module : ~7 rows (environ)
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`id`, `categorie_id`, `nom`) VALUES
	(1, 1, 'mod.1-1'),
	(2, 1, 'mod.1-2'),
	(3, 2, 'mod.2-1'),
	(4, 2, 'mod.2-2'),
	(5, 2, 'mod.2-3'),
	(6, 3, 'mod.3-1'),
	(7, 5, 'testModuleForm');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

-- Listage de la structure de la table sfsessionbk. programme
DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `nombre_jours` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  KEY `IDX_3DDCB9FFAFC2B591` (`module_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sfsessionbk.programme : ~2 rows (environ)
/*!40000 ALTER TABLE `programme` DISABLE KEYS */;
INSERT INTO `programme` (`id`, `session_id`, `module_id`, `nombre_jours`) VALUES
	(1, 6, 7, 3),
	(2, 6, 5, 7),
	(3, 5, 7, 4),
	(4, 6, 4, 2);
/*!40000 ALTER TABLE `programme` ENABLE KEYS */;

-- Listage de la structure de la table sfsessionbk. session
DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formation_id` int(11) NOT NULL,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nombre_place_theorique` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D45200282E` (`formation_id`),
  CONSTRAINT `FK_D044D5D45200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sfsessionbk.session : ~6 rows (environ)
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`id`, `formation_id`, `nom`, `date_debut`, `date_fin`, `nombre_place_theorique`) VALUES
	(1, 1, 'Session Actuelle Milieu', '2007-02-16', '2025-05-25', 6),
	(2, 2, 'Session Actuelle Debut', '2023-07-24', '2026-07-24', 8),
	(3, 3, 'Session Actuelle Fin', '2016-07-24', '2023-07-24', 4),
	(4, 1, 'Session Avenir', '2023-09-02', '2024-05-24', 5),
	(5, 2, 'session Passé', '2018-07-24', '2022-07-24', 7),
	(6, 4, 'testSessionForm', '2023-08-28', '2023-10-05', 4);
/*!40000 ALTER TABLE `session` ENABLE KEYS */;

-- Listage de la structure de la table sfsessionbk. stagiaire
DROP TABLE IF EXISTS `stagiaire`;
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sfsessionbk.stagiaire : ~9 rows (environ)
/*!40000 ALTER TABLE `stagiaire` DISABLE KEYS */;
INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `date_naissance`, `email`, `telephone`, `sexe`, `ville`) VALUES
	(1, 'Tara', 'Rata', '2003-02-11', 'rata.tara@gmail.com', '0622332244', 'F', 'Dijon'),
	(2, 'Ciao', 'Polo', '1978-11-24', 'm.polo@gmail.com', '0784265917', 'M', 'Epinal'),
	(3, 'aaa', 'zzz', '1995-07-20', 'aaazzz@gmail.com', '0626594823', 'F', 'Paris'),
	(4, 'eee', 'rrr', '2002-05-24', 'eeerrr@gmail.com', '0774859612', 'M', 'Orléan'),
	(5, 'ttt', 'yyy', '1986-09-18', 'tttyyy@gmail.com', '0798653214', 'M', 'Bordeau'),
	(6, 'uuu', 'iii', '1995-04-30', 'uuuiii@gmail.com', '0636251498', 'M', 'Lille'),
	(7, 'ooo', 'ppp', '2003-11-17', 'oooppp@gmail.com', '0747142536', 'F', 'Aix'),
	(8, 'qqq', 'sss', '1969-06-09', 'qqqsss@gmail.com', '0690690960', 'F', 'Lyon'),
	(9, 'dddTest', 'fffTest', '1998-07-18', 'ddd.fff.test@gmail.com', '0987123456', 'F', 'Toulouse');
/*!40000 ALTER TABLE `stagiaire` ENABLE KEYS */;

-- Listage de la structure de la table sfsessionbk. stagiaire_session
DROP TABLE IF EXISTS `stagiaire_session`;
CREATE TABLE IF NOT EXISTS `stagiaire_session` (
  `stagiaire_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  PRIMARY KEY (`stagiaire_id`,`session_id`),
  KEY `IDX_D32D02D4BBA93DD6` (`stagiaire_id`),
  KEY `IDX_D32D02D4613FECDF` (`session_id`),
  CONSTRAINT `FK_D32D02D4613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D32D02D4BBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sfsessionbk.stagiaire_session : ~3 rows (environ)
/*!40000 ALTER TABLE `stagiaire_session` DISABLE KEYS */;
INSERT INTO `stagiaire_session` (`stagiaire_id`, `session_id`) VALUES
	(1, 6),
	(2, 6),
	(3, 6),
	(9, 6);
/*!40000 ALTER TABLE `stagiaire_session` ENABLE KEYS */;

-- Listage de la structure de la table sfsessionbk. user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Listage des données de la table sfsessionbk.user : ~4 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `pseudo`, `is_verified`) VALUES
	(1, 'admin@gmail.com', '[]', '$2y$13$//8s49QSEYceZurwZ6auTO8u80jWZYJikUve5RzzBjJqv2rb69Zxq', 'Admin', 0),
	(2, 'admin.admin@gmail.com', '[]', '$2y$13$HpaW2bkDrPLEDQlr3h9s8u1YhpxyOIuN6l4K8.bRJwk7kplqeF2V6', 'admi', 1),
	(3, 'admino@gmail.com', '[]', '$2y$13$i2B/S4rHl1qPw6wXSGJjlehgEQWq5nIe4133rzH6swQdmJ1uXdLWa', 'admino', 0),
	(4, 'adminato@gmail.com', '[]', '$2y$13$TBpPme.L8GOdreMj2GGWWueYucKqx8PbnISGBYTd0123REZBfjGoK', 'adminato', 1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
