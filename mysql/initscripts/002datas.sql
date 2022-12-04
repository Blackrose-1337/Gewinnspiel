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
    `Competition` (`id`, `title`, `text`, `teilnehmerbedingungen`)
VALUES
    (
        1,
        'Wettbewerb der Schattensticker',
        'Lang oder über Kurz ergibt der Text nicht viel Sinn',
        '- mindestens 18 Jahre alt'
    );

INSERT INTO
    `Project` (`id`, `userId`, `title`, `text`)
VALUES
    (1, 1, 'Sankt Nicolaustag', 'nicht viel'),
    (2, 2, 'HexStick', 'FF or something like that');

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
        '$2y$12$QjSH496pcT5CEbzjD/vtVeH03tfHKFy36d4J0Ltp3lRtee9HDxY3K'
    );

INSERT INTO
    `Salt` (`id`, `salt`)
VALUES
    (1, 1000000000),
    (2, 1000000000),
    (3, 1000000000),
    (4, 1000000000),
    (5, 1000000000);

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
        8547,
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
    );