<?php
include_once 'include.php';

$pdo = Bd::getInstance()->getConnexion();

$files = scandir('./data/backup/');
print '<form action="recover.php" method="post">';
print 'Choisir un fichier de backup : <select name="selectionBackup">';
    foreach($files as $file) {
        if($file == '.' || $file == '..' || !str_starts_with($file, "backup") ) continue;
        print '<option name='.$file.'>' . $file . '</option>';
    }
print '</select>';
    ?>
<br>
<input class="btn btn-primary" type="submit" value="Démarrer la backup">
</form>
<?php
    if(isset($_POST['selectionBackup'])){
        $path = "./data/backup/";
        $filename = $_POST['selectionBackup'];
        $file = fopen($path.$filename, 'r');
        while(!feof($file)) {
            $query = trim(fgets($file, 255));
            while(!str_ends_with($query, ";")){
                $query .= trim(fgets($file, 255));
            }
            $query = $pdo->prepare($query);
            $query->execute();
        }
        echo "La base de données à été restaurée";
    }