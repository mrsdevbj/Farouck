@echo off
setlocal enabledelayedexpansion
cd /d "c:\Users\Ordinateur\OneDrive\Desktop\ADEKAMBI"

REM Lire le fichier et remplacer action="#" par action="envoyer_message.php"
for /f "delims=" %%A in (contact.html) do (
    set "line=%%A"
    set "line=!line:action="#"=action="envoyer_message.php"!"
    echo !line!
) > contact_temp.html

REM Remplacer le fichier original
del contact.html
rename contact_temp.html contact.html

echo Mise à jour terminée avec succès !
pause
