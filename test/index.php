<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>       
    </head>
    <body>
        <div id="fb-root"></div>
        <script type="text/javascript">
            window.fbAsyncInit = function() {
                FB.init({appId: '183138518439417', status: true, cookie: true, xfbml: true});
 
                /* All the events registered */
                FB.Event.subscribe('auth.login', function(response) {
                    // do something with response
                    login();
                });
                FB.Event.subscribe('auth.logout', function(response) {
                    // do something with response
                    logout();
                });
 
                FB.getLoginStatus(function(response) {
                    if (response.session) {
                        // logged in and connected user, someone you know
                        login();
                    }
                });
            };
            (function() {
                var e = document.createElement('script');
                e.type = 'text/javascript';
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
            }());
 
            function login(){
                FB.api('/me', function(response) {
                    document.getElementById('login').style.display = "block";
                    document.getElementById('login').innerHTML = response.name + " succsessfully logged in!";
                });
				fqlQuery();
            }
            function logout(){
                document.getElementById('login').style.display = "none";
            }
            function fqlQuery(){
                FB.api('/me', function(response) {
                     var query = FB.Data.query('select name, hometown_location, sex, pic_square from user where uid={0}', response.id);
                     query.wait(function(rows) {
 
                       document.getElementById('name').innerHTML =
                         'Your name: ' + rows[0].name + "<br />" +
                         'Your Firstname: ' + response.first_name + "<br />" +
                         'Your LastName: ' + response.last_name + "<br />" +						 						 
                         'Your email: ' + response.email + "<br />" +						 
                         'Your Bday: ' + response.birthday + "<br />" +						 						 
                         'Profile id: ' + response.id + "<br />" +						 						 						 
                         '<img src="' + rows[0].pic_square + '" alt="" />' + "<br />";
                     });
                });
            }            
        </script>
        
        <p><fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream"></fb:login-button></p>
 
        <p>
           
            <a href="#" onclick="fqlQuery(); return false;">FQL Query Example</a>
        </p>                 
 
        <br /><br /><br />
        <div id="login" style ="display:none"></div>
        <div id="name"></div>
 
    </body>
</html>