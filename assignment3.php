<?php
	
	$pdo = null;
	$imageDetails = null;
	$continents = null;
	$countries = null;
	
	function runQuery($queryString) {
		global $pdo;
		$stm = $pdo->query($queryString);
		return $stm;
	}
	
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=travel', 'testuser', 'mypassword');
	} catch(PDOException $e) {
		die($e->getMessage());
	}
	
	$imageDetails = runQuery('SELECT * from imagedetails');
	$continents = runQuery('SELECT * from continents');
	$countries = runQuery('SELECT * from countries INNER JOIN imagedetails ON countries.ISO = imagedetails.CountryCodeISO GROUP BY countries.ISO');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Assignment 3</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    
    

    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    

</head>

<body>
    <?php include 'includes/header.inc.php'; ?>
    


    <!-- Page Content -->
    <main class="container">
        <div class="panel panel-default">
          <div class="panel-heading">Filters</div>
          <div class="panel-body">
            <form action="assignment3.php" method="get" class="form-horizontal">
              <div class="form-inline">
              <select name="continent" class="form-control">
                <option value="0">Select Continent</option>
                <?php
				foreach($continents as $continent) {
					echo '<option value="' . $continent['ContinentCode'] . '">' . $continent['ContinentName'] . '</Option>';
				}
				?>
              </select>     
              
              <select name="country" class="form-control">
                <option value="0">Select Country</option>
                <?php 
				foreach($countries as $country) {
					echo '<option value="' . $country['ISO'] . '">' . $country['CountryName'] . '</Option>';
				}
				?>
              </select>    
              <input type="text"  placeholder="Search title" class="form-control" name=title>
              <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </form>

          </div>
        </div>     
                                    

		<ul class="caption-style-2">
            <?php /* display list of images ... sample below ... replace ???? with field data*/
				foreach($imageDetails as $imageDetail) {
					echo '<li>';
					echo '<a href="detail.php?id=' . $imageDetail['ImageID'] . '" class="img-responsive">';
					echo '<img src="images/square-medium/' . $imageDetail['Path'] . '" alt="' . $imageDetail['Title'] . '">';
					echo '<div class="caption">';
					echo '<div class="blur"></div>';
					echo '<div class="caption-text">';
					echo '<p>' . $imageDetail['Title'] . '</p>';
					echo '</div>';
					echo '</div>';
					echo '</a>';
					echo '</li>';
				}
			   /*<li>
                  <a href="detail.php?id=????" class="img-responsive">
                          <img src="images/square-medium/????" alt="Test">
                          <div class="caption">
                              <div class="blur"></div>
                              <div class="caption-text">
                                  <p>????</p>
                              </div>
                          </div>
                  </a>
			  </li>    */    
           ?>
       </ul>       

      
    </main>
    
    <footer>
        <div class="container-fluid">
                    <div class="row final">
                <p>Copyright &copy; 2017 Creative Commons ShareAlike</p>
                <p><a href="#">Home</a> / <a href="#">About</a> / <a href="#">Contact</a> / <a href="#">Browse</a></p>
            </div>            
        </div>
        

    </footer>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>