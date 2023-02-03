SET
    NAMES utf8;

SET
    time_zone = '+00:00';

SET
    foreign_key_checks = 0;

SET
    sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET
    NAMES utf8mb4;

INSERT INTO
    `Bewertung` (
        `id`,
        `administrativeId`,
        `projectId`,
        `kriterienId`,
        `bewertung`,
        `finish`
    )
VALUES
    (52, 4, 2, 1, 4, 1),
    (53, 4, 2, 2, 3, 1),
    (54, 4, 2, 3, 2, 1),
    (55, 4, 4, 1, 1, 0),
    (56, 4, 4, 2, 3, 0),
    (57, 4, 4, 3, 5, 0),
    (58, 4, 3, 1, 2, 0),
    (59, 4, 3, 2, 3, 0),
    (60, 4, 3, 3, 4, 0),
    (61, 4, 5, 1, 2, 0),
    (62, 4, 5, 2, 1, 0),
    (63, 4, 5, 3, 1, 0),
    (64, 4, 1, 1, 2, 0),
    (65, 4, 1, 2, 3, 0),
    (66, 4, 1, 3, 5, 0),
    (67, 3, 3, 1, 2, 0),
    (68, 3, 3, 2, 3, 0),
    (69, 3, 3, 3, 2, 0),
    (70, 3, 4, 1, 4, 0),
    (71, 3, 4, 2, 4, 0),
    (72, 3, 4, 3, 4, 0),
    (73, 3, 2, 1, 2, 0),
    (74, 3, 2, 2, 3, 0),
    (75, 3, 2, 3, 3, 0),
    (76, 3, 1, 1, 4, 0),
    (77, 3, 1, 2, 4, 0),
    (78, 3, 1, 3, 5, 0),
    (79, 3, 5, 1, 2, 0),
    (80, 3, 5, 2, 2, 0),
    (81, 3, 5, 3, 4, 0),
    (82, 4, 24, 1, 4, 0),
    (83, 4, 24, 2, 5, 0),
    (84, 4, 24, 3, 4, 0),
    (85, 4, 25, 1, 4, 0),
    (86, 4, 25, 2, 5, 0),
    (87, 4, 25, 3, 5, 0),
    (88, 4, 27, 1, 3, 0),
    (89, 4, 27, 2, 4, 0),
    (90, 4, 27, 3, 3, 0),
    (91, 4, 26, 1, 3, 0),
    (92, 4, 26, 2, 5, 0),
    (93, 4, 26, 3, 3, 0),
    (94, 4, 28, 1, 4, 0),
    (95, 4, 28, 2, 5, 0),
    (96, 4, 28, 3, 3, 0),
    (97, 4, 30, 1, 2, 0),
    (98, 4, 30, 2, 4, 0),
    (99, 4, 30, 3, 3, 0),
    (100, 4, 29, 1, 4, 0),
    (101, 4, 29, 2, 5, 0),
    (102, 4, 29, 3, 5, 0);

INSERT INTO
    `Competition` (
        `id`,
        `title`,
        `text`,
        `teilnehmerbedingung`,
        `wettbewerbbeginn`,
        `wettbewerbende`,
        `wettbewerbCloseText`
    )
VALUES
    (
        2,
        '<h1>Wettbewerb Stickstoff</h1>',
        '<font size=\"4\"><b><i>Lang</i> </b>oder über<i> <b>Kurz</b> </i>ergibt der <b><sup>Text</sup> nicht viel <sub>Sinn </sub><strike>asdadada</strike></b></font>',
        '<ul><li><b>mindestens 18 Jahre alt.</b></li><li><b>Test</b></li><li><b>Testtext 13</b></li></ul>',
        '2021-02-09',
        '2023-03-07',
        '<font size=\"7\">Der Wettbewerb ist geschlossen <b>seit dem 24 März</b>. Die Auswertung ist im Gange und wird am 12.Mai bekannt </font>'
    );

INSERT INTO
    `Image` (`id`, `projectid`, `path`)
VALUES
    (20, 2, '../data/project0/Image0.png'),
    (21, 2, '../data/project0/Image1.png'),
    (22, 3, '../data/project1/Image0.png'),
    (23, 3, '../data/project1/Image1.png'),
    (37, 24, '../data/project7/Image0.png'),
    (38, 25, '../data/project8/Image0.png'),
    (39, 26, '../data/project9/Image0.png'),
    (40, 27, '../data/project10/Image0.png'),
    (41, 28, '../data/project11/Image0.png'),
    (42, 29, '../data/project12/Image0.png'),
    (43, 30, '../data/project13/Image0.png');

INSERT INTO
    `Kriterien` (`id`, `frage`)
VALUES
    (1, 'Wie ist die Stoffwahl?'),
    (2, 'Wie ist das Stickmuster?'),
    (3, 'Wie ist der Kontrast?');

INSERT INTO
    `Project` (`id`, `userId`, `title`, `text`)
VALUES
    (1, 1, 'Sankt Nicolaustag test', 'nicht viel'),
    (2, 2, 'HexStick ', 'FF or something like that'),
    (
        3,
        7,
        'Täglicher Begleiter 2',
        'Auch gibt es niemanden, der den Schmerz an sich liebt, sucht oder wünscht, nur, weil er Schmerz ist, es sei denn, es kommt zu zufälligen Umständen, in denen Mühen und Schmerz ihm große Freude bereiten können. Um ein triviales Beispiel zu nehmen, wer von uns unterzieht sich je anstrengender körperlicher Betätigung, außer um Vorteile daraus zu ziehen? Aber wer hat irgend ein Recht, einen Menschen zu tadeln, der die Entscheidung trifft, eine Freude zu genießen, die keine unangenehmen Folgen hat, oder einen, der Schmerz vermeidet, welcher keine daraus resultierende Freude nach sich zieht? Auch gibt es niemanden, der den Schmerz an sich liebt, sucht oder wünscht, nur, weil er Schmerz ist, es sei denn, es kommt zu zufälligen Umständen, in denen Mühen und Schmerz ihm große Freude bereiten können. '
    ),
    (
        4,
        8,
        'Werther',
        'Eine wunderbare Heiterkeit hat meine ganze Seele eingenommen, gleich den süßen Frühlingsmorgen, die ich mit ganzem Herzen genieße. Ich bin allein und freue mich meines Lebens in dieser Gegend, die für solche Seelen geschaffen ist wie die meine.\r\n\r\nIch bin so glücklich, mein Bester, so ganz in dem Gefühle von ruhigem Dasein versunken, daß meine Kunst darunter leidet. Ich könnte jetzt nicht zeichnen, nicht einen Strich, und bin nie ein größerer Maler gewesen als in diesen Augenblicken. Wenn das liebe Tal um mich dampft, und die hohe Sonne an der Oberfläche der undurchdringlichen Finsternis meines Waldes ruht, und nur einzelne'
    ),
    (5, 9, 'Brueggli', 'lange lebe es!'),
    (24, 31, 'test', 'test'),
    (25, 32, 'test', 'test'),
    (26, 33, 'test', 'test'),
    (27, 34, 'adadadsa', 'dsadasdadasdasd'),
    (28, 35, 'adadadsa', 'dsadasdadasdasd'),
    (29, 36, 'adadadsa', 'dsadasdadasdasd'),
    (30, 37, 'asadadsad', 'dadadadsd');

INSERT INTO
    `Pw` (`id`, `hash`)
VALUES
    (
        1,
        'c8828f8e1633bd8e42b6b20fd96583a54eb14dcd522963506e90c67233387207323f8855b9758526b60f70682f99bcba3f4f4a78d02b50bb551008741619153b'
    ),
    (
        2,
        '$2y$12$QjSH496pcT5CEbzjD/vtVeH03tfHKFy36d4J0Ltp3lRtee9HDxY3K'
    ),
    (
        3,
        'd3665c5680690d98214db70c3d5714f83eb168b2adb6575b6d0088513ad6acea847b339a8dce0099d804a5a8d6609f17b9193236dad91beb61f5d15d86148c7f'
    ),
    (
        4,
        'ce670ee7ba34c1a9eb527fcde2ec2c1e5feac41ee70a4505734eb9d18d5bc8d62e61fe9762910ee2a0ecc7ef459353052cc5eec3fac19a841647b2f668f39c1c'
    ),
    (
        5,
        '397bf6b54622a374516f917d6bb60f4f8a773e883f3fb7b20e4704c056028e322f1c7233ee1bd1bc45fa5da6033ced24d24197657c4d2fa1ae2ae40522fb4da5'
    ),
    (
        6,
        '96c870fd10376e5e7a070a2d2aa4b621f00041e7f78cbebb3f59e323a9b308641874a48b7013288975c5c3253e536ce894d8efe7dfad78bf00beeb8dec16562c'
    ),
    (
        7,
        '66b6c546912052d4d184baa17caafeae385c3f3dd4ca5b73caa46602fd92f666fc688b88be06c980abacdf1b2ca699e807fc298ccf50139b3041bce11dcd1a0f'
    ),
    (
        8,
        '30049ee3949b37d2eccaad1a5a674018054017691592558bcdefa6d8f61b943cacd3e170b11982dcf6cf1b3797354e74793efd47a6f0f010676609b9ed1db4c7'
    ),
    (
        9,
        '33154d550da512da77ce99d0dcf87607b9044dc33bb93c0ec1b21bafc7efce54c54de06cb1c5acba24329dd616a8a9751643aa94e6d0bc0e99cbd6b5ef50846f'
    ),
    (
        10,
        '3c7e7df167fa197e5deb7eb19e8ba606fa4e8cb43063c083a7a110ce826ab972be76b4866afad5694e50a31be8a5e6e8f04310178d121fe4eb1d29a35711c3a9'
    ),
    (
        22,
        '2e57fda4ef32239a9c83b12fedd99806fb035c3d39a8bb66e0270129858726ec9f12cda55917988281027524f887dd85c608ec203d2bcd43f2b81e4d2ab7a7be'
    ),
    (
        23,
        '19cca3bbc302b4a91a6fe290585d74e0f922fb29ccffc16adaf6d986bfeba722a7f0cf52d30bb63454d9c45fc2a2527b7ca77061d5c4202347cc4dd45b29ce28'
    ),
    (
        24,
        '6e355d57768f2fc3005bf6d1934739eb22af3c4d72b6ea276f3715cf211f1f30554403437748053eaadf720cddc45ea059c0778986dfcfddccfe1b5b00844d56'
    ),
    (
        32,
        'a71e51bd4dbb3f2d7188b716b5d0fcbaec2980f75e408de1683e688545c32b51f7f374f69232871177e12a848e1d216a1a1d300ad8f2a616b9da9c4232bde7ee'
    ),
    (
        33,
        '61006577197ae9d5d45e649893e9986c6812252cdf5f969fc4df0fcf46baf2cf19dac65033332994e75e0e8c9a4066449c200f0975bca9b2fc1f4ad4239c33c0'
    ),
    (
        34,
        '9471fea88040dbdb4857914706c7022de8da815c1e1940f16f044f9eb7954f9c7131cd9cf09fb3b9db56848d232fa6002dda5afa4f7f74eb0ca791b0e30f5b12'
    ),
    (
        35,
        '5ee732ed4c6339ab359931b96683a2a4a65cb4c27f375474940f5acc7d99e1f898e18089a5601c16783f36ecdc68e3953b06d7caba91630611964bab3ce2dd36'
    ),
    (
        36,
        '1c0edd2a7ddfcada4cf93cddecf45f6d6d02f4334f23abe7e237cad5bc646bcd52d9ed0b3e1a6377b00679b680bda46dfb9b01a5edf756088112cb4ef0fb1aef'
    ),
    (
        37,
        '33d23f60e8a86cca5c4b47a637156055656d5259b76884d52be48a9858dc274e20a12f2425ac97aee6304bd48881ed3805851e32f079f9100cce8ea3d60ac8ae'
    ),
    (
        38,
        'b772d4fbcbcc1ee39ee24905c0c6abb497e93141162f152b3a565ea2005da01f2616c25a91ce0bd0dc752cd833805a4b83eb458bc4750101bf0f529eaf166aed'
    );

INSERT INTO
    `Salt` (`id`, `salt`)
VALUES
    (1, 1000000000),
    (2, 1000000000),
    (3, 1000000000),
    (4, 1000000000),
    (5, 1931822859),
    (6, 3632013457),
    (7, 7728136415),
    (8, 4140439885),
    (9, 3923884473),
    (10, 2376418949),
    (22, 2188335785),
    (23, 2686182262),
    (24, 8562076677),
    (32, 7209756852),
    (33, 3687941967),
    (34, 8645510835),
    (35, 5759256307),
    (36, 9979967985),
    (37, 9514388684),
    (38, 7648326930);

INSERT INTO
    `User` (
        `id`,
        `name`,
        `surname`,
        `role`,
        `email`,
        `land`,
        `plz`,
        `ortschaft`,
        `strasse`,
        `strNr`,
        `tel`,
        `vorwahl`,
        `pwId`,
        `saltId`,
        `optIn`,
        `token`
    )
VALUES
    (
        1,
        'Leandro-Davide',
        'Nicolaus',
        'teilnehmende',
        'cookies@gmail.com',
        'CHE',
        8550,
        'entenhausen',
        'wasserentchenstr.',
        69,
        7841411499,
        NULL,
        2,
        2,
        NULL,
        NULL
    ),
    (
        2,
        'Manuel',
        'Schumacher',
        'teilnehmende',
        'nanomail@gmail.com',
        'CHE',
        8456,
        'Nowhere',
        'binarystreet',
        1111,
        794502143,
        NULL,
        3,
        3,
        NULL,
        NULL
    ),
    (
        3,
        'Yannick',
        'Basler',
        'admin',
        'poppel@gmx.ch',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        1,
        1,
        1,
        'cookies'
    ),
    (
        4,
        'Joaquin Pablo',
        'Koller Garcia',
        'jury',
        'business@gmail.com',
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        4,
        4,
        NULL,
        NULL
    ),
    (
        5,
        'Alexander',
        'Widmer',
        'jury',
        'testen@gmail.com',
        'CH',
        9000,
        'St.Galle',
        '',
        42,
        66666666,
        '+75',
        5,
        5,
        NULL,
        NULL
    ),
    (
        6,
        'Kevin',
        'Doeding',
        'jury',
        'derchief@gmail.com',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        NULL,
        6,
        6,
        NULL,
        NULL
    ),
    (
        7,
        'test',
        'test',
        'teilnehmende',
        'test@gmail.com',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        NULL,
        7,
        7,
        NULL,
        NULL
    ),
    (
        8,
        'Thomas',
        'Weber',
        'teilnehmende',
        'leinen@gmail.com',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        NULL,
        8,
        8,
        NULL,
        NULL
    ),
    (
        9,
        'Stephan',
        'Höse',
        'teilnehmende',
        'Stephan.hoese@gmail.com',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        NULL,
        9,
        9,
        NULL,
        NULL
    ),
    (
        10,
        'Douglas',
        'Duda',
        'jury',
        'JSLove@gmail.com',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        NULL,
        10,
        10,
        NULL,
        NULL
    ),
    (
        24,
        'Mark',
        'Mathis',
        'jury',
        'shoggi@gmx.ch',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        NULL,
        24,
        24,
        NULL,
        NULL
    ),
    (
        31,
        'test',
        'test',
        'teilnehmende',
        'test@gm.csd',
        'AU',
        NULL,
        'adsdad',
        'asdad',
        3,
        485,
        '+4885',
        32,
        32,
        NULL,
        '7cfcd9d54a546a0b0ce2a63f89a0cd52'
    ),
    (
        32,
        'test',
        'test',
        'teilnehmende',
        'test@gm.csd',
        'AU',
        2133,
        'adsdad',
        'asdad',
        3,
        485,
        '+4885',
        33,
        33,
        NULL,
        'c0d62fc7ebce31d4d465239103863ba0'
    ),
    (
        33,
        'test',
        'test',
        'teilnehmende',
        'test@gm.csd',
        'AU',
        2133,
        'adsdad',
        'asdad',
        3,
        485,
        '+4885',
        34,
        34,
        NULL,
        'ce8b8cea08501f1bc1531940ccbe65ee'
    ),
    (
        34,
        'adsdasda',
        'dadsdsadsad',
        'teilnehmende',
        'asdsadasd@gm.asd',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        '',
        35,
        35,
        NULL,
        '0b43e9cd838ff7ca30bb385a9803c1ea'
    ),
    (
        35,
        'adsdasda',
        'dadsdsadsad',
        'teilnehmende',
        'asdsadasd@gm.asd',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        '',
        36,
        36,
        NULL,
        '483384a1270bb31c388aa662c12d33eb'
    ),
    (
        36,
        'adsdasda',
        'dadsdsadsad',
        'teilnehmende',
        'kkdgdgg@gm.asd',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        '',
        37,
        37,
        NULL,
        '169a649aee9407770c90e4b2ca8feacb'
    ),
    (
        37,
        'dsadsa',
        'adadasdsada',
        'teilnehmende',
        'vbdfbf@gm.dh',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        '',
        38,
        38,
        1,
        '8097831a8d59ac92ff98633b66c96bb5'
    );