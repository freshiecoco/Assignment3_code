<!doctype html>
<html lang="en" data-theme="retro">

<?php require_once 'header.php' ?>
<body>
<?php require_once 'nav.php' ?>
    <div class="container mx-auto my-10 px-4"> 
    <?php foreach($data as $article): ?> 
        <div class="text-xl p-8 shadow-lg rounded flex flex-row justify-between">
            <div>
                <p class="text-secondary-focus"><?= htmlspecialchars($article->title) ?>
                </p>
                <a href="<?= $article->url ?>" class="text-secondary-focus"><i class="fas fa-link mb-8"></i> Link</a>

                <p class="text-xs m-1" ><i class="fa fa-calendar text-neutral-focus mr-2"></i>Created at <?= $article->created_at ?></p>
                <?php $updatedTime = $article->updated_at ?> 
                <?php if(!empty($updatedTime)) {?> 
                <p class="text-xs m-1" ><i class="fa fa-calendar text-neutral-focus mr-2"></i>Updated at <?= $updatedTime ?></p>
                <?php } ?> 
                <div class="flex items-center">
                    <div class="avatar">
                        <div class="w-6 rounded-full">
                            <img src="../../images/<?= htmlspecialchars($article->profile_pic) ?>"  alt="author_profile"/>
                        </div>
                    </div>
                    <p class="text-xs m-1" >Posted by <?= htmlspecialchars($article->author_name) ?></p>
                </div>
            </div>

            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $article->author_id) { ?>
            <div>
                <a href="/update?id=<?= $article->id ?>&updated=true">
                <i class="fa-regular fa-pen-to-square text-neutral-focus"></i>
                </a>
                <a href="/delete?id=<?= $article->id ?>">
                <i class="fa-regular fa-trash-can text-primary-focus mx-3"></i>
                </a>
            </div>
            <?php } ?>
        </div>
    <?php endforeach; ?>
    </div>
</body>
</html>