@echo Off
REM ----------------------------------------
REM Transform all *.tsk files to *.http file format 
REM %1 : path to target file 
REM %2 : path to source folder
REM ----------------------------------------

CLS 

REM --- destination file and folder ---------------------------------

if "%1" NEQ "" (
	SET dstPath=%1
) else (
    REM set dstPath=""
    set dstPath=%~dp0curl_http_files\
)

REM --- source folder folder ---------------------------------

if "%2" NEQ "" (
	SET srcPath=%2
) else (
    REM set srcPath=%~dp0curl_tsk_files\
    set srcPath=%~dp0
)

REM --- transformation -------------------------------

@echo Transform all *.tsk files to *.http file format 
@echo.

REM Call transformation on each matching file

REM for %%i in (*.tsk) do @echo %%i
ECHO "for %%i in (*.tsk) do CALL :tsk2httpFile %%i"
for %%i in (*.tsk) do CALL :tsk2httpFile %%i


@ECHO -----------------------------------------------
@Echo all *.tsk files are transferred
@ECHO -----------------------------------------------

REM pause

goto :EOF

REM ----------------------------------------
REM transform all *.tsk files into *.html file (in other folder)
REm ----------------------------------------

:tsk2httpFile
Rem expected files and folders befor deleting .\progs\*.hel ...

ECHO tsk2httpFile: "%1"

REM if not exist %1\nul goto :EOF

SET NO_PAUSE=true
CALL _task2http_file.bat %1 %dstPath%
SET NO_PAUSE=

goto :EOF
