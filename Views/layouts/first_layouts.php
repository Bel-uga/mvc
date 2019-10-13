<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Главная страница</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="./js/jquery-3.2.1.js"></script>

        <script type="text/javascript" src="./js/bootstrap.js"></script>
        <script type="text/javascript" src="./js/main.js"></script>
        <link rel="stylesheet" href="./css/bootstrap.css"  type="text/css" media="all">
        <link rel="stylesheet" href="./css/styles.css"  type="text/css" media="all">
    </head>
    <body>
        <ul id="nav" class="nav justify-content-end">

            <li id="loginDropDown" class="nav-item dropdown" >
                <div class="dropdown mr-3">
                <a class="nav-link text-secondary"  id="signIn" >Войти</a>
                <div  class="dropdown-content" id="signInDropdown" >
                    <form id="signInForm">
                        <input type="text" class="form-control mb-2" name="login" placeholder="Логин">
                        <input type="password" class="form-control mb-2" name="password" placeholder="Пароль">
                    </form>
                    <button type="button" class="btn btn-primary btn-sm" id="signInBtn">Войти</button>
                </div>
                </div>
            </li>
            <li id="authUser" class="nav-item dropdown" >
                <div class="dropdown">
                <a id="userAuth" class="nav-link text-secondary"></a>
                <div class="dropdown-content">
                    <a  id="exitBtn" class="nav-link text-secondary">Выход</a>
                </div>
                </div>
            </li>
        </ul>
        <div class="container pt-5">
            <?php
                include($contentPage);
            ?>
        </div>
    </body>
</html >
