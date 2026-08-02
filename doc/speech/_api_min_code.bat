@ECHO OFF
REM CLS
ECHO --- _api_min_code.bat ---------------------------
ECHO.

REM does use the python plugin markdown-pp to collect 
REM all *.md files and create RSGallery2.Documentation.md
REM file. 
REM In Atom use the plugin markdown to PDF to create the matching *.PDF

ECHO markdown-pp _api_min_code.mdpp -o 01__API_min_code_doc.md -e latexrender
markdown-pp _api_min_code.mdpp -o 01__API_min_code_doc.md -e latexrender

ECHO Done
ECHO.

