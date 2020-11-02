<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('asset/css/materialize.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
    <?= $v->section('css'); ?>
    <style>
        header,
        main,
        footer {
            padding-left: 300px;
        }

        @media only screen and (max-width : 992px) {

            header,
            main,
            footer {
                padding-left: 0;
            }
        }

        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }
    </style>
    <title><?= $v($title) ?></title>

</head>

<body>



    <?= $v->section("content"); ?>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="<?= asset('js/jquery-3.5.1.min.js') ?>"></script>
    <script src="<?= asset('asset/js/materialize.js') ?>"></script>
    <script>
        $(document).ready(function() {
            $('.sidenav').sidenav();
        });
    </script>
    <?= $v->section('js'); ?>
</body>

</html>