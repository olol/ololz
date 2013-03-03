-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 03 Mars 2013 à 13:36
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
  `name` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
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
(78, 'Ionian Boots of Lucidity - Alacr', 'ionian-boots-of-lucidity-alacrit'),
(79, 'Ionian Boots of Lucidity - Capta', 'ionian-boots-of-lucidity-captain'),
(80, 'Ionian Boots of Lucidity - Disto', 'ionian-boots-of-lucidity-distort'),
(81, 'Ionian Boots of Lucidity - Furor', 'ionian-boots-of-lucidity-furor'),
(82, 'Ionian Boots of Lucidity - Homeg', 'ionian-boots-of-lucidity-homegua'),
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
  `ours` int(10) unsigned NOT NULL,
  `theirs` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `source_type_theirs` (`source_id`,`type`,`theirs`),
  UNIQUE KEY `source_type_ours` (`source_id`,`type`,`ours`),
  KEY `mapping_source_id` (`source_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=368 ;

--
-- Contenu de la table `mapping`
--

INSERT INTO `mapping` (`id`, `source_id`, `type`, `ours`, `theirs`) VALUES
(1, 1, 'position', 1, 'Top Lane'),
(2, 1, 'position', 2, 'Middle Lane'),
(3, 1, 'position', 3, 'AD Carry'),
(4, 1, 'position', 4, 'Support'),
(5, 1, 'position', 5, 'Jungler'),
(6, 1, 'champion', 1, 'ahri'),
(7, 1, 'champion', 2, 'akali'),
(8, 1, 'champion', 3, 'alistar'),
(9, 1, 'champion', 4, 'amumu'),
(10, 1, 'champion', 5, 'anivia'),
(11, 1, 'champion', 6, 'annie'),
(12, 1, 'champion', 7, 'ashe'),
(13, 1, 'champion', 8, 'blitzcrank'),
(14, 1, 'champion', 9, 'brand'),
(15, 1, 'champion', 10, 'caitlyn'),
(16, 1, 'champion', 11, 'cassiopeia'),
(17, 1, 'champion', 12, 'chogath'),
(18, 1, 'champion', 13, 'corki'),
(19, 1, 'champion', 14, 'darius'),
(20, 1, 'champion', 15, 'diana'),
(21, 1, 'champion', 16, 'drmundo'),
(22, 1, 'champion', 17, 'draven'),
(23, 1, 'champion', 18, 'elise'),
(24, 1, 'champion', 19, 'evelynn'),
(25, 1, 'champion', 20, 'ezreal'),
(26, 1, 'champion', 21, 'fiddlesticks'),
(27, 1, 'champion', 22, 'fiora'),
(28, 1, 'champion', 23, 'fizz'),
(29, 1, 'champion', 24, 'galio'),
(30, 1, 'champion', 25, 'gangplank'),
(31, 1, 'champion', 26, 'garen'),
(32, 1, 'champion', 27, 'gragas'),
(33, 1, 'champion', 28, 'graves'),
(34, 1, 'champion', 29, 'hecarim'),
(35, 1, 'champion', 30, 'heimerdinger'),
(36, 1, 'champion', 31, 'irelia'),
(37, 1, 'champion', 32, 'janna'),
(38, 1, 'champion', 33, 'jarvaniv'),
(39, 1, 'champion', 34, 'jax'),
(40, 1, 'champion', 35, 'jayce'),
(41, 1, 'champion', 36, 'karma'),
(42, 1, 'champion', 37, 'karthus'),
(43, 1, 'champion', 38, 'kassadin'),
(44, 1, 'champion', 39, 'katarina'),
(45, 1, 'champion', 40, 'kayle'),
(46, 1, 'champion', 41, 'kennen'),
(47, 1, 'champion', 42, 'khazix'),
(48, 1, 'champion', 43, 'kogmaw'),
(49, 1, 'champion', 44, 'leblanc'),
(50, 1, 'champion', 45, 'leesin'),
(51, 1, 'champion', 46, 'leona'),
(52, 1, 'champion', 47, 'lulu'),
(53, 1, 'champion', 48, 'lux'),
(54, 1, 'champion', 49, 'malphite'),
(55, 1, 'champion', 50, 'malzahar'),
(56, 1, 'champion', 51, 'maokai'),
(57, 1, 'champion', 52, 'masteryi'),
(58, 1, 'champion', 53, 'missfortune'),
(59, 1, 'champion', 54, 'mordekaiser'),
(60, 1, 'champion', 55, 'morgana'),
(61, 1, 'champion', 56, 'nami'),
(62, 1, 'champion', 57, 'nasus'),
(63, 1, 'champion', 58, 'nautilus'),
(64, 1, 'champion', 59, 'nidalee'),
(65, 1, 'champion', 60, 'nocturne'),
(66, 1, 'champion', 61, 'nunu'),
(67, 1, 'champion', 62, 'olaf'),
(68, 1, 'champion', 63, 'orianna'),
(69, 1, 'champion', 64, 'pantheon'),
(70, 1, 'champion', 65, 'poppy'),
(71, 1, 'champion', 66, 'quinn'),
(72, 1, 'champion', 67, 'rammus'),
(73, 1, 'champion', 68, 'renekton'),
(74, 1, 'champion', 69, 'rengar'),
(75, 1, 'champion', 70, 'riven'),
(76, 1, 'champion', 71, 'rumble'),
(77, 1, 'champion', 72, 'ryze'),
(78, 1, 'champion', 73, 'sejuani'),
(79, 1, 'champion', 74, 'shaco'),
(80, 1, 'champion', 75, 'shen'),
(81, 1, 'champion', 76, 'shyvana'),
(82, 1, 'champion', 77, 'singed'),
(83, 1, 'champion', 78, 'sion'),
(84, 1, 'champion', 79, 'sivir'),
(85, 1, 'champion', 80, 'skarner'),
(86, 1, 'champion', 81, 'sona'),
(87, 1, 'champion', 82, 'soraka'),
(88, 1, 'champion', 83, 'swain'),
(89, 1, 'champion', 84, 'syndra'),
(90, 1, 'champion', 85, 'talon'),
(91, 1, 'champion', 86, 'taric'),
(92, 1, 'champion', 87, 'teemo'),
(93, 1, 'champion', 88, 'thresh'),
(94, 1, 'champion', 89, 'tristana'),
(95, 1, 'champion', 90, 'trundle'),
(96, 1, 'champion', 91, 'tryndamere'),
(97, 1, 'champion', 92, 'twistedfate'),
(98, 1, 'champion', 93, 'twitch'),
(99, 1, 'champion', 94, 'udyr'),
(100, 1, 'champion', 95, 'urgot'),
(101, 1, 'champion', 96, 'varus'),
(102, 1, 'champion', 97, 'vayne'),
(103, 1, 'champion', 98, 'veigar'),
(104, 1, 'champion', 99, 'vi'),
(105, 1, 'champion', 100, 'viktor'),
(106, 1, 'champion', 101, 'vladimir'),
(107, 1, 'champion', 102, 'volibear'),
(108, 1, 'champion', 103, 'warwick'),
(109, 1, 'champion', 104, 'monkeyking'),
(110, 1, 'champion', 105, 'xerath'),
(111, 1, 'champion', 106, 'xinzhao'),
(112, 1, 'champion', 107, 'yorick'),
(113, 1, 'champion', 108, 'zed'),
(114, 1, 'champion', 109, 'ziggs'),
(115, 1, 'champion', 110, 'zilean'),
(116, 1, 'champion', 111, 'zyra'),
(117, 1, 'item', 1, '3001'),
(118, 1, 'item', 2, '3105'),
(119, 1, 'item', 3, '1052'),
(120, 1, 'item', 4, '3003'),
(121, 1, 'item', 5, '3174'),
(122, 1, 'item', 6, '3005'),
(123, 1, 'item', 7, '3198'),
(124, 1, 'item', 8, '3197'),
(125, 1, 'item', 9, '3196'),
(126, 1, 'item', 10, '3093'),
(127, 1, 'item', 11, '1038'),
(128, 1, 'item', 12, '3060'),
(129, 1, 'item', 13, '3102'),
(130, 1, 'item', 14, '3006'),
(131, 1, 'item', 15, '3254'),
(132, 1, 'item', 16, '3251'),
(133, 1, 'item', 17, '3253'),
(134, 1, 'item', 18, '3252'),
(135, 1, 'item', 19, '3250'),
(136, 1, 'item', 20, '3144'),
(137, 1, 'item', 21, '3188'),
(138, 1, 'item', 22, '3153'),
(139, 1, 'item', 23, '1026'),
(140, 1, 'item', 24, '3166'),
(141, 1, 'item', 25, '3117'),
(142, 1, 'item', 26, '3274'),
(143, 1, 'item', 27, '3271'),
(144, 1, 'item', 28, '3273'),
(145, 1, 'item', 29, '3272'),
(146, 1, 'item', 30, '3270'),
(147, 1, 'item', 31, '1001'),
(148, 1, 'item', 32, '3009'),
(149, 1, 'item', 33, '3284'),
(150, 1, 'item', 34, '3281'),
(151, 1, 'item', 35, '3283'),
(152, 1, 'item', 36, '3282'),
(153, 1, 'item', 37, '3280'),
(154, 1, 'item', 38, '1051'),
(155, 1, 'item', 39, '3010'),
(156, 1, 'item', 40, '1031'),
(157, 1, 'item', 41, '3028'),
(158, 1, 'item', 42, '1018'),
(159, 1, 'item', 43, '1029'),
(160, 1, 'item', 44, '2041'),
(161, 1, 'item', 45, '1042'),
(162, 1, 'item', 46, '3128'),
(163, 1, 'item', 47, '1055'),
(164, 1, 'item', 48, '1056'),
(165, 1, 'item', 49, '1054'),
(166, 1, 'item', 50, '3173'),
(167, 1, 'item', 51, '2039'),
(168, 1, 'item', 52, '2037'),
(169, 1, 'item', 53, '3097'),
(170, 1, 'item', 54, '3184'),
(171, 1, 'item', 55, '3123'),
(172, 1, 'item', 56, '2050'),
(173, 1, 'item', 57, '1004'),
(174, 1, 'item', 58, '3108'),
(175, 1, 'item', 59, '3110'),
(176, 1, 'item', 60, '3022'),
(177, 1, 'item', 61, '1011'),
(178, 1, 'item', 62, '3024'),
(179, 1, 'item', 63, '3159'),
(180, 1, 'item', 64, '3026'),
(181, 1, 'item', 65, '3124'),
(182, 1, 'item', 66, '3136'),
(183, 1, 'item', 67, '2003'),
(184, 1, 'item', 68, '3155'),
(185, 1, 'item', 69, '3146'),
(186, 1, 'item', 70, '3145'),
(187, 1, 'item', 71, '3187'),
(188, 1, 'item', 72, '1039'),
(189, 1, 'item', 73, '3025'),
(190, 1, 'item', 74, '2048'),
(191, 1, 'item', 75, '2040'),
(192, 1, 'item', 76, '3031'),
(193, 1, 'item', 77, '3158'),
(194, 1, 'item', 78, '3279'),
(195, 1, 'item', 79, '3276'),
(196, 1, 'item', 80, '3278'),
(197, 1, 'item', 81, '3277'),
(198, 1, 'item', 82, '3275'),
(199, 1, 'item', 83, '3098'),
(200, 1, 'item', 84, '3067'),
(201, 1, 'item', 85, '3186'),
(202, 1, 'item', 86, '3035'),
(203, 1, 'item', 87, '3151'),
(204, 1, 'item', 88, '3100'),
(205, 1, 'item', 89, '3190'),
(206, 1, 'item', 90, '1036'),
(207, 1, 'item', 91, '3104'),
(208, 1, 'item', 92, '3106'),
(209, 1, 'item', 93, '3114'),
(210, 1, 'item', 94, '3037'),
(211, 1, 'item', 95, '2004'),
(212, 1, 'item', 96, '3004'),
(213, 1, 'item', 97, '3156'),
(214, 1, 'item', 98, '3041'),
(215, 1, 'item', 99, '3139'),
(216, 1, 'item', 100, '3111'),
(217, 1, 'item', 101, '3269'),
(218, 1, 'item', 102, '3266'),
(219, 1, 'item', 103, '3268'),
(220, 1, 'item', 104, '3267'),
(221, 1, 'item', 105, '3265'),
(222, 1, 'item', 106, '3222'),
(223, 1, 'item', 107, '3165'),
(224, 1, 'item', 108, '3042'),
(225, 1, 'item', 109, '3115'),
(226, 1, 'item', 110, '1058'),
(227, 1, 'item', 111, '1057'),
(228, 1, 'item', 112, '3047'),
(229, 1, 'item', 113, '3264'),
(230, 1, 'item', 114, '3261'),
(231, 1, 'item', 115, '3263'),
(232, 1, 'item', 116, '3262'),
(233, 1, 'item', 117, '3260'),
(234, 1, 'item', 118, '1033'),
(235, 1, 'item', 119, '3180'),
(236, 1, 'item', 120, '3056'),
(237, 1, 'item', 121, '2042'),
(238, 1, 'item', 122, '2047'),
(239, 1, 'item', 123, '3084'),
(240, 1, 'item', 124, '3044'),
(241, 1, 'item', 125, '3046'),
(242, 1, 'item', 126, '3096'),
(243, 1, 'item', 127, '1037'),
(244, 1, 'item', 128, '1062'),
(245, 1, 'item', 129, '1063'),
(246, 1, 'item', 130, '3140'),
(247, 1, 'item', 131, '3089'),
(248, 1, 'item', 132, '3143'),
(249, 1, 'item', 133, '3074'),
(250, 1, 'item', 134, '1043'),
(251, 1, 'item', 135, '1006'),
(252, 1, 'item', 136, '3027'),
(253, 1, 'item', 137, '1028'),
(254, 1, 'item', 138, '2045'),
(255, 1, 'item', 139, '3085'),
(256, 1, 'item', 140, '3107'),
(257, 1, 'item', 141, '3116'),
(258, 1, 'item', 142, '3181'),
(259, 1, 'item', 143, '1027'),
(260, 1, 'item', 144, '3191'),
(261, 1, 'item', 145, '3040'),
(262, 1, 'item', 146, '3092'),
(263, 1, 'item', 147, '3057'),
(264, 1, 'item', 148, '3069'),
(265, 1, 'item', 149, '2044'),
(266, 1, 'item', 150, '2049'),
(267, 1, 'item', 151, '3020'),
(268, 1, 'item', 152, '3259'),
(269, 1, 'item', 153, '3256'),
(270, 1, 'item', 154, '3258'),
(271, 1, 'item', 155, '3257'),
(272, 1, 'item', 156, '3255'),
(273, 1, 'item', 157, '3207'),
(274, 1, 'item', 158, '3209'),
(275, 1, 'item', 159, '3206'),
(276, 1, 'item', 160, '1080'),
(277, 1, 'item', 161, '3065'),
(278, 1, 'item', 162, '3087'),
(279, 1, 'item', 163, '3101'),
(280, 1, 'item', 164, '3068'),
(281, 1, 'item', 165, '3131'),
(282, 1, 'item', 166, '3141'),
(283, 1, 'item', 167, '3070'),
(284, 1, 'item', 168, '3071'),
(285, 1, 'item', 169, '3072'),
(286, 1, 'item', 170, '3134'),
(287, 1, 'item', 171, '3200'),
(288, 1, 'item', 172, '3185'),
(289, 1, 'item', 173, '3075'),
(290, 1, 'item', 174, '3077'),
(291, 1, 'item', 175, '2009'),
(292, 1, 'item', 176, '3078'),
(293, 1, 'item', 177, '3023'),
(294, 1, 'item', 178, '1053'),
(295, 1, 'item', 179, '2043'),
(296, 1, 'item', 180, '3135'),
(297, 1, 'item', 181, '3082'),
(298, 1, 'item', 182, '3083'),
(299, 1, 'item', 183, '3122'),
(300, 1, 'item', 184, '3152'),
(301, 1, 'item', 185, '3091'),
(302, 1, 'item', 186, '3090'),
(303, 1, 'item', 187, '3154'),
(304, 1, 'item', 188, '3142'),
(305, 1, 'item', 189, '3086'),
(306, 1, 'item', 190, '3050'),
(307, 1, 'item', 191, '3172'),
(308, 1, 'item', 192, '3157'),
(309, 2, 'spell', 1, 'barrier-17'),
(310, 2, 'spell', 2, 'clairvoyance-13'),
(311, 2, 'spell', 3, 'clarity-9'),
(312, 2, 'spell', 4, 'cleanse-7'),
(313, 2, 'spell', 5, 'exhaust-1'),
(314, 2, 'spell', 6, 'flash-14'),
(315, 2, 'spell', 7, 'fortify-8'),
(316, 2, 'spell', 8, 'garrison-15'),
(317, 2, 'spell', 9, 'ghost-2'),
(318, 2, 'spell', 10, 'heal-3'),
(319, 2, 'spell', 11, 'ignite-11'),
(320, 2, 'spell', 12, 'promote-10'),
(321, 2, 'spell', 13, 'rally-12'),
(322, 2, 'spell', 14, 'revive-4'),
(323, 2, 'spell', 15, 'smite-5'),
(324, 2, 'spell', 16, 'surge-16'),
(325, 2, 'spell', 17, 'teleport-6'),
(339, 1, 'spell', 1, '21'),
(340, 1, 'spell', 2, '2'),
(341, 1, 'spell', 3, '13'),
(342, 1, 'spell', 4, '1'),
(343, 1, 'spell', 5, '3'),
(344, 1, 'spell', 6, '4'),
(345, 1, 'spell', 8, '17'),
(346, 1, 'spell', 9, '6'),
(347, 1, 'spell', 10, '7'),
(348, 1, 'spell', 11, '14'),
(349, 1, 'spell', 12, '20'),
(350, 1, 'spell', 14, '10'),
(351, 1, 'spell', 15, '11'),
(352, 1, 'spell', 16, '16'),
(353, 1, 'spell', 17, '12'),
(354, 1, 'match_type', 1, 'Normal 5v5'),
(355, 1, 'match_type', 2, 'Ranked Solo 5v5'),
(356, 1, 'match_type', 3, 'Ranked Team 5v5'),
(357, 1, 'match_type', 4, 'Normal 3v3'),
(358, 1, 'match_type', 5, 'Ranked Team 3v3'),
(359, 1, 'match_type', 6, 'Custom'),
(365, 1, 'match_type', 7, 'Proving Grounds'),
(366, 1, 'match_type', 8, 'Dominion'),
(367, 1, 'match_type', 9, 'Co-Op Vs AI');

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
(9, 'Co-op vs AI', 'co-op-vs-ai', NULL);

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
