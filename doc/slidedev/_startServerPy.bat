@ECHO off
REM startServerPy.bat

ECHO python -m http.server -d ./reveal.js/
python -m http.server -d ./reveal.js/
