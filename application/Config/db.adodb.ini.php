<?php

// Make sure this file can be not directly opened.
// DO NOT remove this EXIT. It is here for security reasons
exit;

?>
; This is the settings page, do not modify the above PHP code.

; Section headers are REQUIRED

; Change any settings in this file to satisfy a particular
; project requirements.

; ============================================================
; ============================================================
[constants]

; ADOdb Library location
ADODB_PATH = {LIBRARY}/adodb5

;
; ADODB_ASSOC_CASE
;
; You can control the associative fetch case for certain drivers which behave
; differently. For the postgres, sybase, oraclepo, mssql, odbc and ibase drivers
; and all drivers derived from them, ADODB_ASSOC_CASE will by default generate.
; recordsets where the field name keys are lower-cased.
;
; For the rest, this doesn't work, but Bluewater "fixed" that!
;
; @link http://phplens.com/adodb/reference.constants.adodb_assoc_case.html
;
; 0 = lowercase field names. $rs->fields['orderid']
; 1 = uppercase field names. $rs->fields['ORDERID']
; 2 = mixedcase field names. $rs->fields['OrderID']
ADODB_ASSOC_CASE = 0

;
; This is a global variable that determines how arrays are retrieved
; within recordsets.
;
; @link http://phplens.com/lens/adodb/docs-adodb.htm;adodb_fetch_mode
;
;  0 = default
;  1 = Indexed array
;  2 = Assocative array
;  3 = Both
;
; Force Indexing By Name
ADODB_FETCH_MODE = 2

;
; ADOdb Cacheing
;
; Utilization of Cache is determined on an idividual db call level.
; Each call simply needs to defines the Cache lifespan with a value greater than ZERO.
; This activates use of Caching for that Execute.
; NOTE: Only use Caching on SELECT calls.
;
; Similar to Execute, except that the recordset is cached for $secs2cache seconds
; in the $ADODB_CACHE_DIR directory, and $inputarr only accepts 1-dimensional arrays.
; If CacheExecute() is called again with the same $sql, $inputarr, and also the same
; database, same userid, and the cached recordset has not expired, the cached recordset
; is returned.
;
; @link http://phplens.com/adodb/caching.of.recordsets.html
;
ADODB_CACHE_DIR = {CACHE_ROOT}/adodb

;
; ADOdb MemCache support
;
; Utilization of MemCache is determined on an individual db call level.
; Each call simply the Cache lifespan with a value greater than ZERO and sets
; ADOdbMemCache to TRUE. This activates use of MemCaching for that Execute.
; NOTE: Only use MemCaching on SELECT calls.
;
; You can also share cached recordsets on a memcache server. The memcache API supports
; one or more pooled hosts. Only if none of the pooled servers can be contacted will
; a connect error be generated.
;
; @link http://phplens.com/adodb/caching.of.recordsets.html
;
; MemCache is defined in a separate file

; End CONSTANT SECTION
; ============================================================

; eof
