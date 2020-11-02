<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('asset/css/materialize.css') ?>">
    <link rel="stylesheet" href="<?= asset('asset/css/style.css') ?>">
    <style>

        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }
    </style>
     <?= $v->section("css"); ?>
    <title><?= $v($title) ?></title>

</head>

<body id="all">
    
    <?= $v->section("content"); ?>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="<?= asset('js/jquery-3.5.1.min.js') ?>"></script>
    <script src="<?= asset('asset/js/materialize.js') ?>"></script>
    <script>
        $(document).ready(function() {
            $('.sidenav').sidenav();
            $('.materialboxed').materialbox();
            $('.dropdown-trigger').dropdown();
        });
    </script>
    <?= $v->section('js'); ?>
</body>

</html>