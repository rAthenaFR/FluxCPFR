FluxCP FR
======
Panneau de contrôle Flux Control Panel (FluxCP) francisé pour les serveurs rAthena.

Cette version est destinée à fournir une base française propre : langue française par défaut, textes d’interface francisés, dossiers de langues inutiles retirés et modules de dons/PayPal supprimés volontairement.

Prérequis
---------
* PHP 7.3 ou plus récent
* Extensions PDO et PDO-MYSQL pour PHP, incluant le support PHP_MYSQL
* MySQL 5 ou plus récent
* Optionnel : GD2, pour les emblèmes de guildes et le CAPTCHA d’inscription
* Optionnel : Tidy, pour une sortie HTML plus propre
* Optionnel : support de mod_rewrite pour la fonctionnalité UseCleanUrls
* Optionnel : [images d’objets](http://rathena.org/board/files/file/2509-item-images/)

Contenu conservé
---------
* Thèmes pré-intégrés :
	- default
	- Bootstrap
* CMS d’actualités et de pages avec TinyMCE intégré
* Service Desk, système de tickets de support
* Logs du panel et logs rAthena
* Classements
* Intégration Discord
* Google ReCaptcha
* Fonctionnalité Remote AtCommand
* Boutique interne basée sur des crédits internes

Retrait volontaire des dons et de PayPal
---------
Les modules de dons, PayPal, IPN, logs de transactions PayPal et fichiers associés ont été retirés volontairement.

Ce choix est assumé pour cette version française :
* le panneau ne doit pas intégrer de flux d’argent réel par défaut ;
* PayPal/IPN ajoute une dépendance externe, une surface de sécurité et des obligations de configuration qui ne sont pas nécessaires à une base communautaire française ;
* les crédits restants sont des crédits internes, utilisables pour la boutique ou des récompenses administratives, sans lien avec un paiement ;
* les anciennes colonnes de suivi liées aux dons sont renommées en `last_credit_date` et `last_credit_amount` pour ne conserver qu’un vocabulaire de crédits internes.

Si un paiement réel doit être réintroduit, il doit l’être sous forme de module séparé, audité, documenté et adapté aux obligations légales du serveur concerné. Ce n’est pas inclus dans cette distribution.

Modules et dossiers retirés
---------
* Module `donate`
* Vues du thème liées aux dons
* Traitements PayPal/IPN
* Logs et schémas de transactions PayPal
* Langues autres que `fr_fr`
* Exemples d’addons non utilisés dans cette distribution française
* Fichiers de langue PHPMailer non français

Documentation
---------
La documentation utile se trouve dans le dossier `doc/` :
* installation
* thèmes
* langue française
* mise à jour de FluxCP
* création de thème personnalisé

Crédits
---------
* FluxCP original créé par Paradox924X et Byteflux, avec des contributions supplémentaires de Xantara.
* FluxCP GitHub : [FluxCP](https://github.com/rathena/FluxCP)
