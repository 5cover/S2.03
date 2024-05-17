# TP

## Le service Web avec le serveur Apache

### 2

`systemctl status apache2`

```text
...
     Active: active (running) since Tue 2024-05-14 11:03:23 CEST; 8min ago
...
    Process: 539 ExecStart=/usr/sbin/apachectl start (code=exited, status=0/SUCCESS)
    Process: 967 ExecReload=/usr/sbin/apachectl graceful (code=exited, status=0/SUCCESS)
   Main PID: 657 (apache2)
      Tasks: 6 (limit: 2285)
     Memory: 18.6M
        CPU: 336ms
...
```

### 3

DocumentRoot : définit le répertoire à partir duquel Apache va servir les fichiers comme les pages HTML et images.

Se trouve dans `/etc/apache2/sites-enabled/*.conf`.

Valeur dans `/etc/apache2/sites-enabled/000-default.conf` : `/var/www/html`

### 4

`type -a apache2` : `/usr/sbin/apache2`, `/sbin/apache2`

### 5

`apache2 -v`

```text
Server version: Apache/2.4.53 (Debian)
Server built:   2022-03-14T16:28:35
```

### 6

`apache2 -l`

```text
  core.c
  mod_so.c
  mod_watchdog.c
  http_core.c
  mod_log_config.c
  mod_logio.c
  mod_version.c
  mod_unixd.c
```

### 7

mod_log_config : Ce module apporte une grande souplesse dans la journalisation des requêtes des clients. Les journaux sont écrits sous un format personnalisable, et peuvent être enregistrés directement dans un fichier, ou redirigés vers un programme externe. La journalisation conditionnelle est supportée, si bien que des requêtes individuelles peuvent être incluses ou exclues des journaux en fonction de leur caractéristiques.

### 8

`apache2 -M`

```text
```

### 9

`apache2 -version`

Il n'y a pas de différence avec `apache2 -v`

Mais il peut y avoir un erreur (friendly warning) si il y a un problème dans le fichier de configuration

### Création d'une partie administration

Index.html&nbsp;:

```html

```

`source /var/apache2/envvars` pour initialiser les variables d'environnement en cas d'erreur de syntax du fichier de configuration.

#### Mise en place de l'authentification administrateur

`htpasswd -c /etc/apache2/pass testeur`

Puis ajouter dans le fichier de configuration du site:

```text
<Directory "/var/www/html/private">
    AuthType Basic
    AuthName "Veuillez saisir votre mot de login/passe"
    AuthUserFile "/etc/apache2/pass"
    Require valid-user
</Directory>
```

Recharget pour appliquer la nouvelle configuration :

`service apache2 reload`

## Le module PHP

### 1

### 2

Il est recommandé de créer un dossier secret pour sécuriser le site. En effet si un utilisateur lambda peut voir les informations à caractère sensibles données par `phpinfo`, cela rend le site vulnérable.

### 3

`127.0.0.1/secret/phpinfo.php`

### 4

Oui car le PHP a fonctionné.

### 5

On voit que le module `php7.4` est présent dnas le dossier `mods-enabled`

TODO

Ce n'est pas un fichier classique, c'est un lien symbolique.

### 6

\#|question|réponse
-|-|-
i.|La version exacte du module PHP utilisé par notre serveur Web|7.4.28
ii| Le dossier de configuration du module PHP utilisé par notre serveur Web|/etc/php/7.4/apache2
ii|. Le fichier de configuration de php pour le serveur Web |/etc/php/7.4/apache2/php.ini
b.|La valeur de l’étiquette appelée « short_open_tag » |Off
c.|À votre avis, dans quel fichier de configuration (chemin exacte) peut-on modifier la valeur de cette étiquette « short_open_tag » ? |/etc/php/7.4/apache2/php.ini
d.|Si on devrait modifier la valeur de cette étiquette dans un fichier de configuration, faut-il recharger/relancer le serveur Web pour que la nouvelle valeur soit prise en compte ?|Oui il faut faire un `service apache2 reload`

### 7

`whereis php` : `/usr/bin/php`

### 8

`a2dismod php7.4`

Le module php est désormais désactivé.

### 9

Oui

### 10

Le PHP ne fonctionne plus.

Il y a une vulnérabilité car les balises PHP ne sont plus substituées. L'utilisateur peut donc les voir dans la page finale.

Accès URL : on a une page vide qui contient le code PHP

Dossier propre à Apache? TODO

### 11

`a2enmod php7.4` puis rechargement du serveur.

Accès URL : ça marche correctement

Dossier propre à Apache? TODO

## 12

mapage.html&nbsp;:

```html
<?php echo "coucou, je suis une code php dans une page HTML ?>
```

## 13

Non

## 14

Dans le viewsource, on peut voir la balise PHP.

En effet, comme *mapage* a pour extension HTML et non PHP, elle n'est pas reconnue par le module PHP, et donc elle n'est pas exécutée.

## 15

Le fichier de configuration à modifier est

`/etc/apache2/mods-available/php7.4.conf`

C'est cette section qui nous intéresse&nbsp;:

```text
<FilesMatch ".+\.ph(ar|p|tml)$"> 
    SetHandler application/x-httpd-php 
</FilesMatch>
```

Il faut modifier l'expression régulière pour matcher les fichiers `*.html`

`.+\.(phar|php|p?html)`
