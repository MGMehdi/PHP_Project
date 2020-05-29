# PHP_Project

## Créer la base de données

Exécuter le script `database.sql` se trouvant dans le dossier `SCRIPTS`.

## Modérateur

Le modérateur enregistré par défaut est :

```
- Mail : root@toto.roto
- Mot de passe : _X`%\5/,cM&^W5xoq"w]%j9}"/e7A*
```

## Configuration

### php.ini

```
[mail function]
SMTP=smtp.gmail.com
smtp_port=587
sendmail_from = i.am.jajino@gmail.com
sendmail_path = "\"E:\xampp\sendmail\sendmail.exe\" -t"
```

### sendmail.ini

```
[sendmail]

smtp_server=smtp.gmail.com
smtp_port=587
error_logfile=error.log
debug_logfile=debug.log
auth_username=i.am.jajino@gmail.com
auth_password=dbyjdkvtiqyzqzyy
force_sender=i.am.jajino@gmail.com
```