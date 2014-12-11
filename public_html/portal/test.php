<?php
require ("../core/lib/sqlMaker.lib.php");
require ("../core/lib/sql.lib.php");
require ("../core/lib/dbTableOptions.lib.php");
require ("../core/lib/FormsValidate.lib.php");
require ("../core/lib/validateMaker.lib.php");
require ("../core/lib/forms.lib.php");
require ("../core/lib/validator.lib.php");
require ("../core/lib/formMaker.lib.php");

require ("../core/sql/users.sql.php");
require ("../core/cls/FormsValidate/id.cls.php");
require ("../core/cls/forms/Extends.cls.php");
require ("../core/cls/validateExtends.cls.php");

$y = new sqlMaker_lib;
$x = $y->tableUsers();
$x->whereId(10);
$x->andconditionId("   >   ", 10);
$x->select();