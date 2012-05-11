<table class="table table-bordered">
    <thead>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>delete</th>
        </tr>
    </thead>

    <tbody>
<?php
//echo count($data);

foreach ($data as $item){
    echo '<tr><td>'.$item['id'].'</td><td>'.$item['title'].'</td><td><a href="/catalog/delete/'.$item['id'].'">Delete</a></td>';
}
?></tbody>
    </table>