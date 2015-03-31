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
        <th>sgroup</th>
        <th>delete</th>
    </tr>
    </thead>

    <tbody>
    <?php
echo count($data);
    $sum=0;
    foreach ($data as $item){
	$sum+=$item['sz'];
        echo '<tr>
            <td>'.$item['id'].'</td><td>'.$item['name'].'</td><td>'.$item['dir'].'</td><td>'.$item['original_name'].'</td><td>'.$item['group'].'</td><td>'.$item['tp'].'</td>
            <td>'.$item['dt'].'</td><td>'.$item['sz'].'</td><td>'.$item['sgroup'].'</td>
            <td><a href="/admin/catalog/delete/'.$item['id'].'">Delete</a></td>
            </tr>

        ';
    }
    echo "Summ:".($sum/1024/1024/1024);
    ?></tbody>
</table>