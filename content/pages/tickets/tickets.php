<style>
    <?php include "tickets.css"; ?>
</style>
<h2>Tickets</h2>

<form action="" method="post" id="new_ticket">
    <input type="hidden" name="action" value="create_ticket">
    <h3>Create ticket(s)</h3>
    <label>
        <h5>Number of tickets</h5>
        <input type="number" name="count" placeholder="1" required>
    </label>
    <label>
        <h5>User</h5>
        <input type="text" name="user" list="users" required>
        <datalist id="users">
            <?php
            $sql = "select * from users order by user_name asc";
            $result = $db->query($sql);
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) :
            ?>
                <option value="<?= $row["ID"] ?>"><?= $row["user_name"] ?> <span><?= $row["user_phone"] ?></span> <span><?= $row["user_email"] ?></span></option>
            <?php
            endwhile;
            ?>
        </datalist>
    </label>
    <hr>
    <button type="submit">Create</button>
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