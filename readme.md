Nette Blog Demo
===============

Zadání:
-------

Vytvořte jednoduchý systém pro blogování. Blog příspěvky bude moci přidávat pouze oprávněný uživatel, takže pro přidání příspěvku bude nutná autorizace. Autorizace se provede vůči tabulce uživatelů, kteří budou uloženi v databázi.

Blok příspěvek bude mít název, anotaci, popis a obrázek. Vytvořte formulář, pomocí kterého bude možné tyto příspěvky vytvářet a plnit. Data uložte do databáze, obrázky případně na disk.

Výstupem na homepage bude seznam příspěvků řazený dle nejnovějších prvně. Vypsány budou pouze nadpisy a anotace příspěvků. Výpis bude stránkovaný po 10 záznamech.

Příspěvek z listu půjde rozkliknout do detailu, ve kterém se zobrazí název, anotace, popis a fotografie. V detailu bude drobečková navigace ve tvaru Úvod - Název stránky, klik na úvod mě proklikne zpět na homepage.

Požadavky na zpracování:
------------------------

Celou aplikaci postavte pomocí Nette verze 2.4.
Využijte správu závislostí pomocí Composer.
Navrhněte datový model a implementujte jej pomocí Doctrine a rozšíření Kdyby pro Nette.
List příspěvků zpracujte jako samostatnou Nette komponentu.
Formulář zpracujte jako samostatnou Nette komponentu.
Pro HTML kód a styly využijte frameworku Bootstrap, tzn. formuláře a vzhled budou alespoň trochu koukatelné :).
Stránkování listu udělejte AJAXově pomocí redraw.
Aplikaci zpracujte a umístěte na web nebo případně zašlete zazipovanou včetně databáze emailem.

Instalace:
----------
Rozbalit archiv
Spustit "composer install" pro stazeni zavislosti
php ./www/index.php orm:schema-tool:update --force


Installation
------------
```
git clone https://github.com/knapovsky/nette-blog
composer install
mkdir temp log
chmod 777 temp log
php ./www/index.php orm:schema-tool:update --force
```

Web Server Setup
----------------
```
php -S localhost:8000 -t www
```

Requirements
------------

PHP 5.6 or higher. To check whether server configuration meets the minimum requirements for
Nette Framework browse to the directory `/checker` in your project root (i.e. `http://localhost:8000/checker`).


Adminer
-------

[Adminer](https://www.adminer.org/) is full-featured database management tool written in PHP and it is part of this Sandbox.
To use it, browse to the subdirectory `/adminer` in your project root (i.e. `http://localhost:8000/adminer`).


License
-------
- Nette: New BSD License or GPL 2.0 or 3.0
- Adminer: Apache License 2.0 or GPL 2
