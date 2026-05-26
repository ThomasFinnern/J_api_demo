@ECHO Off
REM ----------------------------------------
REM Transform *.http file to *.tsk file format
REM %1 : path and name to source file
REM %2 : path to target file or path and name to target file
REM %3 : joomla token file or path
REM %4 : response file path
REM ----------------------------------------

REM ECHO \%NO_CLS\%: "%NO_CLS%"
if "%NO_CLS%" EQU "" (
    CLS
)
SET CmdArgs=

ECHO ----------------------------------------------
@ECHO Transform *.http file to *.tsk file format
ECHO ----------------------------------------------
@ECHO.

REM task command http to tsk conversion
Call :AddNextArg -t "task:http2tskFile"

REM task command http to tsk conversion
Call :AddNextArg -e "tsk"


REM --- source file and folder ---------------------------------

if "%1" NEQ "" (
	REM ECHO path0: %~dpn0
	REM ECHO path1: %~dpn1
    REM ECHO path2: %~dpnx1
	REM ECHO path3: %~dpx1
	REM ECHO path4: %~dp0
	REM ECHO path5: %~f1
	REM ECHO path6: %~dp0%1

 	SET srcFile=%~dp0%1

) else (
	SET srcFile=%~dp0curl_http_files\rsg2_getGalleries.http
)

REM source path
Call :AddNextArg -s %srcFile%

REM ECHO srcFile (1): %srcFile%

REM --- destination file and folder ---------------------------------

if "%2" NEQ "" (
	SET dstFileOrPath=%2
) else (
    SET dstFileOrPath=%~dp0curl_tsk_files\
)

REM source path
Call :AddNextArg -d %dstFileOrPath%

REM ECHO dstFileOrPath (1): %dstFileOrPath%

REM --- joomla token file or path ---------------------------------

if "%3" NEQ "" (
	SET jt_FileOrPath=%~f3
) else (
    SET jt_FileOrPath=d:\Entwickl\2025\_gitHub\xTokenFiles\token_joomla5x.txt
)

REM joomla token
Call :AddNextArg -j %jt_FileOrPath%


REM %4 : response file path

REM --- destination file and folder ---------------------------------

if "%4" NEQ "" (
	SET resFileOrPath=%~f4
) else (
    SET resFileOrPath=%~dp0
)

REM resolve file
Call :AddNextArg -r %resFileOrPath%


REM --- tell found options bat ------------------------

@REM ECHO srcFile: %srcFile%
@REM ECHO dstFileOrPath: %dstFileOrPath%
@REM ECHO.
@REM ECHO CmdArgs: %CmdArgs%
@REM
@REM goto :EOF

REM --- Php exe path -------------------------------------------------

REM Path for calling
SET ExePath=e:\wamp64\bin\php\php8.4.5\
REM ECHO ExePath: "%ExePath%"

if exist "%ExePath%php.exe" (
    REM path known (WT)
    ECHO ExePath: "%ExePath%"
) else (
    REM Direct call
    ECHO PHP in path variable
    SET ExePath=
)

ECHO.
ECHO ----------------------------------------------
"%ExePath%php.exe" --version

ECHO ----------------------------------------------
ECHO.

REM ECHO --- "%ExePath%php.exe" ..\..\..\apiByCurlHtml\src\task_http_file\tsk2httpFileCmd.php %CmdArgs%
REM "%ExePath%php.exe" ..\..\..\apiByCurlHtml\src\task_http_file\tsk2httpFileCmd.php %CmdArgs%

pushd ..\..\..\apiByCurlHtml\src\task_http_file
REM dir

ECHO CmdArgs: %CmdArgs%

ECHO --- "%ExePath%php.exe" tsk2httpFileCmd.php %CmdArgs%
"%ExePath%php.exe" tsk2httpFileCmd.php %CmdArgs%

popd

ECHO ----------------------------------------------
@ECHO Transform of %srcFile% done
@ECHO.

REM ECHO \%NO_PAUSE\%: "%NO_PAUSE%"
if "%NO_PAUSE%" EQU "" (
	pause
)

GOTO :EOF

REM ------------------------------------------
REM Adds given argument to the already known command arguments
:AddNextArg
	SET NextArg=%*
	SET CmdArgs=%CmdArgs% %NextArg%
	ECHO  '%NextArg%'
GOTO :EOF

