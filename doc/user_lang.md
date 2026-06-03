Fichiers de langue
======

Comment fonctionnent-ils ?
---------
Le répertoire **lang/** contient la traduction utilisée avec FluxCP. Cette version française conserve uniquement `fr_fr.php`, et la langue utilisée est contrôlée par le paramètre `DefaultLanguage` dans `config/application.php`.

En clair, `'DefaultLanguage' => 'fr_fr'` charge le fichier de langue français et utilise les chaînes qu’il contient partout où `Flux::message()` est appelé dans les fichiers de thème.


Comment les utiliser ?
---------
Par exemple, dans un fichier de thème qui affiche si le personnage d’un joueur est masculin ou féminin, vous verrez `<?php echo Flux::message('GenderTypeMale') ?>` ou `<?php echo Flux::message('GenderTypeFemale') ?>`.

Les menus définis dans `config/application.php` sont configurés pour utiliser automatiquement les fichiers de langue. Par exemple, regardons ce menu précis :

```
'MenuItems'		=> array(
		'MainMenuLabel'		=> array(
			'HomeLabel'			=> array('module' => 'main'),
			'NewsLabel'			=> array('module' => 'news'),
		),
),
```

Lorsque la page est rendue, vous verrez que ces chaînes sont remplacées par leurs équivalents provenant du fichier de langue.
'MainMenuLabel' devient 'Menu principal', 'HomeLabel' devient 'Accueil', 'NewsLabel' devient 'Actualités'.


Mauvaise utilisation courante
---------
Beaucoup de personnes pensent encore que la partie 'Label' de ces chaînes doit être supprimée dans le fichier de configuration, car cela affiche 'HomeLabel' sur la page au lieu de 'Home'. **C’est incorrect.** Cela signifie simplement que le thème que vous utilisez a été créé avant août 2014 et que vous ne devriez pas l’utiliser.
