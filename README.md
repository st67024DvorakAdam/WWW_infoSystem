# WWW_infoSystem
Bootstrap
- hned po otevření bude dostupná registrace a přihlášení
- když se přihlásím, tak musím vidět nějakou nástěnku firemních akcí
- vpravo nahoře vidět jako kdo jsem přihlášen
- uvidím odkaz na samostné okno s chatováním


Databáze
- user
  - id
  - first_name
  - last_name
  - sex
  - email
  - phone_number
  - password
  - isAdmin
  - img_path
  - register_date
    

- user_post
  - id
  - img_path
  - text
  - postDateTime
  - user_id

- Zpráva
  - Odesílatel (uzivatel)
  - Příjemce (uzivatel)
  - Text 
  - Datum a čas (datetime)
  
PHP
- šifrovat heslo
- kvůli gdpr šifrovat asi i mail a telefon
- login musí být univerzální
- musí být jeden admin
