-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Jeu 16 Mai 2013 à 17:49
-- Version du serveur: 5.5.27-log
-- Version de PHP: 5.4.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `temara`
--

-- --------------------------------------------------------

--
-- Structure de la table `bien`
--

DROP TABLE IF EXISTS `bien`;
CREATE TABLE IF NOT EXISTS `bien` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(15) NOT NULL,
  `codePostalPublic` int(5) NOT NULL,
  `villePublique` varchar(25) NOT NULL,
  `lieuPublic` varchar(255) NOT NULL,
  `quartier` varchar(255) DEFAULT NULL,
  `prix` int(11) NOT NULL,
  `titre` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `dateCreation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `typeGeneral` enum('1','2','3','4') NOT NULL,
  `typeAnnonce` enum('1','2') NOT NULL,
  `codeAgence` varchar(8) NOT NULL,
  `pourInvestisseur` tinyint(1) DEFAULT NULL,
  `pourInvestisseurPotentiel` tinyint(1) DEFAULT NULL,
  `surface` decimal(8,2) NOT NULL,
  `nombrePieces` int(11) DEFAULT NULL,
  `nombreChambres` int(11) DEFAULT NULL,
  `reception` decimal(6,2) DEFAULT NULL,
  `nombreEtages` int(11) DEFAULT NULL,
  `terrain` decimal(6,2) DEFAULT NULL,
  `jardin` decimal(7,2) DEFAULT NULL,
  `exposition` varchar(20) DEFAULT NULL,
  `chauffage` varchar(20) DEFAULT NULL,
  `eau` tinyint(1) DEFAULT NULL,
  `gaz` tinyint(1) DEFAULT NULL,
  `electricite` tinyint(1) DEFAULT NULL,
  `assainissement` tinyint(1) DEFAULT NULL,
  `surfaceTerrasse` decimal(6,2) DEFAULT NULL,
  `interphone` tinyint(1) DEFAULT NULL,
  `etage` tinyint(1) DEFAULT NULL,
  `ascenseur` tinyint(1) DEFAULT NULL,
  `surfaceConstructible` decimal(8,2) DEFAULT NULL,
  `facade` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `bien`
--

INSERT INTO `bien` (`id`, `reference`, `codePostalPublic`, `villePublique`, `lieuPublic`, `quartier`, `prix`, `titre`, `description`, `dateCreation`, `typeGeneral`, `typeAnnonce`, `codeAgence`, `pourInvestisseur`, `pourInvestisseurPotentiel`, `surface`, `nombrePieces`, `nombreChambres`, `reception`, `nombreEtages`, `terrain`, `jardin`, `exposition`, `chauffage`, `eau`, `gaz`, `electricite`, `assainissement`, `surfaceTerrasse`, `interphone`, `etage`, `ascenseur`, `surfaceConstructible`, `facade`) VALUES
(2, '12345 MC', 80000, 'Amiens', 'rue Sagebien 80000 Amiens', 'Amiens - Plein sud', 150000, 'Maison amiens sud', 'AMIENS. Pavillon individuel sur sous sol complet avec possibilité de garer 2 voitures comprenant entrée, séjour, cuisine, suite parentale de plain pied avec salle d''eau et WC. A l''étage : palier, 3 chambres; salle de bain et WC. Jardin clos et arboré, terrasse. LE TOUT SUR PLUS DE 700 M² DE TERRAIN ! ', '2013-05-15 22:00:00', '1', '1', '80TEMAAM', NULL, 1, '220.00', 6, 3, '25.00', 2, '2000.00', '150.00', 'plein sud', 'EDF', NULL, NULL, NULL, NULL, '15.00', NULL, NULL, NULL, NULL, NULL),
(3, '789GT', 80480, 'Salouël', 'rue de la Bailly 80480 Salouël', 'Salouël centre', 100000, 'maison salouel', 'maison située à salouël', '2013-05-15 22:00:00', '1', '1', '80TEMAAM', 0, NULL, '80.00', 6, 3, NULL, NULL, NULL, '20.00', NULL, 'GAZ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '55ds', 80000, 'Amiens', 'route de Rouen 80000 Amiens', 'Amiens - sud-ouest', 150000, 'Appart amiens sud', 'd', '2013-05-15 22:00:00', '1', '1', '80TEMAAM', NULL, NULL, '55.00', 3, NULL, NULL, NULL, NULL, NULL, 'sud', 'FUEL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '57', 80480, 'Salouël', 'rue Paul Eluard 80480 Salouël', 'Secteur Salouël', 100000, 'maison salouel', 'rtyt', '2013-05-15 22:00:00', '1', '1', '80TEMAAM', NULL, NULL, '110.00', 5, 2, NULL, NULL, NULL, '10.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '87', 80000, 'Amiens', 'allée de la Paix 80000 Amiens', 'Amiens - Quartier du pigeonnier', 50, 'l', 'l', '2013-05-15 22:00:00', '1', '1', '80TEMACO', NULL, NULL, '6.50', 1, NULL, NULL, NULL, NULL, NULL, 'est', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '44', 80136, 'Rivery', 'rue Baudrez 80136 Rivery', 'Amiens Est', 7000, 'appartement à Rivery', 'Location bel appartement centre-ville Rivery', '2013-05-15 22:00:00', '2', '2', '80TEMACO', NULL, NULL, '40.00', 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '58742', 80000, 'Amiens', 'rue des Cordeliers 80000 Amiens', 'centre ville, proche gare', 54500, 'Superbe appartement centre ville amiens', 'Très bel appartement situé en plein coeur d''Amiens', '2013-05-15 22:00:00', '2', '1', '80TEMAAM', NULL, 1, '50.00', 2, NULL, '10.50', 2, NULL, NULL, NULL, 'EDF', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL),
(9, '41T', 80000, 'Amiens', '44 rue du Bellay 80000 Amiens', 'Amiens - Saint-Honoré', 85000, 'Charmante petite maison Amiens sud', 'Superbe maison à découvrir au plus vite !', '2013-05-15 22:00:00', '1', '1', '80TEMAAM', NULL, 1, '80.00', 4, 1, NULL, NULL, NULL, '15.00', NULL, 'Gaz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '123V', 80000, 'Amiens', 'rue de l''Offrande 80000 Amiens', 'Amiens - Saint-Honoré', 300000, 'Villa au bord d''Amiens', 'superbe villa', '2013-05-15 22:00:00', '1', '1', '80TEMACO', NULL, NULL, '250.00', 11, 4, '55.00', NULL, '400.00', '200.00', 'plein sud', 'Fuel', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'TER1', 80800, 'Vaux-sur-somme', 'vaux-sur-somme', 'secteur Corbie', 200000, 'Terrain de loisir avec étang', 'Terrain de loisir de 1 500 m² environ dont 1 000 m² d''eau. LA NATURE AUX PORTES DE LA METROPOLE !!', '2013-05-15 22:00:00', '3', '1', '80TEMACO', 1, NULL, '200.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'TER2', 80440, 'Boves', 'Boves', NULL, 400000, 'SECTEUR MOREUIL  TERRAIN A BATIR A LA CAMPAGNE', 'Terrain à bâtir viabilisé de 560 m² environ, hors lotissement. PETIT PRIX POUR GRAND PROJET !', '2013-05-15 22:00:00', '3', '1', '80TEMACO', 1, NULL, '6800.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '1500.00', '200.00'),
(13, 'GAR1', 80000, 'Amiens', '50 rue du bellay amiens', NULL, 15000, 'Garage à vendre', 'Garage à vendre amiens sud', '2013-05-15 22:00:00', '4', '1', '80TEMAAM', NULL, NULL, '10.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'TAR23', 80000, 'Amiens', 'rue Saint-Fuscien', NULL, 80000, 'test', 'test', '2013-05-15 22:00:00', '1', '1', '80TEMAAM', NULL, 1, '80.00', 6, 4, '20.00', 2, '50.00', '50.00', 'sud', 'Gaz', 1, 1, 1, 1, '50.00', 1, 1, 1, '50.00', '50.00'),
(15, 'TRUC21', 80000, 'Amiens', 'gare Amiens', NULL, 100000, 'Proche gare Amiens', 'Jolie maison à proximité de la gare', '2013-05-15 22:00:00', '1', '1', '80TEMAAM', NULL, NULL, '10.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'PLIT', 80000, 'Amiens', '36 rue Saint Fuscien Amiens', NULL, 150000, 'Maison rue Saint-Fuscien', '', '2013-05-15 22:00:00', '1', '1', '80TEMAAM', NULL, NULL, '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `mail` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `levelUser` tinyint(1) NOT NULL,
  `civilite` tinyint(1) DEFAULT NULL,
  `nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `codePostal` varchar(5) DEFAULT NULL,
  `ville` varchar(30) DEFAULT NULL,
  `telephone` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `compte`
--

INSERT INTO `compte` (`mail`, `password`, `levelUser`, `civilite`, `nom`, `prenom`, `adresse`, `codePostal`, `ville`, `telephone`) VALUES
('admin@test.fr', '$2y$10$nedKHGOAAQ9x0pF6xeXgXe4DaiYNUUfapaUl0YfK6nfOikKjBqFPm$2y$10$nedKHGOAAQ9x0pF6xeXgXf', 1, 3, '', '', '', '', '', ''),
('christophesauvage62@gmail.com', '$2y$10$Ki4PI7Cz/gbHOyzgw2X/aObwKLU4zhJFo.VoCjZ9Ci0cB/7g2yLpK$2y$10$Ki4PI7Cz/gbHOyzgw2X/aY', 0, 0, '', '', '', '', '', ''),
('csa62@live.fr', '$2y$10$SKWNOuwif/b3z/.YYl2m6OO0Eo/gUvON3EftqZwKIIxUtEcWd/Mh.$2y$10$SKWNOuwif/b3z/.YYl2m6a', 0, 1, 'SAUVAGE', 'Christophe', '44 rue du Bellay', '80000', 'Amiens', '06.15.87.58.55');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `civilite` tinyint(1) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `telephone` varchar(25) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `typeBien` varchar(255) DEFAULT NULL,
  `etat` tinyint(1) DEFAULT NULL,
  `budgetMin` int(11) DEFAULT NULL,
  `budgetMax` int(11) DEFAULT NULL,
  `surfaceMin` int(11) DEFAULT NULL,
  `surfaceMax` int(11) DEFAULT NULL,
  `nbPiecesMin` int(11) DEFAULT NULL,
  `nbPiecesMax` int(11) DEFAULT NULL,
  `remarques` text,
  `lu` tinyint(1) DEFAULT NULL,
  `dateEnvoi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `contact`
--

INSERT INTO `contact` (`id`, `civilite`, `nom`, `prenom`, `telephone`, `mail`, `typeBien`, `etat`, `budgetMin`, `budgetMax`, `surfaceMin`, `surfaceMax`, `nbPiecesMin`, `nbPiecesMax`, `remarques`, `lu`, `dateEnvoi`) VALUES
(3, 1, 'Nomtest', 'PrenomTest', '00.00.00.00.00', 'email@email.com', 'Maison', 1, 300, 600, 25, NULL, 2, NULL, 'test<br />\r\n<br />\r\ntest', 1, '2013-05-07 08:14:12');

-- --------------------------------------------------------

--
-- Structure de la table `demande_infos`
--

DROP TABLE IF EXISTS `demande_infos`;
CREATE TABLE IF NOT EXISTS `demande_infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idBien` int(11) NOT NULL,
  `civilite` tinyint(1) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `telephone` varchar(25) NOT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `commentaire` text,
  `demandeVisite` tinyint(1) DEFAULT NULL,
  `lu` tinyint(1) DEFAULT NULL,
  `dateEnvoi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idBien` (`idBien`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Contenu de la table `demande_infos`
--

INSERT INTO `demande_infos` (`id`, `idBien`, `civilite`, `nom`, `prenom`, `telephone`, `mail`, `commentaire`, `demandeVisite`, `lu`, `dateEnvoi`) VALUES
(74, 14, 1, 'NOMTEST', 'PRENOMTEST', '00.00.00.00.00', 'email@email.com', '', 0, 1, '2013-04-30 12:23:24'),
(75, 15, 1, 'NOMTEST', 'PRENOMTEST', '00.00.00.00.00', 'email@email.com', '', 0, NULL, '2013-05-16 07:37:57');

-- --------------------------------------------------------

--
-- Structure de la table `estimation`
--

DROP TABLE IF EXISTS `estimation`;
CREATE TABLE IF NOT EXISTS `estimation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeBien` varchar(30) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `nbPieces` tinyint(2) NOT NULL,
  `surface` decimal(8,2) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `codePostal` varchar(5) NOT NULL,
  `ville` varchar(30) NOT NULL,
  `description` text,
  `civilite` tinyint(1) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `telephone` varchar(25) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `commentaire` text,
  `lu` tinyint(1) NOT NULL,
  `dateEnvoi` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `estimation`
--

INSERT INTO `estimation` (`id`, `typeBien`, `etat`, `nbPieces`, `surface`, `adresse`, `codePostal`, `ville`, `description`, `civilite`, `nom`, `prenom`, `telephone`, `mail`, `commentaire`, `lu`, `dateEnvoi`) VALUES
(12, 'Maison', 1, 4, '200.00', 'rue de la Somme', '80000', 'Amiens', 'Bonjour,<br />\r\n<br />\r\nJ''aimerais mettre mon bien en vente.<br />\r\n<br />\r\nJe suis disponible pour toutes questions.<br />\r\n<br />\r\nCordialement', 1, 'NOMTEST', 'PRENOMTEST', '00.00.00.00.00', 'email@email.com', 'Bonjour,<br />\r\n<br />\r\ntest', 1, '2013-04-30 07:49:22');

-- --------------------------------------------------------

--
-- Structure de la table `fiche_recherche`
--

DROP TABLE IF EXISTS `fiche_recherche`;
CREATE TABLE IF NOT EXISTS `fiche_recherche` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mailCompte` varchar(50) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `typeAnnonce` varchar(255) DEFAULT NULL,
  `typeBien` varchar(255) DEFAULT NULL,
  `budgetMin` int(11) DEFAULT NULL,
  `budgetMax` int(11) DEFAULT NULL,
  `surfaceMin` int(11) DEFAULT NULL,
  `surfaceMax` int(11) DEFAULT NULL,
  `nbPiecesMin` int(11) DEFAULT NULL,
  `nbPiecesMax` int(11) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `investisseur` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mailCompte` (`mailCompte`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Contenu de la table `fiche_recherche`
--

INSERT INTO `fiche_recherche` (`id`, `mailCompte`, `nom`, `typeAnnonce`, `typeBien`, `budgetMin`, `budgetMax`, `surfaceMin`, `surfaceMax`, `nbPiecesMin`, `nbPiecesMax`, `ville`, `investisseur`) VALUES
(1, 'email@email.com', 'Recherche 1', 'a:2:{i:0;i:1;i:1;i:2;}', 'a:0:{}', 80000, 150000, 80, NULL, 2, 5, 'Amiens', NULL),
(3, 'email@email.com', 'Recherche 4', 'a:1:{i:0;s:1:"1";}', 'a:1:{i:0;s:1:"1";}', 50000, 150000, 50, 150, 5, 15, 'Salou&euml;l', NULL),
(19, 'email@email.com', 'Recherche 5', 'a:1:{i:0;s:1:"1";}', 'a:1:{i:0;s:1:"3";}', 200000, NULL, NULL, NULL, NULL, NULL, '', 1),
(30, 'email@email.com', 'Appartement Henriville', 'a:1:{i:0;s:1:"2";}', 'a:1:{i:0;s:1:"2";}', 300, 600, 25, NULL, NULL, NULL, 'Amiens Henriville', NULL),
(31, 'admin@test.fr', 'Recherche 1', 'a:1:{i:0;s:1:"1";}', 'a:1:{i:0;s:1:"1";}', NULL, NULL, NULL, NULL, NULL, NULL, 'Amiens', 0),
(32, 'admin@test.fr', 'Recherche 2', 'a:0:{}', 'a:0:{}', NULL, NULL, NULL, NULL, NULL, NULL, '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

DROP TABLE IF EXISTS `lieu`;
CREATE TABLE IF NOT EXISTS `lieu` (
  `adresse` varchar(255) NOT NULL,
  `coordonnees` varchar(255) NOT NULL,
  PRIMARY KEY (`adresse`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `lieu`
--

INSERT INTO `lieu` (`adresse`, `coordonnees`) VALUES
('&quot;''&quot;''&quot;''&quot;''salou&euml;l', '(49.870724,2.2478039999999737)'),
('36 rue Saint Fuscien Amiens', '(49.8853893,2.3037014000000227)'),
('44 rue du Bellay 80000 Amiens', '(49.88616220000001,2.282508699999994)'),
('50 rue du bellay amiens', '(49.8860812,2.2823547000000417)'),
('a', '(48.8693329,2.3338589999999613)'),
('abbeville', '(50.105467,1.8368330000000697)'),
('albert', '(50.001357,2.6516040000000203)'),
('allée de la Paix 80000 Amiens', '(49.9111691,2.3043718999999783)'),
('amiens', '(49.894067,2.2957529999999906)'),
('Amiens 80000', '(49.89905,2.275277200000005)'),
('amiens sud', '(49.8756267,2.2937209000000394)'),
('angle', '(50.59598,4.907709999999952)'),
('boulogne', '(50.725231,1.613334000000009)'),
('Boves', '(49.845461,2.3905449999999746)'),
('cardonnette', '(49.95188419999999,2.359818099999984)'),
('corbie', '(49.907676,2.5119469999999637)'),
('dreuil les amiens', '(49.916388,2.2262829999999667)'),
('flesselles', '(50.00312,2.2600219999999354)'),
('gare Amiens', '(49.9091524,2.2643306999999595)'),
('plachy buyon', '(49.816555,2.217495999999983)'),
('pont de metz', '(49.881692,2.2432699999999386)'),
('poulainville', '(49.947652,2.3134079999999813)'),
('route de Rouen 80000 Amiens', '(49.8849169,2.2590761999999813)'),
('rue Baudrez 80136 Rivery', '(49.9034728,2.322356799999966)'),
('rue de l''Offrande 80000 Amiens', '(49.879661,2.2802389999999377)'),
('rue de la Bailly 80480 Salouël', '(49.8686349,2.249020400000063)'),
('rue des Cordeliers 80000 Amiens', '(49.8925802,2.2950581999999713)'),
('rue Paul Eluard 80480 Salouël', '(49.8682712,2.256209600000034)'),
('rue Sagebien 80000 Amiens', '(49.87620039999999,2.29111069999999)'),
('rue Saint-Fuscien', '(49.8737426,2.3065967)'),
('sa', '(23.885942,45.079162)'),
('saint-ladre', '(49.548233,2.2714892999999847)'),
('Salou&euml;l', '(49.870724,2.2478039999999737)'),
('Salouël', '(49.870724,2.2478039999999737)'),
('Salouël 80480', '(49.870724,2.2478039999999737)'),
('saveuse', '(49.899016,2.2173290000000634)'),
('vaux-sur-somme', '(49.922755,2.5491010000000642)'),
('villers-bocage', '(49.9973699,2.3194570000000567)');

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL,
  `idBien` int(11) NOT NULL,
  `numeroImage` int(2) NOT NULL,
  `nomImage` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `publierSurInternet` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idBien` (`idBien`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `photo`
--

INSERT INTO `photo` (`id`, `idBien`, `numeroImage`, `nomImage`, `description`, `publierSurInternet`) VALUES
(0, 2, 1, '12345MC_1', 'Façade de la maison', 1),
(1, 2, 2, '12345MC_2', 'Intérieur en bois, très chaleureux', 1),
(2, 2, 3, '12345MC_3', 'Superbe intérieur', 1),
(3, 2, 4, '12345MC_4', 'à découvrir', 1),
(4, 2, 5, '12345MC_5', '', 1),
(5, 2, 6, '12345MC_6', '', 1),
(6, 2, 7, '12345MC_7', '', 1),
(7, 2, 8, '12345MC_8', '', 1),
(8, 2, 9, '12345MC_9', '', 1),
(9, 2, 10, '12345MC_10', '', 1),
(10, 2, 11, '12345MC_11', '', 1),
(11, 2, 12, '12345MC_12', '', 1),
(12, 2, 13, '12345MC_13', '', 1),
(13, 2, 14, '12345MC_14', '', 1),
(14, 2, 15, '12345MC_15', '', 1),
(15, 2, 16, '12345MC_16', '', 1),
(16, 2, 18, '12345MC_18', '', 1),
(17, 3, 1, '789GT_1', 'Photo du salon, très lumineux', 1),
(18, 3, 2, '789GT_2', 'Autre photo de la salle à manger', 0),
(19, 3, 3, '789GT_3', 'Jolie chambre 9m² avec lit double, grand espace pour votre armoire', 1),
(20, 3, 4, '789GT_4', 'photo appart', 0),
(21, 3, 5, '789GT_5', 'Façade de l''immeuble, appartement se trouve au 2e étage', 1),
(22, 4, 1, '55ds_1', 'Façade de la maison', 1),
(23, 5, 1, '57_1', 'Joli jardin 30m² cloisonné par des haies', 1),
(24, 6, 1, '87_1', 'Façade de l''immeuble, places de parking disponibles', 1),
(25, 7, 1, '44_1', 'Maison se trouve au coin de la rue', 1),
(26, 8, 1, '58742_1', 'Salon moderne', 1),
(27, 9, 1, '41T_1', 'façade maison', 1),
(28, 10, 1, '123V_1', 'superbe villa', 1);

-- --------------------------------------------------------

--
-- Structure de la table `selection_client`
--

DROP TABLE IF EXISTS `selection_client`;
CREATE TABLE IF NOT EXISTS `selection_client` (
  `mailCompte` varchar(50) NOT NULL,
  `idBien` int(11) NOT NULL,
  PRIMARY KEY (`mailCompte`,`idBien`),
  KEY `idBien` (`idBien`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `selection_client`
--

INSERT INTO `selection_client` (`mailCompte`, `idBien`) VALUES
('email@email.com', 2),
('admin@test.fr', 3),
('email@email.com', 3),
('email@email.com', 5),
('email@email.com', 12);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `demande_infos`
--
ALTER TABLE `demande_infos`
  ADD CONSTRAINT `demande_infos_ibfk_1` FOREIGN KEY (`idBien`) REFERENCES `bien` (`id`);

--
-- Contraintes pour la table `fiche_recherche`
--
ALTER TABLE `fiche_recherche`
  ADD CONSTRAINT `fiche_recherche_ibfk_1` FOREIGN KEY (`mailCompte`) REFERENCES `compte` (`mail`);

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`idBien`) REFERENCES `bien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `selection_client`
--
ALTER TABLE `selection_client`
  ADD CONSTRAINT `selection_client_ibfk_3` FOREIGN KEY (`mailCompte`) REFERENCES `compte` (`mail`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `selection_client_ibfk_4` FOREIGN KEY (`idBien`) REFERENCES `bien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
