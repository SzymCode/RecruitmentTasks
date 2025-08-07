# PatientManager  <div> ![PHP](https://raw.githubusercontent.com/SzymCode/SzymCode/main/img/technologies/badge/php.svg) ![TypeScript](https://raw.githubusercontent.com/SzymCode/SzymCode/main/img/technologies/badge/typescript.svg) ![Laravel](https://raw.githubusercontent.com/SzymCode/SzymCode/main/img/technologies/badge/laravel.svg) ![Nuxt](https://raw.githubusercontent.com/SzymCode/SzymCode/main/img/technologies/badge/nuxt.svg) ![Vue](https://raw.githubusercontent.com/SzymCode/SzymCode/main/img/technologies/badge/vue.svg) ![SCSS](https://raw.githubusercontent.com/SzymCode/SzymCode/main/img/technologies/badge/sass.svg)</div>

This is a recruitment task project for [ALAB Laboratoria](https://www.alab.pl/) company. 



<br>
<details><summary> 📖 Problem description </summary>
<br>
    
```

1. Command do Importu Danych

Zaimplementuj polecenie konsolowe w Laravel, które wczyta dane pacjentów i wyniki ich badań z pliku CSV (results.csv) o następującym formacie:

| patientId | patientName | patientSurname | patientSex | patientBirthDate | orderId | testName | testValue | testReference |
|-----------|-------------|----------------|------------|------------------|---------|----------|-----------|---------------|

- Importowane dane mają zostać zapisane w bazie danych (tabele pacjentów, zamówień i wyników badań).
- **Wymagania techniczne:**
    - Obsługa błędów w przypadku niekompletnego lub wadliwego pliku CSV.
    - Logowanie poprawnie zaimportowanych rekordów oraz błędów do pliku.

---

2. Stworzenie API

- **Endpointy:**
    - `POST /api/login` – logowanie użytkownika na podstawie loginu (połączenie imienia i nazwiska pacjenta, np. `PiotrKowalski`) i hasła (data urodzenia pacjenta, np. `1983-04-12`). Zwraca token JWT.
    - `GET /api/results` – zwraca dane zalogowanego pacjenta oraz wyniki jego badań na podstawie tokenu JWT.
      Endpoint powinien zwrócić dane w następującej postaci:

{
  "patient": {
    "id": 10,
    "name": "John",
    "surname": "Smith",
    "sex": "m",
    "birthDate": "2021-01-01"
  },
  "orders": [
    {
      "orderId": "20",
      "results": [
        {
          "name": "foo",
          "value": "1",
          "reference": "1-2"
        },
        {
          "name": "bar",
          "value": "2",
          "reference": "1-2"
        }
      ]
    },
    {
      "orderId": "21",
      "results": [
        {
          "name": "foo",
          "value": "1",
          "reference": "1-2"
        },
        {
          "name": "bar",
          "value": "2",
          "reference": "1-2"
        }
      ]
    }
  ]
}

- **Dodatkowe wymagania:**
    - Autoryzacja za pomocą tokenu JWT.
    - Obsługa błędów (401 dla nieautoryzowanych żądań, 404 dla braku danych).

---

3. Frontend (Vue.js)

- **Funkcjonalności:**
    - **Logowanie użytkownika:**
        - Formularz logowania (login: imię + nazwisko pacjenta, hasło: data urodzenia).
        - Po pomyślnym zalogowaniu, użytkownik zostaje przekierowany do widoku z wynikami badań.
    - **Podgląd danych pacjenta i wyników badań:**
        - Wyświetlanie szczegółowych informacji o pacjencie.
        - Lista wyników badań (nazwa badania, wartość, wartość referencyjna).

- **Wymagania techniczne:**
    - Przechowywanie tokenu JWT w LocalStorage.
    - Automatyczne wylogowanie po wygaśnięciu tokenu (nice to have).

---

4. Baza Danych

- Przygotuj schemat bazy danych (PostgreSQL lub MySQL), który obsłuży:
    - Pacjentów.
    - Zamówienia (orderId) i wyniki badań.
- Zaimplementuj migracje w Laravel.

---

5. CI/CD

- Przygotuj plik konfiguracyjny dla GitLab CI/CD, który:
    - Uruchamia testy jednostkowe i integracyjne dla API.
    - Buduje aplikację frontendową (nice to have).
    - Buduje i wypycha obraz Docker (nice to have).

---

6. Docker

- Opracuj plik `docker-compose.yml`, który umożliwi lokalne uruchomienie aplikacji z backendem, frontendem i bazą danych.

---

Czas Realizacji

Zadanie należy wykonać w ciągu **7 dni** od momentu jego otrzymania.

---

Wynik Końcowy

Kandydat powinien dostarczyć repozytorium GIT (np. link do GitHub/GitLab/Bitbucket), które zawiera:
- Kod źródłowy backendu i frontendu.
- Pliki konfiguracyjne Docker, CI/CD i migracji.
- Plik README.md z instrukcjami uruchomienia projektu i pipeline’a CI/CD.

```

<hr>
<br>
</details>


<details><summary> 🛠️ Installation </summary>
<br>
    
- First make sure u have installed latest versions of [Composer](https://getcomposer.org/).

- Clone this repository from patient-manager branch.

```
git clone -b patient-manager https://github.com/SzymCode/RecruitmentTasks.git
```

- Change *.env.example* file to *.env* in root directory.

```bash
composer install
php artisan sail:install
sail up --build -d  # or ./vendor/bin/sail if you didn't define alias
sail art key:generate
sail art migrate
```


That's it! You can enter ```localhost:3000``` now.
<hr>
<br>
</details>


<details><summary> ❓ Usage </summary>
<br>

1. Backend tests - ```sail pest```
2. Backend code format - ```sail pint```
3. Frontend code format - ```npm run write```

<hr>
<br>
</details>


<details><summary> ✅ Solved Problems  </summary>
    
- [X] Import CSV command + API with frontend

- [X] API for results & login

- [X] Backend tests (100% coverage)

- [X] Nuxt with SSR + prerendering

- [X] Docker

</details>
