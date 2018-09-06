<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8"> 
	<meta name="description" content="TESTE LINHAS DUPLICADAS EM ARQUIVOS CSV">
	<meta name="keywords" content="PHP, CSV, Linhas duplicadas">
	<meta name="author" content="Hoheckell">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TESTE LINHAS DUPLICADAS EM ARQUIVOS CSV</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<div class="container">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12">
<h1>TESTE LINHAS DUPLICADAS EM ARQUIVOS CSV</h1>
</div>
</div>
<?php
if(!empty($_FILES['csv'])){
    $arquivo = $_FILES['csv'];
    //die(var_dump($arquivo['tmp_name']));
    $pasta = "./";
    $linha = '';
    $destination_path = getcwd().DIRECTORY_SEPARATOR;
    $target_path = $destination_path . basename( $_FILES["csv"]["name"]);
    $readed = array();
    $duplicados = array();
    $linha = 0;
    if (@move_uploaded_file($_FILES['csv']['tmp_name'], $target_path)) {
        if (($carga = fopen( $target_path, "r")) !== FALSE) {
            $n=0;
            while (($data = fgetcsv($carga, 1024, ";")) !== FALSE) {
                $linha++;
                if(!in_array($data,$readed)){
                    array_push($readed,$data);
                }else{
                    $duplicados[$linha] = $data;
                }
            }
        }

        $dupli = count($duplicados);
        if($dupli > 0) {
            echo '<div class="row"><div class="col-lg-12 col-md-12 col-sm-12">Numero de linhas duplciadas ' . $dupli . '<br><br> <strong>Duplicados:</strong><br><ul>';
            foreach ($duplicados as $k => $v) {
                echo "<li>A Linha " . $k . " é copia da linha " . ((int)array_search($v, $readed) + 1) . " -> " . implode(";", $v) . "</li>";
            }
			echo "</ul></div></div>"
        }else{
            echo "Sem Linha duplicadas";
        }

    }

    if(is_file(basename( $_FILES["csv"]["name"]))){
        chmod(basename( $_FILES["csv"]["name"]) ,777);
        $name = basename( $_FILES["csv"]["name"]);
        unlink($name);
		/* PARA WINDOWS
        exec("DEL /F/Q \"$name\"" , $lines, $deleteError);
        if ($deleteError) {
            echo 'file delete error';
        }
		*/
    }

}else{
    ?>

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12">
    <form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
        <label for="csv">CSV:</label>
        <input type="file" name="csv" id="csv" class="form-control">
		</div>
        <button type="submit" class="btn btn-priamry">Enviar CSV</button>
    </form>
</div>
</div>

<?php
}
?>

</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
