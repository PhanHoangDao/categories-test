<?php

if(isset($_POST['edit_name'])){
    $new_parent_id=$_POST['edit_parent_id'];
    $new_name=$_POST['edit_name'];
    $cate=new CategoryController();
    if(!empty($new_parent_id)){
        $cate->update($data_old['id'],$new_name,$new_parent_id);
    }else{
        $cate->update($data_old['id'],$new_name);
    }
}
?>

<div class="form-group container">
    <form method="post">
        <div class="form-group">
            <label for="edit_name_cate">Category name</label>
            <input type="text" class="form-control" id="edit_name_cate" name="edit_name"
                placeholder="Enter category name"
                value="<?php echo isset($data_old['name']) ? $data_old['name'] : '' ?>" required>
        </div>
        <label for="parent_id">Parent category</label>
        <select class="form-control mb-3" id="parent_id" name="edit_parent_id">
            <?php
            if($data_old['parent_id']==null){
                echo '<option value="0" selected>---Default---</option>';
            }
            //remove existing element from original array
            foreach ($data_cate as $key => $category) {
                if ($category['id'] == $data_old['id']) {
                    unset($data_cate[$key]);
                }
            }
            foreach ($data_cate as $key => $value) {
                if($data_old['id'] != $value['parent_id']){
                    if (($data_old['parent_id'] == $value['id'])&& $data_old['parent_id']!=null) {
                        echo '<option value="'.null.'" > ---Default---</option>';
                        echo '<option value='.$value['id'].' selected > '.$value['name'] .'</option>';
                    } else {
                        echo '<option value='.$value['id'].' >'.$value['name'] .'</option>';
                    }
                } 
            }
            
            ?>

            <?php
           
            ?>
        </select>
        <button type="submit" name='update' class="btn btn-primary">Save</button>
</div>
</form>
<!-- <div class="modal fade" id="edit_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="edit_name_cate">Category name</label>
                        <input type="text" class="form-control" id="edit_name_cate" name="name"
                            placeholder="Enter category name" required>
                    </div>

                    
            </div>
        </div>
    </div>
</div> -->