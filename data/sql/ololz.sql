-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Jeu 14 Mars 2013 à 07:20
-- Version du serveur: 5.1.63
-- Version de PHP: 5.3.5-1ubuntu7.11

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `ololz`
--

-- --------------------------------------------------------

--
-- Structure de la table `champion`
--

CREATE TABLE IF NOT EXISTS `champion` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position_id` tinyint(3) unsigned DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `champion_position_id` (`position_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=112 ;

--
-- Contenu de la table `champion`
--

INSERT INTO `champion` (`id`, `position_id`, `name`, `code`) VALUES
(1, 2, 'Ahri', 'ahri'),
(2, 1, 'Akali', 'akali'),
(3, 4, 'Alistar', 'alistar'),
(4, 5, 'Amumu', 'amumu'),
(5, 2, 'Anivia', 'anivia'),
(6, 2, 'Annie', 'annie'),
(7, 3, 'Ashe', 'ashe'),
(8, 4, 'Blitzcrank', 'blitzcrank'),
(9, 2, 'Brand', 'brand'),
(10, 3, 'Caitlyn', 'caitlyn'),
(11, 2, 'Cassiopeia', 'cassiopeia'),
(12, 1, 'Cho''Gath', 'cho-gath'),
(13, 3, 'Corki', 'corki'),
(14, 1, 'Darius', 'darius'),
(15, 2, 'Diana', 'diana'),
(16, 5, 'Dr. Mundo', 'dr-mundo'),
(17, 3, 'Draven', 'draven'),
(18, 2, 'Elise', 'elise'),
(19, 2, 'Evelynn', 'evelynn'),
(20, 3, 'Ezreal', 'ezreal'),
(21, 5, 'Fiddlesticks', 'fiddlesticks'),
(22, 1, 'Fiora', 'fiora'),
(23, 2, 'Fizz', 'fizz'),
(24, 2, 'Galio', 'galio'),
(25, 1, 'Gangplank', 'gangplank'),
(26, 1, 'Garen', 'garen'),
(27, 2, 'Gragas', 'gragas'),
(28, 3, 'Graves', 'graves'),
(29, 5, 'Hecarim', 'hecarim'),
(30, 2, 'Heimerdinger', 'heimerdinger'),
(31, 1, 'Irelia', 'irelia'),
(32, 4, 'Janna', 'janna'),
(33, 5, 'Jarvan IV', 'jarvan-iv'),
(34, 1, 'Jax', 'jax'),
(35, 1, 'Jayce', 'jayce'),
(36, 4, 'Karma', 'karma'),
(37, 2, 'Karthus', 'karthus'),
(38, 2, 'Kassadin', 'kassadin'),
(39, 2, 'Katarina', 'katarina'),
(40, 1, 'Kayle', 'kayle'),
(41, 2, 'Kennen', 'kennen'),
(42, 1, 'Kha''Zix', 'kha-zix'),
(43, 3, 'Kog''Maw', 'kog-maw'),
(44, 2, 'LeBlanc', 'leblanc'),
(45, 5, 'Lee Sin', 'lee-sin'),
(46, 4, 'Leona', 'leona'),
(47, 4, 'Lulu', 'lulu'),
(48, 2, 'Lux', 'lux'),
(49, 1, 'Malphite', 'malphite'),
(50, 2, 'Malzahar', 'malzahar'),
(51, 5, 'Maokai', 'maokai'),
(52, 5, 'Master Yi', 'master-yi'),
(53, 3, 'Miss Fortune', 'miss-fortune'),
(54, 1, 'Mordekaiser', 'mordekaiser'),
(55, 2, 'Morgana', 'morgana'),
(56, 4, 'Nami', 'nami'),
(57, 1, 'Nasus', 'nasus'),
(58, 5, 'Nautilus', 'nautilus'),
(59, 1, 'Nidalee', 'nidalee'),
(60, 5, 'Nocturne', 'nocturne'),
(61, 4, 'Nunu', 'nunu'),
(62, 1, 'Olaf', 'olaf'),
(63, 2, 'Orianna', 'orianna'),
(64, 1, 'Pantheon', 'pantheon'),
(65, 1, 'Poppy', 'poppy'),
(66, 1, 'Quinn', 'quinn'),
(67, 5, 'Rammus', 'rammus'),
(68, 1, 'Renekton', 'renekton'),
(69, 5, 'Rengar', 'rengar'),
(70, 1, 'Riven', 'riven'),
(71, 1, 'Rumble', 'rumble'),
(72, 2, 'Ryze', 'ryze'),
(73, 5, 'Sejuani', 'sejuani'),
(74, 5, 'Shaco', 'shaco'),
(75, 1, 'Shen', 'shen'),
(76, 5, 'Shyvana', 'shyvana'),
(77, 1, 'Singed', 'singed'),
(78, 2, 'Sion', 'sion'),
(79, 3, 'Sivir', 'sivir'),
(80, 5, 'Skarner', 'skarner'),
(81, 4, 'Sona', 'sona'),
(82, 4, 'Soraka', 'soraka'),
(83, 2, 'Swain', 'swain'),
(84, 2, 'Syndra', 'syndra'),
(85, 1, 'Talon', 'talon'),
(86, 4, 'Taric', 'taric'),
(87, 1, 'Teemo', 'teemo'),
(88, 4, 'Thresh', 'thresh'),
(89, 3, 'Tristana', 'tristana'),
(90, 5, 'Trundle', 'trundle'),
(91, 1, 'Tryndamere', 'tryndamere'),
(92, 2, 'Twisted Fate', 'twisted-fate'),
(93, 3, 'Twitch', 'twitch'),
(94, 5, 'Udyr', 'udyr'),
(95, 3, 'Urgot', 'urgot'),
(96, 3, 'Varus', 'varus'),
(97, 3, 'Vayne', 'vayne'),
(98, 2, 'Veigar', 'veigar'),
(99, 1, 'Vi', 'vi'),
(100, 2, 'Viktor', 'viktor'),
(101, 2, 'Vladimir', 'vladimir'),
(102, 1, 'Volibear', 'volibear'),
(103, 5, 'Warwick', 'warwick'),
(104, 1, 'Wukong', 'wukong'),
(105, 2, 'Xerath', 'xerath'),
(106, 5, 'Xin Zhao', 'xin-zhao'),
(107, 1, 'Yorick', 'yorick'),
(108, 1, 'Zed', 'zed'),
(109, 2, 'Ziggs', 'ziggs'),
(110, 2, 'Zilean', 'zilean'),
(111, 2, 'Zyra', 'zyra');

-- --------------------------------------------------------

--
-- Structure de la table `invocation`
--

CREATE TABLE IF NOT EXISTS `invocation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `summoner_id` int(10) unsigned NOT NULL,
  `champion_id` int(10) unsigned NOT NULL,
  `match_team_id` int(10) unsigned NOT NULL,
  `position_id` tinyint(3) unsigned DEFAULT NULL,
  `kills` smallint(5) unsigned DEFAULT NULL,
  `deaths` smallint(5) unsigned DEFAULT NULL,
  `assists` smallint(5) unsigned DEFAULT NULL,
  `gold` float unsigned DEFAULT NULL,
  `minions` smallint(5) unsigned DEFAULT NULL,
  `damage_dealt` float unsigned DEFAULT NULL,
  `damage_received` float unsigned DEFAULT NULL,
  `healing_done` float unsigned DEFAULT NULL,
  `largest_multi_kill` tinyint(3) unsigned DEFAULT NULL,
  `time_spent_dead` smallint(5) unsigned DEFAULT NULL,
  `turrets_destroyed` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invocation_champion_id` (`champion_id`),
  KEY `invocation_summoner_id` (`summoner_id`),
  KEY `invocation_position_id` (`position_id`),
  KEY `invocation_match_team_id` (`match_team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `invocation`
--


-- --------------------------------------------------------

--
-- Structure de la table `invocation_item`
--

CREATE TABLE IF NOT EXISTS `invocation_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invocation_id` int(10) unsigned NOT NULL,
  `item_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `invocation_item_invocation_id` (`invocation_id`),
  KEY `invocation_item_item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `invocation_item`
--


-- --------------------------------------------------------

--
-- Structure de la table `invocation_spell`
--

CREATE TABLE IF NOT EXISTS `invocation_spell` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invocation_id` int(10) unsigned NOT NULL,
  `spell_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invocation_id_spell_id` (`invocation_id`,`spell_id`),
  KEY `invocation_spell_invocation_id` (`invocation_id`),
  KEY `invocation_spell_spell_id` (`spell_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `invocation_spell`
--


-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `code` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=193 ;

--
-- Contenu de la table `item`
--

INSERT INTO `item` (`id`, `name`, `code`) VALUES
(1, 'Abyssal Scepter', 'abyssal-scepter'),
(2, 'Aegis of the Legion', 'aegis-of-the-legion'),
(3, 'Amplifying Tome', 'amplifying-tome'),
(4, 'Archangel''s Staff', 'archangel-s-staff'),
(5, 'Athene''s Unholy Grail', 'athene-s-unholy-grail'),
(6, 'Atma''s Impaler', 'atma-s-impaler'),
(7, 'Augment: Death', 'augment-death'),
(8, 'Augment: Gravity', 'augment-gravity'),
(9, 'Augment: Power', 'augment-power'),
(10, 'Avarice Blade', 'avarice-blade'),
(11, 'B. F. Sword', 'b-f-sword'),
(12, 'Banner of Command', 'banner-of-command'),
(13, 'Banshee''s Veil', 'banshee-s-veil'),
(14, 'Berserker''s Greaves', 'berserker-s-greaves'),
(15, 'Berserker''s Greaves - Alacrity', 'berserker-s-greaves-alacrity'),
(16, 'Berserker''s Greaves - Captain', 'berserker-s-greaves-captain'),
(17, 'Berserker''s Greaves - Distortion', 'berserker-s-greaves-distortion'),
(18, 'Berserker''s Greaves - Furor', 'berserker-s-greaves-furor'),
(19, 'Berserker''s Greaves - Homeguard', 'berserker-s-greaves-homeguard'),
(20, 'Bilgewater Cutlass', 'bilgewater-cutlass'),
(21, 'Blackfire Torch', 'blackfire-torch'),
(22, 'Blade of the Ruined King', 'blade-of-the-ruined-king'),
(23, 'Blasting Wand', 'blasting-wand'),
(24, 'Bonetooth Necklace', 'bonetooth-necklace'),
(25, 'Boots of Mobility', 'boots-of-mobility'),
(26, 'Boots of Mobility - Alacrity', 'boots-of-mobility-alacrity'),
(27, 'Boots of Mobility - Captain', 'boots-of-mobility-captain'),
(28, 'Boots of Mobility - Distortion', 'boots-of-mobility-distortion'),
(29, 'Boots of Mobility - Furor', 'boots-of-mobility-furor'),
(30, 'Boots of Mobility - Homeguard', 'boots-of-mobility-homeguard'),
(31, 'Boots of Speed', 'boots-of-speed'),
(32, 'Boots of Swiftness', 'boots-of-swiftness'),
(33, 'Boots of Swiftness - Alacrity', 'boots-of-swiftness-alacrity'),
(34, 'Boots of Swiftness - Captain', 'boots-of-swiftness-captain'),
(35, 'Boots of Swiftness - Distortion', 'boots-of-swiftness-distortion'),
(36, 'Boots of Swiftness - Furor', 'boots-of-swiftness-furor'),
(37, 'Boots of Swiftness - Homeguard', 'boots-of-swiftness-homeguard'),
(38, 'Brawler''s Gloves', 'brawler-s-gloves'),
(39, 'Catalyst the Protector', 'catalyst-the-protector'),
(40, 'Chain Vest', 'chain-vest'),
(41, 'Chalice of Harmony', 'chalice-of-harmony'),
(42, 'Cloak of Agility', 'cloak-of-agility'),
(43, 'Cloth Armor', 'cloth-armor'),
(44, 'Crystalline Flask', 'crystalline-flask'),
(45, 'Dagger', 'dagger'),
(46, 'Deathfire Grasp', 'deathfire-grasp'),
(47, 'Doran''s Blade', 'doran-s-blade'),
(48, 'Doran''s Ring', 'doran-s-ring'),
(49, 'Doran''s Shield', 'doran-s-shield'),
(50, 'Eleisa''s Miracle', 'eleisa-s-miracle'),
(51, 'Elixir of Brilliance', 'elixir-of-brilliance'),
(52, 'Elixir of Fortitude', 'elixir-of-fortitude'),
(53, 'Emblem of Valor', 'emblem-of-valor'),
(54, 'Entropy', 'entropy'),
(55, 'Executioner''s Calling', 'executioner-s-calling'),
(56, 'Explorer''s Ward', 'explorer-s-ward'),
(57, 'Faerie Charm', 'faerie-charm'),
(58, 'Fiendish Codex', 'fiendish-codex'),
(59, 'Frozen Heart', 'frozen-heart'),
(60, 'Frozen Mallet', 'frozen-mallet'),
(61, 'Giant''s Belt', 'giant-s-belt'),
(62, 'Glacial Shroud', 'glacial-shroud'),
(63, 'Grez''s Spectral Lantern', 'grez-s-spectral-lantern'),
(64, 'Guardian Angel', 'guardian-angel'),
(65, 'Guinsoo''s Rageblade', 'guinsoo-s-rageblade'),
(66, 'Haunting Guise', 'haunting-guise'),
(67, 'Health Potion', 'health-potion'),
(68, 'Hexdrinker', 'hexdrinker'),
(69, 'Hextech Gunblade', 'hextech-gunblade'),
(70, 'Hextech Revolver', 'hextech-revolver'),
(71, 'Hextech Sweeper', 'hextech-sweeper'),
(72, 'Hunter''s Machete', 'hunter-s-machete'),
(73, 'Iceborn Gauntlet', 'iceborn-gauntlet'),
(74, 'Ichor of Illumination', 'ichor-of-illumination'),
(75, 'Ichor of Rage', 'ichor-of-rage'),
(76, 'Infinity Edge', 'infinity-edge'),
(77, 'Ionian Boots of Lucidity', 'ionian-boots-of-lucidity'),
(78, 'Ionian Boots of Lucidity - Alacrity', 'ionian-boots-of-lucidity-alacrity'),
(79, 'Ionian Boots of Lucidity - Captain', 'ionian-boots-of-lucidity-captain'),
(80, 'Ionian Boots of Lucidity - Distortion', 'ionian-boots-of-lucidity-distortion'),
(81, 'Ionian Boots of Lucidity - Furor', 'ionian-boots-of-lucidity-furor'),
(82, 'Ionian Boots of Lucidity - Homeguard', 'ionian-boots-of-lucidity-homeguard'),
(83, 'Kage''s Lucky Pick', 'kage-s-lucky-pick'),
(84, 'Kindlegem', 'kindlegem'),
(85, 'Kitae''s Bloodrazor', 'kitae-s-bloodrazor'),
(86, 'Last Whisper', 'last-whisper'),
(87, 'Liandry''s Torment', 'liandry-s-torment'),
(88, 'Lich Bane', 'lich-bane'),
(89, 'Locket of the Iron Solari', 'locket-of-the-iron-solari'),
(90, 'Long Sword', 'long-sword'),
(91, 'Lord Van Damm''s Pillager', 'lord-van-damm-s-pillager'),
(92, 'Madred''s Razors', 'madred-s-razors'),
(93, 'Malady', 'malady'),
(94, 'Mana Manipulator', 'mana-manipulator'),
(95, 'Mana Potion', 'mana-potion'),
(96, 'Manamune', 'manamune'),
(97, 'Maw of Malmortius', 'maw-of-malmortius'),
(98, 'Mejai''s Soulstealer', 'mejai-s-soulstealer'),
(99, 'Mercurial Scimitar', 'mercurial-scimitar'),
(100, 'Mercury''s Treads', 'mercury-s-treads'),
(101, 'Mercury''s Treads - Alacrity', 'mercury-s-treads-alacrity'),
(102, 'Mercury''s Treads - Captain', 'mercury-s-treads-captain'),
(103, 'Mercury''s Treads - Distortion', 'mercury-s-treads-distortion'),
(104, 'Mercury''s Treads - Furor', 'mercury-s-treads-furor'),
(105, 'Mercury''s Treads - Homeguard', 'mercury-s-treads-homeguard'),
(106, 'Mikael''s Crucible', 'mikael-s-crucible'),
(107, 'Morellonomicon', 'morellonomicon'),
(108, 'Muramana', 'muramana'),
(109, 'Nashor''s Tooth', 'nashor-s-tooth'),
(110, 'Needlessly Large Rod', 'needlessly-large-rod'),
(111, 'Negatron Cloak', 'negatron-cloak'),
(112, 'Ninja Tabi', 'ninja-tabi'),
(113, 'Ninja Tabi - Alacrity', 'ninja-tabi-alacrity'),
(114, 'Ninja Tabi - Captain', 'ninja-tabi-captain'),
(115, 'Ninja Tabi - Distortion', 'ninja-tabi-distortion'),
(116, 'Ninja Tabi - Furor', 'ninja-tabi-furor'),
(117, 'Ninja Tabi - Homeguard', 'ninja-tabi-homeguard'),
(118, 'Null-Magic Mantle', 'null-magic-mantle'),
(119, 'Odyn''s Veil', 'odyn-s-veil'),
(120, 'Ohmwrecker', 'ohmwrecker'),
(121, 'Oracle''s Elixir', 'oracle-s-elixir'),
(122, 'Oracle''s Extract', 'oracle-s-extract'),
(123, 'Overlord''s Bloodmail', 'overlord-s-bloodmail'),
(124, 'Phage', 'phage'),
(125, 'Phantom Dancer', 'phantom-dancer'),
(126, 'Philosopher''s Stone', 'philosopher-s-stone'),
(127, 'Pickaxe', 'pickaxe'),
(128, 'Prospector''s Blade', 'prospector-s-blade'),
(129, 'Prospector''s Ring', 'prospector-s-ring'),
(130, 'Quicksilver Sash', 'quicksilver-sash'),
(131, 'Rabadon''s Deathcap', 'rabadon-s-deathcap'),
(132, 'Randuin''s Omen', 'randuin-s-omen'),
(133, 'Ravenous Hydra', 'ravenous-hydra'),
(134, 'Recurve Bow', 'recurve-bow'),
(135, 'Rejuvenation Bead', 'rejuvenation-bead'),
(136, 'Rod of Ages', 'rod-of-ages'),
(137, 'Ruby Crystal', 'ruby-crystal'),
(138, 'Ruby Sightstone', 'ruby-sightstone'),
(139, 'Runaan''s Hurricane', 'runaan-s-hurricane'),
(140, 'Runic Bulwark', 'runic-bulwark'),
(141, 'Rylai''s Crystal Scepter', 'rylai-s-crystal-scepter'),
(142, 'Sanguine Blade', 'sanguine-blade'),
(143, 'Sapphire Crystal', 'sapphire-crystal'),
(144, 'Seeker''s Armguard', 'seeker-s-armguard'),
(145, 'Seraph''s Embrace', 'seraph-s-embrace'),
(146, 'Shard of True Ice', 'shard-of-true-ice'),
(147, 'Sheen', 'sheen'),
(148, 'Shurelya''s Reverie', 'shurelya-s-reverie'),
(149, 'Sight Ward', 'sight-ward'),
(150, 'Sightstone', 'sightstone'),
(151, 'Sorcerer''s Shoes', 'sorcerer-s-shoes'),
(152, 'Sorcerer''s Shoes - Alacrity', 'sorcerer-s-shoes-alacrity'),
(153, 'Sorcerer''s Shoes - Captain', 'sorcerer-s-shoes-captain'),
(154, 'Sorcerer''s Shoes - Distortion', 'sorcerer-s-shoes-distortion'),
(155, 'Sorcerer''s Shoes - Furor', 'sorcerer-s-shoes-furor'),
(156, 'Sorcerer''s Shoes - Homeguard', 'sorcerer-s-shoes-homeguard'),
(157, 'Spirit of the Ancient Golem', 'spirit-of-the-ancient-golem'),
(158, 'Spirit of the Elder Lizard', 'spirit-of-the-elder-lizard'),
(159, 'Spirit of the Spectral Wraith', 'spirit-of-the-spectral-wraith'),
(160, 'Spirit Stone', 'spirit-stone'),
(161, 'Spirit Visage', 'spirit-visage'),
(162, 'Statikk Shiv', 'statikk-shiv'),
(163, 'Stinger', 'stinger'),
(164, 'Sunfire Cape', 'sunfire-cape'),
(165, 'Sword of the Divine', 'sword-of-the-divine'),
(166, 'Sword of the Occult', 'sword-of-the-occult'),
(167, 'Tear of the Goddess', 'tear-of-the-goddess'),
(168, 'The Black Cleaver', 'the-black-cleaver'),
(169, 'The Bloodthirster', 'the-bloodthirster'),
(170, 'The Brutalizer', 'the-brutalizer'),
(171, 'The Hex Core', 'the-hex-core'),
(172, 'The Lightbringer', 'the-lightbringer'),
(173, 'Thornmail', 'thornmail'),
(174, 'Tiamat', 'tiamat'),
(175, 'Total Biscuit of Rejuvenation', 'total-biscuit-of-rejuvenation'),
(176, 'Trinity Force', 'trinity-force'),
(177, 'Twin Shadows', 'twin-shadows'),
(178, 'Vampiric Scepter', 'vampiric-scepter'),
(179, 'Vision Ward', 'vision-ward'),
(180, 'Void Staff', 'void-staff'),
(181, 'Warden''s Mail', 'warden-s-mail'),
(182, 'Warmog''s Armor', 'warmog-s-armor'),
(183, 'Wicked Hatchet', 'wicked-hatchet'),
(184, 'Will of the Ancients', 'will-of-the-ancients'),
(185, 'Wit''s End', 'wit-s-end'),
(186, 'Wooglet''s Witchcap', 'wooglet-s-witchcap'),
(187, 'Wriggle''s Lantern', 'wriggle-s-lantern'),
(188, 'Youmuu''s Ghostblade', 'youmuu-s-ghostblade'),
(189, 'Zeal', 'zeal'),
(190, 'Zeke''s Herald', 'zeke-s-herald'),
(191, 'Zephyr', 'zephyr'),
(192, 'Zhonya''s Hourglass', 'zhonya-s-hourglass');

-- --------------------------------------------------------

--
-- Structure de la table `map`
--

CREATE TABLE IF NOT EXISTS `map` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `map`
--

INSERT INTO `map` (`id`, `name`, `code`) VALUES
(1, 'Crystal Scar', 'crystal-scar'),
(2, 'Proving Grounds', 'proving-grounds'),
(3, 'Summoner''s Rift', 'summoner-s-rift'),
(4, 'Twisted Treeline', 'twisted-treeline');

-- --------------------------------------------------------

--
-- Structure de la table `mapping`
--

CREATE TABLE IF NOT EXISTS `mapping` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source_id` tinyint(3) unsigned NOT NULL,
  `type` enum('champion','item','map','match_type','position','spell','summoner') NOT NULL,
  `column` enum('id','code') NOT NULL DEFAULT 'id',
  `ours` int(10) unsigned NOT NULL,
  `theirs` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `source_type_theirs` (`source_id`,`type`,`theirs`,`column`),
  UNIQUE KEY `source_type_ours` (`source_id`,`type`,`ours`,`column`),
  KEY `mapping_source_id` (`source_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=478 ;

--
-- Contenu de la table `mapping`
--

INSERT INTO `mapping` (`id`, `source_id`, `type`, `column`, `ours`, `theirs`) VALUES
(1, 1, 'position', 'code', 1, 'Top Lane'),
(2, 1, 'position', 'code', 2, 'Middle Lane'),
(3, 1, 'position', 'code', 3, 'AD Carry'),
(4, 1, 'position', 'code', 4, 'Support'),
(5, 1, 'position', 'code', 5, 'Jungler'),
(6, 1, 'match_type', 'code', 1, 'Normal 5v5'),
(7, 1, 'match_type', 'code', 2, 'Ranked Solo 5v5'),
(8, 1, 'match_type', 'code', 3, 'Ranked Team 5v5'),
(9, 1, 'match_type', 'code', 4, 'Normal 3v3'),
(10, 1, 'match_type', 'code', 5, 'Ranked Team 3v3'),
(11, 1, 'match_type', 'code', 6, 'Custom'),
(12, 1, 'match_type', 'code', 7, 'Proving Grounds'),
(13, 1, 'match_type', 'code', 8, 'Dominion'),
(14, 1, 'match_type', 'code', 9, 'Co-Op Vs AI'),
(15, 1, 'match_type', 'code', 10, 'Co-Op Vs AI 3v3'),
(16, 1, 'spell', 'id', 1, '21'),
(17, 1, 'spell', 'id', 2, '2'),
(18, 1, 'spell', 'id', 3, '13'),
(19, 1, 'spell', 'id', 4, '1'),
(20, 1, 'spell', 'id', 5, '3'),
(21, 1, 'spell', 'id', 6, '4'),
(22, 1, 'spell', 'id', 8, '17'),
(23, 1, 'spell', 'id', 9, '6'),
(24, 1, 'spell', 'id', 10, '7'),
(25, 1, 'spell', 'id', 11, '14'),
(26, 1, 'spell', 'id', 12, '20'),
(27, 1, 'spell', 'id', 14, '10'),
(28, 1, 'spell', 'id', 15, '11'),
(29, 1, 'spell', 'id', 16, '16'),
(30, 1, 'spell', 'id', 17, '12'),
(31, 2, 'spell', 'id', 1, '17'),
(32, 2, 'spell', 'code', 1, 'barrier'),
(33, 2, 'spell', 'id', 2, '13'),
(34, 2, 'spell', 'code', 2, 'clairvoyance'),
(35, 2, 'spell', 'id', 3, '9'),
(36, 2, 'spell', 'code', 3, 'clarity'),
(37, 2, 'spell', 'id', 4, '7'),
(38, 2, 'spell', 'code', 4, 'cleanse'),
(39, 2, 'spell', 'id', 5, '1'),
(40, 2, 'spell', 'code', 5, 'exhaust'),
(41, 2, 'spell', 'id', 6, '14'),
(42, 2, 'spell', 'code', 6, 'flash'),
(43, 2, 'spell', 'id', 7, '8'),
(44, 2, 'spell', 'code', 7, 'fortify'),
(45, 2, 'spell', 'id', 8, '15'),
(46, 2, 'spell', 'code', 8, 'garrison'),
(47, 2, 'spell', 'id', 9, '2'),
(48, 2, 'spell', 'code', 9, 'ghost'),
(49, 2, 'spell', 'id', 10, '3'),
(50, 2, 'spell', 'code', 10, 'heal'),
(51, 2, 'spell', 'id', 11, '11'),
(52, 2, 'spell', 'code', 11, 'ignite'),
(53, 2, 'spell', 'id', 12, '10'),
(54, 2, 'spell', 'code', 12, 'promote'),
(55, 2, 'spell', 'id', 13, '12'),
(56, 2, 'spell', 'code', 13, 'rally'),
(57, 2, 'spell', 'id', 14, '4'),
(58, 2, 'spell', 'code', 14, 'revive'),
(59, 2, 'spell', 'id', 15, '5'),
(60, 2, 'spell', 'code', 15, 'smite'),
(61, 2, 'spell', 'id', 16, '16'),
(62, 2, 'spell', 'code', 16, 'surge'),
(63, 2, 'spell', 'id', 17, '6'),
(64, 2, 'spell', 'code', 17, 'teleport'),
(65, 1, 'champion', 'id', 1, '103'),
(66, 1, 'champion', 'code', 1, 'ahri'),
(67, 1, 'champion', 'id', 2, '84'),
(68, 1, 'champion', 'code', 2, 'akali'),
(69, 1, 'champion', 'id', 3, '12'),
(70, 1, 'champion', 'code', 3, 'alistar'),
(71, 1, 'champion', 'id', 4, '32'),
(72, 1, 'champion', 'code', 4, 'amumu'),
(73, 1, 'champion', 'id', 5, '34'),
(74, 1, 'champion', 'code', 5, 'anivia'),
(75, 1, 'champion', 'id', 6, '1'),
(76, 1, 'champion', 'code', 6, 'annie'),
(77, 1, 'champion', 'id', 7, '22'),
(78, 1, 'champion', 'code', 7, 'ashe'),
(79, 1, 'champion', 'id', 8, '53'),
(80, 1, 'champion', 'code', 8, 'blitzcrank'),
(81, 1, 'champion', 'id', 9, '63'),
(82, 1, 'champion', 'code', 9, 'brand'),
(83, 1, 'champion', 'id', 10, '51'),
(84, 1, 'champion', 'code', 10, 'caitlyn'),
(85, 1, 'champion', 'id', 11, '69'),
(86, 1, 'champion', 'code', 11, 'cassiopeia'),
(87, 1, 'champion', 'id', 12, '31'),
(88, 1, 'champion', 'code', 12, 'chogath'),
(89, 1, 'champion', 'id', 13, '42'),
(90, 1, 'champion', 'code', 13, 'corki'),
(91, 1, 'champion', 'id', 14, '122'),
(92, 1, 'champion', 'code', 14, 'darius'),
(93, 1, 'champion', 'id', 15, '131'),
(94, 1, 'champion', 'code', 15, 'diana'),
(95, 1, 'champion', 'id', 16, '36'),
(96, 1, 'champion', 'code', 16, 'drmundo'),
(97, 1, 'champion', 'id', 17, '119'),
(98, 1, 'champion', 'code', 17, 'draven'),
(99, 1, 'champion', 'id', 18, '60'),
(100, 1, 'champion', 'code', 18, 'elise'),
(101, 1, 'champion', 'id', 19, '28'),
(102, 1, 'champion', 'code', 19, 'evelynn'),
(103, 1, 'champion', 'id', 20, '81'),
(104, 1, 'champion', 'code', 20, 'ezreal'),
(105, 1, 'champion', 'id', 21, '9'),
(106, 1, 'champion', 'code', 21, 'fiddlesticks'),
(107, 1, 'champion', 'id', 22, '114'),
(108, 1, 'champion', 'code', 22, 'fiora'),
(109, 1, 'champion', 'id', 23, '105'),
(110, 1, 'champion', 'code', 23, 'fizz'),
(111, 1, 'champion', 'id', 24, '3'),
(112, 1, 'champion', 'code', 24, 'galio'),
(113, 1, 'champion', 'id', 25, '41'),
(114, 1, 'champion', 'code', 25, 'gangplank'),
(115, 1, 'champion', 'id', 26, '86'),
(116, 1, 'champion', 'code', 26, 'garen'),
(117, 1, 'champion', 'id', 27, '79'),
(118, 1, 'champion', 'code', 27, 'gragas'),
(119, 1, 'champion', 'id', 28, '104'),
(120, 1, 'champion', 'code', 28, 'graves'),
(121, 1, 'champion', 'id', 29, '120'),
(122, 1, 'champion', 'code', 29, 'hecarim'),
(123, 1, 'champion', 'id', 30, '74'),
(124, 1, 'champion', 'code', 30, 'heimerdinger'),
(125, 1, 'champion', 'id', 31, '39'),
(126, 1, 'champion', 'code', 31, 'irelia'),
(127, 1, 'champion', 'id', 32, '40'),
(128, 1, 'champion', 'code', 32, 'janna'),
(129, 1, 'champion', 'id', 33, '59'),
(130, 1, 'champion', 'code', 33, 'jarvaniv'),
(131, 1, 'champion', 'id', 34, '24'),
(132, 1, 'champion', 'code', 34, 'jax'),
(133, 1, 'champion', 'id', 35, '126'),
(134, 1, 'champion', 'code', 35, 'jayce'),
(135, 1, 'champion', 'id', 36, '43'),
(136, 1, 'champion', 'code', 36, 'karma'),
(137, 1, 'champion', 'id', 37, '30'),
(138, 1, 'champion', 'code', 37, 'karthus'),
(139, 1, 'champion', 'id', 38, '38'),
(140, 1, 'champion', 'code', 38, 'kassadin'),
(141, 1, 'champion', 'id', 39, '55'),
(142, 1, 'champion', 'code', 39, 'katarina'),
(143, 1, 'champion', 'id', 40, '10'),
(144, 1, 'champion', 'code', 40, 'kayle'),
(145, 1, 'champion', 'id', 41, '85'),
(146, 1, 'champion', 'code', 41, 'kennen'),
(147, 1, 'champion', 'id', 42, '121'),
(148, 1, 'champion', 'code', 42, 'khazix'),
(149, 1, 'champion', 'id', 43, '96'),
(150, 1, 'champion', 'code', 43, 'kogmaw'),
(151, 1, 'champion', 'id', 44, '7'),
(152, 1, 'champion', 'code', 44, 'leblanc'),
(153, 1, 'champion', 'id', 45, '64'),
(154, 1, 'champion', 'code', 45, 'leesin'),
(155, 1, 'champion', 'id', 46, '89'),
(156, 1, 'champion', 'code', 46, 'leona'),
(157, 1, 'champion', 'id', 47, '117'),
(158, 1, 'champion', 'code', 47, 'lulu'),
(159, 1, 'champion', 'id', 48, '99'),
(160, 1, 'champion', 'code', 48, 'lux'),
(161, 1, 'champion', 'id', 49, '54'),
(162, 1, 'champion', 'code', 49, 'malphite'),
(163, 1, 'champion', 'id', 50, '90'),
(164, 1, 'champion', 'code', 50, 'malzahar'),
(165, 1, 'champion', 'id', 51, '57'),
(166, 1, 'champion', 'code', 51, 'maokai'),
(167, 1, 'champion', 'id', 52, '11'),
(168, 1, 'champion', 'code', 52, 'masteryi'),
(169, 1, 'champion', 'id', 53, '21'),
(170, 1, 'champion', 'code', 53, 'missfortune'),
(171, 1, 'champion', 'id', 54, '82'),
(172, 1, 'champion', 'code', 54, 'mordekaiser'),
(173, 1, 'champion', 'id', 55, '25'),
(174, 1, 'champion', 'code', 55, 'morgana'),
(175, 1, 'champion', 'id', 56, '267'),
(176, 1, 'champion', 'code', 56, 'nami'),
(177, 1, 'champion', 'id', 57, '75'),
(178, 1, 'champion', 'code', 57, 'nasus'),
(179, 1, 'champion', 'id', 58, '111'),
(180, 1, 'champion', 'code', 58, 'nautilus'),
(181, 1, 'champion', 'id', 59, '76'),
(182, 1, 'champion', 'code', 59, 'nidalee'),
(183, 1, 'champion', 'id', 60, '56'),
(184, 1, 'champion', 'code', 60, 'nocturne'),
(185, 1, 'champion', 'id', 61, '20'),
(186, 1, 'champion', 'code', 61, 'nunu'),
(187, 1, 'champion', 'id', 62, '2'),
(188, 1, 'champion', 'code', 62, 'olaf'),
(189, 1, 'champion', 'id', 63, '61'),
(190, 1, 'champion', 'code', 63, 'orianna'),
(191, 1, 'champion', 'id', 64, '80'),
(192, 1, 'champion', 'code', 64, 'pantheon'),
(193, 1, 'champion', 'id', 65, '78'),
(194, 1, 'champion', 'code', 65, 'poppy'),
(195, 1, 'champion', 'id', 66, '133'),
(196, 1, 'champion', 'code', 66, 'quinn'),
(197, 1, 'champion', 'id', 67, '33'),
(198, 1, 'champion', 'code', 67, 'rammus'),
(199, 1, 'champion', 'id', 68, '58'),
(200, 1, 'champion', 'code', 68, 'renekton'),
(201, 1, 'champion', 'id', 69, '107'),
(202, 1, 'champion', 'code', 69, 'rengar'),
(203, 1, 'champion', 'id', 70, '92'),
(204, 1, 'champion', 'code', 70, 'riven'),
(205, 1, 'champion', 'id', 71, '68'),
(206, 1, 'champion', 'code', 71, 'rumble'),
(207, 1, 'champion', 'id', 72, '13'),
(208, 1, 'champion', 'code', 72, 'ryze'),
(209, 1, 'champion', 'id', 73, '113'),
(210, 1, 'champion', 'code', 73, 'sejuani'),
(211, 1, 'champion', 'id', 74, '35'),
(212, 1, 'champion', 'code', 74, 'shaco'),
(213, 1, 'champion', 'id', 75, '98'),
(214, 1, 'champion', 'code', 75, 'shen'),
(215, 1, 'champion', 'id', 76, '102'),
(216, 1, 'champion', 'code', 76, 'shyvana'),
(217, 1, 'champion', 'id', 77, '27'),
(218, 1, 'champion', 'code', 77, 'singed'),
(219, 1, 'champion', 'id', 78, '14'),
(220, 1, 'champion', 'code', 78, 'sion'),
(221, 1, 'champion', 'id', 79, '15'),
(222, 1, 'champion', 'code', 79, 'sivir'),
(223, 1, 'champion', 'id', 80, '72'),
(224, 1, 'champion', 'code', 80, 'skarner'),
(225, 1, 'champion', 'id', 81, '37'),
(226, 1, 'champion', 'code', 81, 'sona'),
(227, 1, 'champion', 'id', 82, '16'),
(228, 1, 'champion', 'code', 82, 'soraka'),
(229, 1, 'champion', 'id', 83, '50'),
(230, 1, 'champion', 'code', 83, 'swain'),
(231, 1, 'champion', 'id', 84, '134'),
(232, 1, 'champion', 'code', 84, 'syndra'),
(233, 1, 'champion', 'id', 85, '91'),
(234, 1, 'champion', 'code', 85, 'talon'),
(235, 1, 'champion', 'id', 86, '44'),
(236, 1, 'champion', 'code', 86, 'taric'),
(237, 1, 'champion', 'id', 87, '17'),
(238, 1, 'champion', 'code', 87, 'teemo'),
(239, 1, 'champion', 'id', 88, '412'),
(240, 1, 'champion', 'code', 88, 'thresh'),
(241, 1, 'champion', 'id', 89, '18'),
(242, 1, 'champion', 'code', 89, 'tristana'),
(243, 1, 'champion', 'id', 90, '48'),
(244, 1, 'champion', 'code', 90, 'trundle'),
(245, 1, 'champion', 'id', 91, '23'),
(246, 1, 'champion', 'code', 91, 'tryndamere'),
(247, 1, 'champion', 'id', 92, '4'),
(248, 1, 'champion', 'code', 92, 'twistedfate'),
(249, 1, 'champion', 'id', 93, '29'),
(250, 1, 'champion', 'code', 93, 'twitch'),
(251, 1, 'champion', 'id', 94, '77'),
(252, 1, 'champion', 'code', 94, 'udyr'),
(253, 1, 'champion', 'id', 95, '6'),
(254, 1, 'champion', 'code', 95, 'urgot'),
(255, 1, 'champion', 'id', 96, '110'),
(256, 1, 'champion', 'code', 96, 'varus'),
(257, 1, 'champion', 'id', 97, '67'),
(258, 1, 'champion', 'code', 97, 'vayne'),
(259, 1, 'champion', 'id', 98, '45'),
(260, 1, 'champion', 'code', 98, 'veigar'),
(261, 1, 'champion', 'id', 99, '254'),
(262, 1, 'champion', 'code', 99, 'vi'),
(263, 1, 'champion', 'id', 100, '112'),
(264, 1, 'champion', 'code', 100, 'viktor'),
(265, 1, 'champion', 'id', 101, '8'),
(266, 1, 'champion', 'code', 101, 'vladimir'),
(267, 1, 'champion', 'id', 102, '106'),
(268, 1, 'champion', 'code', 102, 'volibear'),
(269, 1, 'champion', 'id', 103, '19'),
(270, 1, 'champion', 'code', 103, 'warwick'),
(271, 1, 'champion', 'id', 104, '62'),
(272, 1, 'champion', 'code', 104, 'monkeyking'),
(273, 1, 'champion', 'id', 105, '101'),
(274, 1, 'champion', 'code', 105, 'xerath'),
(275, 1, 'champion', 'id', 106, '5'),
(276, 1, 'champion', 'code', 106, 'xinzhao'),
(277, 1, 'champion', 'id', 107, '83'),
(278, 1, 'champion', 'code', 107, 'yorick'),
(279, 1, 'champion', 'id', 108, '238'),
(280, 1, 'champion', 'code', 108, 'zed'),
(281, 1, 'champion', 'id', 109, '115'),
(282, 1, 'champion', 'code', 109, 'ziggs'),
(283, 1, 'champion', 'id', 110, '26'),
(284, 1, 'champion', 'code', 110, 'zilean'),
(285, 1, 'champion', 'id', 111, '143'),
(286, 1, 'champion', 'code', 111, 'zyra'),
(287, 1, 'item', 'id', 1, '3001'),
(288, 1, 'item', 'id', 2, '3105'),
(289, 1, 'item', 'id', 3, '1052'),
(290, 1, 'item', 'id', 4, '3003'),
(291, 1, 'item', 'id', 5, '3174'),
(292, 1, 'item', 'id', 6, '3005'),
(293, 1, 'item', 'id', 7, '3198'),
(294, 1, 'item', 'id', 8, '3197'),
(295, 1, 'item', 'id', 9, '3196'),
(296, 1, 'item', 'id', 10, '3093'),
(297, 1, 'item', 'id', 11, '1038'),
(298, 1, 'item', 'id', 12, '3060'),
(299, 1, 'item', 'id', 13, '3102'),
(300, 1, 'item', 'id', 14, '3006'),
(301, 1, 'item', 'id', 15, '3254'),
(302, 1, 'item', 'id', 16, '3251'),
(303, 1, 'item', 'id', 17, '3253'),
(304, 1, 'item', 'id', 18, '3252'),
(305, 1, 'item', 'id', 19, '3250'),
(306, 1, 'item', 'id', 20, '3144'),
(307, 1, 'item', 'id', 21, '3188'),
(308, 1, 'item', 'id', 22, '3153'),
(309, 1, 'item', 'id', 23, '1026'),
(310, 1, 'item', 'id', 24, '3166'),
(311, 1, 'item', 'id', 25, '3117'),
(312, 1, 'item', 'id', 26, '3274'),
(313, 1, 'item', 'id', 27, '3271'),
(314, 1, 'item', 'id', 28, '3273'),
(315, 1, 'item', 'id', 29, '3272'),
(316, 1, 'item', 'id', 30, '3270'),
(317, 1, 'item', 'id', 31, '1001'),
(318, 1, 'item', 'id', 32, '3009'),
(319, 1, 'item', 'id', 33, '3284'),
(320, 1, 'item', 'id', 34, '3281'),
(321, 1, 'item', 'id', 35, '3283'),
(322, 1, 'item', 'id', 36, '3282'),
(323, 1, 'item', 'id', 37, '3280'),
(324, 1, 'item', 'id', 38, '1051'),
(325, 1, 'item', 'id', 39, '3010'),
(326, 1, 'item', 'id', 40, '1031'),
(327, 1, 'item', 'id', 41, '3028'),
(328, 1, 'item', 'id', 42, '1018'),
(329, 1, 'item', 'id', 43, '1029'),
(330, 1, 'item', 'id', 44, '2041'),
(331, 1, 'item', 'id', 45, '1042'),
(332, 1, 'item', 'id', 46, '3128'),
(333, 1, 'item', 'id', 47, '1055'),
(334, 1, 'item', 'id', 48, '1056'),
(335, 1, 'item', 'id', 49, '1054'),
(336, 1, 'item', 'id', 50, '3173'),
(337, 1, 'item', 'id', 51, '2039'),
(338, 1, 'item', 'id', 52, '2037'),
(339, 1, 'item', 'id', 53, '3097'),
(340, 1, 'item', 'id', 54, '3184'),
(341, 1, 'item', 'id', 55, '3123'),
(342, 1, 'item', 'id', 56, '2050'),
(343, 1, 'item', 'id', 57, '1004'),
(344, 1, 'item', 'id', 58, '3108'),
(345, 1, 'item', 'id', 59, '3110'),
(346, 1, 'item', 'id', 60, '3022'),
(347, 1, 'item', 'id', 61, '1011'),
(348, 1, 'item', 'id', 62, '3024'),
(349, 1, 'item', 'id', 63, '3159'),
(350, 1, 'item', 'id', 64, '3026'),
(351, 1, 'item', 'id', 65, '3124'),
(352, 1, 'item', 'id', 66, '3136'),
(353, 1, 'item', 'id', 67, '2003'),
(354, 1, 'item', 'id', 68, '3155'),
(355, 1, 'item', 'id', 69, '3146'),
(356, 1, 'item', 'id', 70, '3145'),
(357, 1, 'item', 'id', 71, '3187'),
(358, 1, 'item', 'id', 72, '1039'),
(359, 1, 'item', 'id', 73, '3025'),
(360, 1, 'item', 'id', 74, '2048'),
(361, 1, 'item', 'id', 75, '2040'),
(362, 1, 'item', 'id', 76, '3031'),
(363, 1, 'item', 'id', 77, '3158'),
(364, 1, 'item', 'id', 78, '3279'),
(365, 1, 'item', 'id', 79, '3276'),
(366, 1, 'item', 'id', 80, '3278'),
(367, 1, 'item', 'id', 81, '3277'),
(368, 1, 'item', 'id', 82, '3275'),
(369, 1, 'item', 'id', 83, '3098'),
(370, 1, 'item', 'id', 84, '3067'),
(371, 1, 'item', 'id', 85, '3186'),
(372, 1, 'item', 'id', 86, '3035'),
(373, 1, 'item', 'id', 87, '3151'),
(374, 1, 'item', 'id', 88, '3100'),
(375, 1, 'item', 'id', 89, '3190'),
(376, 1, 'item', 'id', 90, '1036'),
(377, 1, 'item', 'id', 91, '3104'),
(378, 1, 'item', 'id', 92, '3106'),
(379, 1, 'item', 'id', 93, '3114'),
(380, 1, 'item', 'id', 94, '3037'),
(381, 1, 'item', 'id', 95, '2004'),
(382, 1, 'item', 'id', 96, '3004'),
(383, 1, 'item', 'id', 97, '3156'),
(384, 1, 'item', 'id', 98, '3041'),
(385, 1, 'item', 'id', 99, '3139'),
(386, 1, 'item', 'id', 100, '3111'),
(387, 1, 'item', 'id', 101, '3269'),
(388, 1, 'item', 'id', 102, '3266'),
(389, 1, 'item', 'id', 103, '3268'),
(390, 1, 'item', 'id', 104, '3267'),
(391, 1, 'item', 'id', 105, '3265'),
(392, 1, 'item', 'id', 106, '3222'),
(393, 1, 'item', 'id', 107, '3165'),
(394, 1, 'item', 'id', 108, '3042'),
(395, 1, 'item', 'id', 109, '3115'),
(396, 1, 'item', 'id', 110, '1058'),
(397, 1, 'item', 'id', 111, '1057'),
(398, 1, 'item', 'id', 112, '3047'),
(399, 1, 'item', 'id', 113, '3264'),
(400, 1, 'item', 'id', 114, '3261'),
(401, 1, 'item', 'id', 115, '3263'),
(402, 1, 'item', 'id', 116, '3262'),
(403, 1, 'item', 'id', 117, '3260'),
(404, 1, 'item', 'id', 118, '1033'),
(405, 1, 'item', 'id', 119, '3180'),
(406, 1, 'item', 'id', 120, '3056'),
(407, 1, 'item', 'id', 121, '2042'),
(408, 1, 'item', 'id', 122, '2047'),
(409, 1, 'item', 'id', 123, '3084'),
(410, 1, 'item', 'id', 124, '3044'),
(411, 1, 'item', 'id', 125, '3046'),
(412, 1, 'item', 'id', 126, '3096'),
(413, 1, 'item', 'id', 127, '1037'),
(414, 1, 'item', 'id', 128, '1062'),
(415, 1, 'item', 'id', 129, '1063'),
(416, 1, 'item', 'id', 130, '3140'),
(417, 1, 'item', 'id', 131, '3089'),
(418, 1, 'item', 'id', 132, '3143'),
(419, 1, 'item', 'id', 133, '3074'),
(420, 1, 'item', 'id', 134, '1043'),
(421, 1, 'item', 'id', 135, '1006'),
(422, 1, 'item', 'id', 136, '3027'),
(423, 1, 'item', 'id', 137, '1028'),
(424, 1, 'item', 'id', 138, '2045'),
(425, 1, 'item', 'id', 139, '3085'),
(426, 1, 'item', 'id', 140, '3107'),
(427, 1, 'item', 'id', 141, '3116'),
(428, 1, 'item', 'id', 142, '3181'),
(429, 1, 'item', 'id', 143, '1027'),
(430, 1, 'item', 'id', 144, '3191'),
(431, 1, 'item', 'id', 145, '3040'),
(432, 1, 'item', 'id', 146, '3092'),
(433, 1, 'item', 'id', 147, '3057'),
(434, 1, 'item', 'id', 148, '3069'),
(435, 1, 'item', 'id', 149, '2044'),
(436, 1, 'item', 'id', 150, '2049'),
(437, 1, 'item', 'id', 151, '3020'),
(438, 1, 'item', 'id', 152, '3259'),
(439, 1, 'item', 'id', 153, '3256'),
(440, 1, 'item', 'id', 154, '3258'),
(441, 1, 'item', 'id', 155, '3257'),
(442, 1, 'item', 'id', 156, '3255'),
(443, 1, 'item', 'id', 157, '3207'),
(444, 1, 'item', 'id', 158, '3209'),
(445, 1, 'item', 'id', 159, '3206'),
(446, 1, 'item', 'id', 160, '1080'),
(447, 1, 'item', 'id', 161, '3065'),
(448, 1, 'item', 'id', 162, '3087'),
(449, 1, 'item', 'id', 163, '3101'),
(450, 1, 'item', 'id', 164, '3068'),
(451, 1, 'item', 'id', 165, '3131'),
(452, 1, 'item', 'id', 166, '3141'),
(453, 1, 'item', 'id', 167, '3070'),
(454, 1, 'item', 'id', 168, '3071'),
(455, 1, 'item', 'id', 169, '3072'),
(456, 1, 'item', 'id', 170, '3134'),
(457, 1, 'item', 'id', 171, '3200'),
(458, 1, 'item', 'id', 172, '3185'),
(459, 1, 'item', 'id', 173, '3075'),
(460, 1, 'item', 'id', 174, '3077'),
(461, 1, 'item', 'id', 175, '2009'),
(462, 1, 'item', 'id', 176, '3078'),
(463, 1, 'item', 'id', 177, '3023'),
(464, 1, 'item', 'id', 178, '1053'),
(465, 1, 'item', 'id', 179, '2043'),
(466, 1, 'item', 'id', 180, '3135'),
(467, 1, 'item', 'id', 181, '3082'),
(468, 1, 'item', 'id', 182, '3083'),
(469, 1, 'item', 'id', 183, '3122'),
(470, 1, 'item', 'id', 184, '3152'),
(471, 1, 'item', 'id', 185, '3091'),
(472, 1, 'item', 'id', 186, '3090'),
(473, 1, 'item', 'id', 187, '3154'),
(474, 1, 'item', 'id', 188, '3142'),
(475, 1, 'item', 'id', 189, '3086'),
(476, 1, 'item', 'id', 190, '3050'),
(477, 1, 'item', 'id', 191, '3172'),
(478, 1, 'item', 'id', 192, '3157');

-- --------------------------------------------------------

--
-- Structure de la table `match`
--

CREATE TABLE IF NOT EXISTS `match` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(32) NOT NULL,
  `map_id` tinyint(3) unsigned DEFAULT NULL,
  `match_type_id` tinyint(3) unsigned NOT NULL,
  `winner_id` int(10) unsigned DEFAULT NULL,
  `loser_id` int(10) unsigned DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `length` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`),
  KEY `match_winner_id` (`winner_id`),
  KEY `match_loser_id` (`loser_id`),
  KEY `match_match_type_id` (`match_type_id`),
  KEY `match_map_id` (`map_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `match`
--


-- --------------------------------------------------------

--
-- Structure de la table `match_team`
--

CREATE TABLE IF NOT EXISTS `match_team` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `match_team_match_id` (`match_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `match_team`
--


-- --------------------------------------------------------

--
-- Structure de la table `match_type`
--

CREATE TABLE IF NOT EXISTS `match_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `map_id` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `match_type_map_id` (`map_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `match_type`
--

INSERT INTO `match_type` (`id`, `name`, `code`, `map_id`) VALUES
(1, 'Normal 5v5', 'normal-5v5', 3),
(2, 'Ranked Solo 5v5', 'ranked-solo-5v5', 3),
(3, 'Ranked Team 5v5', 'ranked-team-5v5', 3),
(4, 'Normal 3v3', 'normal-3v3', 4),
(5, 'Ranked Team 3v3', 'ranked-team-3v3', 4),
(6, 'Custom', 'custom', NULL),
(7, 'ARAM', 'aram', 2),
(8, 'Dominion', 'dominion', 1),
(9, 'Co-op vs AI 5v5', 'co-op-vs-ai-5v5', 3),
(10, 'Co-op vs AI 3v3', 'co-op-vs-ai-3v3', 4);

-- --------------------------------------------------------

--
-- Structure de la table `position`
--

CREATE TABLE IF NOT EXISTS `position` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `position`
--

INSERT INTO `position` (`id`, `name`, `code`) VALUES
(1, 'Top Lane', 'top'),
(2, 'Middle Lane', 'mid'),
(3, 'AD Carry', 'adc'),
(4, 'Support', 'support'),
(5, 'Jungler', 'jungle');

-- --------------------------------------------------------

--
-- Structure de la table `source`
--

CREATE TABLE IF NOT EXISTS `source` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `code` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `source`
--

INSERT INTO `source` (`id`, `name`, `code`) VALUES
(1, 'LoL King', 'lolking'),
(2, 'MOBA Fire', 'mobafire');

-- --------------------------------------------------------

--
-- Structure de la table `spell`
--

CREATE TABLE IF NOT EXISTS `spell` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `spell`
--

INSERT INTO `spell` (`id`, `name`, `code`) VALUES
(1, 'Barrier', 'barrier'),
(2, 'Clairvoyance', 'clairvoyance'),
(3, 'Clarity', 'clarity'),
(4, 'Cleanse', 'cleanse'),
(5, 'Exhaust', 'exhaust'),
(6, 'Flash', 'flash'),
(7, 'Fortify', 'fortify'),
(8, 'Garrison', 'garrison'),
(9, 'Ghost', 'ghost'),
(10, 'Heal', 'heal'),
(11, 'Ignite', 'ignite'),
(12, 'Promote', 'promote'),
(13, 'Rally', 'rally'),
(14, 'Revive', 'revive'),
(15, 'Smite', 'smite'),
(16, 'Surge', 'surge'),
(17, 'Teleport', 'teleport');

-- --------------------------------------------------------

--
-- Structure de la table `summoner`
--

CREATE TABLE IF NOT EXISTS `summoner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `realm` enum('euw','na','br','eune','kr') NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_realm` (`name`,`realm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `summoner`
--


--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `champion`
--
ALTER TABLE `champion`
  ADD CONSTRAINT `champion_position_id` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `invocation`
--
ALTER TABLE `invocation`
  ADD CONSTRAINT `invocation_champion_id` FOREIGN KEY (`champion_id`) REFERENCES `champion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `invocation_position_id` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `invocation_summoner_id` FOREIGN KEY (`summoner_id`) REFERENCES `summoner` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `invocation_item`
--
ALTER TABLE `invocation_item`
  ADD CONSTRAINT `invocation_item_invocation_id` FOREIGN KEY (`invocation_id`) REFERENCES `invocation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `invocation_item_item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `invocation_spell`
--
ALTER TABLE `invocation_spell`
  ADD CONSTRAINT `invocation_spell_invocation_id` FOREIGN KEY (`invocation_id`) REFERENCES `invocation` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `invocation_spell_spell_id` FOREIGN KEY (`spell_id`) REFERENCES `spell` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `mapping`
--
ALTER TABLE `mapping`
  ADD CONSTRAINT `mapping_source_id` FOREIGN KEY (`source_id`) REFERENCES `source` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `match`
--
ALTER TABLE `match`
  ADD CONSTRAINT `match_winner_id` FOREIGN KEY (`winner_id`) REFERENCES `match_team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `match_match_type_id` FOREIGN KEY (`match_type_id`) REFERENCES `match_type` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `match_map_id` FOREIGN KEY (`map_id`) REFERENCES `map` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `match_loser_id` FOREIGN KEY (`loser_id`) REFERENCES `match_team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `match_team`
--
ALTER TABLE `match_team`
  ADD CONSTRAINT `match_team_match_id` FOREIGN KEY (`match_id`) REFERENCES `match` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `match_type`
--
ALTER TABLE `match_type`
  ADD CONSTRAINT `match_type_map_id` FOREIGN KEY (`map_id`) REFERENCES `map` (`id`);
SET FOREIGN_KEY_CHECKS=1;
