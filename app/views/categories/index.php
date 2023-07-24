<?php 
    $cate= new CategoryController();
    $this->view('categories/create', ['data'=>$data_cate]);
    $this->view('categories/delete', ['data'=>$data_cate]);
?>

<div class="container my-5">
    <form class="form-inline my-2 my-lg-0 d-flex justify-content-end " method="get">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="keyword">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <div class="d-flex justify-content-between align-items-center py-3">

        <?php 
            if(!empty($count_result)){
            ?>
        <p>Search found <b><?php echo $count_result ?></b> results</p>
        <?php 
        }else{
            echo '<p></p>';
        }
        
        ?>

        <button type="button" class="btn btn-primary rounded-circle border border-info bg-transparent text-primary"
            data-toggle="modal" data-target="#add_category">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
    </div>
    <div class="table-responsive">
        <table class="table w- table-hover ">
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        <div class="ml-auto">Category Name </div>
                    </th>
                    <th>
                        Operations
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $sortedData = $cate->sortByParentId($data_cate);
                $cate->paginate($sortedData);
            ?>
    </div>
</div>
<script>
function copyToClipboard(id) {
    const copyText = document.getElementById(id + '');
    const name = copyText.innerText.trim()
    navigator.clipboard.writeText(name);

}
</script>