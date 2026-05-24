# Joomla! 4.x Component Boilerplate

Secondhand
Bare minimum component displaying a books list
com_secondhand

Copyright (C) 2026 Steven Smith. All rights reserved. 
Steven Smith
https://smith14639@whatever.com

Diese mit dem formativ.net Extension Builder erstellte Joomla! 4.x Komponente stellt nur ein Grundgerüst für Ihre 
Komponente dar.

## Weiterführende Informationen

Developing an MVC Component for Joomla 4.x

https://docs.joomla.org/J4.x:Developing_an_MVC_Component

Joomla! Coding Standards

https://developer.joomla.org/coding-standards/basic-guidelines.html

Astrid Günther: Joomla 4.x-Tutorial - Entwicklung von Erweiterungen - Der Weg zu Joomla 4 Erweiterungen

https://blog.astrid-guenther.de/der-weg-zu-joomla4-erweiterungen/

## Erste Schritte

### Sprachen-Dateien

Die erstellten Sprachen-Dateien haben alle den gleichen Inhalt. Bitte ergänzen und übersetzen Sie diese. 

### Datenbank-Tabellen

Die Tabellen sind Vorlagen die Spalten für gängige Funktionen enthalten. Diese müssen von Ihnen angepasst werden.

### Javascript

Alle Frontend-Views laden via Joomla! Web Asset Manager die Javascript-Datei /media/com_secondhand/js/script.js

In der script.js können Sie Ihre Javascript-Funktionen hinterlegen.

## Setup-Script

Das Setup-Script wird während der Installation Ihrer Joomla! 4.x Komponente ausgeführt.
Aufgabe des Setup-Script ist es zusätzliche Installationsschritte auszuführen die der Joomla! Installer nicht selbst
anhand der XML-Datei und der SQL-Datei ausführen kann.

## Changelog

Seit Joomla! 4.0 können Extension-Entwickler die Fähigkeit von Joomla! nutzen, eine Changelog-Datei zu lesen und eine 
visuelle Darstellung des Changelogs zu geben. Wenn eine bestimmte Version nicht im Changelog gefunden wird, wird die Schaltfläche Changelog nicht angezeigt.

https://blog.astrid-guenther.de/joomla-update-und-change-logeinrichten/

Kopieren Sie die Datei changelog.xml auf Ihren Server.

/changelog.xml

## Update-Server

https://docs.joomla.org/Deploying_an_Update_Server/de

https://blog.astrid-guenther.de/joomla-update-und-change-logeinrichten/

Kopieren Sie die Datei extension.xml sowie die Zip-Datei auf Ihren Server.

https://YOUR-UPDATE-URL.COM/com_secondhand/extension.xml

https://YOUR-UPDATE-URL.COM/com_secondhand/com_secondhand.zip

