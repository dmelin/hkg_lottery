<h2>Users</h2>

<form id="new_user" action="" method="post">
    <h3><?= (!isset($data[1])) ? "Add new user" : "Edit user" ?></h3>
    <?php
    $user = false;
    if (isset($data[1])) :
        $sql = "select * from users where ID = {$data[1]} limit 0, 1";
        $user = $db->query($sql)->fetchArray(SQLITE3_ASSOC);
    endif;

    $user_edit = true;
    if (!$user) :
        if (isset($data[1])) :
            echo "<p>No such user</p>";
            $user_edit = false;
        endif;
        $user = array(
            "ID" => 0,
            "user_name" => "",
            "user_email" => "",
            "user_phone" => ""
        );
    else :

    endif;

    if ($user_edit) :
    ?>
    <label>
        <h5>User name</h5>
        <input type="text" name="name" value="<?= $user["user_name"] ?>">
    </label>
    <label>
        <h5>Email</h5>
        <input type="text" name="email" value="<?= $user["user_email"] ?>">
    </label>
    <label>
        <h5>User phone</h5>
        <input type="text" name="phone" value="<?= $user["user_phone"] ?>">
    </label>
    <?php endif; ?>
</form>

<hr>

<div id="users">
    <?php
    $sql = "select * from users order by user_name asc";
    $result = $db->query($sql);
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) :
    ?>
        <a href="/users/<?= $row["ID"] ?>" class="user">
            <div class="user__name">
                <?= $row["user_name"] ?>
            </div>
            <div class="user__email">
                <?= $row["user_email"] ?>
            </div>
            <div class="user__phone">
                <?= $row["user_phone"] ?>
            </div>
            <div class="user__created">
                <?= $row["user_created"] ?>
            </div>
        </a>
    <?php
    endwhile;
    ?>
</div>