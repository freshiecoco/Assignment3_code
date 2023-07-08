<?php
    // show the form for registering a new user!
?>
<?php require_once 'header.php' ?>
<body>
<div class="flex flex-col justify-center items-center h-screen">
    <div class="m-8 text-3xl font-bold">JNewCo. Registration</div>
    <div>
        <form action="/register" method="post"
                class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-sm">
                <div class="mb-6">
                    <span class="text-red-500"><?php
                            if (isset($_SESSION['name_error'])) {
                                echo $_SESSION['name_error'];
                                unset($_SESSION['name_error']);
                            }
                        ?>
                    </span><br>
                    <label for="username">Name</label>
                    <div>
                        <input id="username" name="username" type="text" placeholder="Your name"
                            class="input input-bordered input-accent w-full max-w-xs">
                    </div>
                </div>
                <div class="mb-6"> 
                     <span class="text-red-500"><?php
                            if (isset($_SESSION['email_error'])) {
                                echo $_SESSION['email_error'];
                                unset($_SESSION['email_error']);
                            }
                        ?>
                    </span><br>                   
                    <label for="email">Email address</label>
                    <div>
                        <input id="email" name="email" type="text" autocomplete="email" placeholder="Your email"
                            class="input input-bordered input-accent w-full max-w-xs">
                    </div>
                </div>

                <div class="mb-6">
                    <span class="text-red-500"><?php
                            if (isset($_SESSION['password_error'])) {
                                echo $_SESSION['password_error'];
                                unset($_SESSION['password_error']);
                            }
                        ?>
                    </span><br>
                    <label for="password"> Password </label>
                    <div>
                        <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Your password"
                            class="input input-bordered input-accent w-full max-w-xs">
                    </div>
                </div>
                <div class="mb-6"><span>Already have an account?</span>
                    <a class="inline-block align-baseline font-bold text-l text-blue-500 hover:text-blue-800 mx-4" href="/login">
                        Login
                    </a>
                </div>
                <div class="flex justify-center">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mx-3">
                        Register
                    </button>
                </div>
        </form>
    </div>
</div>
</body>
</html>