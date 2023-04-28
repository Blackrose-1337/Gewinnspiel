SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

INSERT INTO `Bewertung` (`id`, `administrativeId`, `projectId`, `kriterienId`, `bewertung`, `finish`) VALUES
                                                                                                          (110,	118,	168,	1,	3,	0),
                                                                                                          (111,	118,	168,	2,	4,	0),
                                                                                                          (112,	118,	168,	3,	3,	0),
                                                                                                          (113,	118,	168,	4,	4,	0),
                                                                                                          (114,	118,	169,	1,	5,	1),
                                                                                                          (115,	118,	169,	2,	5,	1),
                                                                                                          (116,	118,	169,	3,	5,	1),
                                                                                                          (117,	118,	169,	4,	5,	1),
                                                                                                          (118,	118,	170,	1,	4,	0),
                                                                                                          (119,	118,	170,	2,	3,	0),
                                                                                                          (120,	118,	170,	3,	4,	0),
                                                                                                          (121,	118,	170,	4,	3,	0),
                                                                                                          (122,	118,	171,	1,	NULL,	0),
                                                                                                          (123,	118,	171,	2,	4,	0),
                                                                                                          (124,	118,	171,	3,	4,	0),
                                                                                                          (125,	118,	171,	4,	NULL,	0),
                                                                                                          (126,	118,	172,	1,	3,	1),
                                                                                                          (127,	118,	172,	2,	2,	1),
                                                                                                          (128,	118,	172,	3,	5,	1),
                                                                                                          (129,	118,	172,	4,	5,	1);

INSERT INTO `Competition` (`id`, `title`, `text`, `teilnehmerbedingung`, `wettbewerbbeginn`, `wettbewerbende`, `wettbewerbCloseText`) VALUES
    (2,	'<h3><font size=\"7\">Gewinnspiel Sequenz 5</font></h3>',	'<font size=\"4\"><b><i>Lang</i> </b>oder über<i> <b>Kurz</b> </i>ergibt der <b><sup>Text</sup> nicht viel <sub>Sinn </sub><strike>asdadada</strike></b></font>',	'<ul><li><b>mindestens 18 Jahre alt.</b></li><li><b>Krass sein</b></li><li><b>Hart sein<br></b></li><li><b>Nochmal krass sein<br></b></li></ul>',	'2021-02-11',	'2023-04-30',	'<font size=\"7\">Der Wettbewerb ist geschlossen <b>seit dem 24 März</b>. Die Auswertung ist im Gange und wird am 12.Mai bekannt </font>');

INSERT INTO `Image` (`id`, `projectid`, `path`) VALUES
                                                    (726,	168,	'./image/project168/ED5B3A09-55F0-4289-A80D-A47E6E2107B1/image01.png'),
                                                    (728,	169,	'./image/project169/CA60D10D-3959-4711-BD22-043EE05DAE66/image01.png'),
                                                    (729,	170,	'./image/project170/CD718AF1-D82B-49D3-BE89-8DD67E67E093/image01.png'),
                                                    (730,	171,	'./image/project171/07D23C6C-8FF6-42F2-AF39-BDCF4E86B032/image01.png'),
                                                    (731,	172,	'./image/project172/1F4065FD-B646-41AC-BE9F-E4816ECAE956/image01.png'),
                                                    (794,	171,	'./image/project171/07D23C6C-8FF6-42F2-AF39-BDCF4E86B032/image007.png'),
                                                    (795,	171,	'./image/project171/07D23C6C-8FF6-42F2-AF39-BDCF4E86B032/image009.png'),
                                                    (796,	171,	'./image/project171/07D23C6C-8FF6-42F2-AF39-BDCF4E86B032/image010.png'),
                                                    (797,	171,	'./image/project171/07D23C6C-8FF6-42F2-AF39-BDCF4E86B032/image011.png'),
                                                    (798,	171,	'./image/project171/07D23C6C-8FF6-42F2-AF39-BDCF4E86B032/image012.png'),
                                                    (799,	171,	'./image/project171/07D23C6C-8FF6-42F2-AF39-BDCF4E86B032/image013.png'),
                                                    (800,	171,	'./image/project171/07D23C6C-8FF6-42F2-AF39-BDCF4E86B032/image014.png'),
                                                    (801,	171,	'./image/project171/07D23C6C-8FF6-42F2-AF39-BDCF4E86B032/image015.png'),
                                                    (840,	171,	'./image/project171/07D23C6C-8FF6-42F2-AF39-BDCF4E86B032/image022.png'),
                                                    (1059,	172,	'./image/project172/1F4065FD-B646-41AC-BE9F-E4816ECAE956/image003.png'),
                                                    (1060,	172,	'./image/project172/1F4065FD-B646-41AC-BE9F-E4816ECAE956/image004.png'),
                                                    (1061,	172,	'./image/project172/1F4065FD-B646-41AC-BE9F-E4816ECAE956/image005.png'),
                                                    (1062,	172,	'./image/project172/1F4065FD-B646-41AC-BE9F-E4816ECAE956/image006.png'),
                                                    (1063,	172,	'./image/project172/1F4065FD-B646-41AC-BE9F-E4816ECAE956/image007.png');

INSERT INTO `Kriterien` (`id`, `frage`) VALUES
                                            (1,	'Kreativität/Originalität'),
                                            (2,	'Technik/ handwerkliche Umsetzung'),
                                            (3,	'Design/ Farbzusammenspiel'),
                                            (4,	'persönlicher Geschmack/ Gesamteindruck');

INSERT INTO `Project` (`id`, `userId`, `title`, `text`, `pictureIncrement`, `finish`) VALUES
                                                                                          (168,	197,	'Handgestickte Blumen',	' Ich habe eine Stickerei von Blumen auf einen Leinenstoff gestickt. Die Blumen sind in verschiedenen Farben und Größen gestaltet. Das Stickbild ist ungefähr 30x40cm groß und kann als Wandbild aufgehängt werden.',	'2',	NULL),
                                                                                          (169,	198,	'Personalisierter Turnbeutel',	' Ich habe einen Turnbeutel mit einem individuellen Schriftzug bestickt. Der Beutel ist aus Baumwolle und die Stickerei in dunkelgrau. Der Schriftzug ist der Name meines Sohnes.',	'2',	NULL),
                                                                                          (170,	199,	'Stickerei auf Jeansjacke',	'Ich habe eine Jeansjacke mit einer Handstickerei verziert. Das Motiv ist ein buntes Blumenfeld. Die Stickerei ist ungefähr 20x30cm groß und befindet sich auf dem Rücken der Jacke.',	'2',	NULL),
                                                                                          (171,	200,	'Stickerei auf Kissen',	'Ich habe ein Kissen mit einer individuellen Stickerei verziert. Das Motiv ist eine Berglandschaft in verschiedenen Grüntönen. Die Stickerei ist ungefähr 15x20cm groß und befindet sich auf der Vorderseite des Kissens.',	'22',	NULL),
                                                                                          (172,	201,	'Stickerei auf T-Shirt',	'Ich habe ein T-Shirt mit einer Handstickerei verziert. Das Motiv ist ein Vogel in verschiedenen Blautönen. Die Stickerei ist ungefähr 10x15cm groß und befindet sich auf der Brusttasche des T-Shirts.',	'7',	NULL);

INSERT INTO `Pw` (`id`, `hash`) VALUES
                                    (1,	'c8828f8e1633bd8e42b6b20fd96583a54eb14dcd522963506e90c67233387207323f8855b9758526b60f70682f99bcba3f4f4a78d02b50bb551008741619153b'),
                                    (4,	'ce670ee7ba34c1a9eb527fcde2ec2c1e5feac41ee70a4505734eb9d18d5bc8d62e61fe9762910ee2a0ecc7ef459353052cc5eec3fac19a841647b2f668f39c1c'),
                                    (134,	'add41f0afad06a1fd8eb6a024f5f247eb29587109bf86fa2c7cabbd5a966664559de5c9527a7cd9ff013db7071b01b3fdf82abc7b7c5e1a9d6056049c8edf50b'),
                                    (141,	'92041ce7d867db6199e6420d8e00ac9901709efbfe5ab04c300f4accfb33007c9ad2b19df707b57dfa6d39dabdda475f8a3db880ebbc933a242b7d8f5e897497'),
                                    (180,	'f49eebef4fe95b60bdc8601947ae04299b3c7a29be0d07a0f6a4abb20a41b45fd57b551400ac7af3e789ab481218d6d9c9ab82b247dce6835a4923d2d9670d9c'),
                                    (182,	'bd3d7a02c06e95f1aa6347c34de62a140400a375330e943117ef93fb2f96931c57e4d3296fa20065b5ac035f583d62a4e73c8ba4fcf53874fa1222005666bc73'),
                                    (184,	'e67154c40afede77eea82311186374a9ec52f44a1baffb8a1b91f7418b419300972122163ead76b3dbce585679201bb5b7589c3440586fb5e2adca39051eb93a'),
                                    (215,	'3d1b98e98214985e17e21cb7903a6c9d2ee45c84cd45d249f197e4271ed64ed05383ef2a97f6140639078a419b78271da20e6219ffffbcba98e3dff00927a057'),
                                    (216,	'e1fbe8940eb0186cf2bf246fb4c607beb01858d203124f92e2a0e9d514cd90266c7a5b9384161d382105a02a3f3c9572695e90db42550906b12070b22ad68048'),
                                    (217,	'e257fb2cb52621c861169a2b3da37c550429248d80d4d5c5e7e70743bc38c1b9c25a7fe31e2c29cf2b092fca021d8f57710485746f2c7c55f3d0d91ae36941eb'),
                                    (218,	'6a64e8218add9dcf9b2e7628c882040eb47ae7a9364f3073330ee309326fe65e38c204a8bd3778954bdbcfdd4779b0f4367f76568674e1501889ac750e9239cc'),
                                    (219,	'f221bd00f47523d7c0c49ebee0406d62e6714939865a7ceb1b7b6677f2ee411276780e2b9417183c6c2d83924e347aefa1842f1a059fcadee75471504280c4d3');

INSERT INTO `Salt` (`id`, `salt`) VALUES
                                      (1,	1000000000),
                                      (4,	1000000000),
                                      (134,	1803906121),
                                      (141,	3304063004),
                                      (180,	8944195501),
                                      (182,	6761248949),
                                      (184,	6214609893),
                                      (215,	4048312457),
                                      (216,	8802812191),
                                      (217,	4829325825),
                                      (218,	5184514966),
                                      (219,	4284859135);

INSERT INTO `User` (`id`, `name`, `surname`, `role`, `email`, `land`, `plz`, `ortschaft`, `strasse`, `strNr`, `tel`, `vorwahl`, `pwId`, `saltId`, `optIn`, `token`) VALUES
                                                                                                                                                                        (3,	'Yannick',	'Basler',	'admin',	'poppel@gmx.ch',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	1,	1,	1,	'cookies'),
                                                                                                                                                                        (4,	'Joaquin Pablo',	'Koller Garcia',	'jury',	'business@gmail.com',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	4,	4,	NULL,	NULL),
                                                                                                                                                                        (118,	'Mark',	'Mathis',	'jury',	'jury@jury.lg',	'',	NULL,	'',	'',	NULL,	NULL,	'',	134,	134,	1,	'aaba0e23ef37157248be39185ed002ee'),
                                                                                                                                                                        (125,	'Thomas',	'Müllter',	'jury',	'öäü@kt.dsc',	'',	NULL,	'',	'',	NULL,	NULL,	'',	141,	141,	NULL,	'e26e3a577d22526968f70b6ceecc7f8f'),
                                                                                                                                                                        (166,	'Tria',	'Wohlenberg',	'jury',	'Tria-Wohlenberg@gmail.com',	'',	NULL,	'',	NULL,	NULL,	NULL,	'',	184,	184,	NULL,	'd41b10c36461d0b31fa9bde39b461313'),
                                                                                                                                                                        (197,	'Anna',	'Meier',	'teilnehmende',	'anna.meier@example.com',	'CH',	6005,	'Luzern',	'Bahnhofstrasse',	15,	NULL,	'',	215,	215,	NULL,	'13ac69b0f2b0b98671d9ea37334e0b8c'),
                                                                                                                                                                        (198,	'Lisa',	'Müller',	'teilnehmende',	'lisa.mueller@example.com',	'DE',	90431,	'Nürnberg',	'Rathsbergstrasse',	6,	NULL,	'',	216,	216,	NULL,	'f0b7fe550e9e535d07339d4359080c10'),
                                                                                                                                                                        (199,	'Max',	'Schmidt',	'teilnehmende',	'max.schmidt@example.com',	'AU',	8020,	'Graz',	'Keplerstrasse',	22,	NULL,	'',	217,	217,	NULL,	'14f6e7adc485f04b2f71dd636b22c85e'),
                                                                                                                                                                        (200,	'Markus',	'Bauer',	'teilnehmende',	'markus.bauer@example.com',	'CH',	8003,	'Zürich',	'Langstrasse',	10,	NULL,	'',	218,	218,	NULL,	'eee33fb489f62f0a4c2cbd95f22eee00'),
                                                                                                                                                                        (201,	'Stefan',	'Müller',	'teilnehmende',	'stefan.mueller@example.com',	'DE',	10178,	'Berlin',	'Alexanderplatz',	1,	NULL,	'',	219,	219,	NULL,	'c6ae0b086aa104a530b6ea24058e8b9b');