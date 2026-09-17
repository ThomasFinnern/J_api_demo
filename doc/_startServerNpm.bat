@ECHO off
REM startServerPy.bat

REM ECHO python -m http.server
REM python -m http.server
REM ECHO npm start
REM npm start -- --port=8001
REM npm run --prefix project ${COMMAND}
ECHO npm run --prefix reveal.js
npm run --prefix reveal.js start
