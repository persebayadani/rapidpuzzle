<!DOCTYPE html>
<head>
    <title>register</title>
</head>
<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('./image/pexels-eberhard-grossgasteiger-1624438.jpg') no-repeat;
            background-size: cover;
            background-position: center;
        }
        header{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 100px;

            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 99;
        }
        .logo{
            font-size: 2em;
            color: white;
            user-select: none;
        }
        .navigation a{
            position: relative;
            font-size: 1.1em;
            color: white;
            text-decoration: none;
            font-weight: 500;
            margin-left: 40px;
        }
        .navigation a::after{
            content: '';
            position: absolute;
            left: 0;
            bottom: -6px;
            width: 75px;
            height: 3px;
            background: white;
            border-radius: 5px;
            transform-origin: right;
            transform: scaleX(0);
            transition: transform .5s;

        }
        .navigation a:hover::after{
            transform-origin: left;
            transform: scaleX(1);
        }
        .navigation .btnLogin-popup{
            width: 130px;
            height: 50px;
            background: transparent;
            border: 2px solid white;
            outline: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            color: white;
            font-weight: 500;
            margin-left: 40px;
            transition: .5s;
        }
        .navigation .btnLogin-popup:hover{
            background: rgb(230, 215, 215);
            color: #162938;
        }
        .wrapper{
            position: relative;
            width: 400px;
            height: 440px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .5);
            border-radius: 20px;
            backdrop-filter: blur(20px);
            box-shadow: 0 0 30px rgba(0, 0, 0, .5);
            display: flex;
            justify-content: center;
            align-items: center;        
        }
        
        .wrapper .form-box{
            width: 100%;
            padding: 40px;
        }
       
        .wrapper .icon-close{
            position: absolute;
            top: 0;
            right: 0;
            width: 45px;
            height: 45px;
            background: #d4d9de;
            font-size: 2em;
            color: rgb(20, 19, 19);
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom-left-radius: 20px;
            cursor: pointer;
            z-index: 1;
        }
        .form-box h2{
            font-size: 2em;
            color: white;
            text-align: center;
        }
        .input-box{
            position: relative;
            width: 100%;
            height: 50px;
            border-bottom: 2px solid black;
            margin: 30px 0;
        }
        .input-box label{
            position: absolute;
            top: 5%;
            left: 5px;
            transform: translateY(-50%);
            font-size: 1em;
            color: rgb(234, 222, 222);
            font-weight: 500;
            pointer-events: none;
            transition: .5s;
        }
        
        .input-box input{
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 1em;
            color: rgb(241, 226, 226);
            font-weight: 600;
            padding: 0 35px 0 5px;
        }
        .input-box .icon{
            position: absolute;
            right: 8px;
            font-size: 1.2em;
            color: rgb(240, 232, 232);
            line-height: 57px;
        }
        .remember-forgot{
            font-size: .9em;
            color: #f4f8fa;
            font-weight: 500;
            margin: -15px 0 15px;
            display: flex;
            justify-content: space-between;
        }
        .remember-forgot label input{
            accent-color: rgb(248, 240, 240);
            margin-right: 3px;
        }
        .remember-forgot a{
            color: #d3dce3;
            text-decoration: none;
        }
        .remember-forgot a:hover{
            text-decoration: underline;
        }
        input[type="submit"]{
            width: 100%;
            height: 45px;
            background: #e3e8ec;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            color: rgb(36, 35, 35);
            font-weight: 500;
        }
        .login-register{
            font-size: .9em;
            color: #cfdbdb;
            text-align: center;
            font-weight: 500;
            margin: 25px 0 10px;
        }
        .login-register p a{
            color: #dfe4ea;
            text-decoration: none;
            font-weight: 600;
        }
        .login-register p a:hover{
            text-decoration: underline;
        }
    </style>
    <?php
    if(isset($_GET['pesan'])){
        if($_GET['pesan']=="gagal"){
            echo "<div class='alert'>
            Username dan Password tidak sesuai !</div>";
        }
    }
    ?>
    
    <div class="wrapper">
        <div class="form-box register">
            <h2>REGISTER</h2>
            <form action="reg.php" method="post">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="username"  name="username"  required>
                    <label>username</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                    <input type="email"  name="email"  required>
                    <label>email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                    <input type="password"  name="password"  required>
                    <label>password</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">i agree to the terms & conditions</label>
                </div>
                <div>
                    <input type="submit" value="register">
                </div>
                <div class="login-register">
                    <p>Already have an account?<a href="loginn.php" class="login-link">Login</a></p>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>