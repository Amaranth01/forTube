<h1>Connectez-vous</h1>

    <div>
        <form action="/index.php?c=user&a=connexion" method="post">
            <div>
                <label for="username">Votre pseudo</label>
                <input type="text" name="username" id="username">

                <label for="password">Votre mot de passe</label>
                <input type="password" name="password" id="password">

                <input type="submit" name="submit" value="connexion">
            </div>
        </form>
    </div>

    <div>
        <p class="account">Pas de compte ? Créez-en un gratuitement !
            <a href="/index.php?c=home&a=login">  Créer un compte</a>
        </p>

        <p id="forgot">
            <a href="" > Mot de passe oublié ?</a>
        </p>

    </div>