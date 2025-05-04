<?php
$page = $_GET["page"] ?? "home";
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="./assets/css/style.css">
    <title>NO! Awateru</title>
</head>

<body>

    <?php
	require_once "./header.php";

	echo "<main>";

	require_once (match($page){
		"home" => "./pages/home.php",
		"login" => "./pages/login.php",
		"registrar" => "./pages/registrar.php",
		"tarefas"=> "./pages/tarefas.php",
		default => "./pages/404.php",
	});

	echo "</main>";
	require_once "./footer.php";
	?>
</body>

</html>