<?
$table_body = "";
$count = 0;

$myFile = new SplFileObject("/root/script/speedtest.log");

$dateTime = "";

while (!$myFile->eof()) {

    // Variáveis
    $retrieving = "";
    $testing = "";
    $host = "";
    $download_speed = "";
    $upload_speed = "";

    // Linha Atual
    $linha = $myFile->fgets() . PHP_EOL;

    // Ex: Fri Sep 2 10:28:52 -03 2022
    if (strpos($linha, " -") !== false){
        $dateTime = $linha;
        
        // Tentando pegar apenas o 00:00:00 da linha
        // $tmp = explode(" ", $linha);
        // foreach ($tmp AS $t){
        //     if (preg_match('/^\d{2}:\d{2}$/', $t)) {
        //         if (preg_match("/(2[0-3]|[0][0-9]|1[0-9]):([0-5][0-9])/", $t)) {
        //             $dateTime = $t;
        //             echo $t."<br>";
        //         }
        //     }
        // }
        
        // var_dump($tmp);
        // echo "<br>";
    }

    // Alimentando as células
    if (strpos($linha, "Retrieving") !== false AND strpos($linha, "configuration") !== false) {
        $retrieving = str_replace("Retrieving ","",$linha);
        $retrieving = str_replace("configuration...","",$retrieving);

        // $table_body .= ($table_body == "") ? "</tr>".$table_body : ""; // Inicia nova linha
        // ***** linha </tr> não está sendo fechada, navegador fecha automaticamente
        $count++;

        $table_body .= "<tr>
        <td style='border: 1px dotted black'>".$dateTime."</td>
        <td style='border: 1px dotted black'>".$retrieving."</td>";

    }
    
    if (strpos($linha, "Testing from") !== false) {
        $testing = str_replace("Testing from","",$linha);
        $testing = str_replace("...","",$testing);

        $table_body .= "<td style='border: 1px dotted black'>".$testing."</td>";
    } 
    
    if (strpos($linha, "Hosted by") !== false) {
        $host = str_replace("Hosted by ","",$linha);
        $table_body .= "<td style='border: 1px dotted black'>".$host."</td>";
    } 
    
    if (strpos($linha, "Download: ") !== false) {
        $download_speed = str_replace("Download: ","",$linha);
        $table_body .= "<td style='border: 1px dotted black'>".$download_speed."</td>";
    } 
    
    if (strpos($linha, "Upload: ") !== false) {
        $upload_speed = str_replace("Upload: ","",$linha);
        $table_body .= "<td style='border: 1px dotted black'>".$upload_speed."</td>";
    }

}

$table_header = "<table style='border: 1px solid black; text-align: center;'>
    <thead>
        <tr>
            <th style='border: 1px dotted black'>dateTime</th>
            <th style='border: 1px dotted black'>Retrieving FROM</th>
            <th style='border: 1px dotted black'>Testing FROM</th>
            <th style='border: 1px dotted black'>HOST</th>
            <th style='border: 1px dotted black'>DOWNLOAD SPEED</th>
            <th style='border: 1px dotted black'>UPLOAD SPEED</th>
        </tr>
    </thead>
    <tbody>";

$table_footer = "
    </tbody>
    <tfooter>
        <tr>
            <td colspan='6'>
                Total: ".$count." registros
            </td>
        </tr>
    </tfooter>
</table>";

echo "<br>";
echo "<br>";
echo $table_header.$table_body.$table_footer;

?>

