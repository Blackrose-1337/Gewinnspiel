# Details

Date : 2023-02-02 13:00:19

Directory /home/vagrant/Project_M133

Total : 77 files,  11848 codes, 517 comments, 630 blanks, all 12995 lines

[Summary](results.md) / Details / [Diff Summary](diff.md) / [Diff Details](diff-details.md)

## Files
| filename | language | code | comment | blank | total |
| :--- | :--- | ---: | ---: | ---: | ---: |
| [README.md](/README.md) | Markdown | 5 | 0 | 4 | 9 |
| [backend/php/Dockerfile](/backend/php/Dockerfile) | Docker | 42 | 7 | 8 | 57 |
| [backend/php/composer.json](/backend/php/composer.json) | JSON | 5 | 0 | 3 | 8 |
| [backend/php/src/Controller/API/AdminController.php](/backend/php/src/Controller/API/AdminController.php) | PHP | 102 | 12 | 19 | 133 |
| [backend/php/src/Controller/API/AuthController.php](/backend/php/src/Controller/API/AuthController.php) | PHP | 165 | 10 | 15 | 190 |
| [backend/php/src/Controller/API/BaseController.php](/backend/php/src/Controller/API/BaseController.php) | PHP | 159 | 12 | 23 | 194 |
| [backend/php/src/Controller/API/CompetitionController.php](/backend/php/src/Controller/API/CompetitionController.php) | PHP | 103 | 11 | 1 | 115 |
| [backend/php/src/Controller/API/ConfirmController.php](/backend/php/src/Controller/API/ConfirmController.php) | PHP | 38 | 4 | 0 | 42 |
| [backend/php/src/Controller/API/DesignerController.php](/backend/php/src/Controller/API/DesignerController.php) | PHP | 2 | 1 | 0 | 3 |
| [backend/php/src/Controller/API/EvaluationController.php](/backend/php/src/Controller/API/EvaluationController.php) | PHP | 212 | 12 | 16 | 240 |
| [backend/php/src/Controller/API/ProjectController.php](/backend/php/src/Controller/API/ProjectController.php) | PHP | 136 | 9 | 4 | 149 |
| [backend/php/src/Controller/API/UserController.php](/backend/php/src/Controller/API/UserController.php) | PHP | 87 | 12 | 5 | 104 |
| [backend/php/src/Model/Database.php](/backend/php/src/Model/Database.php) | PHP | 77 | 14 | 18 | 109 |
| [backend/php/src/Model/ModelBase.php](/backend/php/src/Model/ModelBase.php) | PHP | 59 | 9 | 15 | 83 |
| [backend/php/src/Model/ModelBewertung.php](/backend/php/src/Model/ModelBewertung.php) | PHP | 95 | 30 | 20 | 145 |
| [backend/php/src/Model/ModelBilder.php](/backend/php/src/Model/ModelBilder.php) | PHP | 50 | 17 | 10 | 77 |
| [backend/php/src/Model/ModelCompetition.php](/backend/php/src/Model/ModelCompetition.php) | PHP | 61 | 30 | 18 | 109 |
| [backend/php/src/Model/ModelProject.php](/backend/php/src/Model/ModelProject.php) | PHP | 117 | 38 | 29 | 184 |
| [backend/php/src/Model/ModelPw.php](/backend/php/src/Model/ModelPw.php) | PHP | 55 | 17 | 18 | 90 |
| [backend/php/src/Model/ModelSalt.php](/backend/php/src/Model/ModelSalt.php) | PHP | 36 | 9 | 8 | 53 |
| [backend/php/src/Model/ModelTeilnehmende.php](/backend/php/src/Model/ModelTeilnehmende.php) | PHP | 305 | 131 | 73 | 509 |
| [backend/php/src/helpers/authcheck.php](/backend/php/src/helpers/authcheck.php) | PHP | 48 | 7 | 8 | 63 |
| [backend/php/src/helpers/session_helper.php](/backend/php/src/helpers/session_helper.php) | PHP | 10 | 0 | 3 | 13 |
| [backend/php/src/helpers/url_helper.php](/backend/php/src/helpers/url_helper.php) | PHP | 4 | 2 | 1 | 7 |
| [backend/php/src/inc/bootstrap.php](/backend/php/src/inc/bootstrap.php) | PHP | 41 | 1 | 6 | 48 |
| [backend/php/src/inc/config.php](/backend/php/src/inc/config.php) | PHP | 8 | 0 | 3 | 11 |
| [backend/php/src/index.php](/backend/php/src/index.php) | PHP | 46 | 2 | 7 | 55 |
| [docker-compose.yml](/docker-compose.yml) | YAML | 38 | 1 | 9 | 48 |
| [frontend/.eslintrc.cjs](/frontend/.eslintrc.cjs) | JavaScript | 17 | 1 | 2 | 20 |
| [frontend/.prettierrc.js](/frontend/.prettierrc.js) | JavaScript | 7 | 8 | 1 | 16 |
| [frontend/Dockerfile](/frontend/Dockerfile) | Docker | 9 | 6 | 7 | 22 |
| [frontend/env.d.ts](/frontend/env.d.ts) | TypeScript | 0 | 1 | 1 | 2 |
| [frontend/index.html](/frontend/index.html) | HTML | 13 | 0 | 0 | 13 |
| [frontend/package-lock.json](/frontend/package-lock.json) | JSON | 6,974 | 0 | 1 | 6,975 |
| [frontend/package.json](/frontend/package.json) | JSON | 58 | 0 | 1 | 59 |
| [frontend/src/App.vue](/frontend/src/App.vue) | vue | 135 | 1 | 14 | 150 |
| [frontend/src/assets/base.css](/frontend/src/assets/base.css) | CSS | 58 | 3 | 15 | 76 |
| [frontend/src/assets/logo.svg](/frontend/src/assets/logo.svg) | XML | 1 | 0 | 0 | 1 |
| [frontend/src/components/Analysis.vue](/frontend/src/components/Analysis.vue) | vue | 30 | 0 | 3 | 33 |
| [frontend/src/components/Competition.vue](/frontend/src/components/Competition.vue) | vue | 281 | 0 | 19 | 300 |
| [frontend/src/components/Confirm.vue](/frontend/src/components/Confirm.vue) | vue | 41 | 0 | 4 | 45 |
| [frontend/src/components/Designe.vue](/frontend/src/components/Designe.vue) | vue | 116 | 0 | 8 | 124 |
| [frontend/src/components/Evaluation.vue](/frontend/src/components/Evaluation.vue) | vue | 53 | 0 | 8 | 61 |
| [frontend/src/components/Formular.vue](/frontend/src/components/Formular.vue) | vue | 231 | 0 | 12 | 243 |
| [frontend/src/components/Project.vue](/frontend/src/components/Project.vue) | vue | 174 | 0 | 15 | 189 |
| [frontend/src/components/Sidebar.vue](/frontend/src/components/Sidebar.vue) | vue | 119 | 8 | 10 | 137 |
| [frontend/src/components/icons/base64pic.json](/frontend/src/components/icons/base64pic.json) | JSON | 1 | 0 | 0 | 1 |
| [frontend/src/components/icons/bild.vue](/frontend/src/components/icons/bild.vue) | vue | 3 | 0 | 2 | 5 |
| [frontend/src/main.ts](/frontend/src/main.ts) | TypeScript | 14 | 19 | 8 | 41 |
| [frontend/src/router/index.ts](/frontend/src/router/index.ts) | TypeScript | 69 | 19 | 6 | 94 |
| [frontend/src/stores/auth.ts](/frontend/src/stores/auth.ts) | TypeScript | 65 | 5 | 5 | 75 |
| [frontend/src/stores/competition.ts](/frontend/src/stores/competition.ts) | TypeScript | 49 | 1 | 6 | 56 |
| [frontend/src/stores/confirm.ts](/frontend/src/stores/confirm.ts) | TypeScript | 26 | 0 | 7 | 33 |
| [frontend/src/stores/evaluation.ts](/frontend/src/stores/evaluation.ts) | TypeScript | 109 | 1 | 10 | 120 |
| [frontend/src/stores/interfaces.ts](/frontend/src/stores/interfaces.ts) | TypeScript | 60 | 0 | 7 | 67 |
| [frontend/src/stores/projects.ts](/frontend/src/stores/projects.ts) | TypeScript | 59 | 3 | 8 | 70 |
| [frontend/src/stores/users.ts](/frontend/src/stores/users.ts) | TypeScript | 75 | 0 | 8 | 83 |
| [frontend/src/utils/networkHelper.ts](/frontend/src/utils/networkHelper.ts) | TypeScript | 84 | 16 | 21 | 121 |
| [frontend/src/views/AuswertungView.vue](/frontend/src/views/AuswertungView.vue) | vue | 23 | 0 | 4 | 27 |
| [frontend/src/views/BestaetigungView.vue](/frontend/src/views/BestaetigungView.vue) | vue | 9 | 0 | 1 | 10 |
| [frontend/src/views/BewertungView.vue](/frontend/src/views/BewertungView.vue) | vue | 32 | 0 | 5 | 37 |
| [frontend/src/views/DesigneView.vue](/frontend/src/views/DesigneView.vue) | vue | 23 | 0 | 4 | 27 |
| [frontend/src/views/LoginView.vue](/frontend/src/views/LoginView.vue) | vue | 100 | 0 | 9 | 109 |
| [frontend/src/views/ProjectView.vue](/frontend/src/views/ProjectView.vue) | vue | 32 | 0 | 5 | 37 |
| [frontend/src/views/UserView.vue](/frontend/src/views/UserView.vue) | vue | 37 | 0 | 6 | 43 |
| [frontend/src/views/VerwaltungView.vue](/frontend/src/views/VerwaltungView.vue) | vue | 43 | 0 | 5 | 48 |
| [frontend/src/views/WettbewerbView.vue](/frontend/src/views/WettbewerbView.vue) | vue | 9 | 0 | 1 | 10 |
| [frontend/tsconfig.app.json](/frontend/tsconfig.app.json) | JSON | 4 | 20 | 0 | 24 |
| [frontend/tsconfig.json](/frontend/tsconfig.json) | JSON with Comments | 18 | 0 | 1 | 19 |
| [frontend/tsconfig.vite-config.json](/frontend/tsconfig.vite-config.json) | JSON | 8 | 0 | 1 | 9 |
| [frontend/tsconfig.vitest.json](/frontend/tsconfig.vitest.json) | JSON | 8 | 5 | 0 | 13 |
| [frontend/vite.config.ts](/frontend/vite.config.ts) | TypeScript | 30 | 1 | 3 | 34 |
| [mysql/initscripts/001tabels.sql](/mysql/initscripts/001tabels.sql) | SQL | 95 | 0 | 20 | 115 |
| [mysql/initscripts/002datas.sql](/mysql/initscripts/002datas.sql) | SQL | 288 | 0 | 10 | 298 |
| [package-lock.json](/package-lock.json) | JSON | 40 | 0 | 1 | 41 |
| [package.json](/package.json) | JSON | 5 | 0 | 1 | 6 |
| [poppel.sh](/poppel.sh) | Shell Script | 7 | 1 | 0 | 8 |

[Summary](results.md) / Details / [Diff Summary](diff.md) / [Diff Details](diff-details.md)