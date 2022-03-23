<style>
<?php include "users.css"; ?>
</style>
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
    <input type="hidden" name="action" value="save_user">
    <input type="hidden" name="ID" value="<?= $user["ID"] ?>">
    <label>
        <h5>User name</h5>
        <input type="text" name="name" value="<?= $user["user_name"] ?>" required>
    </label>
    <label>
        <h5>Email</h5>
        <input type="text" name="email" value="<?= $user["user_email"] ?>" required>
    </label>
    <label>
        <h5>User phone</h5>
        <input type="text" name="phone" value="<?= $user["user_phone"] ?>" required>
    </label>
    <button type="submit">Save</button>
    <?php endif; ?>
</form>
<div id="tickets">
    <?php
    $sql = "
    select
        tickets.ID as ticketID,
        tickets.ticket_created as ticketCreated,
        users.user_name as userName,
        users.user_phone as userPhone,
        users.user_email as userEmail
    from tickets
    
    join users on users.ID = tickets.user_ID
    
    where users.ID = {$user["ID"]}

    order by tickets.ticket_created desc
    ";
    $result = $db->query($sql);
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) :
        $sql = "select count(ID) as draftCount from drafts where ticket_ID = '{$row["ticketID"]}'";
        $draft = $db->query($sql)->fetchArray(SQLITE3_ASSOC);
    ?>
        <div class="ticket">
            <div class="ticket__id">
                <?= $row["ticketID"] ?>
            </div>
            <div class="ticket__date" title="<?= $row["ticketCreated"] ?>">
                <?= date("Y-m-d", strtotime($row["ticketCreated"])) ?>
            </div>
            <div class="ticket__name">
                <?= $row["userName"] ?>
            </div>
            <div class="ticket__email">
                <?= $row["userEmail"] ?>
            </div>
            <div class="ticket__phone">
                <?= $row["userPhone"] ?>
            </div>
            <div class="ticket__drafts">
                <?= $draft["draftCount"] ?>
            </div>
        </div>
    <?php
    endwhile;
    ?>
</div>
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