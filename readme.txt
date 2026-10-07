=== Aesys MyInfo.City Viewer ===
Contributors: Milmor
Version:	2.2
Stable tag:	2.2
Author:		Marco Milesi
Author URI:   https://profiles.wordpress.org/milmor/
Requires at least: 3.8
Tested up to: 6.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Visualizza i display AESYS in post, pagine e widget: un nuovo strumento di informazione utile, facile e veloce!

== Description ==

[MyInfo.City](https://mic.aesys.com/) è una App che facilita l’incontro e lo scambio di informazioni tra Pubbliche Amministrazioni, Enti e cittadini. Grazie a MyInfoCity, gli Enti Pubblici possono gestire i propri display Informacittà, o altri dispositivi installati sul territorio (es. display per l'indirizzamento ai parcheggi, videocamere, display per l'accesso alle ZTL) per comunicare informazioni ai cittadini, che a loro volta possono consultarle ovunque, in ogni momento, sul web e sui dispositivi mobili.

Questo plugin è compatibile solo con i display che trovi nel portale [MyInfo.City](https://mic.aesys.com/).

https://youtu.be/wBKTMcg4Ujs

= Shortcode =

Per visualizzare i display nei tuoi post, pagine o widget, utilizza lo shortcode:

`[aesys id="XXX" title="XXX" height="XXX" width="XXX"]`

Parametri disponibili:

* **id** - default: 0 - Consulta la videoguida per trovare il tuo ID
* **height** - default: auto
* **width** - default: 100%
* **title** - default: nessuno

Il plugin integra un sistema di cache che rigenera i display ogni 15 minuti

= Credits =

* Developed by [Marco Milesi](https://www.marcomilesi.com/) for the project [wpgov.it](https://wpgov.it/)
* Based on [aesys.com](http://aesys.com/) cloud technology

**Plugin non ufficiale rilasciato previo accordo con AESYS S.p.A.**
Il marchio "MyInfoCity" e la tecnologia cloud dei display "Informacittà" sono di proprietà di AESYS S.p.A.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==
1. Display systems loading (admin dashboard)
2. Display systems (admin dashboard)
3. Public page example (shortcode)
4. Public post example (shortcode)

== Changelog ==

= 2.2 20230217 =
* Minor changes
* Compatibility check

= 2.1 20220313 =
* Minor changes
* Compatibility check

= 2.0.4 20201003 =
* Minor changes
* Compatibility check

= 2.0.3 20200314 =
* Resolved possibile warnings.

= 2.0.2 20200312 =
* Compatibility check

= Versione 2.0.1 05.12.2018 =
* Added auto detect of HTTP/HTTPS to fetch embed

= Versione 2.0 2.05.2018 =
* **Gli ID dei tabelloni sono cambiati e vanno riconfigurati!**
* **Creato videotutorial di spegazione**
* **Miglioramenti performance**
* Bugfix su funzione deprecata per lo scraping

= Version 1.4 16.11.2017 =
* Tested **WP 4.9** compatibility

= Version 1.3 - 14.09.2016 =
* Added 15-minutes cache system, for all users
* Some bugfix
* Some changes and improvements

= Version 1.2.1 - 17.11.2015 =
* Minor changes

= Version 1.2 - 17.11.2015 =
* Internet Explorer Bugfix (old versions)

= Version 1.1.2 - 27.10.2015 =
* Fixed conflict with [EU Cookie Law](https://wordpress.org/plugins/eu-cookie-law/)
* Readme.txt changes

= Version 1.1 - 26.10.2015 =
* Fixed css problem
* Fixed update issue
* Readme.txt changes

= Version 1.0 - 26.10.2015 =
* Now display sistems are in real time
* Added async image load with javascript (real time)
* Minor changes

= Version 0.1 - 20.10.2015 =
First upload
