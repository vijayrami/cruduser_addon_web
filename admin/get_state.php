<?php
include_once("../database/db_conection.php");

if(!empty($_POST["country_id"])) {
    $query ="SELECT * FROM state WHERE country_id = '" . $_POST["country_id"] . "'";
    $results = mysqli_query($db_conn,$query);
?>
    <option value="">Select State</option>
<?php
    foreach($results as $state) {
?>
    <option value="<?php echo $state["state_id"]; ?>"><?php echo $state["name"]; ?></option>
<?php
    }
}
?>