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
    $boatNameSql = "
        SELECT BoatName FROM MarinaSlip LIMIT 10; 
    ";


    # Second query
    $serviceCategorySql = "
        SELECT CategoryDescription FROM ServiceCategory;
    ";

    # The resutlt of passing that query to the db
    $boatNameResult = $pdo->query($boatNameSql);
    $serviceCategoryResult = $pdo->query($serviceCategorySql);

    # $row = $result->fetch(PDO::FETCH_BOTH);

    # The result of all the rows of that query
    $boatNameRows = $boatNameResult->fetchAll();
    $serviceCategoryRows = $serviceCategoryResult->fetchAll();

    # Output table first
    echo '
    <div width="100%">
        <form action="/~z1732715/assign11/list_boat_services.php" method="POST">
            <table width="100%" border="50px" cellpadding="25%">
                <tr>
                    <td>
                        <h3>Boat name to update</h3>
                        <select name="slipId">
    ';
 
    foreach( $boatNameRows as $row ):
        echo '<option value="' . $row[SlipID] . '" name="' . $row[BoatName] . '" >' . $row[BoatName] . '</option>';
    endforeach;

    echo '
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>Service category to update</h3>
                        <select name="categoryNum">
    ';
 
    foreach( $serviceCategoryRows as $row ):
        echo '<option value="' . $row[CategoryNum] . '" name="' . $row[CategoryDescription] . '" >' . $row[CategoryDescription] . '</option>';
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
    $slipId = trim($_POST['slipId'] ?? '');
    $categoryNum = trim($_POST['categoryNum'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $newSql = "INSERT INTO ServiceRequest ( SlipID, CategoryNum, Description ) VALUES(:slipId, :categoryNum, :description );";

    $prepared = $pdo->prepare($newSql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
 
    $specificServiceRequest= $prepared->execute(array(':slipId' => $slipId, ':categoryNum' => $categoryNum, ':description' => $description));

    echo '
    <div width="100%">
        <table width="100%" border="50px" cellpadding="25%">
        <tr>
            <td>
                <h3>SlipID ' . $slipId . ' created</h3>
                <p>Service request description: ' . $description . '</p>
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
