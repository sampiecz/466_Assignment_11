<!--|Name: Samuel Piecz       -->
<!--|Section: 3               -->
<!--|Instructor Name: Lehuta  -->
<!--|TA Name:  Raj            -->
<!--|Semester: Spring         -->
<!--|Due Date: 4/20/18         -->

<!-- Include header so I don't have to retype it every time -->
<?php include 'header.html'; ?>

<?php
    $pageName = "Add Owner";
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

<!-- Get all Boat names, owner first and last names, the marina name and the slipname of that boat -->
<?php
    # My query or sql statement 
    $sql = "
        SELECT ms.BoatName, o.LastName, o.FirstName, m.Name, ms.SlipNum 
        FROM Owner o JOIN MarinaSlip ms JOIN Marina m ON o.OwnerNum = ms.OwnerNum AND ms.MarinaNum = m.MarinaNum
        ORDER BY ms.BoatName, m.Name LIMIT 10;
    ";


    # The resutlt of passing that query to the db
    $result = $pdo->query($sql);

    # $row = $result->fetch(PDO::FETCH_BOTH);

    # The result of all the rows of that query
    $allrows = $result->fetchAll();
    
    # Output table first
    echo '<div width="100%">
            <table width="100%" border="50px" cellpadding="25%">
                <tr>
                    <th>Boat Name</th>
                    <th>Owner Last Name</th>
                    <th>Owner First Name</th>
                    <th>Marina Name</th>
                    <th>Marina Slip #</th>
                <tr>
    ';


    # Generate table row for every row in the result of my query
    foreach( $allrows as $row ):
        echo "<tr>";
        # Generate table data for each attribute's value in every row
            echo "<td><center>" . $row["BoatName"] . "</center></td>";
            echo "<td><center>" . $row["LastName"] . "</center></td>";
            echo "<td><center>" . $row["FirstName"] . "</center></td>";
            echo "<td><center>" . $row["Name"] . "</center></td>";
            echo "<td><center>" . $row["SlipNum"] . "</center></td>";
        echo "</tr>";
    endforeach;

    # Close my html table as the query is done
    echo "</table></div>";

?>
<!-- End DB query and html table -->


<!-- Inlude the footer so I don't have to retype it every time -->
<?php include 'footer.html'; ?>
