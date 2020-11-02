<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('asset/css/materialize.css') ?>">
    <title><?=$v($title)?></title>
    <?= $v->section('css') ?>
    
</head>
<body ng-app="mainModule" ng-controller="mainController">
<?=$v->insert('header')?>
<?= $v->section("content");?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="<?= asset('js/jquery-3.5.1.min.js') ?>"></script>
<script src="<?= asset('asset/js/materialize.js') ?>"></script>
<?= $v->section('js') ?>
</body>
</html>