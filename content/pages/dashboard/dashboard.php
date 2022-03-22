<style>
    <?php include "dashboard.css"; ?>
</style>
<h2>Dashboard</h2>

<div id="dashboard">
    <div id="tickets">
        <h3>Latest Tickets</h3>
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
    limit 0, 10
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
                <div class="ticket__drafts">
                    <?= $draft["draftCount"] ?>
                </div>
            </div>
        <?php
        endwhile;
        ?>
    </div>
</div>