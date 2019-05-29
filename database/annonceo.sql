-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 29 mai 2019 à 08:27
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `annonceo`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description_courte` varchar(255) NOT NULL,
  `description_longue` text NOT NULL,
  `prix` double(7,2) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `pays` varchar(30) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `cp` int(5) NOT NULL,
  `membre_id` int(3) NOT NULL,
  `photo_id` int(3) DEFAULT NULL,
  `categorie_id` int(3) DEFAULT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `titre`, `description_courte`, `description_longue`, `prix`, `photo`, `pays`, `ville`, `adresse`, `cp`, `membre_id`, `photo_id`, `categorie_id`, `date_enregistrement`) VALUES
(4, 'iphone 5s', 'je suis un iphone 5S', 'je suis un iphone 5S je suis un iphone 5S je suis un iphone 5S je suis un iphone 5S', 25000.00, 'images/15555159110-100-pantalon_bleu.jpg', 'Lyon', 'Paris', '1 rue de la liberté', 69, 1, 3, 6, '2019-04-17 17:45:11'),
(5, 'voyage en normandie', '1 semaine trarnquil oklm', '1 semaine trarnquil oklm 1 semaine trarnquil oklm 1 semaine trarnquil oklm 1 semaine trarnquil oklm', 12000.00, 'images/15555160460-200-chemise_blanche.jpg', 'France', 'Rouen', 'rue de la reussite', 52000, 1, 4, 4, '2019-04-17 17:47:26'),
(6, 'Maison pas cher', 'Je suis une maison un peu en ruine, mais le prix va t\'attirer', 'Je suis une maison un peu en ruine, mais le prix va t\'attirer Je suis une maison un peu en ruine, mais le prix va t\'attirer Je suis une maison un peu en ruine, mais le prix va t\'attirer Je suis une maison un peu en ruine, mais le prix va t\'attirer Je suis une maison un peu en ruine, mais le prix va t\'attirer Je suis une maison un peu en ruine, mais le prix va t\'attirer', 130.00, 'images/15555161380-500-chaussettes_blanches.jpg', 'France', 'Marseille', '1 rue de la santé', 13000, 1, 5, 3, '2019-04-17 17:48:58'),
(10, 'Surface Pro 3 corei5 8go ssd256go clavier et facture', 'Pc Portant pc Hp', 'Bonjour je vends un Pc portable hp pavillon il et encore neuf je le vend entre 450 ou 380 euro \r\n\r\nC est un ( i5,Windows 7,carte graphique radeon', 1890.00, 'images/15560299350-image-un-annonce-deux.jpg', 'France', 'Paris', 'Paris 20ème', 91210, 7, 9, 6, '2019-04-23 16:32:15'),
(13, 'Pc dell', 'Je vends mon pc dell', 'Je vends mon pc dell\r\nprocesseur intel core i5 8 giga de ram, le pc fonctionne avec un cable vga,\r\nil y a juste l\'ecran qui est n\'est pas cassé mais il a pris un coup donc impossible de voir, je le vends dans l\'état\r\n', 90.00, 'images/15560305890-image-cinq-annonce-cinq.jpg', 'France', ' tourcoing', 'La mairie', 59200, 12, 12, 6, '2019-04-23 16:43:09'),
(14, 'Toyota Yaris III 90 D-4D Business 5p', 'Toyota Yaris III 90 D-4D Business 5p berline, gris, 4 cv, 5 portes, mise en circulation le 26/11/2015, garantie 6 mois.', 'Toyota Yaris III 90 D-4D Business 5p berline, gris, 4 cv, 5 portes, mise en circulation le 26/11/2015, garantie 6 mois.\r\n\r\nOPTIONS ET EQUIPEMENTS :\r\nExtérieur :\r\n- rétroviseurs électriques\r\n- caméra de recul\r\n- filtre à particules\r\n\r\nIntérieur et confort :\r\n- auto-radio commandé au volant\r\n- ordinateur de bord\r\n- volant multifonctions\r\n- volant réglable\r\n- bluetooth\r\n- volant cuir\r\n- climatisation\r\n\r\nSécurité :\r\n- détecteur de pluie\r\n- fermeture centralisée\r\n- rétroviseurs dégivrants\r\n- ABS\r\n- airbags frontaux\r\n- airbags latéraux\r\n- anti-démarrage\r\n- anti-patinage\r\n- ESP\r\n- phares antibrouillard\r\n- radar arrière de détection d\'obstacles\r\n- aide au freinage d\'urgence\r\n- fixation ISOFIX\r\n- airbags rideaux\r\n- régulateur de vitesse\r\n- limiteur de vitesse', 8450.00, 'images/15560911910-image-voiture-un-un.jpg', 'France', 'Paris', 'Paris 2ieme', 1, 4, 13, 2, '2019-04-24 09:33:11'),
(18, '208 Feline - HDI 115cv - Toit Panoramique', 'Peugeot 208 Féline Toit panoramique', 'Peugeot 208 Féline Toit panoramique\r\n5 portes, mise en circulation en 2012 \r\nHDI - 115cv - 1,6l \r\n\r\n1er main - suivi chez Peugeot - \r\nHistorique entretien \r\n\r\nFull options\r\nGPS, radar de recul, Semi Cuir, Toit panoramique, Climatisation automatique, Feux et essuie-glaces automatiques, Jante aluminium \r\n......\r\n\r\nGarantie 3 mois avec possibilité d\'extension.', 8.00, 'images/15560926150-image-voiture-cinq-cinq.jpg', 'France', 'Marseille', 'Pres du port', 0, 12, 17, 2, '2019-04-24 09:56:56'),
(58, 'test', 'testinputpreview', 'testinputpreviewtestinputpreviewtestinputpreviewtestinputpreviewtestinputpreview', 160.00, 'images/15573172980-15555159110-100-pantalon_bleu.jpg', 'France', 'Lisses', '28 Chemin de la Joute', 1, 4, 58, 16, '2019-05-08 14:08:18'),
(60, 'Manteaux', 'CHAMPS ELYSEESCHAMPS ELYSEES', 'CHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEESCHAMPS ELYSEES', 1200.00, 'images/15580341370-8281465505_1_1_1.jpg', 'Allemagne', 'munich', '500 PLACE DES CHAMPS ELYSEES', 1, 1, 60, 16, '2019-05-16 21:15:37'),
(61, 'Manteaux kaki', 'j\'aime le kaki', 'j\'aime le kaki, tout kaki, tout rikiki, tout rakaka', 160.00, 'images/15582007310-8281465505_1_1_1.jpg', 'France', 'Lens', '28 Chemin blabla', 1, 1, 61, 16, '2019-05-18 19:32:11'),
(62, 'Manteaux kaki', 'j\'aime le kaki', 'j\'aime le kaki, tout kaki, tout rikiki, tout rakaka', 160.00, 'images/15582023790-8281465505_1_1_1.jpg', 'France', 'Lens', '28 Chemin blabla', 1, 1, 62, 16, '2019-05-18 19:59:39'),
(63, 'Manteaux bleu', 'ceci est un test google map', 'ceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google mapceci est un test google map', 1200.00, 'images/15582194740-8281465505_1_1_1.jpg', 'France', 'Lisses', '28 Chemin de la Joute', 1, 1, 63, 16, '2019-05-19 00:44:34');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(3) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `motscles` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `titre`, `motscles`) VALUES
(2, 'Vehicules', 'Voitures, Motos, Bateaux, Vélos, Equipement'),
(3, 'Immobilier', 'Ventes, Location, Colocations, Bureaux, Logements'),
(4, 'Vacances', 'Camping, Hotel, Gites'),
(6, 'Multimedia', 'Jeux videos, Informatique, Image, Son, Téléphone'),
(11, 'Emploi', 'Offres d\'emploi'),
(12, 'Loisirs', 'Films, Musiques, Livres'),
(13, 'Matériel', 'Outillage, Fourniture de bureau, Matériel Agricoles'),
(14, 'Services', 'Prestations de services, Evénements'),
(15, 'Maison', 'Ameublement, Electroménager, Bricolage, Jardinage'),
(16, 'Vêtements', 'Jean, Chemise, Robe, Chaussure, ...'),
(17, 'Autres', '...');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int(3) NOT NULL,
  `membre_id` int(3) DEFAULT NULL,
  `annonce_id` int(3) NOT NULL,
  `commentaire` text NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `membre_id`, `annonce_id`, `commentaire`, `date_enregistrement`) VALUES
(1, 1, 58, 'pas ce jeans vous faite un prix dessus ?', '2019-05-18 21:19:39');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `civilite` enum('m','f') NOT NULL,
  `statut` int(1) NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `telephone`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(1, 'samir', '$2y$10$iYJc0I5q6kcAnOZ3BjVmsur8s.EDuOblZvbmuaxK3kGTuL7PQEnGW', 'naggaral', 'samira', '0612370575', 'zbapin@gmail.com', 'm', 2, '2019-04-16 15:19:49'),
(4, 'zeineb', '$2y$10$CoZGYqxf6d0nVqtzrkN9te69Z90i/5Vk1hxxfJzupoJWWMEyBzuR6', 'zeineb', 'zeineb', '0600000000', 'zeineb@zeineb.fr', 'f', 2, '2019-04-16 17:43:59'),
(6, 'magid', '$2y$10$crSP4FdXp6aip/Z5/0gE1Owq.0rS6Wj2QlvyZnH2xraTAPrg0wJrq', 'naggara', 'magid', '0612214557', 'magid@outlook.com', 'm', 1, '2019-04-23 15:49:49'),
(7, 'malika', '$2y$10$AzgXed/lO7T3u/n8eT7DKecJL.RtgErtEy7NoesWn0eoGbsoMVP6u', 'mouhou', 'malika', '0645869523', 'malika@mouhou.fr', 'f', 1, '2019-04-23 15:50:20'),
(8, 'rayane', '$2y$10$iO3JKh0MrrDsUivdOPbSO.XfoknZtWByXgcR/NE5Eyb1/uBSGS1vO', 'mouhou', 'rayane', '0678964536', 'rayane@mouhou.com', 'm', 2, '2019-04-23 15:50:53'),
(9, 'aude', '$2y$10$HBdl26k4Qc6wuugw5MBKb.BYJJRFe0NwjBUwKLpJZ/UAF05lCejj.', 'barat', 'aude', '0645789535', 'aude@barat.fr', 'f', 2, '2019-04-23 15:52:00'),
(10, 'leila', '$2y$10$MT9fG2JR3Z2yNWjkQ9VvJuOHlpUe6OqVr3Dl4o5LZyXf/Qs9VeVW2', 'naggara', 'leila', '0625659585', 'leila@naggara.com', 'f', 1, '2019-04-23 15:52:36'),
(11, 'gabriel', '$2y$10$3lafHmehtqXRHm1mRQiW7excl8oIY/RV8u0W199x0bk19xFxZtuMm', 'fassy', 'gabriel', '0612451459', 'Gabriel.fasse@gmail.com', 'm', 2, '2019-04-23 15:53:15'),
(12, 'wendy', '$2y$10$2j/jUAK38Hr4DswJP5lMBO/gU3H2CKz89y.wLWt0wfTYf.yvNU9mO', 'derosario', 'wendy', '0612859575', 'doRosario@outlook.com', 'f', 1, '2019-04-23 15:54:52'),
(13, 'mickael91', '$2y$10$apWtU5JhwNJW4uCxQ7FasO2PCpukTq6uzyZUSAgzt2uYEdQ/MOk/y', 'testpsw', 'mickael', '0666662045', 'mickael.christine@bbox.fr', 'm', 1, '2019-04-28 22:22:48'),
(14, 'testpswd', '$2y$10$apWtU5JhwNJW4uCxQ7FasO2PCpukTq6uzyZUSAgzt2uYEdQ/MOk/y', 'testpsw2', 'mickael', '0666662045', 'mickael.christine@bbox.fr', 'm', 1, '2019-04-28 22:24:11'),
(15, 'mickael2', '$2y$10$apWtU5JhwNJW4uCxQ7FasO2PCpukTq6uzyZUSAgzt2uYEdQ/MOk/y', 'mickael', 'mickael', '0666662045', 'mickael.christine@bbox.fr', 'm', 2, '2019-05-09 00:40:28'),
(16, 'micka91test91', '$2y$10$SzkZiJKiq7G54D6T3ByIZOkFAigZ52P4c/nB1iN0es5qw6Lt4YjwO', 'christine', 'mickael', '0666662045', 'mickael.christine@hotmail.com', 'm', 1, '2019-05-18 21:55:48'),
(17, 'kloe', '$2y$10$GYJGnWgo0f3t/ryMsUnZVuJ3O16EwP2IyTk4JcgmvnACm1bbXa0oe', 'vincent', 'chloe', '0606060606', 'kloe_v@hotmail.com', 'f', 2, '2019-05-20 01:02:27'),
(18, 'mickael123', '$2y$10$dcOwMW1L35w.YqMmO6jI2eww/OedrSLqyOm0zB6hGu5iqiiUOQhle', 'mickael', 'mickcku', '0666662045', 'mickael@mail.fr', 'm', 2, '2019-05-25 22:33:56');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE `note` (
  `id_note` int(3) NOT NULL,
  `membre_id1` int(3) DEFAULT NULL,
  `membre_id2` int(3) NOT NULL,
  `note` int(3) NOT NULL,
  `avis` text NOT NULL,
  `date_enregistrement` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `note`
--

INSERT INTO `note` (`id_note`, `membre_id1`, `membre_id2`, `note`, `avis`, `date_enregistrement`) VALUES
(1, 1, 4, 3, 'Zeineb n\'est vraiment plus aussi sympa qu\'au debut, elle est trop loin', '2019-04-18 13:00:00'),
(2, 4, 1, 5, 'Samir est trop grand', '2019-04-03 00:00:00'),
(3, NULL, 1, 5, 'Samir m\'adore, donc c\'est ok', '2019-04-12 00:00:00'),
(4, NULL, 4, 2, 'Vasy trop chiante la meuf t\'as vu', '2019-04-15 00:00:00'),
(5, 4, 4, 5, 'aller, je remonte ta note!! Tu le mérite!!', '2019-04-19 16:02:02'),
(6, 4, 4, 5, 'Je m\'aime trop c\'est fou', '2019-04-19 16:04:16'),
(7, 4, 4, 5, 'Me trouve belle aujourd\'hui', '2019-04-19 16:05:06'),
(8, 4, 4, 5, 'j\'avais pas d\'inscription', '2019-04-19 16:37:57'),
(9, 4, 4, 5, 'dgdfg', '2019-04-19 16:38:56'),
(10, NULL, 4, 2, 'zafezfazef', '2019-05-05 15:07:03'),
(11, 17, 1, 5, 'je test des avis', '2019-05-24 00:25:59');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id_photo` int(3) NOT NULL,
  `photo1` varchar(255) NOT NULL,
  `photo2` varchar(255) NOT NULL,
  `photo3` varchar(255) NOT NULL,
  `photo4` varchar(255) NOT NULL,
  `photo5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id_photo`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`) VALUES
(1, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(2, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(3, 'images/15570073841-15555159113-103-pantalon_gris.jpg', 'images/15570074112-15555159115-104-pantalon_noir.jpg', 'images/15570074113-15555159114-103-pantalon_gris.jpg', 'images/15570074114-15555160460-200-chemise_blanche.jpg', 'images/15570074115-15555160464-204-chemise_rose.jpg'),
(4, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(5, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(6, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(7, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(8, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(9, 'images/15570073661-15555157622-15555145072-teamRocket2.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(10, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(11, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(12, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(13, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(14, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(15, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(16, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(17, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(18, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(19, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(20, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(21, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(22, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(23, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(24, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(25, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(26, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(27, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(28, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(29, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(30, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(31, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(32, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(33, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(34, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(35, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(36, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(37, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(38, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(39, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(40, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(41, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(42, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(43, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(44, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(45, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(46, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(47, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(48, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(49, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(50, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(51, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(52, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(53, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(54, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(55, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(56, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(57, 'images/15566626011-15555159112-101-profil.jpg', 'images/15566626112-15555159113-103-pantalon_gris.jpg', 'images/15566626383-15555157621-15555145071-teamRocket1.jpg', 'images/15566626384-15555157625-15555154685--teamRocket.jpg', 'images/15566626385-15555161384-504-chaussettes_rouges.jpg'),
(58, '', '', '', '', ''),
(59, 'images/15580339361-8281465505_2_1_1.jpg', 'images/15580339362-8281465505_2_2_1.jpg', 'images/15580339363-8281465505_2_3_1.jpg', 'images/15580339364-8281465505_2_6_1.jpg', 'images/15580339365-8281465505_6_1_1.jpg'),
(60, 'images/15580341371-8281465505_2_1_1.jpg', 'images/15580341372-8281465505_2_2_1.jpg', 'images/15580341373-8281465505_2_3_1.jpg', 'images/15580341374-8281465505_2_6_1.jpg', 'images/15580341375-8281465505_6_1_1.jpg'),
(61, 'images/15582007311-8281465505_2_1_1.jpg', 'images/15582007312-8281465505_2_2_1.jpg', 'images/15582007313-8281465505_2_3_1.jpg', 'images/15582007314-8281465505_2_6_1.jpg', 'images/15582007315-8281465505_6_1_1.jpg'),
(62, 'images/15582023791-8281465505_2_1_1.jpg', 'images/15582023792-8281465505_2_2_1.jpg', 'images/15582023793-8281465505_2_3_1.jpg', 'images/15582023794-8281465505_2_6_1.jpg', 'images/15582023795-8281465505_6_1_1.jpg'),
(63, 'images/15582194741-8281465505_2_1_1.jpg', 'images/15582194742-8281465505_2_2_1.jpg', 'images/15582194743-8281465505_2_6_1.jpg', 'images/15582194744-8281465505_2_3_1.jpg', 'images/15582194745-8281465505_6_1_1.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `pwdreset`
--

CREATE TABLE `pwdreset` (
  `pwdResetId` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`),
  ADD KEY `membre_id` (`membre_id`),
  ADD KEY `photo_id` (`photo_id`),
  ADD KEY `categorie_id` (`categorie_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`),
  ADD UNIQUE KEY `titre` (`titre`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `membre_id` (`membre_id`),
  ADD KEY `annonce_id` (`annonce_id`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Index pour la table `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `membre_id1` (`membre_id1`),
  ADD KEY `membre_id2` (`membre_id2`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id_photo`);

--
-- Index pour la table `pwdreset`
--
ALTER TABLE `pwdreset`
  ADD PRIMARY KEY (`pwdResetId`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `note`
--
ALTER TABLE `note`
  MODIFY `id_note` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id_photo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `pwdreset`
--
ALTER TABLE `pwdreset`
  MODIFY `pwdResetId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_2` FOREIGN KEY (`photo_id`) REFERENCES `photo` (`id_photo`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `annonce_ibfk_3` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id_categorie`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `commentaire_ibfk_1` FOREIGN KEY (`annonce_id`) REFERENCES `annonce` (`id_annonce`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commentaire_ibfk_2` FOREIGN KEY (`membre_id`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `note`
--
ALTER TABLE `note`
  ADD CONSTRAINT `note_ibfk_1` FOREIGN KEY (`membre_id2`) REFERENCES `membre` (`id_membre`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `note_ibfk_2` FOREIGN KEY (`membre_id1`) REFERENCES `membre` (`id_membre`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
