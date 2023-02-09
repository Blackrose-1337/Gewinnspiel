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
    `Kriterien` (`id`, `frage`)
VALUES
    (1, 'Wie ist die Stoffwahl?'),
    (2, 'Wie ist das Stickmuster?'),
    (3, 'Wie ist der Kontrast?');

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
        24,
        '6e355d57768f2fc3005bf6d1934739eb22af3c4d72b6ea276f3715cf211f1f30554403437748053eaadf720cddc45ea059c0778986dfcfddccfe1b5b00844d56'
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
    (24, 8562076677);

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
        'WhereIsIt',
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
    (5, 9, 'Brueggli', 'lange lebe es!');

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
    (81, 3, 5, 3, 4, 0);