<!--|Name: Samuel Piecz       -->
<!--|Section: 3               -->
<!--|Instructor Name: Lehuta  -->
<!--|TA Name:  Raj            -->
<!--|Semester: Spring         -->
<!--|Due Date: 4/20/18         -->

<!-- Include header so I don't have to retype it every time -->
<?php include 'header.html'; ?>

<?php
    $pageName = "List Boat Services";
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
       SELECT * FROM Owner LIMIT 10; 
    ";

    # The resutlt of passing that query to the db
    $result = $pdo->query($sql);

    # $row = $result->fetch(PDO::FETCH_BOTH);

    # The result of all the rows of that query
    $allrows = $result->fetchAll();

    # Output table first
    echo '
    <div width="100%">
        <form action="/~z1732715/assign11/list_boat_services.php" method="POST">
            <table width="100%" border="50px" cellpadding="25%">
                <tr>
                    <td>
                        <h3>Enter owner last name</h3>
                        <input type="text" placeholder="Enter owner last name" name="lastName"> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Enter owner first name</h3>
                        <input type="text" placeholder="Enter owner first name" name="firstName"> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Enter owner address</h3>
                        <input type="text" placeholder="Enter owner address" name="address"> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Enter owner city</h3>
                        <input type="text" placeholder="Enter owner city" name="city"> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Enter owner state</h3>
                        <input type="text" placeholder="Enter owner state" name="state"> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Enter owner zip</h3>
                        <input type="text" placeholder="Enter owner zip" name="zip"> 
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
    $lastName = trim($_POST['serviceId'] ?? '');
    $firstName = trim($_POST['firstName'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip = trim($_POST['zip'] ?? '');

    $newSql = "INSERT INTO Owner (LastName, FirstName, Address, City, State, Zip) VALUES(:lastName, :firstName, :address, :city, :state, :zip)";
    $prepared = $pdo->prepare($newSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $specificServiceRequest= $prepared->execute(array(':lastName' => $lastName, ':firstName' => $firstName, ':address' => $address, ':city' => $city, ':state' => $state, ':zip' => $zip));

    echo '
    <div width="100%">
        <table width="100%" border="50px" cellpadding="25%">
            <tr>
                <td>
                    <h3>Owner ' . $firstName . ' ' . $lastName . ' added</h3>
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
