# AdminPanel  <div> ![PHP](https://img.shields.io/badge/PHP-%23777BB4.svg?style=flat&logo=php&logoColor=white) [![JavaScript](https://shields.io/badge/JavaScript-black?logo=JavaScript&logoColor=F7DF1E)](https://developer.mozilla.org/en-US/docs/Web/JavaScript) ![Laravel](https://img.shields.io/badge/Laravel-%23FF2D20.svg?style=flat&logo=laravel&logoColor=white) ![Vue.js](https://img.shields.io/badge/Vue.js-%234FC08D.svg?style=flat&logo=vue.js&logoColor=white) </div>

This is a recruitment task project for [ONX Center](https://onx.com.pl/) company. \
[Preview!](http://adminpanel-szymcode-a7c075dcede4.herokuapp.com/home)


<details><summary> <h2>  📖 Problem description  </summary>

```
Twoim zadaniem jest stworzenie zaawansowanego panelu administracyjnego do
zarządzania treściami na stronie internetowej. Aplikacja powinna być oparta na frameworku
Laravel 10 (PHP) oraz Vue.js 3, a także działać jako pojedyncza strona aplikacji (SPA).
Celem tego zadania jest przetestowanie Twoich umiejętności programistycznych, zdolności
projektowych oraz umiejętności pracy z technologiami Laravel i Vue.js.


Wymagania:
• Stwórz stronę SPA, która będzie pełniła rolę zaawansowanego panelu administracyjnego.
• Wykorzystaj framework Laravel 10 do tworzenia API oraz obsługi logiki backendowej
aplikacji.
• Skorzystaj z Vue.js 3 do stworzenia interfejsu użytkownika, wykorzystując komponenty Vue
do tworzenia interaktywnych widoków.
• Aplikacja powinna umożliwiać zalogowanie się do panelu poprzez formularz logowania.
• Dane użytkowników oraz treści powinny być przechowywane w bazie danych SQL (wybierz
odpowiednią dla Ciebie technologię).
• Po zalogowaniu, użytkownik powinien mieć dostęp do następujących funkcji:
  - Zarządzanie użytkownikami: Implementuj pełne CRUD dla użytkowników (imię, nazwisko,
e-mail, rola).
  - Zarządzanie treściami: Stwórz CRUD dla wpisów (tytuł, treść, data publikacji) wraz z
możliwością przypisywania tagów.


Dodatkowe wyzwania:
• Implementuj paginację dla listy użytkowników i wpisów w interfejsie użytkownika.
• Zabezpiecz aplikację przed atakami typu SQL Injection oraz Cross-Site Scripting (XSS).
• Zaimplementuj autoryzację i autentykację w oparciu o wbudowane mechanizmy Laravel
oraz rolę użytkowników w dostępie do poszczególnych funkcji.
• Zaimplementuj wyszukiwanie użytkowników i wpisów w panelu administracyjnym.
• Dodaj możliwość sortowania i filtrowania wpisów na podstawie tagów.
• Stwórz mechanizm do przypisywania uprawnień użytkownikom na podstawie ich ról.


Zadanie z gwiazdką:
Czy jesteś w stanie zoptymalizować zapytania do bazy danych w celu maksymalizacji
wydajności aplikacji, szczególnie przy dużym obciążeniu?


Ocenianie:
Twoje rozwiązanie będzie oceniane pod kątem:
• Jakości kodu w oparciu o standardy Laravel.
• Skuteczności interfejsu użytkownika.
• Bezpieczeństwa i walidacji danych.
• Implementacji autoryzacji i autentykacji.
• Umiejętności pracy z PHP (Laravel) i Vue.js.
• Wydajności i responsywności aplikacji.
• Sposób na testowanie aplikacji (szczególną uwagę przywiązujemy do testów).
```

<br/>
</details>


<details><summary> <h2>  🛠️ Installation  </summary>

- First make sure u have installed latest versions of [Laravel](https://laravel.com/), [Vue.js](https://vuejs.org/), [XAMPP](https://www.apachefriends.org/pl/index.html) and [Composer](https://getcomposer.org/).

- Clone this repository from admin-panel branch.

```
git clone -b admin-panel https://github.com/SzymCode/RecruitmentTasks.git
```

- Install modules in root directory.

```bash
npm install
composer update
```

### **Make sure u have installed all modules!**


- Change *.env.example* file to *.env* in root directory, run XAMPP mysql server and create database.
```bash
mysql -u root -p
create database adminpanel
```

- Migrate and seed database.
```bash
php artisan migrate:fresh --seed
```

<br/>
</details>


<details><summary> <h2>  🚀 Run  </summary>

<br/>

- root directory:

```bash
npm run dev
php artisan serve
```

<br/>

</details>  



<details><summary> <h2>  ❓ Factories & Tests  </summary>

- Run factories to generate fake data.
```bash
php artisan tinker
User::factory()->count(100)->create();
Post::factory()->count(100)->create();      
```

- Run backend tests.
```bash
php artisan test tests/Feature/PostsControllerTest.php
php artisan test tests/Feature/UsersControllerTest.php
```

<br/>

</details>


<details><summary> <h2> ✅ Solved Problems  </summary>

- [X] Single Page App

- [X] Responsive design

- [X] CRUD for users and posts

- [X] Search, filter and sort functionalities

- [X] Prevent SQL injection attack

- [X] Backend tests 

- [X] Pagination

- [X] Live preview

</details>
