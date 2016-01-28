<?php
/*
Snippet für MODx2
- versieht Namen von CSS-Dateien mit einem Zeitstempel, womit sichergestellt ist, dass kein veraltetes aus dem Browser-Cache geladen wird

- beim ersten Aufruf wird das wichtige CSS inline eingebunden und das komplette per JavaScript nachgeladen
- bei weiteren Aufrufen wird die (nun bereits gecachete CSS-Datei als  Link-Element eingebunden
- Das CSS-Skript basierent auf https://github.com/filamentgroup/loadCSS (Thanks to Scott Jehl)


Verwendung

- in die .htaccess diese Zeilen einfügen

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule (.+)\.(min|dev)\.(\d+)\.(js|css)$ $1.$2.$4 [L]

- Snippet incCSS anlegen
- in den ungecacheten head-Bereich Aufrufnach folgendem Muster einfügen [[incCSS? &cssPath=`client/css/` &cssFast=`1.dev.css` &cssComplete=`2.dev.css`]]
einfügen

Parameter

&cssPath = Pfad zu den CSS-Dateien
&cssFast = gekürzte CSS-Datei
&cssComplete = komplette CSS-Datei

Wichtig: Die CSS-Datei muss nach dem Muster meine-datei.dev.css oder meine-datei.min.css benannt werden.

Und am Ende nicht vergessen, CSS und JavaScript zu komprimieren

*/
$includeFastPath = './' . $cssPath .''. $cssFast;   
$pathCompleteAbsolute = $modx->config["base_path"].''.$cssPath.''.$cssComplete;
$pathCompleteParts = pathinfo($pathCompleteAbsolute);
$pathComplete = $cssPath.''.$pathCompleteParts['filename'].'.'.filemtime($pathCompleteAbsolute). '.'.$pathCompleteParts['extension'];
echo (!isset($_COOKIE['css'])) ? '<style>' . file_get_contents($includeFastPath) . '</style><script>document.cookie="css=1";
(function(w){
	"use strict";
	var loadCSS = function( href, before, media ){
		var doc = w.document;
		var ss = doc.createElement( "link" );
		var newMedia = media || "all";
		var ref;
		if( before ){
			ref = before;
		}
		else {
			var refs = ( doc.body || doc.getElementsByTagName( "head" )[ 0 ] ).childNodes;
			ref = refs[ refs.length - 1];
		}
		var sheets = doc.styleSheets;
		ss.rel = "stylesheet";
		ss.href = href;
		ss.media = "only x";
		ref.parentNode.insertBefore( ss, ( before ? ref : ref.nextSibling ) );
		var onloadcssdefined = function( cb ){
			var resolvedHref = ss.href;
			var i = sheets.length;
			while( i-- ){
				if( sheets[ i ].href === resolvedHref ){
					return cb();
				}
			}
			setTimeout(function() {
				onloadcssdefined( cb );
			});
		};
		if( ss.addEventListener ){
			ss.addEventListener( "load", function(){
				this.media = newMedia;
			});
		}
		ss.onloadcssdefined = onloadcssdefined;
		onloadcssdefined(function() {
			if( ss.media !== newMedia ){
				ss.media = newMedia;
			}
		});
		return ss;
	};
	if( typeof exports !== "undefined" ){
		exports.loadCSS = loadCSS;
	}
	else {
		w.loadCSS = loadCSS;
	}
}( typeof global !== "undefined" ? global : this ));
loadCSS("/' . $pathComplete . '");   
</script>' : '<link href="/' . $pathComplete . '" rel="stylesheet" media="screen">';
