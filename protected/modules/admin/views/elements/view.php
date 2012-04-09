<?php if ($item): ?>
      <table  class="table table-striped table-bordered table-condensed">
        <thead>
        <th>key</th>
        <th>value</th>
    </thead>
    <tbody>
        <?php foreach ($item as $key => $value): ?>
            <tr>
                <td><?= $key; ?></td>
                <td><?= $value; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
<?php endif; ?>