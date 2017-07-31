<table class="table">
    <thead>
    <tr>
        <td>Date</td>
        <td>Change</td>
        <td>USD</td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($history as $item):
    ?>
        <tr>
            <td><?= $item->created_at ?></td>
            <td><?= $item->change ?></td>
            <td><?= $item->change_usd ?></td>
        </tr>
    <?php
    endforeach;
    ?>
    <tr>
        <td>Total</td>
        <td><?= $total ?></td>
        <td><?= $totalUsd ?></td>
    </tr>
    </tbody>
</table>
<a href="<?=$downloadUrl?>" target="_blank">Download</a>