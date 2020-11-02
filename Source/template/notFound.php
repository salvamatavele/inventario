<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">

    <!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="<?= asset('css/error.css') ?>" />
	<title><?=$v($title)?></title>

</head>
<body>
<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>Ooops!</h1>
			</div>
			<h2><?=$error ?> - Page not found</h2> 
			<p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
			<a href="<?= $router->route('product') ?>">Go To Homepage</a>
		</div>
	</div>
</body>
</html>