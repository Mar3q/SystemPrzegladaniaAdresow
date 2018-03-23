# Projekt Zespołowy grupy pierwszej.

## Opis
Wstępny Szkielet projektu z podstawowymi widokami, stworzony w Zend Framework 3.

## Wymagania : Apache 2.4, PHP 5.6 (lub nowszy) i MySQL 5.6 (lub nowszy), Composer.




## Instalacja na Linuxie (Ubuntu)

Przykładowo pobieramy projekt do katalogu domowego :
```bash
$ cd ~
$ git clone https://gitlab.com/Gizan/UWM2018
```

Przechodzimy do katalogu projektu i instalujemy zależności :
```bash
$ cd ~
$ cd UWM2018
$ composer update
```
Konfigurujemy VirtalHosta :

```bash
$ cd ~
$ cd /etc/apache2/sites-available
$ gedit 000-default.conf
```
W pliku 000-default.conf dodajemy następujący wpis:
(Należy pamiętać, aby odpowiednio skofigurować ścieżki do pliku DocumentRoot i Directory )

Przykładowo:
```
<VirtualHost *:80>

    ServerAdmin webmaster@localhost
    DocumentRoot /home/marek/UWM2018/public
    
	<Directory /home/marek/UWM2018/public/>
        DirectoryIndex index.php
        AllowOverride All
        Require all granted
    </Directory>
    
</VirtualHost>
```

Jeżeli wykonaliśmy wszystkie kroki instrukcji prawidłowo to powinniśmy zobaczyć Projekt pod adresem "http://localhost/".

## Instalacja na Windowsie (XAMPP)

Zakładamy, że xampp jest zainstalowany na "c:\xampp"

Wchodzimy w Git Basha i pobieramy projekt do katalogu htdocs:
```bash
$ cd /c/xampp/htdocs
$ git clone https://gitlab.com/Gizan/UWM2018
```

Wchodzimy w SHELL-a w XMAPP-ie i przechodzimy do katalogu projektu i instalujemy zależności :
```
cd /xampp/htdocs/UWM2018
composer update
```
Konfigurujemy VirtalHosta :
```
Idziemy do pliku : C:\xampp\apache\conf\extra\httpd-vhosts.conf
Dodajemy następujący wpis:

(Należy pamiętać, aby odpowiednio skofigurować ścieżki do pliku DocumentRoot i Directory )
<VirtualHost *:80>
    DocumentRoot C:/xampp/htdocs/UWM2018/public
	<Directory C:/xampp/htdocs/UWM2018/public/>
        DirectoryIndex index.php
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
Jeżeli wykonaliśmy wszystkie kroki instrukcji prawidłowo to powinniśmy zobaczyć Projekt pod adresem "http://localhost/".



