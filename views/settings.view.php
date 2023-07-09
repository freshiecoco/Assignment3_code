<!doctype html>
<html lang="en" data-theme="retro">

<?php require_once 'header.php' ?>
<body>
<?php require_once 'nav.php' ?> 
<?php if(isset($_SESSION['user_id']) && isset($data[0])) { ?>
    <?php if ($_SESSION['user_id'] == htmlspecialchars($data[0]->id) ) { ?>
    <div class="text-3xl font-bold flex items-center justify-center m-8">Settings</div>
    <div class="flex justify-center">
        <form action="/settings" method="post" class="w-5/6" enctype="multipart/form-data">
            <div class="container m-8 p-6 border border-gray-200 bg-base
                        rounded-lg shadow hover:bg-accent dark:bg-accent
                        dark:border-accent dark:hover:bg-accent
                        text-xl
                        flex flex-col">
                
                <input type="hidden" name="user_id" 
                       value="<?php echo $_SESSION['user_id'] ?? '' ?>">
                <div class="flex items-center">
                    <p class="text-neutral m-3 w-2/5">Email (cannot be changed)</p>
                    <p class="container m-3 px-4 py-4 shadow-inner w-3/5"> 
                        <?php echo htmlspecialchars($data[0]->email) ?> </p>
                </div>
                <hr>
                
                <div class="flex items-center">
                    <label for="username" class="text-neutral m-3 w-2/5">Username</label>
                    <div class="w-3/5"> 
                        <span class="text-red-500 m-3">
                        <?php
                        if (isset($_SESSION['username_error'])) {
                            echo $_SESSION['username_error'];
                            unset($_SESSION['username_error']);
                        }
                        ?>
                        </span>
                        <input type="text" name="updated_username" id="username" 
                            class="container m-3 px-4 py-4 shadow-inner"
                            value="<?php echo htmlspecialchars($data[0]->name) ?>">
                    </div>
                </div>
                <hr>
                <div class="flex items-center">
                    <label for="photo" class="text-neutral m-3 w-2/5">Photo</label>
                    <div class="flex items-center container m-3 py-4 w-3/5">
                        <div class="avatar mr-4">
                            <div class="w-12 rounded-full">
                                <img src="../../images/<?= htmlspecialchars($data[0]->profile_picture) ?>" />
                            </div>
                        </div>
                        <input type='file' name='filename' size='10' id="photo"
                               class="flex items-center border border-gray-300 p-5 bg-secondary">
                       
                   </div>
                </div>


            
            </div>
            <button class="text-xl font-bold bg-secondary hover:bg-warning
                        py-2 px-4 mx-8 rounded" 
                    type="submit">Save</button>
        </form>
    </div>
    <?php }?>
<?php }?>
</body>
</html>