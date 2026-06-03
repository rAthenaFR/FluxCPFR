Utiliser un thème personnalisé
======

Comment cela fonctionne-t-il ?
---------
Le système de thèmes de FluxCP est basé sur une "structure d’héritage". En termes simples, cela signifie que vous devez uniquement ajouter dans le dossier de votre nouveau thème les fichiers que vous souhaitez modifier.

Tout fonctionne de manière similaire au système d’import de configuration dans rAthena. Le thème par défaut est lu en premier, puis s’il existe dans le thème personnalisé des fichiers correspondant à la vue requise, ceux-ci sont chargés à la place. Cela signifie que **vous n’avez pas besoin de copier/coller le thème par défaut à chaque fois que vous créez un nouveau thème personnalisé**.

Le fichier manifest.php contrôle l’héritage avec `'inherit'     => 'default',`.

À quoi mon thème doit-il ressembler ?
---------
Voici un exemple de structure de répertoires pour un thème personnalisé dans une installation fraîche de FluxCP :
```
.
├── config
├── data
├── doc
├── lang
├── lib
├── modules
├── themes
|   ├── bootstrap
|   └── cust_theme1
|       └── css
|           ├── flux.css
|           └── customstyle.css
|       └── img
|           ├── bg.jpg
|           └── logo.png
|       └── js
|           ├── flux.unitip.js
|           └── ie9.js
|       └── main
|           ├── index.php
|           └── sidebar.php
|       ├── footer.php
|       ├── header.php
|       └── manifest.php
|   ├── default
|   └── installer
├── .gitignore
├── .htaccess
├── LICENSE
├── README.md
├── error.php
└── index.php
```

Comme vous pouvez le voir, il n’y a que quelques fichiers dans le dossier **cust_theme1**.


Comment l’afficher sur mon site web ?
---------
Pour activer votre thème, ajoutez-le simplement au tableau des thèmes dans /config/application.php :
```'ThemeName'					=> array('default', 'bootstrap', 'cust_theme1'),```

Si vous souhaitez que votre nouveau thème soit toujours affiché et supprimer la boîte de sélection du thème dans le pied de page, retirez les autres thèmes de ce tableau afin qu’il ressemble à ceci :
```'ThemeName'					=> array('cust_theme1'),```


Comment savoir si un thème que j’ai téléchargé fonctionnera ?
---------
En règle générale, si votre nouveau thème possède un fichier `manifest.php` dans le dossier du thème, il fonctionnera très bien avec les versions actuelles de FluxCP.

S’il ne possède pas de fichier `manifest.php`, vous devrez en créer un. Cela permettra au nouveau thème de se charger, mais vous aurez tout de même des problèmes.

Par le passé, même après l’introduction de ce système de thèmes, des concepteurs de thèmes ont quand même choisi de créer des thèmes dépendant d’anciennes versions de FluxCP. Ils sont paresseux. Utilisez-les à vos risques et périls.
