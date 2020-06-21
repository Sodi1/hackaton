# Front-End Ed+

Данная директория содержит скрипты для запуска веб-панели.

## Стек технологий

`VueJS`,`TypeScript`,`NPM`

## Каталог

```bash
hack2:
│   .gitignore
│   README.md                    // Этот файл
│
└───src                          // Каталог с исходными кодами
    │   .browserslistrc
    │   .env
    │   .eslintrc.js
    │   .gitignore
    │   .prettierrc
    │   babel.config.js
    │   package-lock.json
    │   package.json
    │   tsconfig.json
    │   vue.config.js
    │
    ├───public
    │       index.html
    │
    └───src
        │   App.vue
        │   main.ts
        │   router.ts
        │   shims-tsx.d.ts
        │   shims-vue.d.ts
        │
        ├───assets
        │   ├───css
        │   │       common.scss
        │   │
        │   └───img
        │       │   avatar.jpg
        │       │   logo.svg
        │       │
        │       └───badges
        │               badge1.png
        │               badge2.png
        │               badge3.png
        │               badge4.png
        │
        ├───components
        │       ChartComponent.vue
        │       LoaderComponent.vue
        │       ProgramsCardComponent.vue
        │       ProgramTileComponent.vue
        │       SelectedProgramView.vue
        │
        ├───layouts
        │       BaseLayout.vue
        │       SideBar.vue
        │
        ├───models
        │       ProgramModel.ts
        │       ScoreColorsModel.ts
        │
        ├───service
        │       http.client.ts
        │       ProgramApiService.ts
        │       TeacherApiService.ts
        │
        └───views
                ProgramsView.vue
                TeacherView.vue
```

## Запуск

#### Требования для запуска

На компьютере должен быть установлен node. Склонировать репозиторий, зайти в папку **src**. *Выполнить:*

```bash
npm install 
npm run serve
```
