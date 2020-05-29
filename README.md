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

### Déplacer le projet

Créer un lien symbolique avec le CMD

```bash
# Dossier de destination - dossier du projet
mklink /d "E:\xampp\htdocs\PHP_Project" "E:\Mehdi\Documents\Code\PHP_Project"
```

### php.ini

Changer le chemin `sendmail_path` pour correspondre avec Xampp

```
[mail function]
SMTP=smtp.gmail.com
smtp_port=587
sendmail_from = i.am.jajino@gmail.com
sendmail_path = "\"E:\xampp\sendmail\sendmail.exe\" -t"
```

### sendmail.ini

`xampp\sendmail\sendmail.ini`

Remplacer le contenu du fichier par ceci :

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

### Pour fini

Après avoir configurer Xampp