@ECHO Off
REM ----------------------------------------
REM Transform *.tsk files to *.bat curl command batch file
REM %1 : path and name to source file
REM %2 : path to target file or path and name to target file
REM ----------------------------------------

SET CmdArgs=

ECHO ----------------------------------------------
@ECHO Transform *.tsk files to *.bat curl command batch file
ECHO ----------------------------------------------
@ECHO.

REM task command curl command batch file
Call :AddNextArg -t "task:tsk2httpCmdLine"

REM task command http to tsk conversion
Call :AddNextArg -e "bat"


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
	set srcFile=rsg2_getGalleries.tsk
)

REM source path
Call :AddNextArg -s %srcFile%

REM ECHO srcFile (1): %srcFile%

REM --- destination file and folder ---------------------------------

if "%2" NEQ "" (
	SET dstFileOrPath=%2
) else (
    SET dstFileOrPath=%~dp0curl_cmdLine\
)

REM source path
Call :AddNextArg -d %dstFileOrPath%

ECHO srcFile: %srcFile%
ECHO dstFileOrPath: %dstFileOrPath%

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

