<?php

if (preg_match('/\w/', htmlspecialchars($_POST["query"]))) {
?>
 Welcome,
     <?php
?>!<br>
 Your query is:<br><h3><?php
    echo htmlspecialchars($_POST["query"]);
?></h3> <?php
    $user_search = htmlspecialchars($_POST['query']);
   
    require_once("database_config.php");
    require_once("database.php");
    require_once("json_data.php");
    require_once("access_database.php");
    require_once("googlepuller_main.php");
    $showjsondata   = new ShowJsonData();
    $mysqldatabase  = new MySQLDatabase();
    $accessdatabase = new AccessDatabase();
    $fetched_data   = array();
   
    $fetched_data   = $accessdatabase->check_database($user_search);
    
    if ($fetched_data[1] == 1) {
        echo "<br>and it is available in database <br>";
        $json = $showjsondata->convert_sql_rows_to_json($fetched_data[0]);
        $showjsondata->display_results($json);
        $mysqldatabase->close_connection();
        
    } else {
        $GooglePuller = new GooglePuller($user_search);
        $GooglePuller->start();
    }
?>.<br>

<?php
} else {
?>

    <form action=

    <?php
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
?>

     method="post">
        query: <input type="text" name="query"><br>
      
        <input type="submit" value="search">
    </form>
<?php
}
?>