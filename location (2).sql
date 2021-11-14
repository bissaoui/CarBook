-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  jeu. 05 mars 2020 à 01:01
-- Version du serveur :  10.3.15-MariaDB
-- Version de PHP :  7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `location`
--

-- --------------------------------------------------------

--
-- Structure de la table `Annonce`
--

CREATE TABLE `Annonce` (
  `idAn` int(11) NOT NULL,
  `titre` varchar(200) NOT NULL,
  `infoA` text NOT NULL,
  `idUser` int(11) NOT NULL,
  `idModel` int(11) NOT NULL,
  `PrixA` decimal(10,0) NOT NULL,
  `statu` char(1) DEFAULT '0',
  `image` varchar(200) DEFAULT NULL,
  `dateConstruction` year(4) NOT NULL,
  `idville` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `kilomitrage` int(11) DEFAULT NULL,
  `datePub` datetime DEFAULT NULL,
  `visitor` int(11) DEFAULT 0,
  `img` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Annonce`
--

INSERT INTO `Annonce` (`idAn`, `titre`, `infoA`, `idUser`, `idModel`, `PrixA`, `statu`, `image`, `dateConstruction`, `idville`, `email`, `telephone`, `kilomitrage`, `datePub`, `visitor`, `img`) VALUES
(45, 'renault megan', 'Ailes Ã©largies avec extraction d\'air Ã  l\'avant, boucliers spÃ©cifiques et lame F1, diffuseur arriÃ¨re fonctionnel, Ã©chappement central, teintes exclusives Orange Tonic ou Jaune Sirius... Avec ses jantes Estoril 18 pouces ou', 1, 1, '39900', '1', '89056d64b41afa81.jpg,6084cac6d88a57eb.jpg,28f5f128ca3aa474.jpg', 2020, 153, 'yassine.bissaoui@gmail.com', '0690198209', 20, '2020-03-01 22:18:45', 22, '89056d64b41afa81.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

CREATE TABLE `marque` (
  `idM` int(11) NOT NULL,
  `libelleM` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`idM`, `libelleM`) VALUES
(1, 'renault'),
(2, 'peugeot'),
(3, 'Opel'),
(4, 'Citroen'),
(5, 'Volkswagen'),
(6, 'Mercedes'),
(7, 'BMW'),
(8, 'Ford'),
(17, 'ferrari');

-- --------------------------------------------------------

--
-- Structure de la table `model`
--

CREATE TABLE `model` (
  `idModel` int(11) NOT NULL,
  `libelleMo` varchar(100) NOT NULL,
  `idM` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `model`
--

INSERT INTO `model` (`idModel`, `libelleMo`, `idM`) VALUES
(1, '19', 1),
(2, '306', 2),
(3, '406', 2),
(4, '1212', 1),
(5, '54', 1),
(6, 'xm8', 7),
(7, 'benz', 6),
(8, '460', 2),
(9, '1000RR', 7);

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `region` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`id`, `region`) VALUES
(1, 'Tanger-Tétouan-Al Hoceïma'),
(2, 'l\'Oriental'),
(3, 'Fès-Meknès'),
(4, 'Rabat-Salé-Kénitra'),
(5, 'Béni Mellal-Khénifra'),
(6, 'Casablanca-Settat'),
(7, 'Marrakech-Safi'),
(8, 'Drâa-Tafilalet'),
(9, 'Souss-Massa'),
(10, 'Guelmim-Oued Noun'),
(11, 'Laâyoune-Sakia El Hamra'),
(12, 'Dakhla-Oued Ed Dahab');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `NomRole` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `NomRole`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `adresse` varchar(200) NOT NULL,
  `idVille` int(11) NOT NULL,
  `telephone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`id`, `username`, `password`, `email`, `adresse`, `idVille`, `telephone`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '33 LOTIS  SANAA 2 LOURINI QU NAJAH EL AMIR', 1, '0637274172'),
(56, 'BISSAOUI', 'bissaoui', 'yassine.bissaoui@gmail.com', '33 LOTIS  SANAA 2 LOURINI QU NAJAH EL AMIR', 49, '0637274172');

-- --------------------------------------------------------

--
-- Structure de la table `UserEst`
--

CREATE TABLE `UserEst` (
  `idUser` int(11) NOT NULL,
  `idRole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `UserEst`
--

INSERT INTO `UserEst` (`idUser`, `idRole`) VALUES
(1, 1),
(56, 2);

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id` int(11) NOT NULL,
  `ville` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id`, `ville`, `region`) VALUES
(1, 'Aïn Harrouda', 6),
(2, 'Ben Yakhlef', 6),
(3, 'Bouskoura', 6),
(4, 'Casablanca', 6),
(5, 'Médiouna', 6),
(6, 'Mohammadia', 6),
(7, 'Tit Mellil', 6),
(8, 'Ben Yakhlef', 6),
(9, 'Bejaâd', 5),
(10, 'Ben Ahmed', 6),
(11, 'Benslimane', 6),
(12, 'Berrechid', 6),
(13, 'Boujniba', 5),
(14, 'Boulanouare', 5),
(15, 'Bouznika', 6),
(16, 'Deroua', 6),
(17, 'El Borouj', 6),
(18, 'El Gara', 6),
(19, 'Guisser', 6),
(20, 'Hattane', 5),
(21, 'Khouribga', 5),
(22, 'Loulad', 6),
(23, 'Oued Zem', 5),
(24, 'Oulad Abbou', 6),
(25, 'Oulad H\'Riz Sahel', 6),
(26, 'Oulad M\'rah', 6),
(27, 'Oulad Saïd', 6),
(28, 'Oulad Sidi Ben Daoud', 6),
(29, 'Ras El Aïn', 6),
(30, 'Settat', 6),
(31, 'Sidi Rahhal Chataï', 6),
(32, 'Soualem', 6),
(33, 'Azemmour', 6),
(34, 'Bir Jdid', 6),
(35, 'Bouguedra', 7),
(36, 'Echemmaia', 7),
(37, 'El Jadida', 6),
(38, 'Hrara', 7),
(39, 'Ighoud', 7),
(40, 'Jamâat Shaim', 7),
(41, 'Jorf Lasfar', 6),
(42, 'Khemis Zemamra', 6),
(43, 'Laaounate', 6),
(44, 'Moulay Abdallah', 6),
(45, 'Oualidia', 6),
(46, 'Oulad Amrane', 6),
(47, 'Oulad Frej', 6),
(48, 'Oulad Ghadbane', 6),
(49, 'Safi', 7),
(50, 'Sebt El Maârif', 6),
(51, 'Sebt Gzoula', 7),
(52, 'Sidi Ahmed', 7),
(53, 'Sidi Ali Ban Hamdouche', 6),
(54, 'Sidi Bennour', 6),
(55, 'Sidi Bouzid', 6),
(56, 'Sidi Smaïl', 6),
(57, 'Youssoufia', 7),
(58, 'Fès', 3),
(59, 'Aïn Cheggag', 3),
(60, 'Bhalil', 3),
(61, 'Boulemane', 3),
(62, 'El Menzel', 3),
(63, 'Guigou', 3),
(64, 'Imouzzer Kandar', 3),
(65, 'Imouzzer Marmoucha', 3),
(66, 'Missour', 3),
(67, 'Moulay Yaâcoub', 3),
(68, 'Ouled Tayeb', 3),
(69, 'Outat El Haj', 3),
(70, 'Ribate El Kheir', 3),
(71, 'Séfrou', 3),
(72, 'Skhinate', 3),
(73, 'Tafajight', 3),
(74, 'Arbaoua', 4),
(75, 'Aïn Dorij', 1),
(76, 'Dar Gueddari', 4),
(77, 'Had Kourt', 4),
(78, 'Jorf El Melha', 4),
(79, 'Kénitra', 4),
(80, 'Khenichet', 4),
(81, 'Lalla Mimouna', 4),
(82, 'Mechra Bel Ksiri', 4),
(83, 'Mehdia', 4),
(84, 'Moulay Bousselham', 4),
(85, 'Sidi Allal Tazi', 4),
(86, 'Sidi Kacem', 4),
(87, 'Sidi Slimane', 4),
(88, 'Sidi Taibi', 4),
(89, 'Sidi Yahya El Gharb', 4),
(90, 'Souk El Arbaa', 4),
(91, 'Akka', 9),
(92, 'Assa', 10),
(93, 'Bouizakarne', 10),
(94, 'El Ouatia', 10),
(95, 'Es-Semara', 11),
(96, 'Fam El Hisn', 9),
(97, 'Foum Zguid', 9),
(98, 'Guelmim', 10),
(99, 'Taghjijt', 10),
(100, 'Tan-Tan', 10),
(101, 'Tata', 9),
(102, 'Zag', 10),
(103, 'Marrakech', 7),
(104, 'Ait Daoud', 7),
(115, 'Amizmiz', 7),
(116, 'Assahrij', 7),
(117, 'Aït Ourir', 7),
(118, 'Ben Guerir', 7),
(119, 'Chichaoua', 7),
(120, 'El Hanchane', 7),
(121, 'El Kelaâ des Sraghna', 7),
(122, 'Essaouira', 7),
(123, 'Fraïta', 7),
(124, 'Ghmate', 7),
(125, 'Ighounane', 8),
(126, 'Imintanoute', 7),
(127, 'Kattara', 7),
(128, 'Lalla Takerkoust', 7),
(129, 'Loudaya', 7),
(130, 'Lâattaouia', 7),
(131, 'Moulay Brahim', 7),
(132, 'Mzouda', 7),
(133, 'Ounagha', 7),
(134, 'Sid L\'Mokhtar', 7),
(135, 'Sid Zouin', 7),
(136, 'Sidi Abdallah Ghiat', 7),
(137, 'Sidi Bou Othmane', 7),
(138, 'Sidi Rahhal', 7),
(139, 'Skhour Rehamna', 7),
(140, 'Smimou', 7),
(141, 'Tafetachte', 7),
(142, 'Tahannaout', 7),
(143, 'Talmest', 7),
(144, 'Tamallalt', 7),
(145, 'Tamanar', 7),
(146, 'Tamansourt', 7),
(147, 'Tameslouht', 7),
(148, 'Tanalt', 9),
(149, 'Zeubelemok', 7),
(150, 'Meknès‎', 3),
(151, 'Khénifra', 5),
(152, 'Agourai', 3),
(153, 'Ain Taoujdate', 3),
(154, 'MyAliCherif', 8),
(155, 'Rissani', 8),
(156, 'Amalou Ighriben', 5),
(157, 'Aoufous', 8),
(158, 'Arfoud', 8),
(159, 'Azrou', 3),
(160, 'Aïn Jemaa', 3),
(161, 'Aïn Karma', 3),
(162, 'Aïn Leuh', 3),
(163, 'Aït Boubidmane', 3),
(164, 'Aït Ishaq', 5),
(165, 'Boudnib', 8),
(166, 'Boufakrane', 3),
(167, 'Boumia', 8),
(168, 'El Hajeb', 3),
(169, 'Elkbab', 5),
(170, 'Er-Rich', 5),
(171, 'Errachidia', 8),
(172, 'Gardmit', 8),
(173, 'Goulmima', 8),
(174, 'Gourrama', 8),
(175, 'Had Bouhssoussen', 5),
(176, 'Haj Kaddour', 3),
(177, 'Ifrane', 3),
(178, 'Itzer', 8),
(179, 'Jorf', 8),
(180, 'Kehf Nsour', 5),
(181, 'Kerrouchen', 5),
(182, 'M\'haya', 3),
(183, 'M\'rirt', 5),
(184, 'Midelt', 8),
(185, 'Moulay Ali Cherif', 8),
(186, 'Moulay Bouazza', 5),
(187, 'Moulay Idriss Zerhoun', 3),
(188, 'Moussaoua', 3),
(189, 'N\'Zalat Bni Amar', 3),
(190, 'Ouaoumana', 5),
(191, 'Oued Ifrane', 3),
(192, 'Sabaa Aiyoun', 3),
(193, 'Sebt Jahjouh', 3),
(194, 'Sidi Addi', 3),
(195, 'Tichoute', 8),
(196, 'Tighassaline', 5),
(197, 'Tighza', 5),
(198, 'Timahdite', 3),
(199, 'Tinejdad', 8),
(200, 'Tizguite', 3),
(201, 'Toulal', 3),
(202, 'Tounfite', 8),
(203, 'Zaouia d\'Ifrane', 3),
(204, 'Zaïda', 8),
(205, 'Ahfir', 2),
(206, 'Aklim', 2),
(207, 'Al Aroui', 2),
(208, 'Aïn Bni Mathar', 2),
(209, 'Aïn Erreggada', 2),
(210, 'Ben Taïeb', 2),
(211, 'Berkane', 2),
(212, 'Bni Ansar', 2),
(213, 'Bni Chiker', 2),
(214, 'Bni Drar', 2),
(215, 'Bni Tadjite', 2),
(216, 'Bouanane', 2),
(217, 'Bouarfa', 2),
(218, 'Bouhdila', 2),
(219, 'Dar El Kebdani', 2),
(220, 'Debdou', 2),
(221, 'Douar Kannine', 2),
(222, 'Driouch', 2),
(223, 'El Aïoun Sidi Mellouk', 2),
(224, 'Farkhana', 2),
(225, 'Figuig', 2),
(226, 'Ihddaden', 2),
(227, 'Jaâdar', 2),
(228, 'Jerada', 2),
(229, 'Kariat Arekmane', 2),
(230, 'Kassita', 2),
(231, 'Kerouna', 2),
(232, 'Laâtamna', 2),
(233, 'Madagh', 2),
(234, 'Midar', 2),
(235, 'Nador', 2),
(236, 'Naima', 2),
(237, 'Oued Heimer', 2),
(238, 'Oujda', 2),
(239, 'Ras El Ma', 2),
(240, 'Saïdia', 2),
(241, 'Selouane', 2),
(242, 'Sidi Boubker', 2),
(243, 'Sidi Slimane Echcharaa', 2),
(244, 'Talsint', 2),
(245, 'Taourirt', 2),
(246, 'Tendrara', 2),
(247, 'Tiztoutine', 2),
(248, 'Touima', 2),
(249, 'Touissit', 2),
(250, 'Zaïo', 2),
(251, 'Zeghanghane', 2),
(252, 'Rabat', 4),
(253, 'Salé', 4),
(254, 'Ain El Aouda', 4),
(255, 'Harhoura', 4),
(256, 'Khémisset', 4),
(257, 'Oulmès', 4),
(258, 'Rommani', 4),
(259, 'Sidi Allal El Bahraoui', 4),
(260, 'Sidi Bouknadel', 4),
(261, 'Skhirate', 4),
(262, 'Tamesna', 4),
(263, 'Témara', 4),
(264, 'Tiddas', 4),
(265, 'Tiflet', 4),
(266, 'Touarga', 4),
(267, 'Agadir', 9),
(268, 'Agdz', 8),
(269, 'Agni Izimmer', 9),
(270, 'Aït Melloul', 9),
(271, 'Alnif', 8),
(272, 'Anzi', 9),
(273, 'Aoulouz', 9),
(274, 'Aourir', 9),
(275, 'Arazane', 9),
(276, 'Aït Baha', 9),
(277, 'Aït Iaâza', 9),
(278, 'Aït Yalla', 8),
(279, 'Ben Sergao', 9),
(280, 'Biougra', 9),
(281, 'Boumalne-Dadès', 8),
(282, 'Dcheira El Jihadia', 9),
(283, 'Drargua', 9),
(284, 'El Guerdane', 9),
(285, 'Harte Lyamine', 8),
(286, 'Ida Ougnidif', 9),
(287, 'Ifri', 8),
(288, 'Igdamen', 9),
(289, 'Ighil n\'Oumgoun', 8),
(290, 'Imassine', 8),
(291, 'Inezgane', 9),
(292, 'Irherm', 9),
(293, 'Kelaat-M\'Gouna', 8),
(294, 'Lakhsas', 9),
(295, 'Lakhsass', 9),
(296, 'Lqliâa', 9),
(297, 'M\'semrir', 8),
(298, 'Massa (Maroc)', 9),
(299, 'Megousse', 9),
(300, 'Ouarzazate', 8),
(301, 'Oulad Berhil', 9),
(302, 'Oulad Teïma', 9),
(303, 'Sarghine', 8),
(304, 'Sidi Ifni', 10),
(305, 'Skoura', 8),
(306, 'Tabounte', 8),
(307, 'Tafraout', 9),
(308, 'Taghzout', 1),
(309, 'Tagzen', 9),
(310, 'Taliouine', 9),
(311, 'Tamegroute', 8),
(312, 'Tamraght', 9),
(313, 'Tanoumrite Nkob Zagora', 8),
(314, 'Taourirt ait zaghar', 8),
(315, 'Taroudannt', 9),
(316, 'Temsia', 9),
(317, 'Tifnit', 9),
(318, 'Tisgdal', 9),
(319, 'Tiznit', 9),
(320, 'Toundoute', 8),
(321, 'Zagora', 8),
(322, 'Afourar', 5),
(323, 'Aghbala', 5),
(324, 'Azilal', 5),
(325, 'Aït Majden', 5),
(326, 'Beni Ayat', 5),
(327, 'Béni Mellal', 5),
(328, 'Bin elouidane', 5),
(329, 'Bradia', 5),
(330, 'Bzou', 5),
(331, 'Dar Oulad Zidouh', 5),
(332, 'Demnate', 5),
(333, 'Dra\'a', 8),
(334, 'El Ksiba', 5),
(335, 'Foum Jamaa', 5),
(336, 'Fquih Ben Salah', 5),
(337, 'Kasba Tadla', 5),
(338, 'Ouaouizeght', 5),
(339, 'Oulad Ayad', 5),
(340, 'Oulad M\'Barek', 5),
(341, 'Oulad Yaich', 5),
(342, 'Sidi Jaber', 5),
(343, 'Souk Sebt Oulad Nemma', 5),
(344, 'Zaouïat Cheikh', 5),
(345, 'Tanger‎', 1),
(346, 'Tétouan‎', 1),
(347, 'Akchour', 1),
(348, 'Assilah', 1),
(349, 'Bab Berred', 1),
(350, 'Bab Taza', 1),
(351, 'Brikcha', 1),
(352, 'Chefchaouen', 1),
(353, 'Dar Bni Karrich', 1),
(354, 'Dar Chaoui', 1),
(355, 'Fnideq', 1),
(356, 'Gueznaia', 1),
(357, 'Jebha', 1),
(358, 'Karia', 3),
(359, 'Khémis Sahel', 1),
(360, 'Ksar El Kébir', 1),
(361, 'Larache', 1),
(362, 'M\'diq', 1),
(363, 'Martil', 1),
(364, 'Moqrisset', 1),
(365, 'Oued Laou', 1),
(366, 'Oued Rmel', 1),
(367, 'Ouazzane', 1),
(368, 'Point Cires', 1),
(369, 'Sidi Lyamani', 1),
(370, 'Sidi Mohamed ben Abdallah el-Raisuni', 1),
(371, 'Zinat', 1),
(372, 'Ajdir‎', 1),
(373, 'Aknoul‎', 3),
(374, 'Al Hoceïma‎', 1),
(375, 'Aït Hichem‎', 1),
(376, 'Bni Bouayach‎', 1),
(377, 'Bni Hadifa‎', 1),
(378, 'Ghafsai‎', 3),
(379, 'Guercif‎', 2),
(380, 'Imzouren‎', 1),
(381, 'Inahnahen‎', 1),
(382, 'Issaguen (Ketama)‎', 1),
(383, 'Karia (El Jadida)‎', 6),
(384, 'Karia Ba Mohamed‎', 3),
(385, 'Oued Amlil‎', 3),
(386, 'Oulad Zbair‎', 3),
(387, 'Tahla‎', 3),
(388, 'Tala Tazegwaght‎', 1),
(389, 'Tamassint‎', 1),
(390, 'Taounate‎', 3),
(391, 'Targuist‎', 1),
(392, 'Taza‎', 3),
(393, 'Taïnaste‎', 3),
(394, 'Thar Es-Souk‎', 3),
(395, 'Tissa‎', 3),
(396, 'Tizi Ouasli‎', 3),
(397, 'Laayoune‎', 11),
(398, 'El Marsa‎', 11),
(399, 'Tarfaya‎', 11),
(400, 'Boujdour‎', 11),
(401, 'Awsard', 12),
(402, 'Oued-Eddahab', 12),
(403, 'Stehat', 1),
(404, 'Aït Attab', 5);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Annonce`
--
ALTER TABLE `Annonce`
  ADD PRIMARY KEY (`idAn`),
  ADD KEY `FkUser` (`idUser`),
  ADD KEY `FKmodel` (`idModel`),
  ADD KEY `FkVille` (`idville`);

--
-- Index pour la table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`idM`);

--
-- Index pour la table `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`idModel`),
  ADD KEY `fkMarque` (`idM`);

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NomRole` (`NomRole`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fkVillllee` (`idVille`);

--
-- Index pour la table `UserEst`
--
ALTER TABLE `UserEst`
  ADD PRIMARY KEY (`idUser`,`idRole`),
  ADD KEY `foriegnkeyRole` (`idRole`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Annonce`
--
ALTER TABLE `Annonce`
  MODIFY `idAn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pour la table `marque`
--
ALTER TABLE `marque`
  MODIFY `idM` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `model`
--
ALTER TABLE `model`
  MODIFY `idModel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=405;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Annonce`
--
ALTER TABLE `Annonce`
  ADD CONSTRAINT `FKmodel` FOREIGN KEY (`idModel`) REFERENCES `model` (`idModel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FkUser` FOREIGN KEY (`idUser`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FkVille` FOREIGN KEY (`idville`) REFERENCES `ville` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `fkMarque` FOREIGN KEY (`idM`) REFERENCES `marque` (`idM`);

--
-- Contraintes pour la table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `fkVillllee` FOREIGN KEY (`idVille`) REFERENCES `ville` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `UserEst`
--
ALTER TABLE `UserEst`
  ADD CONSTRAINT `foriegnkeyRole` FOREIGN KEY (`idRole`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foriegnkeyUser` FOREIGN KEY (`idUser`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
