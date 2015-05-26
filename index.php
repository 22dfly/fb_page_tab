<?php
require 'config.php';

// Get owner page information
if (isset($_POST['signed_request'])) {
    list($encoded_sig, $payload) = explode('.', $_POST['signed_request'], 2); 
    $pageTabSigned = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
}
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#" xml:lang="en" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
</head>
<body>

    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '<?php echo FACEBOOK_APP_ID ?>',
                    cookie     : true,
                    oauth      : true,
                    status     : true,
                    xfbml      : true
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <div id="container" class="container">
        <div id="content">
            
            <form method="POST" action="action.php" id="form">
                <label>Name<label>
                <input type="text" value="">   
                <input type="hidden" id="owner-user-id" name="owner_user_id" value="<?= isset($pageTabSigned) ? $pageTabSigned['id'] : '' ?>" />
                <input type="hidden" id="guest-user-id" name="guest_user_id" value="" />

                <button type="submit" id="submit-button">Submit</button>
            </form>

            <script type="text/javascript">
                $('#form').submit(function(event){
                    event.preventDefault();

                    FB.getLoginStatus(function(response) {
                        if (response.status === 'connected') {
                            var userID = response.authResponse.userID;
                            var accessToken = response.authResponse.accessToken;
                            $('#guest-user-id').val(userID);
                        } else if (response.status === 'not_authorized') {
                            FB.login(function(response){
                                if (response.status === 'connected') {
                                    console.log(response);
                                };
                            });
                        } else {
                            // the user isn't logged in to Facebook.
                        }
                    });
                });
            </script>

            <div class="seperator" style="height:50px;"></div>

            <!-- Like/Share button-->
            <div class="fb-like" data-send="true" data-width="450" data-show-faces="true"></div>

        </div>
    </div>
</body>
</html>
