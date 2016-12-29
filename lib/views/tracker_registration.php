<div class="container trackerBackground">
    <?php if (!isset($result)) { ?>
        <aside class="span5 trackerInfo">
            <form id="login" action="daily.php" method="post">
                <fieldset>
                    <legend>Login Form</legend>
                    <label for="name">username</label>
                    <input id="name" type="text" name="name" value="">
                    <label for="password">password</label>
                    <input id="password" type="password" name="password">
                    <input type="submit" name="login" value="login">
                </fieldset>
            </form>
            <p>Location is your starting position and it does not have to be the city where you currently reside, for example it could be Detroit, MI. Don't worry you will be able to change you location and destination other than the registration form.</p>
            <?php echo (isset($loginError)) ? $loginError : null;?>
        </aside>
    <?php } else { ?>
        <aside class="span5 trackerInfo">
            <?php
            echo "<h1>Error Reporting</h1>";
            echo ($result['empty'] === FALSE) ? '<p>All Non-Grey Fields must be filled in, please re-enter!</p>' : NULL;
            echo ($result['duplicate'] === FALSE) ? '<p>Username is unavailable, please re-enter!</p>' : NULL;
            echo ($result['validPassword'] === FALSE) ? '<p>Invalid Password, please re-enter!' : NULL;
            echo ($result['validEmail'] === FALSE) ? '<p>Invalid Email Address, please re-enter!' : NULL;
            ?>
        </aside>
    <?php } ?>
    <section class="span7">
        <form id="tracker" action="register.php" method="post">
            <fieldset>
                <legend>Registration Form</legend>                
                <label for="username">Username</label>
                <input id="username" type="text" name="data[name]" value="">
                <label for="password">Password</label>
                <input id="password" type="password" name="data[password]">
                <label for="email">Email</label>
                <input id="email" type="text" name="data[email]" value="">
                <label for="location1">Location</label>
                <input id="location1" type="text" name="data[location]" placeholder="City, State or Zip Code" value="">
                <label for="lat1">Latitude</label>
                <input id="lat1" type="text" name="data[startLat]" value="" readonly>
                <label for="lon1">Longitude</label>
                <input id="lon1" type="text" name="data[startLon]" value="" readonly>
                <label for="location2">Destination</label>
                <input id="location2" type="text" name="data[destination]" placeholder="City, State or Zip Code" value="">
                <input id="lat2" type="hidden" name="data[endLat]" value="" readonly>
                <input id="lon2" type="hidden" name="data[endLon]" value="" readonly>
                <label for="totalDistance">Total Miles</label>
                <input id="totalDistance" type="text" name="data[totalDistance]" value="" readonly>
                <input type="hidden" name="data[dateCreated]" value="<?php echo $dateCreated ?>">
                <input class="submitBTN" type="submit" name="submit" value="enter">
            </fieldset>
        </form>
    </section>
</div>