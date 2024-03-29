# LinkhouseBlog <div> [![PHP](https://img.shields.io/badge/PHP-%234F5B93.svg?style=for-the-badge&logo=php&logoColor=white&style=plastic)](https://www.php.net) [![Typescript](https://img.shields.io/badge/TypeScript-007ACC?style=for-the-badge&logo=typescript&logoColor=white&style=plastic)](https://www.typescriptlang.org) [![Laravel](https://img.shields.io/badge/Laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white&style=plastic)](https://laravel.com) [![Vue.js](https://img.shields.io/badge/Vue.js-%234FC08D.svg?style=for-the-badge&logo=vue.js&logoColor=white&style=plastic)](https://vuejs.org) [![Sass](https://img.shields.io/badge/Sass-CC6699?logo=sass&logoColor=white)](https://sass-lang.com) [![XAMPP](https://img.shields.io/badge/XAMPP-%23FB7A24.svg?style=flat&logo=xampp&logoColor=white)](https://www.apachefriends.org/pl/index.html) [![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)](https://www.docker.com/) </div>

This is a recruitment task project for [Linkhouse](https://linkhouse.pl) company.


<br>
<details><summary> 📖 Problem description </summary>
<br>
    
```
Cel: wykonanie prostej aplikacji do przeglądania artykułów z bloga Linkhouse. Aplikacja powinna pozwolić
użytkownikowi na przeglądanie listy artykułów oraz wyświetlanie ich opisów po kliknięciu (forma bloga).



Część frontendowa: Vue.js lub Nuxt.js

- Interfejs użytkownika:
    1. Formularz z polami do obsługi wyszukiwarki frontendowej
    2. Lista artykułów: tytuł, data publikacji
    3. Szczegóły artykułu: opis, kategorie, link

- Funkcjonalność:
    1. Otwieranie nowego artykułu po kliknięciu na liście
    2. Możliwość przejścia do pełnego artykułu z linku pod opisem
    3. Wyszukiwarka frontendowa - po tytule oraz kategoriach
    4. Możliwość powrotu do listy artykułów



Część backendowa: PHP

- Pobranie oraz parsowanie artykułów z https://linkhouse.pl/feed/

- Endpointy:
    1. [GET] /articles - listowanie wszystkich artykułów
    2. [GET] /article/:guid - szczegóły jednego artykułu

- Model danych:
    1. ArticleList: Array[{ guid, title, pubDate, category }]
    2. Article: { guid, title, link, description, category }
```
![image](https://github.com/SzymCode/RecruitmentTasks/assets/107359025/7c553ca5-f153-4262-9ef3-f6fff5c01b2f)
```
Instrukcje:
    - Zacznij od stworzenia nowego projektu backendu - wybrany framework PHP, oraz nowego projektu frontendu - Vue lub Nuxt.
    - Zaimplementuj wymienione powyżej funkcjonalności.
    - Zwróć uwagę na jakość kodu, strukturę projektu oraz obsługę błędów.

Dodatkowo:
    - Jeśli wystarczy Ci czasu, możesz dodatkowo zaimplementować angielską wersję językową z https://linkhouse.net/feed/
        w formie przełącznika PL/EN.

Kryteria oceny:
    - Poprawność działania aplikacji,
    - Struktura, nazewnictwo, jakość kodu,
    - Adekwatny dobór narzędzi, frameworków,
    - Obsługa błędów, przygotowanie się na błędne odpowiedzi serwera.

Uwagi:
    - Skup się na dostarczeniu prostego, schludnego, działającego rozwiązania,
    - Jeżeli nie zdążysz zrobić wszystkiego, skup się na kluczowych funkcjonalnościach.

```


<br>
</details>


<details><summary>  🛠️ Installation & Setup  </summary>

<br>


<details><summary> &nbsp;<img src="https://upload.wikimedia.org/wikipedia/commons/d/dc/XAMPP_Logo.png" height=20/> &nbsp;XAMPP </summary> 

- First make sure u have installed latest versions of [PHP](https://www.php.net), [Laravel](https://laravel.com/), [Vue.js](https://vuejs.org/), [Node.js](https://nodejs.org/en), [npm](https://www.npmjs.com), [XAMPP](https://www.apachefriends.org/pl/index.html) and [Composer](https://getcomposer.org/)

- I recommend use [nvm](https://github.com/nvm-sh/nvm/blob/master/README.md) for install latest supported versions of [Node.js](https://nodejs.org/en) and [npm](https://www.npmjs.com), 

```
nvm use --lts
```

- Clone this repository from linkhouse-blog branch.

```
git clone -b linkhouse-blog https://github.com/SzymCode/RecruitmentTasks.git
```

- Change *.env.example* file to *.env*

- Install modules in root directory

```bash
npm install
composer update
```

### **Make sure u have installed all modules!**

- Run XAMPP mysql server and then create database

```bash
mysql -u root -p
create database linkhouse_blog
```

<br>
</details>

<details><summary> &nbsp;<img src="https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/97_Docker_logo_logos-512.png" height=20/> &nbsp;Docker </summary> 

- First make sure u have installed latest versions of [PHP](https://www.php.net), [Laravel](https://laravel.com/), [Vue.js](https://vuejs.org/), [Node.js](https://nodejs.org/en), [npm](https://www.npmjs.com), [Composer](https://getcomposer.org/) and [Docker](https://www.docker.com)

- I recommend use [nvm](https://github.com/nvm-sh/nvm/blob/master/README.md) for install latest supported versions of [Node.js](https://nodejs.org/en) and [npm](https://www.npmjs.com), 

```
nvm use --lts
```

- Clone this repository from linkhouse-blog branch.

```
git clone -b linkhouse-blog https://github.com/SzymCode/RecruitmentTasks.git
```

- Change *.env.example* file to *.env*
  
- Install modules in root directory

```bash
composer update
php artisan sail:install    # prepare .env file
```

### **Make sure u have installed all modules!**

</details>
<hr>
</details>


<details><summary> 🚀 Run </summary>

<br>

<details><summary> &nbsp;<img src="https://upload.wikimedia.org/wikipedia/commons/d/dc/XAMPP_Logo.png" height=20/> &nbsp;XAMPP </summary> 
<br>

- root directory:

```bash
npm run dev
php artisan serve
```

<br>
</details>


<details><summary> &nbsp;<img src="https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/97_Docker_logo_logos-512.png" height=20/> &nbsp;Docker </summary> 
<br>

**Remember to shutdown all XAMPP processes!**
- root directory:

```bash
sail up -d    # run containers in background

docker compose exec laravel.test bash    # this command open sail container's bash, then run command bellow
npm run dev
```

Possible problem: 
- Sail: no such file or directory found: [Solution 1](https://laravel.com/docs/10.x/sail#configuring-a-shell-alias), [Solution 2](https://stackoverflow.com/questions/71503871/laravel-error-laravel-sail-no-such-file-or-directory-found)
</details>

<hr>
</details>  



<details><summary> ❓ Usage </summary>
<br>

<details><summary> Migrations </summary>
<br>

Run migrations (optional with seed)
```bash
php artisan migrate:fresh --seed
```

<br>
</details>

<details><summary> Tests </summary>
<br>
    
Run all backend tests:
```bash
docker compose exec laravel.test bash    # this command open sail container's bash, then run command bellow

./vendor/bin/pest
```


<br>
</details>

<details><summary> npm </summary>
<br>

1. Vite build:

```
npm run build
```

2. Activate Husky git hooks:

```
npm run prepare
```
   
3. Eslint fix:

```
npm run lint
```

4. Run prettier:

```
npm run write
```

</details>
</details>


