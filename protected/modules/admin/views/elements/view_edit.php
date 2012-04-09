<?php if ($item): ?>
    <form id="Item_edit" method="post" >
        <a href="#" onClick="return toggleEdit(this);">Режим редактирования</a>
        <table  class="table table-striped table-bordered table-condensed">
            <thead>
            <th width="10">key</th>
            <th>value</th>
            <th>Comment</th>
            </thead>
            <tbody>
                <?php
                $iterator = 0;
                foreach ($item as $key => $value):
                    ?>
                    <tr>
                        <td><?= $key; ?></td>
                        <td name="<?= $key; ?>" <? if (!$columns[$iterator]['Extra']) echo 'class="editable"'; ?> 
                        <?
                        if (!(strpos($columns[$iterator]['Type'], 'tinyint(1)') === false)) {
                            echo 'type="bool"';
                            if ($value)
                                $value = "Yes"; else
                                $value = "No";
                        }
                        ?>><?= $value; ?></td>
                        <td><?= $columns[$iterator]['Comment']; ?></td>
                    </tr>
        <?php
        $iterator++;
    endforeach;
    ?>
            </tbody>
        </table>
    </form>
<?php endif; ?>

<script>   
    var state=0;
    var changes=0;
    function toggleEdit(e){
        
        if (state==0){
            $('.editable').each(function(index){    
                $(this).removeClass('editable');
                var name = $(this).attr('name');
                var ivalue = $(this).html();
                var itype= $(this).attr('type');
                if ( itype=='bool'){
                    active='';
                    if (ivalue=="Yes")
                        active='checked="checked"';
                    $(this).html('<input name="'+name+'" type="radio" value="1"'+active+'/> Yes ');
                    if (ivalue=="No")
                        active='checked="checked"';
                    else 
                        active='';
                    $(this).append('<input name="'+name+'" type="radio" value="0"'+active+'/> No ');
                } else if ( itype == 'text' ){
                    $(this).html('<textarea name="'+name+'">'+ivalue+'</textarea>');
                }
                else {
                    $(this).html('<input name="'+name+'" type="text" value="'+ivalue+'"/>');
                }
                $(this).addClass('editing');
                $(this).children().change(function(){
                    if ($(this).old != $(this).val()) changes=1;
                });
                $(e).html('Выйти из редактирования и сохранить');
            });
            state=1;
        } else {
            if (changes){
                alert('Вы сделали изменения. Они пока не сохраняются');
                //submit form
            }
            $('.editing').each(function(index){
                $(this).removeClass('editing');
                value =$(this).children('input[type=text]').val();
                if (!value) $(this).children('input:checked').val();
                if (!value) $(this).children('textarea').html();
                $(this).html(value);
                
                
                $(this).addClass('editable');
                
            });
            state=0;
            changes=0;
            $(e).html('Режим редактирования');
        }
        return false;
    }
    
  
</script>

