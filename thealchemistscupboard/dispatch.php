<?php
require_once 'tfpdf/tfpdf.php';
require_once 'classes/FwsApi.php';
require_once 'classes/DispatchNote.php';
$toDispatch = json_decode($_POST['toDispatch']);
$api = new FwsApi();
$pdf = new tFPDF();
$dispatchNote = new DispatchNote($api, $toDispatch, $pdf);
$dispatchNote->create();
?>
