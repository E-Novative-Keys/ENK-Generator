--
-- Structure de la table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `maintenance` tinyint(1) NOT NULL DEFAULT '0',
  `allow_register` tinyint(1) NOT NULL DEFAULT '0',
  `shield_attempts` tinyint(2) unsigned NOT NULL DEFAULT '10',
  `shield_duracy` tinyint(2) unsigned NOT NULL DEFAULT '2',
  `calendar` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `homeworks` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `notes` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `informations` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `links` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `courses` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `codiad` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `ftp` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `projets` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `faq` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `mails` tinyint(1) unsigned NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `config`
--

INSERT INTO `config` (`id`, `maintenance`, `allow_register`, `shield_attempts`, `shield_duracy`, `calendar`, `homeworks`, `notes`, `informations`, `links`, `courses`, `codiad`, `ftp`, `projets`, `faq`, `mails`) VALUES
(1, 0, 1, 5, 5, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2);