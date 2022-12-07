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
        'Wettbewerb der Schattenstickeradsadasdadads',
        'Lang oder über Kurz ergibt der Text nicht viel Sinnasdadada',
        ' -was geht',
        '2021-02-14',
        '2022-08-31',
        'Der Wettbewerb ist geschlossen seit dem 24 März. Die Auswertung ist im Gange und wird am 12.Mai bekannt gegebensaadadaddsdasdadaddd'
    );

INSERT INTO
    `Project` (`id`, `userId`, `title`, `text`)
VALUES
    (1, 1, 'Sankt Nicolaustag', 'nicht viel'),
    (
        2,
        2,
        'HexSticktest',
        'FF or something like that'
    ),
    (
        21,
        29,
        'asdasdasdwererewrewrewrewr',
        'asdsadasd'
    ),
    (22, 30, 'asdadasd', 'asdasdsadsadasdada');

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
        8,
        '397bf6b54622a374516f917d6bb60f4f8a773e883f3fb7b20e4704c056028e322f1c7233ee1bd1bc45fa5da6033ced24d24197657c4d2fa1ae2ae40522fb4da5'
    ),
    (
        9,
        '0ca95273ccef77b45d531d5c2ad941fc67c97af14eddfc8fe0da85c27fd0830acc4844a03c2174c8baa2d68d4b5eaa13fe756f848a101921d15f4844ae7dc0a9'
    ),
    (
        28,
        '66b6c546912052d4d184baa17caafeae385c3f3dd4ca5b73caa46602fd92f666fc688b88be06c980abacdf1b2ca699e807fc298ccf50139b3041bce11dcd1a0f'
    ),
    (
        29,
        '55d77c6541b7ef82040754911764dc48c8347c5c5b073be045533b66d23ceb470aea9c7a68a1a8caa1e5a61aade61e1b6380bd81b09807743f22d6d61ea410c6'
    );

INSERT INTO
    `Salt` (`id`, `salt`)
VALUES
    (1, 1000000000),
    (2, 1000000000),
    (3, 1000000000),
    (4, 1000000000),
    (68, 1931822859),
    (69, 5469338098),
    (88, 7728136415),
    (89, 4067766816);

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
        `saltId`
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
        2
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
        3
    ),
    (
        7,
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
        1
    ),
    (
        8,
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
        4
    ),
    (
        13,
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
        8,
        68
    ),
    (
        14,
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
        9,
        69
    ),
    (
        29,
        'test',
        'test',
        'Teilnehmende',
        'test@gmail.com',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        28,
        88
    ),
    (
        30,
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
        29,
        89
    );