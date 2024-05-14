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

mod_log_config : Ce module apporte une grande souplesse dans la journalisation des requêtes des clients. Les journaux sont écrits sous un format personnalisable, et peuvent être enregistrés directement dans un fichier, ou redirigés vers un programme externe. La journalisation conditionnelle est supportée, si bien que des requêtes individuelles peuvent être incluses ou exclues des journaux en fonction de leur caractéristiques.
