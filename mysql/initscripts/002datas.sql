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
    `Image` (`id`, `projectid`, `path`)
VALUES
    (
        98,
        95,
        './images/project95/EAD40981-232C-4573-A56B-38141B4A70D0/image1.png'
    ),
    (
        99,
        95,
        './images/project95/EAD40981-232C-4573-A56B-38141B4A70D0/image2.png'
    ),
    (
        243,
        96,
        './images/project96/D5C46CB1-CC95-41F3-A822-FE8197AF13CA/image4.png'
    ),
    (
        256,
        96,
        './images/project96/D5C46CB1-CC95-41F3-A822-FE8197AF13CA/image7.png'
    ),
    (
        258,
        96,
        './images/project96/D5C46CB1-CC95-41F3-A822-FE8197AF13CA/image9.png'
    ),
    (
        259,
        96,
        './images/project96/D5C46CB1-CC95-41F3-A822-FE8197AF13CA/image7.png'
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
    (2, 2, 'HexStick ', 'FF or something like that'),
    (95, 105, 'BaslerTest', 'Testversuch'),
    (96, 106, 'test', 'test');

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
    ),
    (
        25,
        '0af397b7ff4621fc3187fd4a239100b04bc5fc1ed697d8753fb5f18ad0d7ba6581572edc6a080ab5bc584109b9373fc31433cb7c66933a8472d76dedb83063cc'
    ),
    (
        26,
        '52503d5c279ba83eced2809ad7fa06b97fafee6342a52721bb4e0f60cc0d81f7623f11ece4fe8db0d525aff716a8b9828d38497a2756102c0bc9792ce0c69ef3'
    ),
    (
        27,
        '740fcb7836d56d88dbdefe1a08b3e4bf11a44fcdd5845ab21b8208ae7cafdd9e481305c15662f94c1dd7d03de8b4ccc2b99f46c09061b2bde7effd0d63354cf7'
    ),
    (
        28,
        '7107de68d94865d63e09149f8d40826e7f84ae61e6bf354b75daa8b05d408af6f85833aa4b43b65385b5a12b078e0f608c3cb8bba7c4fd6b02ba71a7f19fb880'
    ),
    (
        29,
        'f0c2a0ef91ff8630903aa9a1a2fce8331c346d67605bb50c881b55b46d7a6dfe82df39df23e346201cc2ba22107ae33c079917d334c20f35194c6c861ccd8aad'
    ),
    (
        30,
        '02b072497cf37fde7e6e74a64da480309497a42fbfaa224c9ff6c84a685cec741e9257de2f3b63a45a92fdc29c84996bdc61a87cd073116079f4b87b67d65297'
    ),
    (
        31,
        'f9d4af597fa8f0d59bbb97f8e70135442f7f5d897f35272acfc1b669eb8cb9c5d8fd23f6536113da8c8260d761421e3d80b293e202f7f8e9c39ef12934e8c47f'
    ),
    (
        32,
        '4588a3149cf16b61a5a21298124a45315b4efd2ef5d92a70ddb165aae5a43ae3c6dc689bc5a59317716ab72a2ebbc1d5d2cbb945168fb3c1ae27bb56af900341'
    ),
    (
        33,
        'd3c1cf1f9dba1583b9a7622d2cf272062801ecfcad45af2c66b4fa262843477b781990d77f7621e42996ceb8cb2de206be631edd217d82ab4622cf2371e6d1e8'
    ),
    (
        34,
        '89949b0715a8b6cc9c212fd992add350ecf88ebac4e9702afc085c19ed8ee510dad6fc9a5b48f5cdc761a0f9fc6c324bad90ade9b8d8524b06a8fae5c929a253'
    ),
    (
        35,
        '39ff1e0e818111096c407455721f8b40d5a6425baccb6f9a4ad9b3bb9c7b6dcd6cff7a46273ab049aa0f7bacdc0eba97e8747923104d8c80a9e7ccb9c0be6f3a'
    ),
    (
        36,
        '3da8d534e4eaf9090018669a0783f6829645423a6d080a88001a2041bc820162c97bc486b97ade9d85d9ebdb3ed71017810b503875e426c88ec12330b7bc2ddc'
    ),
    (
        37,
        '31d329b94388310ba92eb1bebdb218f803c79a74e046ca9e5d5c88f346cccda1d6d3ee3284b5326c3d44be798aa1e50893aa6441345c191405cc3b2799ef11d1'
    ),
    (
        38,
        'b67f119988f065f844082476ad9dc57335057de64985b8f3a4a72640d3f6b0276320b884ca49819d8b68811a7b910e711cc56fb2d68aab73e741717a8242c2ae'
    ),
    (
        39,
        'af52f05be4f70ce3c41b468fd31ae07e7385f00b383f0ee28afed777089b63515511af07ceb91001b3ad366318946c7770bcbe77c69069bff6e3f653eddeec3a'
    ),
    (
        40,
        'e8831d6598f1285e1493394e9aacb9d2066524b10892800c895432aeccacc83a67b3bfdb2dfd54d1ef3863227073533cfe508879d734db37f02c5815f81718bf'
    ),
    (
        41,
        '9e48e2c1a7a476583696e05445c87b1ec627c021ad3498c375d629b0a88b509524ed0dd43ff2c1c79c01285cdbafe4a0603afbacf75ec590a0ffed6e4ad1bae9'
    ),
    (
        42,
        'ff22ce38a4a6e40e57a05d63279bfd42baff0bd67237c22d5a40fc6c884b9bcfa032d006285c9ede4497569ccffe098d19efc17d0355935b89bd977bf5b84f6f'
    ),
    (
        43,
        '989108beb986198e6e59fee983579a6352d4d3dab4cac7d982146d3bf991c9ab2f56399367556837bd697e7d96479b647b6c1886ceda2bb58cb1f60d547cefc4'
    ),
    (
        44,
        'b750598069e5aac248159015d37e950354d8270b2ece592048d25bb7ca1fd5639dc37ae7d19270cab9f30a837cbef65096eea5e88e484dd23db25ec7d822ba9f'
    ),
    (
        45,
        '18d4cf51d4ee38b083c4c7e8ba866285a7f61c6b88befb629078b3a77b6036ea92218cce2c6860a9c5c1eff222990b23259d27bf0834908cd6da3e4a353a8ac2'
    ),
    (
        46,
        'd04540193b56257da23a36278bfe2a3cfdebfe38ae248c0f8d85dd975dd2f00370df5a3842986139fa8b4a116cdb54ece9e964d3f6b603c3981b12f3eaaef426'
    ),
    (
        47,
        'd7adaddc06217068a4529150c7ea298466150b95865b9d706a2822cab14ac9b4b579297db2de57609fd5bcde84f2231c8cf48dc46d925a01364b4d84ae58716e'
    ),
    (
        48,
        '8ff25d368aefa19c66b2c6d70f334eb344a6b99051bfd73d230c2820d0ed208f1907f006e5c189bb36ae83f55d74dbb2c4b60ab57f2cadd8083dd243a06fefe4'
    ),
    (
        49,
        '097218bf27f54ce32245184693b0c478c228f00897185b118ea75772cdb3ea073345f6b137d3ef198bf193f91aa838107650d7525b4c23d23bc999b7408841ec'
    ),
    (
        50,
        'e5eead23b00f9d9b0299d048a54e6cf9052b6c12f0bd28088454fa525dc52358b4bf0ac10295c1cf113484af8872bf875b90b23d1b632b387f5320d733a687a0'
    ),
    (
        51,
        '52700af31746ce5f9655d9c339cf34b1095574040756c6facc24c1b6c312d1b4cf5dc8292864b6ff19732ed5329c7b54ea1f9c7eb05f5e6826aa3c21d6a6e9d8'
    ),
    (
        52,
        'c1fcbbc5afc4dfe00f3682800ff45093e2894697f7d3aed8b98b0be6d010b53be464be2426be6d2d194579cf5202ddc1bec64b4128703c82eabdc6c346fe1241'
    ),
    (
        53,
        '1675163708233d7416839c165348d70b5d1b094b30aec5bd4ad5dbf7110bd7f0a43030e0606c59496ff329071743b2218c609b78028030f5807f55ae74d88b94'
    ),
    (
        54,
        '1de110ca0580441c6fe83162315df82dc88925cdeb7b94fe69d142e71012f0b0cae0840c3fa5449c081506e68a09fea66934728f567dc6bed9a4c0bf14b3afee'
    ),
    (
        55,
        '828ba377dddf875bce6ad273693bc56871494c1c74e8a4c5e1b9f8306bb03e8cd67c719f4a0a3f5a27f6aeed67648a02d63dd1c4209f6c89551b0c81fd286a5d'
    ),
    (
        56,
        '36d11203bcba2f6d4d6b17e428a0fbf3e4f9049e5f8dba7bcf30d12fd1fac5d97461e19af0ff4a6042485517906996418558e09a1e28b4f9392621d927d060db'
    ),
    (
        57,
        '13085137cbd5ee0a0024a510f756d4670e442b97a17b87c7f338530228cdd789411c84915b7e6876814ffb215794c45d119dbde082c667cd9123c874252a36c3'
    ),
    (
        58,
        '670f3e6028eb7ab93e76cd6b1d17be0c3abf5ebd0ff6a1ea09f331b8bf531373dd89932f4767f10cabc97148638d3d67438d58bb27bb10767584840f3ecc2de4'
    ),
    (
        59,
        'f43fad42c5e33fd350455cb284eb4d039466ccb05c8694bced03d0f217f21ad10f6e39eb53279d72db7f562d71af37bf6480e4fe760db407b5893d76612759ae'
    ),
    (
        60,
        'a310539f483eb5cb05f7c3fb5e7a5e58aa4be6486bcbfc0d9bb6324327fb6f74107f1938346c5038417d1b5fbe56ed32555ac6cdd8c8a0cd157c2e66fcf19d33'
    ),
    (
        61,
        '1cf1ae0727c753122280b34a71d65ed988fa45abf44c7c31caa22d3643275f174ac074d8f37d82d3f25c9c6d6dba3e21d694070053894701175d603079d783f1'
    ),
    (
        62,
        '91915a4fd9cdb92fb865dc873f3837de4582f53e06c99280345deb651e1f25572e94f645a1093873a8ef785130cbcd28da66844f2cf4ddde81d2bc4326e3af44'
    ),
    (
        63,
        '132fd568ef2a8a5daa0373f19c7046a890338fdfd574dec8360ea0a3b7fb568d223be973c9db7abc3e24171455947287ff85a614baf44f9a76a917e8fb0ac6f1'
    ),
    (
        64,
        'a1be5e6f2860c97b76bcbb006f23a8a0572f301c7b53adaa735c1405c49b0d8f78f7744f9b04390b5a662046743b8b98a0300af30635925d1e521abd60aa02dc'
    ),
    (
        65,
        'c9e97a095fbc5f262991b2e638177f38b1d9709dc0621a994fe0e04573192751f6705db234a76a8b630aae0165ec398d4a5816344e399dbae7284fec10a2a6a5'
    ),
    (
        66,
        '3df12a98176851a41bfd25ad5fec6a053d852b42ddcc444d7f58c870a06a165f9dbebcc55af1e78f6db4317c7b812bf6a31f113325c82b77275d624c988faa98'
    ),
    (
        67,
        '8de421619d31fba9c33ff4cbfb0e93403431b3238b9fd9669262953d891b5b78d595a78577df61151d557115232e555d26af998d1f4266c43b0029079256a2ee'
    ),
    (
        68,
        '40fd24fedbc13e734d38c0b56022500a0550ff5198faf974dd55ae77871237ed653d5ff0732d348913023c47f5ebcadff6e0f761660a26197854e43277bdeeb1'
    ),
    (
        69,
        '0bb2c8ef9c4dfff7a2b28b5e522faf2a61053e0cfbb8cbd6467e64b4362a85d0a6f0405c65547079516a9277a8f6a74de44db5ff96e5a2b2860eb7e3667d6101'
    ),
    (
        70,
        'dfc17a61cd9c83bf312b67cc2544ac10a91b2a2e13486877017be274aba531f9cdc50c403c9a09618678d984afa3570bf624ac5e1bc47a749a6bc1cd33f6497a'
    ),
    (
        71,
        '82158da243c90de23e42ffcc6dd8f6c6ac301080a4198627b7e3b2302bdc84b052db07b70d9fb5391b028269c4c6b52a15b9ace79435dbdb899f859cc586b262'
    ),
    (
        72,
        '2ade9a10a490d412665661a53f26db29dcdecff053007f96f535879b9828aed421f82abaa3e0b12eecfeeccf2cf01d534fcc5d93b0e964de03bc3e15cd8add83'
    ),
    (
        73,
        '9f7eb6c3e746258239ea2f2f7acc4cd65a5dd0dd158cf260bff0e8906854babf80914d4551759f0dc63ec5ac32361182456e8399108c9098369359e520db9930'
    ),
    (
        74,
        'f916c1f9b7c67743726ca9b74f2bfa21949fa6a96568f2081e90584da95afa6b68c7a0fc09a3c06fdfdab09d5135a4a0fa000f2d7fb345b8f7bf7092b8313e6d'
    ),
    (
        75,
        'c168e6566ce41ab411869fd63a1ee5cede93d480a701b989e0e642df4fbb273faf6c5d6fecabcdd99c50ae74cfda445951f17d95eab2310764a64e012d1c59c6'
    ),
    (
        76,
        'eff50b456a23dd19f6d26631d03e3fcd1c17e3c42b37efd127de0a645b97ded132a12fbab76af4d04a8279213647de7a3f1897db169b21d25ebf74bc0f1702bd'
    ),
    (
        77,
        '6d9064d5532a7da13985907c845b70e9246c9861b22691f701d03f27ab73b139ccc70c3742103cf2bc5f7f63ec7e863028bd03a20b3270bdf85877a223eb3bf1'
    ),
    (
        78,
        'ea4f5531159d587158d7fbcc5ba0f32a4f39333a5c4ae1e9599fbdc76b87af3789a960ca300111f1684d3ca198210ecd6925a0382c9d072d0f7b233b81737403'
    ),
    (
        79,
        'a5981add55df4d0e5fdc7bd655e2353611cbb6968fc9ed7db14c835e6a94e7f582bba72dbd830763ff40f50716ede651ae34c1887b5e7466ddd73c04bb83c8d0'
    ),
    (
        80,
        '990453454aeb5009f061015d4de8709ae8652fb0edec7d03f5ab9951a5f6fcd784659d280ebae44de2e74f8812c9bc16c4aadf5cd7a040520f6f029287bb9cc8'
    ),
    (
        81,
        'c0e3e90b7e37402a0523b59652ca00feef41f760f4dd2471c7c736bc1c85056019a77fed451c64ac86a6b988034c3c17e9a2b1a7f10f612f975fdcb8b2120162'
    ),
    (
        82,
        'ad42ad2c0ab9923e2d220685ef205eec674567db0134d4cd87d8eb2041bf8250793e72ac7861b891367f07c1f5a7d1a08feade2649eac02c2197aaffa4f9f460'
    ),
    (
        83,
        '7be85e8a3eb19fc782f31d2332fbca6412264d3c2bb023af9a0aa20a15861127df2e46dbbbbff60b54238e5796522beee9c2ec690227639583328cc910321c42'
    ),
    (
        84,
        '0fcb0010123c9ea5b66634aecd682506a381fbe78a1e12c861c89bfbaf04380456b81eb9731119a059f4dec45fbfa4488b8e497020a1fd7be86dd2ecfdb8dd78'
    ),
    (
        85,
        '4589ebb935e5da8e75cf3c66c7de3dd5b7074306cc2d14b5f10bfc84d393ca7a0d0dbf234a4e806ed4a549e69a9c0312d962a0fc796d2cf76cce9559d74d1f6f'
    ),
    (
        86,
        '1506094af288a4f989f9cb11fa7ff686e8c9b5c3573dfb71efdd17fb2a6be0625868d5377528b1afe3bb91ef9c6a0d0f8e999c4949c9833e789874695f1197fa'
    ),
    (
        87,
        '6fbf0b3964b8f46af83f49a215daacdc8f82bd6df91daad21f4d83ab9cdbb608622e143d9dbf0334e2ab2aef2f988422de5da8aa404d15a026769d2b6abf182e'
    ),
    (
        88,
        '9add7ac4c89e1554f0bfb8d47b4f686d61113fc0795bf15822490b99b618bfe95bc0d8dbafa95d0c5a8f7979d7555eec0820f50507ce8c7bb9215f5af3137e2f'
    ),
    (
        89,
        'fa2cd4511e131673a806e971487bfb132c0fa2e036e2297d033ae90e83f94ed58fe6d65586f7358fab07673ab5d5c4fc3f69fc60b7fe3238af9436b3ee99b390'
    ),
    (
        90,
        '0ad64c57a8cebcab753cad9b59e1934ca0d8a4d4a67aaffb1825c81eb13141b85c93324db79d7b0178fa61f1b85ba99986e5e4492b95ec1878e5417f9eb967a3'
    ),
    (
        91,
        'a76ded480cc398fb6f873bef65d329b57ef2993388260f9efdc6263f21918b28cd2f33ca8a78d9d5a1fb1d7922bb4617ed3bf9c0fd335afc3b767f04f7b1a698'
    ),
    (
        92,
        '97ce2d95a6fab355f1e1062239bc2bff823c76e1d3330a6bdee9eb1b6ea2b7166dfb13b8591a5c96caafad6001565363474f7b947b339449bfcca9c0db2543af'
    ),
    (
        93,
        'd27bc1ee7992e617f6da9a22720b5cb195d1e7a956186108f8b73c31582c9669dd3b7c6fcea3eed9e147e91e9e4bad92d658691c34a03a62bd12240de1b96895'
    ),
    (
        94,
        '62c158eaf9e5bb53cb33fabb0728dfcceb66aab0b3fdf5eb4c0505a86788437e067a7bae886ee487165866111ef407993b42ea44f870852335e95eae059b2242'
    ),
    (
        95,
        '28e002ea8bcadbece873c1783eab46c926c6a4219bf079424aad2b2895de797738b9ee7d298603370d0264c90328771aa0f7393d6f444f2d02fd17c3faa01c1f'
    ),
    (
        96,
        '5a19642b76217a28c4888e2eac1ca441ebd2b057971b291c92c066247532343383fc0b3a3672a08fa37441edb41061d1ad5dd2470f792876b52de014ccbde110'
    ),
    (
        97,
        '4720a53ca376c9c23180c3b6dc2966cbcef08331187f5ca2d8511ceeb428f5ecf44407547995c25e4ea495f99c00edf5d356fe6bc905affa2dd60ba45b320ed7'
    ),
    (
        98,
        'f6f0f88cbde7cbef8acfba102ceb6635a50b9b8df5a8fb1154293df649667980373dcfa997a5658e0dacbc6fb582a83cec6ad75936b22e7994252555f3248263'
    ),
    (
        99,
        'e8d997931b8312789cade7758448c9d7e52fb8441eb704f42c7d93a3a12fdb07503f059a483603cb3f8e35449831a778d47f06f502fe3dafbdeba3618893476b'
    ),
    (
        100,
        'd2e68659ea28b0ecf05afa6a3aaf3c3439408863d56b18e55dad573deb6589f24719987260a4e6c440a0799a6a08857c7125d1d65f1a94b46ce41e107fd9fa77'
    ),
    (
        101,
        '49a8561404993b62c9a1e8c1573458926cef3bf56b4e26ed439216328d60efdcf9c68d6b67000e7a2470ffac1f891701900cacb9740b5139e93f04f2d9be6558'
    ),
    (
        102,
        '07aa8d74e2682ed8925bd688827fb9f9b5b9536824c91dde2ae1d60d596895a14a28685e548d22fbaf761f713092c9cc9d3b9a25b073cf7b8cf9c9b129bc23cb'
    ),
    (
        103,
        'b4c17f7faceecdc3f1fcad2d4ee82c720757ddc613569112b890f830b6f7e8f2d6c0103072cc24c4d13163122dc75227a3a6d2bc532c5b74b7f85559d58853bb'
    ),
    (
        104,
        '6d3d721ee370272ccecd4125ea98f1f30ecf82573d40dd3ef83f7248f404f126fd2690972d514b3da2b5422e3ed9550bac175d807790ffba4c98a78f6d619dae'
    ),
    (
        105,
        '7151cb7bb2fd9d525cbeb931b2d7ef12e66ff3619d150e70a7dcec4cb6885d8d99806f22ae480766f1d5a83f0b7c384ce6f46b20f92db083be02cc229cf03b66'
    ),
    (
        106,
        '30f46afa20269608a16fc2125e0110de27f28772acedcabcf713ab8d88b2a72636a39385bdc490a03688f1ba5c6ef83a57c4a93e81473d0e72777be4ee4d0563'
    ),
    (
        107,
        '57cafe3600cede0d9af33a35255631e7335dc7cb16a4a4ae3a7ca7dbf499928becbf6275bf3b8100506ff49ef5bb30909fbc76c738148757ef81a0f0323ba39b'
    ),
    (
        108,
        'd65965a997508e2db51a4d60dfd1de841c671e5712a43f891fc7b7cc20abcbe3f9bccb93e80f7e90895173a13857c6862ab402ea59d527b314f7007961c378d1'
    ),
    (
        109,
        '514c987dd13beba663fd7da38af665067aec39f23b3090ae894d10b35388b3707c6a024926af1a15b20314c7d99d10285c3896969f1622407dbe4535d4302ace'
    ),
    (
        110,
        '7ebffb8f7c161c18e373062de6e26d2b03874852c68627c2e5d156efd0d37f98bc8d925fb59a6d05748ab446b9677ad27769148664107abe8035bfa698f673b4'
    ),
    (
        111,
        'a25088321cdf530c3ca377c5c0c6de9055e8ed1e337d9c2d06dd48a327642831a89afcf9f48c2593fa95162a5d23e0e9d3a59039d220e19ff20779f0b7fc1da8'
    ),
    (
        112,
        '0507fc0374ad0727857a29317099b3b04cb0c93e336f7502fe4b31048828a4eb059833f1a48b95d95ea1b489e482683ea697ea01770f3f3acda91eb2aa1aff03'
    ),
    (
        113,
        '4791942d132b7834b8a74d946a040001f027cc51e4a6a19966c4671aa996f40016d18f8f2888a88f3905ebf01d72e3d48271ad0465dfd8bbd5ae58257f63b7cd'
    ),
    (
        114,
        'b3bef5b429446e24e682f5af19ed6acd0caf78be870f4797d5767be3b3ec64bbd223b89c54b821d57505beb2f07f0164fd8746c7586aa2243708c42cafdc34d6'
    ),
    (
        115,
        'aece2e416b38179c40d0ce97d2d54c548f5a4df756a5d5618cd21af44f4004e1b863cee850e59b79bc27b4551507983b320e25d3654497a8cdbbb303ab1523be'
    ),
    (
        116,
        '49b7cfebac2529a371906cafdfb994d0cce7b383878f82353955c8e32552079610aff964759d000b4f977f94dcb6a865fd53c9d1fe448b53785fb9c879272231'
    ),
    (
        117,
        'cf9dba3190348aba5877e0085aff2ea98720d7d0045d60ae561f6957a5e2701fdd7e96071ab628d003b9e45c832d9ec42dfb8a0aa2f0235947e42b0ce503dcb9'
    ),
    (
        118,
        '6c2a2c5e4208347cddd01b3e511325f002a9232ca6e33c7f52ad5a6f94036abe4d46abf50cfa721419718640d33e5600664842085afc79b2bde335cace3b32eb'
    ),
    (
        119,
        'fdc100421e57e3662232d1a1fa36dc59ac1d4526296d9c0187df37fb207b075f00ad34daac3899d2263470a5b0b659eff97500d7498028ca27742afd3a4ab136'
    ),
    (
        120,
        'd75259e8f0c04db5d39b1746a12d10aeec28a5b540223770c0a5d727a710468b3a1715887f5d557aa602f371ba4b10b358d7381601373fb3942cb91887811bc5'
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
    (24, 8562076677),
    (25, 4923288383),
    (26, 9656596842),
    (27, 6446830437),
    (28, 1064257432),
    (29, 5696272082),
    (30, 4339613724),
    (31, 6681133770),
    (32, 1792659016),
    (33, 3582470075),
    (34, 2332489497),
    (35, 2244053782),
    (36, 8597234591),
    (37, 7714630629),
    (38, 8234446349),
    (39, 8391466765),
    (40, 6206197985),
    (41, 2892497255),
    (42, 8463946644),
    (43, 3995480053),
    (44, 4099233271),
    (45, 8342200227),
    (46, 1233060829),
    (47, 5829028660),
    (48, 5157360907),
    (49, 1427785737),
    (50, 1030485881),
    (51, 3310640783),
    (52, 9904589806),
    (53, 7235466316),
    (54, 9475333666),
    (55, 5418855619),
    (56, 2642354426),
    (57, 4710935328),
    (58, 4059332979),
    (59, 5683026512),
    (60, 5365024058),
    (61, 7971592109),
    (62, 4040236128),
    (63, 9103659536),
    (64, 4197085179),
    (65, 3554715686),
    (66, 1246826683),
    (67, 5817072358),
    (68, 3601751263),
    (69, 4731193215),
    (70, 8845979479),
    (71, 2988029294),
    (72, 1490489702),
    (73, 6500554931),
    (74, 6389209841),
    (75, 1896116750),
    (76, 6313289356),
    (77, 6176850967),
    (78, 8388958648),
    (79, 5389015439),
    (80, 8680687798),
    (81, 4038798731),
    (82, 4891051839),
    (83, 4578213184),
    (84, 2247382586),
    (85, 7995858707),
    (86, 1098285279),
    (87, 7681573849),
    (88, 8450990065),
    (89, 5919060767),
    (90, 2091463921),
    (91, 2731970548),
    (92, 4930773718),
    (93, 2400956007),
    (94, 5653598645),
    (95, 1581157113),
    (96, 4365401770),
    (97, 5089162496),
    (98, 6179833280),
    (99, 8255574083),
    (100, 6997926149),
    (101, 2071099772),
    (102, 1719135225),
    (103, 2153434360),
    (104, 2261774097),
    (105, 2992798573),
    (106, 9919714683),
    (107, 4400212425),
    (108, 7313734427),
    (109, 7067317096),
    (110, 6375521974),
    (111, 1309217587),
    (112, 4852215071),
    (113, 2519317007),
    (114, 3097999473),
    (115, 5546975375),
    (116, 9261413014),
    (117, 3250421914),
    (118, 1525550184),
    (119, 9665738673),
    (120, 2471776959);

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
        23,
        'Mark',
        'Mathis',
        'jury',
        'backside@gmail.com',
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
        '1f42427ef026977479338e0ece9be97b'
    ),
    (
        26,
        'doglas',
        'duada',
        'jury',
        'asd@go.jt',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        '',
        40,
        40,
        NULL,
        '752e59f9b12be377f00a64a65bfde7d1'
    ),
    (
        105,
        'Yannick',
        'Basler',
        'teilnehmende',
        'Yannick-basler@gmx.ch',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        '',
        119,
        119,
        1,
        '943d07eeccc6a296bc47cade90d5f5e4'
    ),
    (
        106,
        'test',
        'test',
        'teilnehmende',
        'asda@ig.hg',
        '',
        NULL,
        '',
        '',
        NULL,
        NULL,
        '',
        120,
        120,
        NULL,
        'e9b9f412507e18bf7336a91f474119a3'
    );