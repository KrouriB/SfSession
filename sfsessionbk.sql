-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage des données de la table sfsessionbk.categorie : ~3 rows (environ)
DELETE FROM `categorie`;
INSERT INTO `categorie` (`id`, `nom`) VALUES
	(1, 'cat1'),
	(2, 'caté2'),
	(3, 'cate3'),
	(4, 'testCategorieForm'),
	(5, 'testCategorieForm2');

-- Listage des données de la table sfsessionbk.doctrine_migration_versions : ~0 rows (environ)
DELETE FROM `doctrine_migration_versions`;
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230720075706', '2023-07-20 07:57:12', 677);

-- Listage des données de la table sfsessionbk.formation : ~3 rows (environ)
DELETE FROM `formation`;
INSERT INTO `formation` (`id`, `nom`) VALUES
	(1, 'test1'),
	(2, 'test2'),
	(3, 'test3'),
	(4, 'testFormationForm');

-- Listage des données de la table sfsessionbk.messenger_messages : ~0 rows (environ)
DELETE FROM `messenger_messages`;

-- Listage des données de la table sfsessionbk.module : ~6 rows (environ)
DELETE FROM `module`;
INSERT INTO `module` (`id`, `categorie_id`, `nom`) VALUES
	(1, 1, 'mod.1-1'),
	(2, 1, 'mod.1-2'),
	(3, 2, 'mod.2-1'),
	(4, 2, 'mod.2-2'),
	(5, 2, 'mod.2-3'),
	(6, 3, 'mod.3-1'),
	(7, 5, 'testModuleForm');

-- Listage des données de la table sfsessionbk.programme : ~0 rows (environ)
DELETE FROM `programme`;

-- Listage des données de la table sfsessionbk.session : ~5 rows (environ)
DELETE FROM `session`;
INSERT INTO `session` (`id`, `formation_id`, `nom`, `date_debut`, `date_fin`, `nombre_place_theorique`) VALUES
	(1, 1, 'Session Actuelle Milieu', '2007-02-16', '2025-05-25', 6),
	(2, 2, 'Session Actuelle Debut', '2023-07-24', '2026-07-24', 8),
	(3, 3, 'Session Actuelle Fin', '2016-07-24', '2023-07-24', 4),
	(4, 1, 'Session Avenir', '2023-09-02', '2024-05-24', 5),
	(5, 2, 'session Passé', '2018-07-24', '2022-07-24', 7),
	(6, 4, 'testSessionForm', '2023-08-28', '2023-10-05', 4);

-- Listage des données de la table sfsessionbk.stagiaire : ~0 rows (environ)
DELETE FROM `stagiaire`;
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

-- Listage des données de la table sfsessionbk.stagiaire_session : ~0 rows (environ)
DELETE FROM `stagiaire_session`;

-- Listage des données de la table sfsessionbk.user : ~2 rows (environ)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `pseudo`, `is_verified`) VALUES
	(1, 'admin@gmail.com', '[]', '$2y$13$//8s49QSEYceZurwZ6auTO8u80jWZYJikUve5RzzBjJqv2rb69Zxq', 'Admin', 0),
	(2, 'admin.admin@gmail.com', '[]', '$2y$13$HpaW2bkDrPLEDQlr3h9s8u1YhpxyOIuN6l4K8.bRJwk7kplqeF2V6', 'admi', 1),
	(3, 'admino@gmail.com', '[]', '$2y$13$i2B/S4rHl1qPw6wXSGJjlehgEQWq5nIe4133rzH6swQdmJ1uXdLWa', 'admino', 0),
	(4, 'adminato@gmail.com', '[]', '$2y$13$TBpPme.L8GOdreMj2GGWWueYucKqx8PbnISGBYTd0123REZBfjGoK', 'adminato', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
