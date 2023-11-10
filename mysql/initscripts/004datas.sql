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
                                    (1,	'10cc670a8240b03e93bf85bad1ac523faf55e925f51f3303426d9cb7675dce802deee6152d3b4b49bb8f5ba0784213a83b29bf553de5529f090c710afc2ae68b'),
                                    (4,	'9f6e1f9dd678621cc33e6a6c05c12abedff8fbae0ab76c78e59923610c47f7d566885f728762eafce31c1a63d286607a15e5cf8727924cb5aea57298fc2752f0');

INSERT INTO `Salt` (`id`, `salt`) VALUES
                                      (1,	6218090845),
                                      (4,	9607202281);

INSERT INTO `User` (`id`, `name`, `surname`, `role`, `email`, `land`, `plz`, `ortschaft`, `strasse`, `strNr`, `tel`, `vorwahl`, `pwId`, `saltId`, `optIn`, `token`) VALUES
                                                                                                                                                                        (3,	'Admin',	'Admin',	'admin',	'admin@admin.ch',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	1,	''),
                                                                                                                                                                        (4,	'JuryMitglied',	'Beispiel',	'jury',	'jurymitglied@beispiel.bsp',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	4,	1,	NULL);

