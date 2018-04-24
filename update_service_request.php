<!--|Name: Samuel Piecz       -->
<!--|Section: 3               -->
<!--|Instructor Name: Lehuta  -->
<!--|TA Name:  Raj            -->
<!--|Semester: Spring         -->
<!--|Due Date: 4/20/18         -->

<!-- Include header so I don't have to retype it every time -->
<?php include 'header.html'; ?>

<?php
    $pageName = "Update Service Request";
     echo "<h1>$pageName</h1></center></td></tr></table></div>";
?>

<!-- Connect to the database -->
<?php
    try {
        $dsn = "mysql:host=courses;dbname=z1732715";
        $username = "z1732715";
        $password = "1996Apr23";
        $pdo = new PDO($dsn, $username, $password);
    }
    catch(PDOexception $e) {
        echo "Connection to database failed: " . $e->getMessage();
    }
?>
<!-- End Connect to the database -->

<!-- Get all Boat names, owner first and last names, the marina name and the slipname of that boat --> <?php
    
    # My query or sql statement 
    $sql = "
       SELECT * FROM ServiceRequest LIMIT 10; 
    ";

    # The resutlt of passing that query to the db
    $result = $pdo->query($sql);

    # $row = $result->fetch(PDO::FETCH_BOTH);

    # The result of all the rows of that query
    $allrows = $result->fetchAll();

    # Output table first
    echo '
    <div width="100%">
        <form action="/~z1732715/assign11/update_service_request.php" method="POST">
            <table width="100%" border="50px" cellpadding="25%">
                <tr>
                    <td>
                        <h3>Service description to update</h3>
                        <select name="serviceId">
    ';
 
    foreach( $allrows as $row ):
        echo '<option value="' . $row[ServiceID] . '" name="' . $row[Status] . '" >' . $row[Description] . '</option>';
    endforeach;

    echo '
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>New service description</h3>
                        <textarea type="text" name="description"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="submit">
                        <input type="reset" value="reset">
                    </td>
                </tr>
            </table>
        </form>
      </div>

    ';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $serviceId = trim($_POST['serviceId'] ?? '');

    $description = trim($_POST['description'] ?? '');

    $newSql = "UPDATE ServiceRequest SET Description=:description WHERE ServiceID=:serviceId;";

    $prepared = $pdo->prepare($newSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
 
    $specificServiceRequest= $prepared->execute(array(':description' => $description, ':serviceId' => $serviceId));

    echo '
    <div width="100%">
        <table width="100%" border="50px" cellpadding="25%">
        <tr>
            <td>
                <h3>ServiceID ' . $serviceId . ' Updated</h3>
                <p>New Description: ' . $description . '</p>
            </td>
        </tr>
    ';

    echo '
        </table>
    </div>
    ';  

} 



?>


<!-- Inlude the footer so I don't have to retype it every time -->
<?php include 'footer.html'; ?>
