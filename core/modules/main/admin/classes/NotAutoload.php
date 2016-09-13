<?
function loadClasses($class_name) {
    require_once $_SERVER["DOCUMENT_ROOT"].ROOT."/modules/main/admin/classes/" . $class_name . '.php';
}

loadClasses("CAdminTableList");
loadClasses("CAdminTableListSQL");
loadClasses("CAdminElement");
