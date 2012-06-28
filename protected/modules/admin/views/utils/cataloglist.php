<table class="table table-bordered">
    <thead>
    <tr>
        <th>id</th>
        <th>name</th>
        <th>dir</th>
        <th>orig_name</th>
        <th>group</th>
        <th>tp</th>
        <th>date</th>
        <th>size</th>
        <th>delete</th>
    </tr>
    </thead>

    <tbody>
    <?php
//echo count($data);

    foreach ($data as $item){
        echo '<tr>
            <td>'.$item['id'].'</td><td>'.$item['name'].'</td><td>'.$item['dir'].'</td><td>'.$item['original_name'].'</td><td>'.$item['group'].'</td><td>'.$item['tp'].'</td>
            <td>'.$item['dt'].'</td><td>'.$item['sz'].'</td>
            <td><a href="/admin/catalog/delete/'.$item['id'].'">Delete</a></td>
            </tr>

        ';
    }
    ?></tbody>
</table>