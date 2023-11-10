SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;


INSERT INTO `Competition` (`id`, `title`, `text`, `teilnehmerbedingung`, `wettbewerbbeginn`, `wettbewerbende`, `wettbewerbCloseText`, `istProjektLoeschenUserErlaubt`, `istEmailAktiv`) VALUES
    (2,	'<h3><font size=\"7\">Gewinnspiel Sequenz 5</font></h3>',	'<font size=\"4\"><b><i>Lang</i> </b>oder über<i> <b>Kurz</b> </i>ergibt der <b><sup>Text</sup> nicht viel <sub>Sinn </sub><strike>asdadada</strike></b></font>',	'<ul><li><b>mindestens 18 Jahre alt.</b></li><li><b>Krass sein</b></li><li><b>Hart sein<br></b></li><li><b>Nochmal krass sein<br></b></li></ul>',	'2021-02-11',	'2023-04-30',	'<font size=\"7\">Der Wettbewerb ist geschlossen <b>seit dem 24 März</b>. Die Auswertung ist im Gange und wird am 12.Mai bekannt </font>',	CONV('0', 2, 10) + 0,	CONV('0', 2, 10) + 0);


INSERT INTO `Kriterien` (`id`, `frage`) VALUES
                                            (1,	'Kreativität/Originalität'),
                                            (2,	'Technik/ handwerkliche Umsetzung'),
                                            (3,	'Design/ Farbzusammenspiel'),
                                            (4,	'persönlicher Geschmack/ Gesamteindruck');


INSERT INTO `Pw` (`id`, `hash`) VALUES
                                    (1,	'c8828f8e1633bd8e42b6b20fd96583a54eb14dcd522963506e90c67233387207323f8855b9758526b60f70682f99bcba3f4f4a78d02b50bb551008741619153b'),
                                    (4,	'ce670ee7ba34c1a9eb527fcde2ec2c1e5feac41ee70a4505734eb9d18d5bc8d62e61fe9762910ee2a0ecc7ef459353052cc5eec3fac19a841647b2f668f39c1c');

INSERT INTO `Salt` (`id`, `salt`) VALUES
                                      (1,	1000000000),
                                      (4,	1000000000);

INSERT INTO `User` (`id`, `name`, `surname`, `role`, `email`, `land`, `plz`, `ortschaft`, `strasse`, `strNr`, `tel`, `vorwahl`, `pwId`, `saltId`, `optIn`, `token`) VALUES
                                                                                                                                                                        (3,	'Admin',	'Admin',	'admin',	'admin@admin.ch',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	1,	''),
                                                                                                                                                                        (4,	'JuryMitglied',	'Beispiel',	'jury',	'jurymitglied@beispiel.beispiel',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	4,	NULL,	NULL);