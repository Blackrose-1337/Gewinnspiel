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
        'huibuh',
        'Lang oder über Kurz ergibt der Text nicht viel Sinnasdadada',
        '-test\n-test2',
        '2021-02-09',
        '2022-08-19',
        'Der Wettbewerb ist geschlossen seit dem 24 März. Die Auswertung ist im Gange und wird am 12.Mai bekannt '
    );

INSERT INTO
    `Kriterien` (`id`, `frage`)
VALUES
    (1, 'Wie ist die Stoffwahl?'),
    (2, 'Wie ist das Stickmuster?'),
    (3, 'Wie ist der Kontrast?');

INSERT INTO
    `Project` (`id`, `userId`, `title`, `text`)
VALUES
    (1, 1, 'Sankt Nicolaustag', 'nicht viel'),
    (2, 2, 'HexStick', 'FF or something like that'),
    (
        3,
        7,
        'Täglicher Begleiter',
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
    `Pw` (`id`, `hash`)
VALUES
    (
        1,
        '$2y$12$QjSH496pcT5CEbzjD/vtVeH03tfHKFy36d4J0Ltp3lRtee9HDxY3K'
    ),
    (
        2,
        '$2y$12$QjSH496pcT5CEbzjD/vtVeH03tfHKFy36d4J0Ltp3lRtee9HDxY3K'
    ),
    (
        3,
        '$2y$12$QjSH496pcT5CEbzjD/vtVeH03tfHKFy36d4J0Ltp3lRtee9HDxY3K'
    ),
    (
        4,
        '$2y$12$QjSH496pcT5CEbzjD/vtVeH03tfHKFy36d4J0Ltp3lRtee9HDxY3K'
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
    (10, 2376418949);

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
        `pwId`,
        `saltId`,
        `optIn`
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
        2,
        2,
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
        3,
        3,
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
        1,
        1,
        NULL
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
        4,
        4,
        NULL
    ),
    (
        5,
        'testen',
        'testen',
        'jury',
        'testen@gmail.com',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        5,
        5,
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
        6,
        6,
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
        7,
        7,
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
        8,
        8,
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
        9,
        9,
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
        10,
        10,
        NULL
    );