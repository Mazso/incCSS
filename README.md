# incCSS

Performance-Gewinn durch intelligentes Laden der CSS-Ressourcen

## Snippet für MODx2

- versieht Namen von CSS-Dateien mit einem Zeitstempel, womit sichergestellt ist, dass kein veraltetes aus dem Browser-Cache geladen wird
- beim ersten Aufruf wird das wichtige CSS inline eingebunden und das komplette per JavaScript nachgeladen
- bei weiteren Aufrufen wird die (nun bereits gecachete CSS-Datei als  Link-Element eingebunden
- Das CSS-Skript basieret auf https://github.com/filamentgroup/loadCSS (Thanks to Scott Jehl)


## Verwendung

- in die .htaccess folgende Zeilen eintragen

```
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule (.+)\.(min|dev)\.(\d+)\.(js|css)$ $1.$2.$4 [L]
```

- Snippet incCSS anlegen
- in den ungecacheten head-Bereich des MODx-Seiten-Templates Aufruf nach folgendem Muster einfügen 

```    
[[incCSS? &cssPath=`client/css/` &cssFast=`1.dev.css` &cssComplete=`2.dev.css`]]
```

**Wichtig:** Die CSS-Dateien *müssen* nach dem Muster `meine-datei.dev.css` oder `meine-datei.min.css` benannt werden.

## Parameter

* &cssPath = Pfad zu den CSS-Dateien
* &cssFast = gekürzte CSS-Datei
* &cssComplete = komplette CSS-Datei

Und am Ende nicht vergessen, CSS und JavaScript zu komprimieren
