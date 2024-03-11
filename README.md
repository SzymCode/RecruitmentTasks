# ArticleSystem  <div> ![PHP](https://img.shields.io/badge/PHP-%23777BB4.svg?style=flat&logo=php&logoColor=white) ![Laravel](https://img.shields.io/badge/Laravel-%23FF2D20.svg?style=flat&logo=laravel&logoColor=white) ![HTML5](https://img.shields.io/badge/HTML5-%23e34f26.svg?logo=html5&logoColor=white) ![Sass](https://img.shields.io/badge/Sass-CC6699?logo=sass&logoColor=white) ![Docker](https://img.shields.io/badge/Docker-2496ED?logo=docker&logoColor=white)</div>

This is a recruitment task project for [Online Venture](https://www.onlineventure.pl) company. \
[Preview!](https://article-system-sc-2f67032d1ea5.herokuapp.com/authors)


<br>
<details><summary> 📖 Problem description </summary>
<br>
    
```
Hey there!
Thanks for joining recruitment for Backend / PHP dev @ Online Venture. We have a small task for you!
Your job is to create a simple news article system, complete with MySQL database, PHP API and HTML
form to add and edit entities.
Data structure
1. News entity with at least title, text and creation date fields.
2. News author entity with at least name field.
3. Articles can have multiple authors
API Endpoints
1. Get article by some id
2. Get all articles for given author
3. Get top 3 authors that wrote the most articles last week.
Requirements:
1. You should include README file with everything we need to know on how to run and "use" your
project.
2. All necessary initial database operations (such as creating tables, inserting fixtures, etc.) should
be done in a single .sql file if needed
3. HTML form should allow us to at least add / edit news articles. List of authors can be hardcoded
into database.
Hints:
1. Don't overthink it! :)
2. No framework is required, but feel free to use one if you fancy it.
3. Pay attention to code quality, formatting, conventions etc.
```

<br>
</details>


<details><summary>  🛠️ Installation & Setup  </summary>

<br>

<details><summary> &nbsp;<img src="https://upload.wikimedia.org/wikipedia/commons/d/dc/XAMPP_Logo.png" height=20/> &nbsp;Standard </summary> 

- First make sure u have installed latest versions of [Laravel](https://laravel.com/), [XAMPP](https://www.apachefriends.org/pl/index.html) and [Composer](https://getcomposer.org/)

- Clone this repository from article-system branch.

```
git clone -b article-system https://github.com/SzymCode/RecruitmentTasks.git
```

- Install modules in root directory

```bash
npm install
composer update
```

### **Make sure u have installed all modules!**

- Change *.env.example* file to *.env* in root directory, run XAMPP mysql server and create database
```bash
mysql -u root -p
create database articlesystem
```

- Migrate and seed database
```bash
php artisan migrate:fresh --seed
```

<br>
</details>

<details><summary> &nbsp;<img src="https://cdn4.iconfinder.com/data/icons/logos-and-brands/512/97_Docker_logo_logos-512.png" height=20/> &nbsp;Docker </summary> 

- First make sure u have installed latest versions of [Laravel](https://laravel.com/), and [Composer](https://getcomposer.org/)

- Clone this repository from article-system branch.

```
git clone -b article-system https://github.com/SzymCode/RecruitmentTasks.git
```

- Change .env.example file to .env in root directory
- Install modules in root directory and prepare database for sail

```bash
composer update

php artisan sail:install
./vendor/bin/sail artisan migrate
```

### **Make sure u have installed all modules!**

- Migrate and seed database.

```
docker compose exec laravel.test bash

php artisan migrate:fresh --seed
```

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
./vendor/bin/sail up -d    # run containers in background

docker compose exec laravel.test bash 
npm run dev
```

Possible problem: [Sail: no such file or directory found](https://stackoverflow.com/questions/71503871/laravel-error-laravel-sail-no-such-file-or-directory-found)
</details>

<hr>
</details>  


<details><summary> ❓ Usage </summary>
<br>

<details><summary> Endpoints </summary>
<br>

```bash

http://127.0.0.1:8000/ (XAMPP)
http://localhost/ (Docker)

# Entities list
/news
/authors

# Api endpoints
/api/news
/api/news/{id}
/api/news/author/{id}

/api/authors
/api/authors/top-authors
```

<br/>
</details>

<details><summary> Migrations & Seed </summary>
<br>

```bash
php artisan migrate:fresh --seed     
```

<br/>
</details>

<details><summary> Factories </summary>
<br>

```bash
php artisan tinker

# if you wish, you can specify count in factory() or attributes in create()
News::factory(100)->create(); 
Author::factory(100)->create();        
```

<br/>
</details>

<details><summary> Tests </summary>
<br>

Backend tests:
```bash
./vendor/bin/pest
```

![tests](https://github.com/SzymCode/RecruitmentTasks/assets/107359025/8422abe9-d818-4d7a-beac-c2c96f24466c)
![tests](https://github.com/SzymCode/RecruitmentTasks/assets/107359025/cc99c04e-475e-4a93-b186-de66ed8ac904)
![tests](https://github.com/SzymCode/RecruitmentTasks/assets/107359025/7f5c84b3-e6e1-4428-96fc-b1e912798b23)


<br>
</details>

<details><summary> npm </summary>
<br>

1. Vite build:

```
npm run build
```

2. Run prettier:

```
npm run write
```

</details>
<br>
</details>


<details><summary> ✅ Solved Problems  </summary>
<br>

Data structure
- [X] News entity with at least title, text and creation date fields.
- [X] News author entity with at least name field.
- [X] Articles can have multiple authors

API Endpoints
- [X] Get article by some id
- [X] Get all articles for given author
- [X] Get top 3 authors that wrote the most articles last week.

Requirements
- [X] The task must be completed by 13.03.2024 (Completed 11.03.2024)
- [X] You should include README file with everything we need to know on how to run and "use" your project
- [X] HTML form should allow us to at least add / edit news articles. List of authors can be hardcoded into database
</details>
