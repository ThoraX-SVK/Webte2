<?php

$conn = createConnectionFromConfigFileCredentials();

/**
 * Visiting this page will fill data to DB
 */

$stmn = $conn->prepare("INSERT w2final.UserRole VALUES (1,'USER')");
$stmn->execute();
$stmn->close();

$stmn = $conn->prepare("INSERT w2final.UserRole VALUES (2,'ADMIN')");
$stmn->execute();
$stmn->close();

$stmn = $conn->prepare("INSERT w2final.User 
  VALUES (1,'user','salt','passwordHash',true,'user@user.sk','name','surname',null,1)");
$stmn->execute();
$stmn->close();

$stmn = $conn->prepare("INSERT w2final.User 
  VALUES (2,'admin','salt','passwordHash',true,'admin@admin.sk','name','surname',null,2)");
$stmn->execute();
$stmn->close();

$conn->close();