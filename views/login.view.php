<?php
?>
<?php require_once 'header.php' ?>
<body>
<div class="bg-secondary flex flex-col justify-center items-center h-screen">
    <div class="m-8 text-3xl font-bold">JNewCo. Login</div>
    <div>
        <form action="/login" method="post"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-sm">
                <div class="text-red-500 mb-6">
                    <?php
                            if (isset($_SESSION['login_error'])) {
                                echo $_SESSION['login_error'];
                                unset($_SESSION['login_error']);
                            }
                    ?>
                </div>
                <div class="mb-6">                    
                    <label for="email">Email address</label>
                    <div>
                        <input id="email" name="email" type="text" autocomplete="email" placeholder="Your email"
                            class="input input-bordered input-accent w-full max-w-xs">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password"> Password </label>
                    <div>
                        <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Your password"
                            class="input input-bordered input-accent w-full max-w-xs">
                    </div>
                </div>
                <div class="mb-6"><span>Don't have an account?</span>
                    <a class="inline-block align-baseline font-bold text-l text-secondary hover:text-primary mx-4" href="/register">
                        Register
                    </a>
                </div>
                <div class="flex justify-center">
                    <button type="submit"
                            class="bg-secondary hover:bg-primary text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mx-3">
                        Login
                    </button>
                </div>
        </form>

        <form action="/login/github" method="GET">
            <button type="submit">Login with Github</button>
        </form>
    </div>
</div>
</body>
</html>
