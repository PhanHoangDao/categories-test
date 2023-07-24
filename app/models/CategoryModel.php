<?php



class CategoryModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllCategories($startFrom=0, $rowsPerPage=1){
        $sql="select * from categories";
        try {
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result= $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage();
            return [];
        }
        

    }

    public function getCategoryById($id)
    {
        $sql="select * from categories where  id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result= $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage();
            return [];
        }
    }

    public function createCategory($name, $parent_id=null)
    {
        try {
            $sql = "insert INTO categories (name, parent_id) VALUES (:name, :parent_id)";
            
            $stmt = $this->db->prepare($sql);
            
            // Gán các giá trị cho các tham số trong câu lệnh
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':parent_id', $parent_id);
        
            // Thực thi câu lệnh SQL
            $stmt->execute();
            $result=[
                'status'=> 200,
                'message' =>'Category added successfully!'
            ];
            return $result;
        } catch (PDOException $e) {
            $result=[
                'status'=> $e->getCode(),
                'message' =>$e->getMessage()
            ];
            return $result;
        }
        

    }

    public function updateCategory($category_id, $new_name, $new_parent_id=null)
    {
        try {
            $sql = "update categories SET name = :new_name, parent_id = :new_parent_id WHERE id = :category_id";

            $stmt = $this->db->prepare($sql);
    
            // Gán các giá trị cho các tham số trong câu lệnh
            $stmt->bindParam(':new_name', $new_name);
            $stmt->bindParam(':new_parent_id', $new_parent_id);
            $stmt->bindParam(':category_id', $category_id);
    
            $stmt->execute();
            $result=[
                'status'=> 200,
                'message' =>'Category updated successfully!'
            ];
            return $result;
        } catch (PDOException $e) {
            $result=[
                'status'=> $e->getCode(),
                'message' =>$e->getMessage()
            ];
            return $result;
        }
    }

    public function deleteCategory($id)
    {
        try {
            $stmt = $this->db->prepare("delete FROM categories WHERE parent_id = :categoryId");
            $stmt->execute(['categoryId' => $id]);

            // Lấy danh sách các category con của category hiện tại
            $stmt =$this->db->prepare("select id FROM categories WHERE parent_id = :categoryId");
            $stmt->execute(['categoryId' => $id]);
            $children = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo '<pre>';
            var_dump($children);
            echo '</pre>';
            // Gọi đệ quy để xóa các category con của các category con
            foreach ($children as $childId) {
                $this->deleteCategory($childId);
            }

            // Xóa chính category hiện tại
            $stmt = $this->db->prepare("delete FROM categories WHERE id = :categoryId");
            $stmt->execute(['categoryId' => $id]);
    
            $result=[
                'status'=> 200,
                'message' =>'Category deleted successfully!'
            ];
            return $result;
        } catch (PDOException $e) {
            $result=[
                'status'=> $e->getCode(),
                'message' =>$e->getMessage()
            ];
            return $result;
        }
    }
    function searchCategoriesByName($keyword)
    {
        $stmt = $this->db->prepare("
            SELECT DISTINCT c1.id, c1.name, c1.parent_id
            FROM categories AS c1
            LEFT JOIN categories AS c2 ON c1.id = c2.parent_id OR c1.parent_id = c2.id
            WHERE c1.name LIKE :searchKeyword OR c2.name LIKE :searchKeyword
        ");
        $stmt->execute(['searchKeyword' => "%$keyword%"]);
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //filter results with keywords to count
        $filteredArray = array();
        foreach ($results as $item) {
            if (strpos(strtolower($item['name']),strtolower($keyword) ) !== false) {
                $filteredArray[] = $item;
            }
        }
        $results=[
            'result'=>$results,
            'count_result'=>count($filteredArray)
        ];
        return $results;
    }
}