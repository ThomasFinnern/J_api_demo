@echo Off
REM ----------------------------------------
REM Transform all *.http files to *.http file format 
REM %1 : path to target file 
REM %2 : path to source folder
REM ----------------------------------------

CLS 

REM --- destination file and folder ---------------------------------

if "%1" NEQ "" (
	SET dstPath=%1
) else (
    REM set dstPath=""
    set dstPath=%~dp0curl_tsk_files\
)

REM --- source folder folder ---------------------------------

if "%2" NEQ "" (
	SET srcPath=%2
) else (
    set srcPath=%~dp0curl_http_files\
)

REM --- transformation -------------------------------

@echo Transform all *.http files to *.http file format 
@echo.

REM Call transformation on each matching file
ECHO "for %%i in (%srcPath%\*.http) do CALL :http2tskFile %%i"
for %%i in (%srcPath%\*.http) do CALL :http2tskFile %%i 


@ECHO -----------------------------------------------
@Echo all *.http files are transferred
@ECHO -----------------------------------------------

REM pause

goto :EOF

REM ----------------------------------------
REM transform all *.http files into *.html file (in other folder)
REm ----------------------------------------

:http2tskFile
Rem expected files and folders befor deleting .\progs\*.hel ...

ECHO http2tskFile: "%1"

REM if not exist %1\nul goto :EOF

SET NO_CLS=true
SET NO_PAUSE=true
CALL _http2task_file.bat %1 %dstPath%
SET NO_PAUSE=
SET NO_CLS=

goto :EOF
