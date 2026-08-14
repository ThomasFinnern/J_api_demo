@ECHO OFF
REM CLS
ECHO --- _lecture.bat ---------------------------
ECHO.

REM does use the python plugin markdown-pp to collect 
REM all *.md files and create RSGallery2.Documentation.md
REM file. 
REM In Atom use the plugin markdown to PDF to create the matching *.PDF

ECHO markdown-pp _lecture.mdpp -o _lecture.md -e latexrender
markdown-pp _lecture.mdpp -o _lecture.md -e latexrender

ECHO Done
ECHO.

