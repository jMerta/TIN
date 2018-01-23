<?php

include 'connect.php';
include "header.php";

$baza =  mysqli_connect(SERVER,USERNAME,PASSWORD,DATABASE);
echo '<h2>Zarejestruj się</h2>';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    // Formularz jeszcze nie został uzupelniony
    echo '<form id="register" class="form-horizontal" role="form" method="post" action="">
        <div class="form-group">
        <label class="control-label col-sm-2" for="user_name">Nazwa użytkownika:</label>
        <div class="col-sm-10"><input id="user_name" type="text" name="user_name" placeholder="Wpisz nazwę użytkownika"/>
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="user_pass" >Hasło:</label>
        <div class="col-sm-10">
        <input id="user_pass" type="password" name="user_pass" placeholder="Wpisz hasło">
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="user_pass_check" >Podaj ponownie hasło:</label>
        <div class="col-sm-10"><input id="user_pass_check" type="password" name="user_pass_check" placeholder="Wpisz ponownie hasło">
        </div>
        </div>
        <div class="form-group">
        <label class="control-label col-sm-2" for="user_mail" >E-mail::</label>
        <div class="col-sm-10"> <input id="user_email" type="email" name="user_email" placeholder="Wpisz swój adres e-mail">
        </div>
        </div>
        <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Dołącz!</button>
</div>
</div>
     </form>
     
     
     
     <script>$("#register").validate({
        rules: {
            user_name: {
                minlength: 2,
                required: true,
                maxlength: 30
            },
            user_email: {
                required: true,
                email: true
            },
            user_pass: {
                minlength: 2,
                required: true
            },
            user_pass_check: {
                minlength: 2,
                required: true,
                equalTo: "#user_pass"
            }
        },
        highlight: function(element) {
            $(element).closest(\'.form-group\').removeClass(\'success\').addClass(\'error\');
        },
        success: function(element) {
            element.text("ok").addClass(\'valid\').closest(\'.form-group\').removeClass(\'error\').addClass(\'success\');
        },
        submitHandler: function(form) {
            // do other stuff for a valid form
            $.post("process.php", $("#register").serialize(), function(data) {
                $("#register").hide();
                $("#results").html(data);
            });
    }
}) </script>';
}

echo '<div id="results"></div>';

include 'footer.php';
?>