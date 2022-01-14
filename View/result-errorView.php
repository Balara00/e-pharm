<?php 
    $search=$_SESSION['searchq'];
?>

<div class="search-results"  >Search results for: <?php echo $search ?></div>
<div class="no-results">
    <p id="results">Your search returned no results.</p>
    <p id="tips">Search Tips</p>
    <li>Double check your spelling</li>
    <li>Try using separate words</li>
    <li>Try searching for an item that is less specific</li>
    
    </div>