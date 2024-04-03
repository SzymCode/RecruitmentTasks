# TagManager <div> [![Typescript](https://img.shields.io/badge/TypeScript-007ACC?style=for-the-badge&logo=typescript&logoColor=white&style=plastic)](https://www.typescriptlang.org) [![React](https://shields.io/badge/React-black?logo=react&style=for-the-badge%22)](https://react.dev) [![Redux](https://img.shields.io/badge/Redux-764ABC?logo=redux&logoColor=white)](https://redux.js.org) [![Chakra UI](https://img.shields.io/badge/Chakra%20UI-319795?logo=chakra-ui&logoColor=white)](https://chakra-ui.com/) </div>

This is a recruitment task project for [Mediporta](https://www.mediporta.pl) company.

[Preview!](http://tagmanager.szymco.de)

<br>
<details><summary> 📖 Problem description </summary>
<br>
    
```
Treść zadania: Przygotować w React interfejs użytkownika przeglądarki tagów udostępnianych przez API StackOverflow (https://api.stackexchange.com/docs).


Założenia projektu:

- stronicowana tabela lub lista tagów wraz liczbą powiązanych postów (pole count)
- liczba elementów na stronie konfigurowalna przez pole liczbowe nad tabelą/listą
- wybór pola i kierunku sortowania przez element UI własnego wyboru/projektu
- przygotować odpowiednie stany dla etapu ładowania danych i błędów przy pobieraniu
- wykorzystać gotową bibliotekę komponentów UI, np. MUI
- wykorzystać gotowe biblioteki do zarządzania stanem i pobierania danych (wybór wedle uznania, stosownie do stopnia komplikacji projektu i z myślą o jak najszybszej realizacji zadania)
- przygotować Storybook do prezentacji wykorzystanych komponentów składowych aplikacji
- rozwiązanie opublikować w repozytorium GitHub
- całość powinna się uruchamiać wyłącznie po wykonaniu komend "npm ci", "npm start", "npm run storybook"
```


<br>
</details>



<details><summary> 🛠️ Installation </summary>
    
- First make sure u have installed latest versions of [Node.js](https://nodejs.org/en) and [npm](https://www.npmjs.com)

- I recommend use [nvm](https://github.com/nvm-sh/nvm/blob/master/README.md) for install latest supported versions of [Node.js](https://nodejs.org/en) and [npm](https://www.npmjs.com), 

```
nvm use --lts
```

- Clone this repository from tag-manager branch.

```
git clone -b tag-manager https://github.com/SzymCode/RecruitmentTasks.git
```

- Install modules in root directory.

```bash
npm ci
```

### **Make sure u have installed all modules!**
<br>
</details>


<details><summary> 🚀 Run </summary>
<br>

- run project:

```bash
npm run dev
```

- StoryBook:
```bash
npm run storybook
```

