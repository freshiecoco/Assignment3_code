<?php
// some kind of reusable navigation bar here!
?>
<div class="navbar bg-secondary">
  <div class="flex-1">
    <a href="/" class="btn btn-ghost normal-case text-3xl">JNewCo.</a>
    <a href="/" class="btn btn-ghost normal-case text-xl">All articles</a>
    <?php if(isset($_SESSION['user_id'])) { ?>
      <a href="/new?complete=true" 
        class="btn btn-ghost normal-case text-xl">New article</a>
    <?php }?>
  </div>
  <div class="flex-none gap-2">
    
   <?php if(!isset($_SESSION['user_id'])) { ?>
    <a href="/login" class="btn btn-ghost normal-case text-xl">Login</a>
    <a href="/register" class="btn btn-ghost normal-case text-xl">Register</a>
    <?php }?>
    <?php if(isset($_SESSION['user_id'])) { ?>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']) ?> </p>
    <div class="dropdown dropdown-end">
      <label tabindex="0" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img src="../../images/<?= htmlspecialchars($_SESSION['user_pic']) ?>" />
        </div>
      </label>
      <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
        <li><a href="/settings?userId=<?= htmlspecialchars($_SESSION['user_id']) ?>">Settings</a></li>
        <li><form action="/logout" method="post"><button>Logout</button></form></li>
      </ul>
    </div>
    <?php }?>
  </div>
</div>
