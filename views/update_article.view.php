<?php
    // display the update article form, and ensure it populates with data when the page renders.
?>
<?php require_once 'header.php' ?>
<body>
<?php require_once 'nav.php' ?> 
<?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $data[0]->author_id ) { ?>
    <div class="text-3xl font-bold flex items-center justify-center m-8">Article</div>
    <div class="flex justify-center">
        <form action="/update" method="post" class="w-5/6">
            <div class="container m-8 p-6 border border-gray-200 bg-base
                        rounded-lg shadow hover:bg-accent dark:bg-accent
                        dark:border-accent dark:hover:bg-accent
                        text-2xl
                        flex flex-col">
                
                <input type="hidden" name="id" value="<?php echo $data[0]->id ?>">

                <span class="text-red-500 m-3">
                    <?php
                    if (isset($_SESSION['title_error'])) {
                        echo $_SESSION['title_error'];
                        unset($_SESSION['title_error']);
                    }
                    ?>
                </span>
                <label for="title" class="text-neutral m-3">Title</label>
                <input type="text" name="updated_title" id="title"
                    class="container m-3 px-4 py-4 shadow-inner"
                    value="<?php echo $_SESSION['updated_title'. $data[0]->id] ?? htmlspecialchars($data[0]->title) ?>">
                
                <span class="text-red-500 m-3">
                    <?php
                    if (isset($_SESSION['url_error'])) {
                        echo $_SESSION['url_error'];
                        unset($_SESSION['url_error']);
                    }
                    ?>
                </span>
                <label for="url" class="text-neutral m-3">Url</label>
                <input type="text" name="updated_url" id="url" 
                    class="container m-3 px-4 py-4 shadow-inner"
                    value="<?php echo $_SESSION['updated_url'. $data[0]->id] ?? htmlspecialchars($data[0]->url) ?>">
            
            </div>
            <button class="text-xl font-bold bg-secondary hover:bg-warning
                        py-2 px-4 mx-8 rounded" 
                    type="submit">Submit</button>
        </form>
    </div>
<?php }?>
</body>
</html>