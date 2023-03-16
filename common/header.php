
    <img src="/phpmotors/images/site/logo.png" alt="phpmotors.com logo"> 
    
    <div id="header-div">
        <div id="login-div">   
           <?php 
                if (isset($_SESSION['loggedin']) == TRUE) {
                    echo "<a href='/phpmotors/accounts/index.php' title='Return to account information'>Welcome " . $_SESSION['clientData']['clientFirstname'] . " </a>  |  <a href='/phpmotors/accounts/index.php?action=logout' title='Log out of PHP Motors account'>Log out</a>";
                } else {
                    echo "<a href='/phpmotors/accounts/index.php?action=login' title='Log into PHP Motors account'>My Account</a>";
                }  
            ?>
        </div>
        <div id="search-div">
            <form method="post" action="/phpmotors/search/index.php">
                <button id='search-button' value='btn' class='btn btn-default '><i class="fa fa-search icon"></i>
                <input type="hidden" name="action" value="search"/></button>
            </form>
        </div>
    </div>
