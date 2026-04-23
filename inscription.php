<?php
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin.php');
    } else {
        header('Location: user.php');
    }
    exit;
}

$erreur = isset($_GET['erreur']) ? $_GET['erreur'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription — NIKORA Tools</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Poppins', sans-serif;
            min-height:100vh;
            display:flex;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        }

        .cote-gauche{
            flex:1;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items:center;
            padding:60px;
            color:white;
        }

        .grand-logo{
            width:180px;
            height:180px;
            background: rgba(0, 0, 80, 0.95);
            border-radius:24px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-bottom:30px;
            box-shadow: 0 0 35px rgba(233, 69, 96, 0.15);
        }

        .grand-logo img{
            width:140px;
            height:140px;
            object-fit:contain;
            border-radius:18px;
        }

        .cote-gauche h1{
            font-size:42px;
            font-weight:700;
            margin-bottom:18px;
            text-align:center;
            color:white;
        }

        .cote-gauche p{
            font-size:16px;
            font-weight:300;
            color: rgba(255,255,255,0.75);
            text-align:center;
            line-height:1.8;
            max-width:380px;
        }

        .points{
            display:flex;
            gap:10px;
            margin-top:35px;
        }

        .points span{
            width:10px;
            height:10px;
            border-radius:50%;
            background: rgba(255,255,255,0.25);
        }

        .points span.active{
            width:28px;
            border-radius:8px;
            background:#e94560;
        }

        .cote-droit{
            width:560px;
            background:white;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:50px 45px;
            border-radius:30px 0 0 30px;
        }

        .formulaire-contenu{
            width:100%;
        }

        .mini-logo{
            display:flex;
            align-items:center;
            gap:10px;
            margin-bottom:30px;
        }

        .logo-img{
            width:40px;
            height:40px;
            object-fit:cover;
            border-radius:8px;
        }

        .mini-logo span{
            font-size:16px;
            font-weight:700;
            color:#1a1a2e;
        }

        .formulaire-contenu h2{
            font-size:26px;
            font-weight:700;
            color:#1a1a2e;
            margin-bottom:6px;
        }

        .sous-titre{
            font-size:13px;
            color:#999;
            margin-bottom:25px;
        }

        .erreur{
            background-color:#fff0f0;
            border-left:4px solid #e94560;
            color:#e94560;
            padding:12px 15px;
            border-radius:8px;
            font-size:13px;
            margin-bottom:20px;
        }

        .ligne{
            display:flex;
            gap:15px;
        }

        .groupe{
            margin-bottom:18px;
            width:100%;
        }

        .groupe label{
            display:block;
            font-size:13px;
            font-weight:500;
            color:#555;
            margin-bottom:8px;
        }

        .groupe input{
            width:100%;
            padding:13px 16px;
            border:2px solid #eee;
            border-radius:10px;
            font-family:'Poppins', sans-serif;
            font-size:14px;
            color:#333;
            outline:none;
            transition:border-color 0.2s;
        }

        .groupe input:focus{
            border-color:#0f3460;
        }

        .btn-inscription{
            width:100%;
            padding:14px;
            margin-top:10px;
            background: linear-gradient(135deg, #e94560, #c23152);
            color:white;
            font-family:'Poppins', sans-serif;
            font-size:15px;
            font-weight:600;
            border:none;
            border-radius:10px;
            cursor:pointer;
        }

        .btn-inscription:hover{
            opacity:0.92;
        }

        .lien-login{
            text-align:center;
            margin-top:22px;
            font-size:13px;
            color:#999;
        }

        .lien-login a{
            color:#0f3460;
            font-weight:500;
            text-decoration:none;
        }

        .lien-login a:hover{
            text-decoration:underline;
        }

        .message-erreur{
            display:block;
            margin-top:6px;
            font-size:12px;
            color:#e94560;
            min-height:16px;
        }

        .input-invalide{
            border-color:#e94560 !important;
        }

        .input-valide{
            border-color:#28a745 !important;
        }

        .password-info{
            display:block;
            margin-top:6px;
            font-size:12px;
            color:#999;
            line-height:1.5;
        }

        @media (max-width: 768px){
            .cote-gauche{ display:none; }
            .cote-droit{ width:100%; border-radius:0; padding:35px 25px; }
            .ligne{ flex-direction:column; gap:0; }
        }
    </style>
</head>
<body>

    <div class="cote-gauche">
        <div class="grand-logo">
            <img src="images/logo.jpeg" alt="Logo">
        </div>
        <h1>NIKORA Tools</h1>
        <p>Créez votre compte pour enregistrer votre historique et personnaliser votre profil.</p>

        <div class="points">
            <span class="active"></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="cote-droit">
        <div class="formulaire-contenu">

            <div class="mini-logo">
                <img src="images/logo.jpeg" alt="Logo" class="logo-img">
                <span>NIKORA Tools</span>
            </div>

            <h2>Créer un compte</h2>
            <p class="sous-titre">Remplissez vos informations</p>

            <?php if ($erreur != '') { ?>
                <div class="erreur">⚠️ <?= htmlspecialchars($erreur) ?></div>
            <?php } ?>

            <form id="inscriptionForm" action="traitement_inscription.php" method="POST" enctype="multipart/form-data">

                <div class="ligne">
                    <div class="groupe">
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
                        <small id="prenomError" class="message-erreur"></small>
                    </div>

                    <div class="groupe">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                        <small id="nomError" class="message-erreur"></small>
                    </div>
                </div>

                <div class="groupe">
                    <label for="email">Adresse e-mail</label>
                    <input type="email" id="email" name="email" placeholder="exemple@mail.com" required>
                    <small id="emailError" class="message-erreur"></small>
                </div>

                <div class="groupe">
                    <label for="photo_profil">Photo de profil (optionnel)</label>
                    <input type="file" id="photo_profil" name="photo_profil" accept="image/*">
                </div>

                <div class="ligne">
                    <div class="groupe">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <small id="passwordError" class="message-erreur"></small>
                        <small class="password-info">
                            Le mot de passe doit contenir au moins 8 caractères, une majuscule,
                            une minuscule et un chiffre.
                        </small>
                    </div>

                    <div class="groupe">
                        <label for="confirm_password">Confirmer le mot de passe</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" required>
                        <small id="confirmPasswordError" class="message-erreur"></small>
                    </div>
                </div>

                <button type="submit" class="btn-inscription">S'inscrire</button>
            </form>

            <div class="lien-login">
                Vous avez déjà un compte ? <a href="login.php">Se connecter</a>
            </div>

        </div>
    </div>

    <script>
        const form = document.getElementById("inscriptionForm");

        const prenom = document.getElementById("prenom");
        const nom = document.getElementById("nom");
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirm_password");

        const prenomError = document.getElementById("prenomError");
        const nomError = document.getElementById("nomError");
        const emailError = document.getElementById("emailError");
        const passwordError = document.getElementById("passwordError");
        const confirmPasswordError = document.getElementById("confirmPasswordError");

        function setError(input, messageElement, message) {
            input.classList.add("input-invalide");
            input.classList.remove("input-valide");
            messageElement.textContent = message;
        }

        function setSuccess(input, messageElement) {
            input.classList.remove("input-invalide");
            input.classList.add("input-valide");
            messageElement.textContent = "";
        }

        function validatePrenom() {
            const value = prenom.value.trim();

            if (value === "") {
                setError(prenom, prenomError, "Le prénom est obligatoire.");
                return false;
            }

            if (value.length < 2) {
                setError(prenom, prenomError, "Le prénom doit contenir au moins 2 caractères.");
                return false;
            }

            setSuccess(prenom, prenomError);
            return true;
        }

        function validateNom() {
            const value = nom.value.trim();

            if (value === "") {
                setError(nom, nomError, "Le nom est obligatoire.");
                return false;
            }

            if (value.length < 2) {
                setError(nom, nomError, "Le nom doit contenir au moins 2 caractères.");
                return false;
            }

            setSuccess(nom, nomError);
            return true;
        }

        function validateEmail() {
            const emailValue = email.value.trim();
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (emailValue === "") {
                setError(email, emailError, "L'adresse e-mail est obligatoire.");
                return false;
            }

            if (!emailPattern.test(emailValue)) {
                setError(email, emailError, "Format d'e-mail invalide. Exemple : nom@gmail.com");
                return false;
            }

            setSuccess(email, emailError);
            return true;
        }

        function validatePassword() {
            const passwordValue = password.value;
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

            if (passwordValue === "") {
                setError(password, passwordError, "Le mot de passe est obligatoire.");
                return false;
            }

            if (!passwordPattern.test(passwordValue)) {
                setError(
                    password,
                    passwordError,
                    "8 caractères minimum, avec majuscule, minuscule et chiffre."
                );
                return false;
            }

            setSuccess(password, passwordError);
            return true;
        }

        function validateConfirmPassword() {
            const passwordValue = password.value;
            const confirmPasswordValue = confirmPassword.value;

            if (confirmPasswordValue === "") {
                setError(confirmPassword, confirmPasswordError, "Veuillez confirmer le mot de passe.");
                return false;
            }

            if (passwordValue !== confirmPasswordValue) {
                setError(confirmPassword, confirmPasswordError, "Les mots de passe ne correspondent pas.");
                return false;
            }

            setSuccess(confirmPassword, confirmPasswordError);
            return true;
        }

        prenom.addEventListener("input", validatePrenom);
        nom.addEventListener("input", validateNom);
        email.addEventListener("input", validateEmail);

        password.addEventListener("input", function () {
            validatePassword();
            if (confirmPassword.value !== "") {
                validateConfirmPassword();
            }
        });

        confirmPassword.addEventListener("input", validateConfirmPassword);

        form.addEventListener("submit", function(e) {
            const isPrenomValid = validatePrenom();
            const isNomValid = validateNom();
            const isEmailValid = validateEmail();
            const isPasswordValid = validatePassword();
            const isConfirmPasswordValid = validateConfirmPassword();

            if (!isPrenomValid || !isNomValid || !isEmailValid || !isPasswordValid || !isConfirmPasswordValid) {
                e.preventDefault();
            }
        });
    </script>

</body>
</html>