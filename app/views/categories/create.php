<?php 
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name=$_POST['name'];
        $parent_id=$_POST['parent_id'];
        $cate=new CategoryController();
        if(!empty($name) && !empty($parent_id)){
            $cate->store($name, $parent_id);
        }else if(!empty($name)){
            $cate->store($name);
        }
    }
?>
<div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="name">Category name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter category name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="parent_id">Parent category</label>
                        <select class="form-control" id="parent_id" name="parent_id">
                            <option value="<?php echo null ?>">---Select---</option>
                            <?php
                                foreach($data as $key => $value){
                                    echo "<option value='{$value['id']}'>{$value['name']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>