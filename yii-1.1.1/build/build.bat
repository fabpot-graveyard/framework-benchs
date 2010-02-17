@echo off

rem -------------------------------------------------------------
rem  build script for Windows.
rem
rem  This is the bootstrap script for running build on Windows.
rem
rem  @author Qiang Xue <qiang.xue@gmail.com>
rem  @link http://www.yiiframework.com/
rem  @copyright Copyright &copy; 2008 Yii Software LLC
rem  @license http://www.yiiframework.com/license/
rem  @version $Id: build.bat 2 2008-09-28 12:03:53Z qiang.xue $
rem -------------------------------------------------------------

@setlocal

set BUILD_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

%PHP_COMMAND% "%BUILD_PATH%build" %*

@endlocal