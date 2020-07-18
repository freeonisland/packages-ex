@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../vendor/propel/propel/bin/propel
php "%BIN_TARGET%" %*
