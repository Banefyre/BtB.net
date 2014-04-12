-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3306
-- Généré le :  Dim 06 Avril 2014 à 11:18
-- Version du serveur :  5.5.36
-- Version de PHP :  5.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `masters_games`
--

-- --------------------------------------------------------

--
-- Structure de la table `ft_account`
--

CREATE TABLE IF NOT EXISTS `ft_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(42) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `ft_account`
--

INSERT INTO `ft_account` (`id`, `email`, `pass`, `date`, `admin`) VALUES
(1, 'apergens@student.42.fr', '97ac06d98429e10e8c6b111f3c5469dc2aed37a516af4532e96754aff28ba0efab1a1c2873ad420d6e8d00e0b3c36a224ba18f200926848af0aeee5be51f4e86', '2014-04-06 12:33:45', 0);

-- --------------------------------------------------------

--
-- Structure de la table `ft_consoles`
--

CREATE TABLE IF NOT EXISTS `ft_consoles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(42) NOT NULL,
  `title` varchar(42) NOT NULL,
  `details` text NOT NULL,
  `price` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `ft_consoles`
--

INSERT INTO `ft_consoles` (`id`, `name`, `title`, `details`, `price`, `date`, `image`) VALUES
(1, 'ps3', 'PlayStation 3', 'La PlayStation 3 (プレイステーション3, Pureisutēshon Surī?, abrégé officiellement PS3) est une console de jeux vidéo de septième génération commercialisée par Sony. Elle est sortie le 11 novembre 2006 au Japon, le 17 novembre 2006 en Amérique du Nord et le 22 mars 2007 en Europe. Elle succède à la PlayStation 2 et concurrence la Xbox 360, et indirectement la Wii.', 169.95, '2014-04-06 13:53:33', '1396792409.png'),
(2, 'ps4', 'PlayStation 4', 'La PlayStation 4 (プレイステション4, Pureisutēshon Fō?, abrégé officiellement PS4) est une console de jeux vidéo de salon de huitième génération développée par Sony Computer Entertainment, présentée le 20 février 2013. Elle succède à la PlayStation 3 et se place en concurrence frontale avec la Xbox One, et plus indirectement avec la Wii U. Elle est sortie le 15 novembre 2013 aux États-Unis et au Canada, et quelques jours plus tard, le 29 novembre, en Europe et en Australie, pour un prix de vente de 399 $ / 399 € ; au Japon, sa sortie a eu lieu le 22 février 2014.', 429.95, '2014-04-06 14:16:25', '1396792634.pmg'),
(3, 'xbox360', 'XBox 360', 'La Xbox 360 est une console de jeux vidéo développée par Microsoft, en coopération avec IBM, ATI, Samsung et SiS, successeur de la Xbox. Elle concurrence la Nintendo Wii et la Sony PlayStation 3 dans la lignée des consoles septième génération. En date du 12 février 2013, 75,9 millions d''exemplaires ont été vendus à travers le monde3. Trois modèles de la console peuvent être distingués — le modèle initial commercialisé aux États-Unis le 22 novembre 2005, la version légère et silencieuse appelée Xbox 360 S commercialisée le 16 juillet 2010 en Europe, et la troisième version Xbox 360 E commercialisée en 2013.\r\n\r\nLa console succède à la Xbox et offre une rétro-compatibilité avec une partie des titres parus sur cette dernière. La Xbox One lui succède fin 2013.', 199.95, '2014-04-06 14:16:25', '1396793207.png'),
(4, 'xboxone', 'XBox One', 'La Xbox One est une console de jeux vidéo de huitième génération développée par Microsoft. Dévoilée le 21 mai 2013, elle succède à la Xbox 360 et se place en concurrence frontale avec la PlayStation 4, et plus indirectement avec la Wii U. Elle est sortie le 22 novembre 2013 dans 13 pays au prix de 499 $ / 499 €.', 499.95, '2014-04-06 14:18:18', '1396793334.png'),
(5, 'wii', 'Wii', 'La Wii (ウィー, Wī?) est une console de jeux vidéo de salon du fabricant japonais Nintendo. Cette console est de la septième génération tout comme la Xbox 360 et la PlayStation 3. Elle est par ailleurs la console la plus vendue de sa génération. Elle a comme particularité d''utiliser un système capable de détecter la position, l''orientation et les mouvements dans l''espace de la manette. Son jeu phare, Wii Sports est lui, le jeu vidéo le plus vendu de tous les temps.\r\n\r\nLa Wii a marqué un tournant dans l''histoire du jeu vidéo en ouvrant ce loisir à un public plus large, et ciblant l''ensemble de la société.', 109.95, '2014-04-06 14:18:18', '1396793505.png'),
(6, 'wiiu', 'Wii U', 'La Wii U est une console de jeu vidéo commercialisée par Nintendo, succédant à la Wii. Elle est sortie le 18 novembre 2012 en Amérique du Nord, le 30 novembre 2012 en Europe et le 8 décembre 2012 au Japon. Première console de jeu vidéo de huitième génération à sortir, elle est en concurrence avec la PlayStation 4 et la Xbox One.', 249.95, '2014-04-06 14:19:23', '1396793574.png'),
(7, 'pc', 'Ordinateur', 'Un ordinateur est une machine électronique qui fonctionne par la lecture séquentielle d''un ensemble d''instructions, organisées en programmes, qui lui font exécuter des opérations logiques et arithmétiques sur des chiffres binaires. Dès sa mise sous tension, un ordinateur exécute, l''une après l''autre, des instructions qui lui font lire, manipuler, puis réécrire un ensemble de données. Des tests et des sauts conditionnels permettent de changer d''instruction suivante, et donc d''agir différemment en fonction des données ou des nécessités du moment.\r\n\r\nLes données à manipuler sont obtenues, soit par la lecture de mémoires, soit par la lecture de composants d''interface (périphériques) qui représentent des données physiques extérieures en valeurs binaires (déplacement d''une souris, touche appuyée sur un clavier, température, vitesse, compression…). Une fois utilisées, ou manipulées, les données sont réécrites, soit dans des mémoires, soit dans des composants qui peuvent transformer une valeur binaire en une action physique (écriture sur une imprimante ou sur un moniteur, accélération ou freinage d''un véhicule, changement de température d''un four…). L''ordinateur peut aussi répondre à des interruptions qui lui permettent d’exécuter des programmes de réponses spécifiques à chacune, puis de reprendre l’exécution séquentielle du programme interrompu.\r\n\r\nDe 1834 à 1837, Charles Babbage conçut une machine à calculer programmable en associant les inventions de Blaise Pascal et de Jacquard, commandant, avec des instructions écrites sur des cartes perforées, un des descendants de la première machine qui suppléa l''intelligence de l''homme: la Pascaline1. C''est durant cette période qu''il imagina la plupart des caractéristiques de l''ordinateur moderne2. Babbage passera le reste de sa vie à essayer de construire sa machine analytique, mais sans succès. Beaucoup de personnes s’intéressèrent et essayèrent de développer cette machine3, mais c''est cent ans plus tard, en 1937, qu''IBM inaugurera l''ère de l''informatique en commençant le développement de l''ASCC/Mark I, une machine basée sur l’architecture de Babbage qui, une fois réalisée, sera considérée comme l’achèvement de son rêve4.\r\n\r\nLa technique actuelle des ordinateurs date du milieu du xxe siècle. Ils peuvent être classés selon plusieurs critères5 tel que domaine d''application, taille ou architecture.', 13.37, '2014-04-06 18:08:27', '1396807562.png');

-- --------------------------------------------------------

--
-- Structure de la table `ft_products`
--

CREATE TABLE IF NOT EXISTS `ft_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(42) NOT NULL,
  `details` text NOT NULL,
  `used` tinyint(1) NOT NULL,
  `price` float NOT NULL,
  `consoles` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `ft_products`
--

INSERT INTO `ft_products` (`id`, `title`, `details`, `used`, `price`, `consoles`, `date`, `image`) VALUES
(1, 'Assassins Creed Revelations', 'Dans Assassins Creed Revelations, le maitre assassin Ezio marche sur les traces de son légendaire ancêtre Altaïr et plonge au coeur d''une quête jonchée de découvertes et de révélations. Son périple le conduira à Constantinople, centre de lempire Ottoman, où une armée de Templiers menace de déstabiliser la région\r\n\r\nEn plus de laventure solo, le mode multijoueur prend une ampleur supplémentaire avec encore plus de modes de jeux, de cartes et de nouveaux personnages.\r\n\r\n<b>Caractéristiques</b>\r\n\r\n SOYEZ PLUS MEURTRIER  Maitrisez les nouvelles compétences dun Ezio plus avisé, plus affuté et plus meurtrier que jamais. Eliminez discrètement vos adversaires avec de nouvelles armes et capacités, grâce notamment à la course libre optimisée ou à la lame-crochet. Découvrez une nouvelle profondeur dans le gameplay avec la fabrication de bombes, et utilisez le Sens de lAigle pour analyser lenvironnement et contrer vos ennemis.\r\n TESTEZ VOS CAPACITES CONTRE LES MEILLEURS  Le mode multijoueur saméliore avec lapparition de nouveaux modes de jeux par équipes.\r\n DECOUVREZ UN GAMEPLAY REVOLUTIONNAIRE  Jouez dans lAnimus et explorez-en les limites pour lever le mystère sur le passé de Desmond et découvrir ce que le futur vous réserve...\r\n\r\n<b>Contenu de la version Animus</b>\r\n\r\n- La boîte Animus : brisez le sceau des Assassins pour découvrir son contenu\r\n- Une encyclopédie complète, qui contient des informations précises sur les personnages et les événements principaux du jeu, ainsi que sur d''autres éléments de l''univers Assassin''s Creed®.\r\n- Contenu de jeu :\r\n La prison de Vlad. Retrouvez le légendaire Vlad l''Empaleur, le fléau de Constantinople qui a inspiré le mythe de Dracula. Partez à la recherche de la cellule de cet être sinistre pour récupérer son arme, une dague redoutable, capable de vaincre n''importe quel ennemi au corps à corps.\r\n Des améliorations de capacité pour vos balles de pistolet caché, bombes et carreaux d''arbalète qui vous donneront un avantage décisif dans la bataille.\r\n Deux personnages multijoueur supplémentaires : incarnez le croisé et le bouffon ottoman, une variante locale du fameux personnage tiré d''Assassin''s Creed® Brotherhood.\r\n L''armure de Brutus d''Assassin''s Creed® Brotherhood.\r\n Un élément de personnalisation exceptionnel.', 0, 39.99, 'a:1:{i:0;s:3:"ps3";}', '2014-04-06 16:42:58', '1396802382.jpg'),
(2, 'The Last Of Us', 'The Last Of Us raconte l’histoire deux personnages, Joël (survivant impitoyable) et Ellie (jeune adolescente plutôt mûre pour son age) qui errent dans une ville décimée par une peste des temps modernes. Dans une ville abandonnée, où la nature a repris ses droits, des hommes et des femmes s’entretuent pour de la nourriture, des armes et tout autre objet sur lequel ils peuvent mettre la main.\r\n\r\nTout au long de leur périple qui va les amener d’un bout à l’autre de ce qu’il reste des États-Unis, Joël et Ellie doivent travailler main dans la main s’ils veulent survivre.', 1, 39.99, 'a:1:{i:0;s:3:"ps3";}', '2014-04-06 17:18:55', '1396804725.jpg'),
(3, 'Grand Theft Auto V', 'Los Santos : une métropole tentaculaire avec ses gourous, ses starlettes et ses gloires du passé fanées qui faisaient jadis rêver le monde entier et qui, aujourd''hui, luttent pour ne pas sombrer dans l''oubli alors que le pays est rongé par la crise. Au milieu de ce chaos ensoleillé, trois criminels très différents jouent gros pour leur avenir : Franklin, un ancien membre de gang de rue qui veut passer à la vitesse supérieure , Michael, le professionnel, un ex-détenu dont la retraite est beaucoup moins tranquille que prévue , et enfin Trevor, le psychopathe du groupe, camé et mégalo. Le dos au mur, les trois hommes risquent le tout pour le tout dans une série de braquages spectaculaires et dangereux.\r\n\r\n<b>Important</b>\r\nGrand Theft Auto V est le plus grand et le plus ambitieux des jeux Rockstar Games créés et exploite toute la puissance des consoles de la génération actuelle. Dans le but de fournir la meilleure expérience possible pour un monde si vaste et extrêmement détaillé, le jeu nécessite une installation sur Xbox 360.\r\n\r\nGrand Theft Auto V se présente sur deux disques , le Disque 1 est utilisé pour une installation unique obligatoire et le Disque 2 est utilisé pour jouer. Après linstallation, les joueurs peuvent profiter à la fois de Grand Theft Auto V et de Grand Theft Auto Online en utilisant uniquement le Disque 2.\r\n\r\nLinstallation initiale nécessite un Disque Dur Xbox 360 ou une clé USB de 16 Go (vendus séparément) avec un espace libre dau moins 8 Go. Si vous utilisez une clé USB, il faut une version 2.0 avec au minimum une vitesse de lecture de 15mb/s et formatée pour être utilisée sur Xbox 360. Une nouvelle clé USB est recommandée pour sassurer dune performance optimum.', 1, 29.99, 'a:1:{i:0;s:7:"xboxone";}', '2014-04-06 17:39:33', '1396805792.jpg'),
(4, 'Rayman Contre les Lapins Crétins', 'Le calme et la tranquillité régnaient à la Fnac. Et soudain, en moins de temps qu’il n’en faut pour hurler Bwaaah !, les lapins Crétins ont débarqué, bien déterminés à semer la pagaille!\r\nDepuis j''ai comme des envies de violence face à tant de sourires niais. Mais si je craque on va encore dire que les jeux vidéos rendent violents.\r\nPar pitié débarrassez nous de cette vermine!', 1, 24.18, 'a:1:{i:0;s:3:"wii";}', '2014-04-06 17:44:17', '1396806181.png'),
(5, 'Super Smash Bros. for Wii U', 'Super Smash Bros. for Wii U est un jeu de combat en arènes dans lesquelles s’affrontent un grand nombre de personnages issus de l’univers de Nintendo, tels que Pikachu, Link, Mario, Samus, ou encore Donkey Kong. De nouveaux combattants arrivent également tels que Luigi, la coach de Wii Fit, et même le villageois de Animal Crossing. De nombreux modes sont disponibles, et le mode multijoueur est bien évidemment toujours de la partie.', 0, 59.9, 'a:1:{i:0;s:4:"wiiu";}', '2014-04-06 17:46:57', '1396806352.jpg'),
(6, 'Watch Dogs Edition Vigilante', 'Watch_Dogs vous plonge au coeur de la ville hyper-connectée de Chicago, dans laquelle votre smartphone vous donne le contrôle de tout ce qui est connecté au réseau : des caméras de surveillance aux feux de signalisation, en passant par le réseau électrique. \r\n\r\nIncarnez Aiden Pearce, un hacker hanté par son passé et lancé dans une vendetta contre les responsables du massacre de sa famille. Dans votre quête de justice, la ville elle-même devient une arme mortelle et vous en détenez maintenant le contrôle !\r\n\r\n Piratez et contrôlez la ville à laide de votre smartphone : manipulez les feux de circulation pour provoquer un accident, coupez le courant pour créer le chaos, ou stoppez un train pour monter à bord et échapper aux forces de l''ordre. Tout ce qui est connecté au réseau peut devenir votre arme.\r\n\r\n Neutralisez vos ennemis brutalement à coup de matraque, ou utilisez l''une des 30 armes disponibles dans des fusillades nerveuses et spectaculaires.\r\n\r\n Prenez le volant de plus de 65 véhicules bénéficiant d''une physique et dune conduite minutieusement travaillées, et ressentez l''adrénaline de courses-poursuites intenses et spectaculaires.\r\n\r\n Grâce à la puissance du tout nouveau moteur de jeu Disrupt, plongez dans une monde urbain réaliste, et observez limpact instantané de vos actions sur toute la ville et sa population.', 0, 89.99, 'a:1:{i:0;s:3:"ps4";}', '2014-04-06 17:56:18', '1396806894.jpg'),
(7, 'New Super Mario Bros. Wii', 'Pour la toute première fois, vous pourrez découvrir un jeu Mario en 2D sur votre console Wii et vous amuser en jouant à plusieurs, et en simultané !\r\n\r\nLe jeu, une aventure classique en 2D, suit le style de New Super Mario Bros. pour la Nintendo DS. La Princesse Peach a été kidnappée par Bowser et cest à Mario de la sauver, mais, cette fois, il nest pas seul ! Jusquà quatre joueurs peuvent samuser en même temps et incarner Mario, Luigi ou lun des personnages Toad. Bien entendu, vous pourrez également jouer seul et améliorer vos performances... Mais vos amis et les membres de votre famille auront très vite envie de prendre leur Wiimote et de participer !\r\n\r\nNew Super Mario Bros. Wii propose un savant mélange de jeu coopératif et compétitif. Vous pourrez collaborer pour sauver la Princesse Peach, ou utiliser votre dextérité pour vous battre et décrocher le meilleur classement. Vous pourrez aussi coopérer en sauvant vos amis du danger, ou vous débarrasser de la concurrence en les jetant dans les pièges !\r\n\r\nLa détection des mouvements de la Wii a été intelligemment mise à profit pour améliorer le gameplay à certains endroits du jeu. Le joueur pourra, par exemple, orienter une plate-forme semblable à une balançoire en penchant la Wiimote et ainsi atteindre des zones secrètes, ou encore orienter le rayon dune lampe pour trouver son chemin dans le noir !\r\n\r\nParmi les nouvelles caractéristiques du jeu vous trouverez la combinaison à réaction qui, lorsque vous secouez la télécommande Wii, permet à votre personnage de voler et de planer... Très pratique pour atteindre les zones secrètes ! Vous pourrez aussi utiliser votre combinaison pour aider vos partenaires de jeu : par exemple, si un autre joueur vous attrape, vous pourrez voler tous les deux ensembles ! Vous découvrirez également une nouvelle combinaison de pingouin qui vous permettra non seulement de lancer des boules de glace sur les ennemis, mais aussi de glisser sur le ventre à une vitesse incroyable dans les sections gelées du jeu !', 0, 44.99, 'a:1:{i:0;s:3:"wii";}', '2014-04-06 18:00:58', '1396807181.jpg'),
(8, 'Titanfall', 'Titanfall sur Xbox 360 est un FPS multijoueur mettant en scène l''affrontement entre de puissants mechas et une infanterie lourdement armée dans un univers science-fiction.', 0, 59.9, 'a:2:{i:0;s:7:"xboxone";i:1;s:2:"pc";}', '2014-04-06 18:04:41', '1396807384.jpg'),
(9, 'Segfaulter', 'Un type d''un genre étrange découvre un jour qu''il possède le pouvoir de faire segfaulter le cerveau humain...\r\n\r\nSon pauvre patron en a fait l''expérience, pauvre de lui :D', 1, 0.02, 'a:1:{i:0;s:2:"pc";}', '2014-04-06 18:14:42', '1396808006.gif');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
