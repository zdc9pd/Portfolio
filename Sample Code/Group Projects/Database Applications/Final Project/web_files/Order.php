<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="main.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="jquery.panelgallery-2.0.0.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="ajax.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Exo+2:400,800' rel='stylesheet' type='text/css'>

    <title>Ordering</title>
</head>
<body>
    <h1>Tony's Pizza</h1>
    <hr />
    <div class="col-md-12">
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href='index.php'>Tony's Pizza</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id=".navbar-collapse">
                    <ul class="nav navbar-nav navbar-center">
                        <li><a href="#">Order Now</a></li>

                        <li><a href="AboutUs.html">About Us</a></li>
                    </ul>
                    <!--</ul>-->
                </div> <!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
    </div><!--col-md-12-->
    </nav>
    <div>
        <form method="POST" action="Order.php">
            <input type="checkbox" name="Special1" value="Special1">Special 1<br />
            <input type="checkbox" name="Special2" value="Special2">Special 2<br />
            <input type="checkbox" name="Special3" value="Special3">Special 3<br />
            <input type="submit" name="submit" value="Execute" />
        </form>
    </div>

</body>
</html>

<?php
include "../secure/database.php";

//Connect to Database using my credentials
$conn = pg_connect(HOST." ".DBNAME." ".USERNAME." ".PASSWORD);
//$conn = pg_connect("host= dbhost-pgsql.cs.missouri.edu user=cs3380f14grp2 password= 82rLygpv dbname= cs3380f14grp2");

if (!$conn)
{
    die('Fail');
}

if(isset($_POST['submit']))
{
    $result = pg_query('SELECT name FROM TonysPizza.specialtyPizza') or die ('Could not find pizza' . pg_last_error());

    $line = pg_fetch_array($result, null, PGSQL_ASSOC);
    echo $line;
    echo '<i> $line <\i> Is what was returned';
}
?>
