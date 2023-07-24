<?php



class CategoryController extends Controller
{
    private $categoryModel;
    public $data, $db;
    public function __construct()
    {
        $this->categoryModel = $this->model("CategoryModel");
    }
    public function index()
    {
        if(isset($_GET['keyword'])){
            $data_search= $this->search($_GET['keyword']);
        }
        if(!empty($data_search)){
            $this->data['sub_content']['data_cate']=$data_search['result'];
            $this->data['sub_content']['count_result']=$data_search['count_result'];
        }else{
            $this->data['sub_content']['data_cate']=$this->categoryModel->getAllCategories();
        }
        $this->data['content']= "categories/index";
        $this->data['title']='Category Page';
        $this->view("layouts/master",$this->data);
    }


    public function showCategories($categories, $parent_id = null, $char = '')
{
    $icon = '';
        
        foreach ($categories as $key => $item)
        {
            // Nếu là chuyên mục con thì hiển thị
            if ($item['parent_id'] == $parent_id || $key==0)
            {
                if(!empty($item['parent_id'])){
                    $icon='<i class="fa fa-level-down" aria-hidden="true"></i>';
                }
                echo '<tr>';
                echo "<td>".($key+1)."</td>";
                echo "<td id=".($key+1)." value=".$item['name']."> ";
                echo $char.$icon.' '.$item['name'];
                echo "</td>";
                echo '<td >
                        <div class="d-flex text-primary">
                            
                            <a class="btn bg-transparent text-warning"
                              href="/category/edit/'.$item['id'].'"  
                            >
                                <i class="fa fa-pencil-square-o" aria-hidden="true" ></i>
                            </a>
                            <button type="button" class="btn bg-transparent text-primary" 
                                    onclick="copyToClipboard('.($key+1).')"
                            >
                                <i class="fa fa-clipboard" aria-hidden="true"></i>
                            </button>
                            <a class="btn bg-transparent text-danger"
                              href="/category/delete/'.$item['id'].'"  
                            >
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </a>
                        </div>
                    </td>';
                echo "</tr>";

                unset($categories[$key]);

                $this->showCategories($categories, $item['id'], $char.'&nbsp;&nbsp;&nbsp;&nbsp;');
                }
            }       
    }   

    public function getCategoryById($id){
        return $this->categoryModel->getCategoryById($id);
    }

    public function store($name, $parent_id=null)
        {
        try {
        $result=$this->categoryModel->createCategory($name, $parent_id);
        $_SESSION['add']=$result;
            header('Location: /category');

        } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }

}

    public function edit($id)
    {
        $id= explode("/",$_SERVER['PATH_INFO'])[3];
        $this->data['content']= "categories/edit";
        $this->data['title']='Category Edit';
        $this->data['sub_content']['data_cate']=$this->categoryModel->getAllCategories();
        $this->data['sub_content']['data_old']=$this->categoryModel->getCategoryById($id);
        $this->view("layouts/master",$this->data);
    }

    public function update($cateId, $new_name, $new_parent_id=null)
    {
        $this->categoryModel->updateCategory($cateId, $new_name, $new_parent_id);
        header('Location: /category');

    }

    public function delete()
    {
        $id= explode("/",$_SERVER['PATH_INFO'])[3];
        $this->categoryModel->deleteCategory($id);
        header('Location: /category');
    }

    public function search($keyword)
    {
        return $this->categoryModel->searchCategoriesByName($keyword);
    }

    public function paginate($data)
    {
        $rowsPerPage = 10;
        
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        // Tính toán tổng số trang
        $totalPages = ceil(count($data) / $rowsPerPage);
        
        // Giới hạn trang hiện tại trong phạm vi hợp lệ
        if ($currentPage < 1) {
            $currentPage = 1;
        } elseif ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }
        $startFrom = ($currentPage - 1) * $rowsPerPage; 
        
        // Lấy dữ liệu cho trang hiện tại
        $currentPageData = array_slice($data, $startFrom, $rowsPerPage);
        // $this->showCategories($currentPageData);
        $this->showCategories($currentPageData);
        echo "</tbody>";
        echo "</table>";
        echo '<div class="d-flex justify-content-center">';
        echo "<nav aria-label='Page navigation example'>";
        echo "<ul class='pagination'>";
        
        if ($currentPage > 1) {
            echo "<li class='page-item'><a class='page-link' href='?page=" . ($currentPage - 1) . "'>Previous</a></li>";
        }
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<li class='page-item " . ($i === $currentPage ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
        }
        if ($currentPage < $totalPages) {
            echo "<li class='page-item'><a class='page-link' href='?page=" . ($currentPage + 1) . "'>Next</a></li>";
        }
        echo "</ul>";
        echo "</nav>";
        echo '</div>';
    }
        
        
    function sortByParentId($array, $parentId = null)
    {
        $sortedArray = array();

        foreach ($array as $item) {
            if ($item['parent_id'] == $parentId) {
                $sortedArray[] = $item;
                $sortedArray = array_merge($sortedArray,$this->sortByParentId($array, $item['id']));
            }
        }

        return $sortedArray;
    }
}