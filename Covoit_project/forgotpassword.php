<?php include('include/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <form method="post" action="forgotpassword_action.php" id="forgotpasswordform">
                    <h5 class="text-danger">
                        Mot de passe oublié ? Entrez votre adresse e-mail :
                    </h5>
                    <div class="form-group">
                        <label for="forgotemail">Email:</label>
                        <input class="form-control" type="email" name="forgotemail" id="forgotemail" placeholder="Email" maxlength="50" required>
                    </div>
                    <button type="submit" class="btn btn-success">
                        Valider
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>