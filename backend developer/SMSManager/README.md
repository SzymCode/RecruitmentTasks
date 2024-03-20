# SMSManager  <div> ![PHP](https://img.shields.io/badge/PHP-%23777BB4.svg?style=flat&logo=php&logoColor=white) [![JavaScript](https://shields.io/badge/JavaScript-black?logo=JavaScript&logoColor=F7DF1E)](https://developer.mozilla.org/en-US/docs/Web/JavaScript) ![Symfony](https://img.shields.io/badge/Symfony-%23000000.svg?logo=symfony&logoColor=white) ![CSS](https://img.shields.io/badge/CSS3-%231572B6.svg?logo=css3&logoColor=white)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-%237952b3.svg?logo=bootstrap&logoColor=white&style=flat)](https://getbootstrap.com/) ![Docker](https://img.shields.io/badge/Docker-%230db7ed.svg?logo=docker&logoColor=white) </div>

This is a recruitment task project for [IronTeam](https://ironteam.pl) company.


<br>
<details><summary> 📖 Problem description </summary>
<br>

```
Zadanie SMS Zadanie polega na napisaniu aplikacji w najnowszym PHP oraz najnowszej
wersji LTS Symfony, która będzie odbierała wiadomości SMS, wyświetlała je dla 
użytkownika i pozwalała na pełną ich modyfikację przez użytkownika. 

- Aplikacja powinna cyklicznie (np. co 1 minutę) pobierać nowe wiadomości SMS oraz 
w warstwie wizualnej powinien znaleźć się przycisk, który uruchomi pobranie nowych 
wiadomości na żądanie. 
- Odbiór wiadomości SMS jest lekko utrudniony, ponieważ każda 
wiadomość SMS jest konwertowana na email, należy zatem odbierać nowe emaile z serwera 
pocztowego, odpowiednio parsować z ich treści nadawcę, datę otrzymania oraz treść 
wiadomości i zapisywać te elementy w bazie danych.  
- Aby wysłać nowego SMS’a należy wysłać SMS na numer telefonu 4628, nasz wysłany SMS 
powinien zawsze rozpoczynać się słowem „iron”(takie niestety ograniczenie darmowego 
numeru odbiorczego), aby był skonwertowany na email. Koszt wysyłanego SMSa jest jak 
koszt zwykłej wiadomości SMS na numer komórkowy. Wiadomości email można podejrzeć ręcznie 
logując się na stronie https://poczta.iq.pl i podając dane: 
  - login (adres e-mail):  sms-rekrutacja@ironteam-raporty.pl 
  - hasło:  sLdVcoRBu23ltiRIrwVt  

Dane do połączenia z serwerem pocztowym: 
  - login (adres e-mail):  sms-rekrutacja@ironteam-raporty.pl 
  - hasło:  sLdVcoRBu23ltiRIrwVt 
  - serwer IMAP:  imap.iq.pl    
  - port nr: 143 lub 993 (SSL)  
  
Wymagania: 
1. Logowanie 
2. Ręczna modyfikacja rekordów odczytanych SMSów: Dodaj/Wyswietl/Edytuj/Usuń 
3. Proste sortowanie i filtrowanie 
4. Uruchomienie ręczne do pobrania SMS. Po uruchomieniu skryptu - automatyczne odświeżenie listy odczytanych SMSów 
5. Opcjonalnie wyszukiwarka  
7. Jako wyniku pracy oczekujemy linku do publicznego repozytorium (np. github) 
z rozwiązaniem zadania oraz podstawowych informacji na temat wersji poszczególnych komponentów do uruchomienia. 
8. Niezbędna również będzie migracja tworząca startową bazę danych lub skrypt .sql.  

Termin: 24H od momentu otrzymania treści zadania. 
```

<br>
</details>


<details><summary> 🚀 Installation & Run </summary>
<br>

- First make sure u have installed latest versions of [Symfony](https://symfony.com), [PHP](https://www.php.net), [Docker](https://www.docker.com) and [Composer](https://getcomposer.org/).

- Clone this repository from sms-manager branch.

```
git clone -b sms-manager https://github.com/SzymCode/RecruitmentTasks.git
```

- Change *.env.example* file to *.env* in root directory.

- Open Docker Desktop

- Run command bellow in cmd:

```
docker-compose up --build -d
```


- Open browser with this url:

```
http://localhost:8000
```


<br>
</details>




<details><summary> ✅ Solved Problems  </summary>

```
1. Ręczna modyfikacja rekordów odczytanych SMSów: Dodaj/Edytuj/Usuń 
2. Uruchomienie ręczne do pobrania SMS. Po uruchomieniu skryptu - automatyczne odświeżenie listy odczytanych SMSów 
3. Jako wyniku pracy oczekujemy linku do publicznego repozytorium (np. github) 
z rozwiązaniem zadania oraz podstawowych informacji na temat wersji poszczególnych komponentów do uruchomienia. 
4. Interfejs graficzny, projekt bazy danych i pozostałe detale – wedle własnego uznania. 
5. Niezbędna również będzie migracja tworząca startową bazę danych lub skrypt .sql.  

```

</details>
