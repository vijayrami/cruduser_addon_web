<?php
include_once("../database/db_conection.php");

if(!empty($_POST["state_id"])) {
    $query ="SELECT * FROM city WHERE state_id = '" . $_POST["state_id"] . "'";
    $results = mysqli_query($db_conn,$query);
?>
    <option value="">Select City</option>
<?php
    foreach($results as $city) {
?>
    <option value="<?php echo $city["city_id"]; ?>"><?php echo $city["city_name"]; ?></option>
<?php
    }
}
?>